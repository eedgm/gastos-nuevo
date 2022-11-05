<div>
    <a wire:click="addIncome({{ $account->id }})" class="w-40 px-5 py-2 text-sm text-white bg-blue-500 rounded cursor-pointer hover:bg-blue-900">
        <i class="bx bx-plus"></i> New Income
    </a>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-5">
                <div>
                    <x-inputs.group class="w-full">
                        <x-inputs.date
                            name="incomeDate"
                            label="Date"
                            wire:model="incomeDate"
                            max="255"
                        ></x-inputs.date>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="income.cost"
                            label="Cost"
                            wire:model="income.cost"
                            max="255"
                            step="0.01"
                            placeholder="Cost"
                        ></x-inputs.number>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.textarea
                            name="income.description"
                            label="Description"
                            wire:model="income.description"
                            maxlength="255"
                        ></x-inputs.textarea>
                    </x-inputs.group>
                </div>
            </div>
        </div>

        <div class="flex justify-between px-6 py-4 bg-gray-50">
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
                wire:click="saveIncome"
            >
                <i class="mr-1 icon ion-md-save"></i>
                @lang('crud.common.save')
            </button>
        </div>
    </x-modal>
</div>
