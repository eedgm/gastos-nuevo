@props(['active', 'title'])

@php
$classes = ($active ?? false)
            ? 'ml-3 leading-5 text-2xl text-green-700 hover:underline text-center'
            : 'ml-3 leading-5 text-2xl text-blue-700 hover:underline text-center';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}<span class="hidden text-xs md:block">{{ $title }}</span></a>
