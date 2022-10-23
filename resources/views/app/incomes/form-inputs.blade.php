@php $editing = isset($income) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="account_id" label="Account" required>
            @php $selected = old('account_id', ($editing ? $income->account_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Account</option>
            @foreach($accounts as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.date
            name="date"
            label="Date"
            value="{{ old('date', ($editing ? optional($income->date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="cost"
            label="Cost"
            :value="old('cost', ($editing ? $income->cost : ''))"
            max="255"
            step="0.01"
            placeholder="Cost"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            >{{ old('description', ($editing ? $income->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
