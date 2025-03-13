<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Role -->
        <div>
            <x-input-label for="role_id" :value="__('Register as')" />
            <select id="role_id" name="role_id" class="block mt-1 w-full" required>
                <option value="" disabled selected>-- Select Role --</option>
                <option value="alumni">Alumni</option>
                <option value="company">Company</option>
            </select>
            <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
        </div>

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
 
        <!-- NIM (Hanya untuk Alumni) -->
        <div class="mt-4 hidden" id="nim_field">
            <x-input-label for="nim" :value="__('NIM')" />
            <x-text-input id="nim" class="block mt-1 w-full" type="text" name="nim" :value="old('nim')" autocomplete="nim" />
            <x-input-error :messages="$errors->get('nim')" class="mt-2" />
        </div>

        <!-- Company Name (Hanya untuk Perusahaan) -->
        <div class="mt-4 hidden" id="company_name_field">
            <x-input-label for="company_name" :value="__('Company Name')" />
            <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" autocomplete="organization" />
            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
        </div>

        <!-- Contact Person -->
        <div class="mt-4 hidden" id="contact_person_field">
            <x-input-label for="contact_person" :value="__('Contact Person')" />
            <x-text-input id="contact_person" class="block mt-1 w-full" type="text" name="contact_person" :value="old('contact_person')" />
            <x-input-error :messages="$errors->get('contact_person')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4 hidden" id="phone_field">
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Address -->
        <div class="mt-4 hidden" id="address_field">
            <x-input-label for="address" :value="__('Address')" />
            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Website -->
        <div class="mt-4 hidden" id="website_field">
            <x-input-label for="website" :value="__('Website')" />
            <x-text-input id="website" class="block mt-1 w-full" type="url" name="website" :value="old('website')" />
            <x-input-error :messages="$errors->get('website')" class="mt-2" />
        </div>

        <!-- Industry -->
        <div class="mt-4 hidden" id="industry_field">
            <x-input-label for="industry" :value="__('Industry')" />
            <x-text-input id="industry" class="block mt-1 w-full" type="text" name="industry" :value="old('industry')" />
            <x-input-error :messages="$errors->get('industry')" class="mt-2" />
        </div>

        <!-- Script untuk menampilkan field sesuai role -->
        <script>
            document.getElementById('role_id').addEventListener('change', function() {
                let selectedRole = this.value;

                // Alumni
                document.getElementById('nim_field').classList.toggle('hidden', selectedRole !== 'alumni');

                // Perusahaan
                let companyFields = ['company_name_field', 'contact_person_field', 'phone_field', 'address_field', 'website_field', 'industry_field'];
                companyFields.forEach(field => {
                    document.getElementById(field).classList.toggle('hidden', selectedRole !== 'company');
                });
            });
        </script>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>