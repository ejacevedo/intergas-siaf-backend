<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">

                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Quotation parameters') }}
                    </h2>

                </header>

                <form wire:submit.prevent="save" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')

                    <div>
                        <div class="relative">
                            <input autocomplete="nope" type="number" class="shadow-sm p-4 block w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " id="price_sale" wire:model.defer="setting.price_sale" min="0.1" step="0.00001" />
                            <label for="price_sale" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white  px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">{{ __('Price Sale') }}</label>
                        </div>
                        @error('setting.price_sale') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <div class="relative">
                            <input autocomplete="nope" type="number" class="shadow-sm p-4 block w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " id="density" wire:model.lazy="setting.density" wire:change="calcLoadCapacityPerLiter()" min="0.1" step="0.01" />
                            <label for="density" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white  px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">{{ __('Density') }}</label>
                        </div>
                        @error('setting.density') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <div class="relative">
                            <input autocomplete="nope" type="number" id="load_capacity_per_kilogram" class="shadow-sm p-4 block w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " wire:model.lazy="setting.load_capacity_per_kilogram" wire:change="calcLoadCapacityPerLiter()" min="0.1" step="0.01" />
                            <label for="load_capacity_per_kilogram" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white  px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">{{ __('Load capacity per kilogram') }}</label>
                        </div>
                        @error('setting.load_capacity_per_kilogram') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <div class="relative">
                            <input aria-label="disabled input" type="number" id="load_capacity_per_liter" class="cursor-not-allowe bg-gray-100 shadow-sm p-4 block w-full text-sm text-gray-900 rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " wire:model.lazy="setting.load_capacity_per_liter" disabled />
                            <label for="load_capacity_per_liter" class="absolute bg-gray-100 text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white  px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">{{ __('Load capacity per Liter') }}</label>
                        </div>
                        @error('setting.load_capacity_per_liter') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>


                    <div>
                        <div class="relative">
                            <input autocomplete="nope" type="number" id="price_disel" class="shadow-sm p-4 block w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " wire:model.defer="setting.price_disel" min="0.1" step="0.01" />
                            <label for="price_disel" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white  px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">{{ __('Price Disel') }}</label>
                        </div>
                        @error('setting.price_disel') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <div class="relative">
                            <input autocomplete="nope" type="number" id="price_event" class="shadow-sm p-4 block w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " wire:model.defer="setting.price_event" min="0.1" step="0.01" />
                            <label for="price_event" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white  px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">{{ __('Price Event') }}</label>
                        </div>
                        @error('setting.price_event') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>


                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="file_routes">
                            {{ __('Load file of routing') }} |
                            <a href="{{asset('rutas.csv')}}" class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline" target="_blank" style="color: #007bff; text-decoration: underline; font-size: inherit;">
                                {{ __('csv_format') }}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                            </a>
                        </label>

                        <input class="block w-full text-lg text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" aria-describedby="file_quotes_help" id="file_routes" type="file" wire:model.defer="file_routes">
                        @error('file_routes') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                        @if ($file_routes_message) <span class="text-sm text-red-600 space-y-1 mt-2">{{ $file_routes_message }}</span>@endif
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700" for="file_addresses">
                            {{ __('Load addresses file') }} |
                            <a href="{{asset('direcciones.csv')}}" class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline" target="_blank" style="color: #007bff; text-decoration: underline; font-size: inherit;">
                                {{ __('csv_format') }}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                            </a>
                        </label>
                        <input class="block w-full text-lg text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" aria-describedby="file_locations_help" id="file_addresses" type="file" wire:model.defer="file_addresses">
                        @error('file_addresses') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                        @if ($file_addresses_message) <span class="text-sm text-red-600 space-y-1 mt-2">{{ $file_addresses_message }}</span>@endif
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button class="nline-flex items-center py-2 bg-orange border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 focus:bg-orange-700 active:bg-orange-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150 primay py-3.5">{{ __('Save') }}</x-primary-button>

                        @if (session('status') === 'updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="aiz flex-shrink-0 inline w-6 h-6 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                            </svg>
                            {{ __('Saved.') }}
                        </p>
                        @endif

                    </div>
                </form>
            </div>
        </div>


    </div>
</div>