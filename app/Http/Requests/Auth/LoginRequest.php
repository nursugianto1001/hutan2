<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'login'    => ['required', 'string'], // Bisa Email, NIM, atau NIP
            'password' => ['required'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $loginValue = $this->input('login');

        // Tentukan apakah input berupa Email, NIM, atau NIP
        $loginField = filter_var($loginField = $this->input('login'), FILTER_VALIDATE_EMAIL) 
            ? 'email' 
            : (DB::table('users')->where('nim', $loginField)->exists() ? 'nim' : 'nip');

        // Buat array credentials
        $credentials = [$loginField => $loginField, 'password' => $this->password];

        if (!Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => __('The provided credentials do not match our records.'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => __('Too many login attempts. Please try again in :seconds seconds.', [
                'seconds' => $seconds,
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('login')).'|'.$this->ip());
    }
}
