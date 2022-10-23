@php $editing = isset($expense) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full lg:w-4/12">
        <x-inputs.datetime
            name="date"
            label="Date"
            value="{{ old('date', ($editing ? optional($expense->date)->format('Y-m-d\TH:i:s') : '')) }}"
            max="255"
            required
        ></x-inputs.datetime>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-4/12">
        <x-inputs.date
            name="date_to"
            label="Date To"
            value="{{ old('date_to', ($editing ? optional($expense->date_to)->format('Y-m-d') : '')) }}"
            max="255"
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-4/12">
        <x-inputs.number
            name="budget"
            label="Budget"
            :value="old('budget', ($editing ? $expense->budget : ''))"
            max="255"
            step="0.01"
            placeholder="Budget"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            >{{ old('description', ($editing ? $expense->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-4/12">
        <x-inputs.select name="cluster_id" label="Cluster" required>
            @php $selected = old('cluster_id', ($editing ? $expense->cluster_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Cluster</option>
            @foreach($clusters as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-4/12">
        <x-inputs.select name="assign_id" label="Assign" required>
            @php $selected = old('assign_id', ($editing ? $expense->assign_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Assign</option>
            @foreach($assigns as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-4/12">
        <x-inputs.select name="account_id" label="Account" required>
            @php $selected = old('account_id', ($editing ? $expense->account_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Account</option>
            @foreach($accounts as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
