<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\RedirectResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'login' => ['required', 'string'], // Bisa Email, NIM, atau NIP
            'password' => ['required', 'string'],
        ]);

        // Ambil input yang dimasukkan pengguna
        $loginValue = $request->input('login');

        // Cek apakah yang diinput adalah Email, NIM, atau NIP
        if (filter_var($loginValue, FILTER_VALIDATE_EMAIL)) {
            $loginField = 'email';
        } elseif (DB::table('users')->where('nim', $loginValue)->exists()) {
            $loginField = 'nim'; // Alumni login dengan NIM
        } elseif (DB::table('users')->where('nip', $loginValue)->exists()) {
            $loginField = 'nip'; // Admin login dengan NIP
        } else {
            return back()->withErrors(['login' => 'Email / NIM / NIP tidak ditemukan.'])->onlyInput('login');
        }

        // Coba login dengan data yang didapat
        $credentials = [$loginField => $loginValue, 'password' => $request->password];

        // Pastikan tidak kena rate limit
        $this->ensureIsNotRateLimited($request);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            // Jika gagal, tambahkan rate limit
            RateLimiter::hit($this->throttleKey($request));

            throw ValidationException::withMessages([
                'login' => __('The provided credentials do not match our records.'),
            ]);
        }

        // Reset percobaan login yang gagal
        RateLimiter::clear($this->throttleKey($request));

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Pastikan user tidak terkena rate limit.
     *
     * @throws \Illuminate\Auth\Events\Lockout
     */
    public function ensureIsNotRateLimited(Request $request): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        event(new Lockout($request));

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'login' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /**
     * Generate the login throttle key.
     */
    protected function throttleKey(Request $request): string
    {
        return strtolower($request->input('login')) . '|' . $request->ip();
    }
}
