<div>
    <x-slot name="header">
            <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" class="sm:ml-05">
                <span>  {{ __('List Users') }} </span>
            </x-nav-link>

            <x-nav-link :href="route('users.create')" :active="request()->routeIs('users.create')" >
                <!-- <span class="px-4" > {{ __('Create User') }} </span> -->
                <span class="px-4" > {{ __('Create User') }} </span>
            </x-nav-link>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 ">
                        <x-text-input id="search" name="search" type="text" class="mt-1 block w-full"   placeholder="{{ __('Search by name or user') }}" wire:model="search"/>
                    </div>
            </div>
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
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
