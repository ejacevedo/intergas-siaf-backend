<x-slot name="header" class="px-4">
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

<div>
    {{-- Be like water. --}}
</div>
