@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 sm:px-6 text-base font-medium leading-5 text-gray-900 focus:outline-none focus:border-orange-700 transition duration-150 ease-in-out bg-orange-act item'
            : 'inline-flex items-center px-1 pt-1 sm:px-6  border-b-2 border-transparent text-base font-medium leading-5 text-gray-500 hover:text-gray-700  focus:outline-none focus:text-gray-700 transition duration-150 ease-in-out item';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
