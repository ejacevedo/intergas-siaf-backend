
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

                    <!-- <div class="mb-4">
                        <label for="name" class="block font-medium text-sm text-gray-700">{{ __('Name') }}</label>
                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name"  wire:model.defer="user.name">
                        @error('user.name') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div> -->

                    <div>
                        <div class="relative">
                            <input autocomplete="nope" type="number" class="shadow-sm p-4 block w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " id="price_sale"  wire:model.defer="setting.price_sale" min="0.1" step="0.00001" />
                            <label for="price_sale" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white  px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">{{ __('Price Sale') }}</label>
                        </div>
                        @error('setting.price_sale') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>


                    <div>
                        <div class="relative">
                            <input autocomplete="nope" type="number" id="price_kilogram"  class="shadow-sm p-4 block w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " wire:model.defer="setting.price_kilogram" min="0.1" step="0.01" />
                            <label for="price_kilogram" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white  px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">{{ __('Price Kilogram') }}</label>
                        </div>
                        @error('setting.price_kilogram') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>


                    <div>
                        <div class="relative">
                            <input autocomplete="nope" type="number" id="price_liter"  class="shadow-sm p-4 block w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " wire:model.defer="setting.price_liter" min="0.1" step="0.01" />
                            <label for="price_liter" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white  px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">{{ __('Price Liter') }}</label>
                        </div>
                        @error('setting.price_liter') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>


                    <div>
                        <div class="relative">
                            <input autocomplete="nope" type="number" id="price_disel"  class="shadow-sm p-4 block w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" "  wire:model.defer="setting.price_disel" min="0.1" step="0.01"/>
                            <label for="price_disel" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white  px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">{{ __('Price Disel') }}</label>
                        </div>
                        @error('setting.price_disel') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <div class="relative">
                            <input autocomplete="nope" type="number" id="price_event"  class="shadow-sm p-4 block w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " wire:model.defer="setting.price_event" min="0.1" step="0.01"/>
                            <label for="price_event" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white  px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">{{ __('Price Event') }}</label>
                        </div>
                        @error('setting.price_event') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>


           

                    <!-- <div>
                        <label for="price_event" class="block font-medium text-sm text-gray-700">{{ __('Price Event') }}</label>
                        <input type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="price_event"  wire:model.defer="setting.price_event">
                        @error('setting.price_event') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div> -->

                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="file_quotes">
                        {{ __('Load file of routing - expenses') }} |
                            <a href="{{asset('rutas-gastos.csv')}}" class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline"  target="_blank" style="color: #007bff; text-decoration: underline; font-size: inherit;"> 
                                {{ __('csv_format') }}
                                <svg  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"> <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /> </svg> 
                            </a>    
                        </label>

                        <!-- <label class="block font-medium text-sm text-gray-700" for="file_quotes">{{ __('Load file of routing - expenses') }} </label> -->
                        <input class="block w-full text-lg text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" aria-describedby="file_quotes_help" id="file_quotes" type="file" wire:model.defer="file_quotes">
                        @error('file_quotes') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                        @if ($file_quotes_message) <span class="text-sm text-red-600 space-y-1 mt-2">{{ $file_quotes_message }}</span>@endif
                    </div>

                    <!-- <div class="flex items-center justify-center w-full">
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                <p class="mb-2 text-sm text-gray-500 "><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                            </div>
                            <input id="dropzone-file" type="file" class="hidden" />
                        </label>
                    </div>  -->

                    <!-- <div class="max-w-xl">
                        <label
                            class="flex justify-center w-full h-32 px-4 transition bg-white border-2 border-gray-300 border-dashed rounded-md appearance-none cursor-pointer hover:border-gray-400 focus:outline-none">
                            <span class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <span class="font-medium text-gray-600">
                                    Drop files to Attach, or
                                    <span class="text-blue-600 underline">browse</span>
                                </span>
                            </span>
                            <input type="file" name="file_upload" class="hidden">
                        </label>
                    </div> -->

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700" for="file_locations">
                            {{ __('Load addresses file') }} |
                            <a href="{{asset('catalogo-rutas.csv')}}" class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline"  target="_blank" style="color: #007bff; text-decoration: underline; font-size: inherit;"> 
                                {{ __('csv_format') }}
                                <svg  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"> <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /> </svg> 
                            </a>    
                        </label>
                        <input class="block w-full text-lg text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" aria-describedby="file_locations_help" id="file_locations" type="file" wire:model.defer="file_locations">
                        @error('file_locations') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                        @if ($file_locations_message) <span class="text-sm text-red-600 space-y-1 mt-2">{{ $file_locations_message }}</span>@endif
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button class="nline-flex items-center py-2 bg-orange border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 focus:bg-orange-700 active:bg-orange-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150 primay py-3.5">{{ __('Save') }}</x-primary-button>

                        @if (session('status') === 'updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600"
                            >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="aiz flex-shrink-0 inline w-6 h-6 mr-1"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path></svg> {{ __('Saved.') }}
                            {{ __('Saved.') }}
                        </p>
                        @endif

                    </div>
                </form>
            </div>
        </div>

        
    </div>
</div>

