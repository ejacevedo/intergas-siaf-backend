
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
</x-slot>


<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">

                <form wire:submit.prevent="save" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')

                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Profile Information') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Update account information.") }}
                        </p>
                    </header>
                    
                    <div class="mb-4">
                        <label for="name" class="block font-medium text-sm text-gray-700">{{ __('Name') }}</label>
                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" wire:model="name">
                        @error('name') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>


                    <div class="mb-4">
                        <label for="username" class="block font-medium text-sm text-gray-700">{{ __('Username') }}</label>
                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" wire:model="username">
                        @error('username') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="roles" class="block font-medium text-sm text-gray-700">{{ __('Roles')  }}</label>
                        <select multiple id="roles" class="border border-gray-300 text-sm rounded focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full" wire:model.defer="selected_roles">
                            @foreach ($roles as $role)
                                <option value="{{$role->name}}"> {{ __( $role->name) }}</option>
                            @endforeach
                        </select>
                         @error('selected_roles') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>

               
                    <div class="mb-4">
                        <label for="roles" class="block font-medium text-sm text-gray-700">{{ __('Status')  }}</label>
                        <select id="roles" class="bg-gray-50 border border-gray-700  text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" wire:model="status">
                        <option value="true">{{ __('Activo') }}</option>
                        <option value="false">{{ __('Inactivo')}}</option>
                        </select>
                    </div>
                    

                    <!-- <div class="mb-4">
                        <label for="roles" class="block font-medium text-sm text-gray-700">Select an option</label>
                        <select id="roles" class="bg-gray-50 border border-gray-700 text-gray-700 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Choose a country</option>
                        <option value="US">United States</option>
                        <option value="CA">Canada</option>
                        <option value="FR">France</option>
                        <option value="DE">Germany</option>
                        </select>
                    </div> -->

                    <header class="mt-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Update Password') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Make sure this account uses a long, random password to maintain security.') }}
                        </p>
                    </header>
                   
                    <div class="mb-4">
                        <label for="password" class="block font-medium text-sm text-gray-700">{{ __('New Password') }}</label>
                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" wire:model="password">
                        @error('password') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block font-medium text-sm text-gray-700">{{ __('Confirm Password') }}</label>
                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password_confirmation" wire:model="password_confirmation">
                        @error('password_confirmation') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>


                
                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>

                    
                    </div>
                </form>
            </div>
        </div>

        
    </div>
</div>

