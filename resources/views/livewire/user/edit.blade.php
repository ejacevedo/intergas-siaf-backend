


<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">

                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Profile Information') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Update account information.") }}
                    </p>
                </header>

                <form wire:submit.prevent="save" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')

                    <!-- <div>
                        <div class="relative">
                            <input type="text" id="name" class="shadow-sm p-4 block w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" id="name" wire:model="name" />
                            <label for="name" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white  px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">{{ __('Name') }}</label>
                        </div>
                        @error('name') <span class="text-xs text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div> -->

                    <div>
                        <div class="relative">
                            <input autocomplete="nope" type="text" id="name" class="shadow-sm p-4 block w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " id="name"  wire:model.defer="name"/>
                            <label for="name" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white  px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">{{ __('Name') }}</label>
                        </div>
                        @error('name') <span class="text-xs text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <div class="relative">
                            <input type="text" id="username" class="shadow-sm p-4 block w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " id="username" wire:model="username" />
                            <label for="username" class="absolute text-sm text-gray-900 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">{{ __('Name') }}</label>
                        </div>
                        @error('username') <span class="text-xs text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>


                    <div>
                        <div class="relative">
                            <label  for="roles" class="absolute text-sm text-gray-900 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">{{ __('Roles')  }}</label>
                            <select multiple id="roles" class="shadow-sm p-4 block w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" wire:model.defer="selected_roles">
                                @foreach ($roles as $role)
                                    <option value="{{$role->name}}"> {{ __( $role->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <div class="relative">
                            <label for="name" class="absolute text-sm text-gray-900 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">{{ __('Status')  }}</label>
                            <select id="roles" class="shadow-sm p-4 block w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" wire:model="status">
                                <option value="true">{{ __('Active') }}</option>
                                <option value="false">{{ __('Inactive')}}</option>
                            </select>
                        </div>
                    </div>


                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Update Password') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Make sure this account uses a long, random password to maintain security.') }}
                        </p>
                    </header>

                    <div>
                        <div class="relative">
                            <input type="password" id="password" class="shadow-sm p-4 block w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " id="password" wire:model="password" />
                            <label for="password" class="absolute text-sm text-gray-900 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">{{ __('New Password') }}</label>
                        </div>
                        @error('password') <span class="text-xs text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <div class="relative">
                            <input type="password" id="password_confirmation" class="shadow-sm p-4 block w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " id="password_confirmation" wire:model="password_confirmation" />
                            <label for="password_confirmation" class="absolute text-sm text-gray-900 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">{{ __('Confirm Password') }}</label>
                        </div>
                        @error('password_confirmation') <span class="text-xs text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>
             
                    <div class="flex items-center gap-4">
                        <x-primary-button class="nline-flex items-center py-2 bg-orange border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 focus:bg-orange-700 active:bg-orange-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150 primay py-3.5">{{ __('Save') }}</x-primary-button>
                    </div>
                    
                </form>
            </div>
        </div>

        
    </div>
</div>

