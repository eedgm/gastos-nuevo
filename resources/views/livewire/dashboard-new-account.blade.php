<div>
    <x-partials.card class="w-full lg:w-2/12">
        <button
            class="w-full px-5 py-3 text-white bg-green-500 rounded-lg text-md hover:bg-green-700"
            wire:click="addAccount()"
        >
            <i class="bx bx-plus"></i> Nueva Cuenta
        </button>
    </x-partials.card>

    <x-modal wire:model="showingModalAccount">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-5">
                <div class="grid grid-cols-1 lg:grid-cols-4">
                    <x-inputs.group class="col-span-1 lg:col-span-2">
                        <x-inputs.text
                            name="name"
                            label="Name"
                            maxlength="255"
                            placeholder="Name"
                            required
                            wire:model="account.name"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group>
                        <x-inputs.text
                            name="number"
                            label="Number"
                            maxlength="255"
                            placeholder="Number"
                            required
                            wire:model="account.number"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group>
                        <x-inputs.select name="type" label="Type" wire:model="account.type">
                            <option value="Ahorro">Ahorro</option>
                            <option value="Corriente">Corriente</option>
                        </x-inputs.select>
                    </x-inputs.group>

                    <x-inputs.group class="col-span-1 lg:col-span-2">
                        <x-inputs.text
                            name="owner"
                            label="Owner"
                            maxlength="255"
                            placeholder="Owner"
                            wire:model="account.owner"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-span-1 lg:col-span-2">
                        <x-inputs.datalist name="bank_id" label="Bank" required wire:model="account.bank_id">
                            @foreach($banks as $value => $label)
                                <option value="{{ $label }}">{{ $label }}</option>
                            @endforeach
                        </x-inputs.datalist>
                    </x-inputs.group>

                    <x-inputs.group class="col-span-1 lg:col-span-4">
                        <x-inputs.textarea
                            name="description"
                            label="Description"
                            wire:model="account.description"
                            >
                        </x-inputs.textarea
                        >
                    </x-inputs.group>
                </div>
            </div>
        </div>

        <div class="flex justify-between px-6 py-4 bg-gray-50">
            <button
                type="button"
                class="button"
                wire:click="$toggle('showingModalAccount')"
            >
                <i class="mr-1 icon ion-md-close"></i>
                @lang('crud.common.cancel')
            </button>

            <button
                type="button"
                class="button button-primary"
                wire:click="saveAccount"
            >
                <i class="mr-1 icon ion-md-save"></i>
                @lang('crud.common.save')
            </button>
        </div>
    </x-modal>
</div>
