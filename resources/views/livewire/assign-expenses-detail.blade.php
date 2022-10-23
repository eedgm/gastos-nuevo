<div>
    <div>
        @can('create', App\Models\Expense::class)
        <button class="button" wire:click="newExpense">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\Expense::class)
        <button
            class="button button-danger"
             {{ empty($selected) ? 'disabled' : '' }} 
            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
            wire:click="destroySelected"
        >
            <i class="mr-1 icon ion-md-trash text-primary"></i>
            @lang('crud.common.delete_selected')
        </button>
        @endcan
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-5">
                <div>
                    <x-inputs.group class="w-full">
                        <x-inputs.datetime
                            name="expense.date"
                            label="Date"
                            wire:model="expense.date"
                            max="255"
                        ></x-inputs.datetime>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.date
                            name="expenseDateTo"
                            label="Date To"
                            wire:model="expenseDateTo"
                            max="255"
                        ></x-inputs.date>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.textarea
                            name="expense.description"
                            label="Description"
                            wire:model="expense.description"
                            maxlength="255"
                        ></x-inputs.textarea>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.select
                            name="expense.cluster_id"
                            label="Cluster"
                            wire:model="expense.cluster_id"
                        >
                            <option value="null" disabled>Please select the Cluster</option>
                            @foreach($clustersForSelect as $value => $label)
                            <option value="{{ $value }}"  >{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="expense.budget"
                            label="Budget"
                            wire:model="expense.budget"
                            max="255"
                            step="0.01"
                            placeholder="Budget"
                        ></x-inputs.number>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.select
                            name="expense.account_id"
                            label="Account"
                            wire:model="expense.account_id"
                        >
                            <option value="null" disabled>Please select the Account</option>
                            @foreach($accountsForSelect as $value => $label)
                            <option value="{{ $value }}"  >{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 flex justify-between">
            <button
                type="button"
                class="button"
                wire:click="$toggle('showingModal')"
            >
                <i class="mr-1 icon ion-md-close"></i>
                @lang('crud.common.cancel')
            </button>

            <button
                type="button"
                class="button button-primary"
                wire:click="save"
            >
                <i class="mr-1 icon ion-md-save"></i>
                @lang('crud.common.save')
            </button>
        </div>
    </x-modal>

    <div class="block w-full overflow-auto scrolling-touch mt-4">
        <table class="w-full max-w-full mb-4 bg-transparent">
            <thead class="text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left w-1">
                        <input
                            type="checkbox"
                            wire:model="allSelected"
                            wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}"
                        />
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.assign_expenses.inputs.date')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.assign_expenses.inputs.date_to')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.assign_expenses.inputs.description')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.assign_expenses.inputs.cluster_id')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.assign_expenses.inputs.budget')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.assign_expenses.inputs.account_id')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($expenses as $expense)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{ $expense->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $expense->date ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $expense->date_to ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $expense->description ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($expense->cluster)->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $expense->budget ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($expense->account)->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $expense)
                            <button
                                type="button"
                                class="button"
                                wire:click="editExpense({{ $expense->id }})"
                            >
                                <i class="icon ion-md-create"></i>
                            </button>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7">
                        <div class="mt-10 px-4">{{ $expenses->render() }}</div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
