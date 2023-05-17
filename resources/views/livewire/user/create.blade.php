<x-slot name="header">
        <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2> -->
        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" class="sm:ml-05">
            <span>  {{ __('List Users') }} </span>
        </x-nav-link>

        <x-nav-link :href="route('users.create')" :active="request()->routeIs('users.create')" >
            <span class="px-4" > {{ __('Create User') }} </span>
        </x-nav-link>
</x-slot>



<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">

                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('User data') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                    {{ __('Ensure your account is using a long, random password to stay secure.') }}
                    </p>
                </header>

                <form wire:submit.prevent="save" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')

                    <!-- <div class="mb-4">
                        <label for="name" class="block font-medium text-sm text-gray-700">{{ __('Name') }}</label>
                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name"  wire:model.defer="user.name">
                        @error('user.name') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div> -->

                    <div>
                        <label for="name" class="block font-medium text-sm text-gray-700">{{ __('Name') }}</label>
                        <input type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="name"  wire:model.defer="user.name">
                        @error('user.name') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>
                    

                    <div>
                        <label for="username" class="block font-medium text-sm text-gray-700">{{ __('Username') }}</label>
                        <input type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="username"  wire:model.defer="user.username">
                        @error('user.username') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>        

                    <div>
                        <label for="password" class="block font-medium text-sm text-gray-700">{{ __('Password') }}</label>
                        <input type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="password" wire:model.defer="password">
                        @error('password') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block font-medium text-sm text-gray-700">{{ __('Confirm Password') }}</label>
                        <input type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="password_confirmation"  wire:model.defer="password_confirmation">
                        @error('password_confirmation') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
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

                    <div>
                        <label for="status" class="block font-medium text-sm text-gray-700">{{ __('Status')  }}</label>
                        <select id="status" class="border border-gray-300 text-sm rounded focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full"  wire:model.defer="user.status">
                        <option value="true">{{ __('Activo') }}</option>
                        <option value="false">{{ __('Inactivo')}}</option>
                        </select>
                        @error('user.status') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>
                
                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>

        
    </div>
</div>

