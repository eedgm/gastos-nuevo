@php $editing = isset($executed) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.number
            name="cost"
            label="Cost"
            :value="old('cost', ($editing ? $executed->cost : ''))"
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
            >{{ old('description', ($editing ? $executed->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="expense_id" label="Expense" required>
            @php $selected = old('expense_id', ($editing ? $executed->expense_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Expense</option>
            @foreach($expenses as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="type_id" label="Type" required>
            @php $selected = old('type_id', ($editing ? $executed->type_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Type</option>
            @foreach($types as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
