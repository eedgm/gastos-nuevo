@php $editing = isset($account) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full lg:w-4/12">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $account->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-4/12">
        <x-inputs.text
            name="number"
            label="Number"
            :value="old('number', ($editing ? $account->number : ''))"
            maxlength="255"
            placeholder="Number"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-4/12">
        <x-inputs.select name="type" label="Type">
            @php $selected = old('type', ($editing ? $account->type : '')) @endphp
            <option value="Ahorro" {{ $selected == 'Ahorro' ? 'selected' : '' }} >Ahorro</option>
            <option value="Corriente" {{ $selected == 'Corriente' ? 'selected' : '' }} >Corriente</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-6/12">
        <x-inputs.text
            name="owner"
            label="Owner"
            :value="old('owner', ($editing ? $account->owner : ''))"
            maxlength="255"
            placeholder="Owner"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-6/12">
        <x-inputs.select name="bank_id" label="Bank" required>
            @php $selected = old('bank_id', ($editing ? $account->bank_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Bank</option>
            @foreach($banks as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            >{{ old('description', ($editing ? $account->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
