<x-slot name="header">
        <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2> -->
        <x-nav-link :href="route('settings.edit')" :active="request()->routeIs('settings.edit')" class="sm:ml-05">
            <span>  {{ __('Parameter settings') }} </span>
        </x-nav-link>

  
</x-slot>


<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">


                <form wire:submit.prevent="save" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')

                    <!-- <div class="mb-4">
                        <label for="name" class="block font-medium text-sm text-gray-700">{{ __('Name') }}</label>
                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name"  wire:model.defer="user.name">
                        @error('user.name') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div> -->

                    <div>
                        <label for="price_sale" class="block font-medium text-sm text-gray-700">{{ __('Price Sale') }}</label>
                        <input type="number" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="price_sale"  wire:model.defer="setting.price_sale" min="0.1" step="0.00001">
                        @error('setting.price_sale') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="price_kilogram" class="block font-medium text-sm text-gray-700">{{ __('Price Kilogram') }}</label>
                        <input type="number" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="price_kilogram"  wire:model.defer="setting.price_kilogram" min="0.1" step="0.01">
                        @error('setting.price_kilogram') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="price_liter" class="block font-medium text-sm text-gray-700">{{ __('Price Liter') }}</label>
                        <input type="number" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="price_liter"  wire:model.defer="setting.price_liter" min="0.1" step="0.01">
                        @error('setting.price_liter') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="price_disel" class="block font-medium text-sm text-gray-700">{{ __('Price Disel') }}</label>
                        <input type="number" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="price_disel"  wire:model.defer="setting.price_disel" min="0.1" step="0.01">
                        @error('setting.price_disel') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="price_event" class="block font-medium text-sm text-gray-700">{{ __('Price Event') }}</label>
                        <input type="number" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="price_event"  wire:model.defer="setting.price_event" min="0.1" step="0.01">
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
                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm mt-1 block w-full cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_quotes_help" id="file_quotes" type="file" wire:model.defer="file_quotes">
                        @error('file_quotes') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                        @if ($file_quotes_message) <span class="text-sm text-red-600 space-y-1 mt-2">{{ $file_quotes_message }}</span>@endif
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="file_locations">
                            {{ __('Load addresses file') }} |
                            <a href="{{asset('catalogo-rutas.csv')}}" class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline"  target="_blank" style="color: #007bff; text-decoration: underline; font-size: inherit;"> 
                                {{ __('csv_format') }}
                                <svg  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"> <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /> </svg> 
                            </a>    
                        </label>
                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm mt-1 block w-full cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_locations_help" id="file_locations" type="file" wire:model.defer="file_locations">
                        @error('file_locations') <span class="text-sm text-red-600 space-y-1 mt-2">{{ $message }}</span>@enderror
                        @if ($file_locations_message) <span class="text-sm text-red-600 space-y-1 mt-2">{{ $file_locations_message }}</span>@endif
                    </div>

                  

                    <!-- <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        <span class="font-medium">Success alert!</span> Change a few things up and try submitting again.
                    </div>
                 -->

                    <div class="flex items-center mb-4">
                        <input checked id="checkbox-1" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" >
                        <label for="checkbox-1" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('I am aware that these changes will affect the cost of the quotation.') }} </label>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>

                        @if (session('status') === 'updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600"
                            >{{ __('Saved.') }}</p>
                        @endif

                    </div>
                </form>
            </div>
        </div>

        
    </div>
</div>

