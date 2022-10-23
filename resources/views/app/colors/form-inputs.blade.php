@php $editing = isset($color) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $color->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="color"
            label="Color"
            :value="old('color', ($editing ? $color->color : ''))"
            maxlength="9"
            placeholder="Color"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
