@php $editing = isset($purpose) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $purpose->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="code"
            label="Code"
            :value="old('code', ($editing ? $purpose->code : ''))"
            maxlength="255"
            placeholder="Code"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="color_id" label="Color" required>
            @php $selected = old('color_id', ($editing ? $purpose->color_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Color</option>
            @foreach($colors as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
