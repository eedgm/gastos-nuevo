<div>
    <div>
        @can('create', App\Models\Executed::class)
        <button class="button" wire:click="newExecuted">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\Executed::class)
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
                        <x-inputs.number
                            name="executed.cost"
                            label="Cost"
                            wire:model="executed.cost"
                            max="255"
                            step="0.01"
                            placeholder="Cost"
                        ></x-inputs.number>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.textarea
                            name="executed.description"
                            label="Description"
                            wire:model="executed.description"
                            maxlength="255"
                        ></x-inputs.textarea>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.select
                            name="executed.expense_id"
                            label="Expense"
                            wire:model="executed.expense_id"
                        >
                            <option value="null" disabled>Please select the Expense</option>
                            @foreach($expensesForSelect as $value => $label)
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
                    <th class="px-4 py-3 text-right">
                        @lang('crud.type_executeds.inputs.cost')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.type_executeds.inputs.description')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.type_executeds.inputs.expense_id')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($executeds as $executed)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{ $executed->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $executed->cost ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $executed->description ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($executed->expense)->date_to ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $executed)
                            <button
                                type="button"
                                class="button"
                                wire:click="editExecuted({{ $executed->id }})"
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
                    <td colspan="4">
                        <div class="mt-10 px-4">{{ $executeds->render() }}</div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
