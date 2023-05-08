<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <ul role="list" class="divide-y divide-blue-200">
                    @foreach ($users as $user)
                        <li class="flex justify-between gap-x-6 py-4">
                            <div class="flex gap-x-4">
                                <div class="min-w-0 flex-auto">
                                    <p class="text-sm font-semibold leading-6 text-gray-900">{{ $user->name }} - {{ $user->username }}</p>
                                    <p class="mt-1 truncate text-xs leading-5 text-gray-500">Super Admin - <span class="font-semibold"> {{ $user->status ? __('Active') : __('Inactive') }}</span> </p>
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

