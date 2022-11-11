@props([
    'name',
    'label',
    'value',
])

<label for="{{ $name }}">{{ $label }}</label>
<input
    list="{{ $name.'s' }}"
    id="{{ $name }}"
    name="{{ $name }}"
    {{ ($required ?? false) ? 'required' : '' }}
    {{ $attributes->merge(['class' => 'block appearance-none w-full py-1 px-2 text-base leading-normal text-gray-800 border border-gray-200 rounded']) }}
    >

<datalist id="{{ $name.'s' }}">
    {{ $slot }}
</datalist>
