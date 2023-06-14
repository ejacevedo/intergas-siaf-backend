<div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" id="default-search" class="mt-1 block w-full shadow p-4 pl-10 text-gray-900 border border-gray-300 rounded-lg sm:text-md focus:ring-gray-500 focus:border-gray-500"  placeholder="{{ __('Search by name or user') }}" wire:model="filter">
                <a type="submit" role="button" class="text-white absolute right-2.5 bottom-2.5 bg-orange-900 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-4 py-2 pl-6" href="{{ route('users.create') }} ">
                    <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none px-1 ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"  fill="none" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    
                    {{ __('Create User') }}
                </a>
            </div>

        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div wire:loading class="ct-loading">
                    </div>
                    <ul role="list" class="divide-y divide-blue-200">
                        @foreach ($users as $user)
                            <li class="flex justify-between gap-x-6 py-4 border-b border-gray-100">
                                <div class="flex gap-x-4">
                                    <div class="min-w-0 flex-auto">
                                        <p class="text-sm leading-6"> <span class="font-semibold text-gray-600"> {{ $user->name }}  </span> - {{ $user->username }}</p> 
                                        <p class="mt-1 truncate text-xs leading-5">
                                            <span class="font-semibold text-gray-600"> {{ __('Status')}}</span>: <span> {{ $user->status ? __('Active') : __('Inactive') }} </span> |
                                            @foreach ($user->roles as $role)
                                                <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">{{ __($role->name) }}  </span>
                                            @endforeach
                                            </p> 
                                    </div>
                                </div>
                                <div class="sm:flex sm:flex-col sm:items-end">
                                    <a href="{{route('users.edit', $user->id)}}" class="text-sm leading-6 text-gray-900">
                                        <p class="font-semibold text-gray-600 underline">Editar</p>
                                    </a>
                                </div>
                            </li>
                        @endforeach
                        
                    
                    </ul>

                    @if(!count($users))
                        @if($filter != '')
                        <main class="grid min-h-full place-items-center text-center bg-white px-6 py-24 sm:py-32 lg:px-8">
                                <svg viewBox="0 0 32 32" fill="none" aria-hidden="true" class="h-8 w-8 mb-4"><path d="m13 13 6 6m0-6-6 6m15-3c0 6.627-5.373 12-12 12S4 22.627 4 16 9.373 4 16 4s12 5.373 12 12Z" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                <h2 class="font-semibold text-slate-900"> {{ __('no_results_found') }}</h2>
                                <p class="mt-2 text-sm leading-6 text-slate-600"> {!! __("no_results_found_detail", [ 'attribute' => $filter ]) !!} </p>
                        </main>
                        @else
                        <main class="grid min-h-full place-items-center text-center bg-white px-6 py-24 sm:py-32 lg:px-8">
                                <svg viewBox="0 0 32 32" fill="none" aria-hidden="true" class="h-8 w-8 mb-4"><path d="m13 13 6 6m0-6-6 6m15-3c0 6.627-5.373 12-12 12S4 22.627 4 16 9.373 4 16 4s12 5.373 12 12Z" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                <h2 class="font-semibold text-slate-900">  {{ __('no_results_found') }}</h2>
                        </main>
                        @endif
                    @else

                    <nav aria-label="Page navigation example" class="mt-4">
                        <ul class="pagination justify-content-center">
                            {{ $users->links() }}
                        </ul>
                    </nav>
                    @endif
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
