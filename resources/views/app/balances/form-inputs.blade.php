@php $editing = isset($balance) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full lg:w-3/12">
        <x-inputs.date
            name="date"
            label="Date"
            value="{{ old('date', ($editing ? optional($balance->date)->format('Y-m-d') : '')) }}"
            max="255"
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-3/12">
        <x-inputs.select name="account_id" label="Account" required>
            @php $selected = old('account_id', ($editing ? $balance->account_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Account</option>
            @foreach($accounts as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-3/12">
        <x-inputs.number
            name="total"
            label="Total"
            :value="old('total', ($editing ? $balance->total : ''))"
            step="0.01"
            placeholder="Total"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="flex items-center w-full lg:w-3/12">
        <x-inputs.checkbox
            name="reported"
            label="Reported"
            :checked="old('reported', ($editing ? $balance->reported : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            >{{ old('description', ($editing ? $balance->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
