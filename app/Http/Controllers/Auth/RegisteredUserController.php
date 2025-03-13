<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Models\Roles;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role_id' => ['required', Rule::in(['alumni', 'company'])], // Ini harus berupa ID, bukan string
        'nim' => [Rule::requiredIf($request->role_id === 'alumni'), 'nullable', 'string', 'max:20', Rule::unique('users', 'nim')],
        'company_name' => [Rule::requiredIf($request->role_id === 'company'), 'nullable', 'string', 'max:255'],
        'contact_person' => ['nullable', 'string', 'max:255'],
        'phone' => ['nullable', 'string', 'max:20'],
        'address' => ['nullable', 'string', 'max:255'],
        'website' => ['nullable', 'string', 'max:255', 'url'],
        'industry' => ['nullable', 'string', 'max:255'],
    ]);

    // **Cari ID role berdasarkan nama role**
    $role = Roles::where('name', $request->role_id)->first();

    if (!$role) {
        return back()->withErrors(['role_id' => 'Invalid role selected.']);
    }

    // Simpan user dengan role_id yang benar
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role_id' => $role->id, // Simpan ID dari tabel roles
        'nim' => $request->role_id === 'alumni' ? $request->nim : null,
        'company_name' => $request->role_id === 'company' ? $request->company_name : null,
        'contact_person' => $request->contact_person,
        'phone' => $request->phone,
        'address' => $request->address,
        'website' => $request->website,
        'industry' => $request->industry,
    ]);

    event(new Registered($user));

    Auth::login($user);

    // Redirect sesuai role
    return match ($request->role_id) {
        'alumni' => redirect()->route('alumni.dashboard'),
        'company' => redirect()->route('company.dashboard'),
        default => redirect('/'),
    };
}
}