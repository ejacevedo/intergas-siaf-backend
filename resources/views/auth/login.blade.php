<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="login">
        @csrf


        <div class="mt-4 mb-6 title text-center">
            SIAF MOBIL
        </div>
        
        <div class="mb-6">
            <label for="username" class="block mb-2 text-sm font-medium text-gray-900 ">{{ __('Username') }}</label>
            <input type="text" id="username" class="shadow-sm block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-white-50 sm:text-md focus:ring-gray-500 focus:border-gray-500" id="username" type="text" name="username" required="required" autofocus="autofocus" autocomplete="username" placeholder="{{ __('placeholder_username') }}"  required autofocus autocomplete="username">
        </div>

        <div class="mb-6">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 ">{{ __('Password') }}</label>
            <input type="password" id="password" class="shadow-sm block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-white-50 sm:text-md focus:ring-gray-500 focus:border-gray-500" id="password" type="password" name="password" required="required" autocomplete="current-password"  placeholder="{{ __('placeholder_password') }}">
        </div>

        <div class="mt-4">
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
        </div>
        
        <div class="flex items-center justify-end mt-4">
        
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-orange border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 focus:bg-orange-700 active:bg-orange-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3 primay py-3.5">
                {{ __('Log in') }}
            </button>

        </div>
    </form>
</x-guest-layout>


<style>
/* .bg-primary {
    background-color: #FF4C00;
} */
</style>