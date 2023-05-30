<div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            
        
       
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="search" id="default-search" class="mt-1 block w-full shadow p-4 pl-10 text-gray-900 border border-gray-300 rounded-lg sm:text-md focus:ring-blue-500 focus:border-blue-500 "  placeholder="{{ __('Search by name or user') }}" wire:model="search"d>
                <!-- <button type="submit" class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 ">Search</button> -->
            </div>
        <!-- </form> -->
<!-- 
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"> <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /> </svg>
            <input type="text" name="search" id="search" class="mt-1 block w-full shadow block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-white-50 sm:text-md focus:ring-gray-500 focus:border-gray-500"  placeholder="{{ __('Search by name or user') }}" wire:model="search"> -->
        
            <!-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 ">
                        <input type="text" name="search" id="search" class="mt-1 block w-full shadow block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-white-50 sm:text-md focus:ring-gray-500 focus:border-gray-500"  placeholder="{{ __('Search by name or user') }}" wire:model="search">
                    </div>
            </div> -->
        </div>

        <!-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"> <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /> </svg>
            <input type="text" name="search" id="search" class="mt-1 block w-full shadow block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-white-50 sm:text-md focus:ring-gray-500 focus:border-gray-500"  placeholder="{{ __('Search by name or user') }}" wire:model="search">
        
        </div> -->
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <ul role="list" class="divide-y divide-blue-200">
                        @foreach ($users as $user)
                            <li class="flex justify-between gap-x-6 py-4 border-b border-gray-100">
                                <div class="flex gap-x-4">
                                    <div class="min-w-0 flex-auto">
                                        <p class="text-sm font-semibold leading-6 text-gray-900">{{ $user->name }} - {{ $user->username }}</p>
                                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">
                                            <span class="font-semibold"> {{ __('Status')}}: {{ $user->status ? __('Active') : __('Inactive') }}</span> 
                                            @foreach ($user->roles as $role)
                                            | {{ __($role->name) }}  
                                            @endforeach
                                            </p> 
                                    </div>
                                </div>
                                <div class="hidden sm:flex sm:flex-col sm:items-end">
                                    <a href="{{route('users.edit', $user->id)}}" class="text-sm leading-6 text-gray-900">
                                        <p>Editar</p>
                                    </a>
                                </div>
                            </li>
                        @endforeach
                        
                    
                    </ul>

                    <!-- @if(!count($users)) 
                        <div class="flex flex-col items-center py-20 text-sm leading-6 text-slate-600 md:py-32 lg:py-40">
                            <svg viewBox="0 0 32 32" fill="none" aria-hidden="true" class="h-8 w-8"><path d="m13 13 6 6m0-6-6 6m15-3c0 6.627-5.373 12-12 12S4 22.627 4 16 9.373 4 16 4s12 5.373 12 12Z" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                            <p class="mt-6">We're sorry we don't have icons for <span class="font-semibold text-slate-900">" {{ $search }}"</span>.</p>                       
                        </div>
                    @endif
                    -->

                    <!-- <br> -->
                    <nav aria-label="Page navigation example" class="mt-4">
                        <ul class="pagination justify-content-center">
                            {{ $users->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .page-item.active .page-link {
    background-color: #061F42;
    border-color: #061F42;
}
</style>
