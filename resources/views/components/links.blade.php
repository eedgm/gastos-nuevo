@props(['active'])

@php
$classes = ($active ?? false)
            ? 'ml-3 leading-5 text-2xl text-green-700 hover:underline'
            : 'ml-3 leading-5 text-2xl text-blue-700 hover:underline';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
