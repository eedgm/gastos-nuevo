<div class="inline-flex mt-1 md:mt-0">
    <a wire:click="addBalance({{ $account->id }})" class="px-5 py-2 text-sm text-white rounded cursor-pointer bg-cyan-600 hover:bg-blue-900">
        <i class="bx {{ $balance_icon }}"></i> {{ $balance_boton }}
    </a>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="flex flex-col flex-wrap mt-5">
                <div>
                    <x-inputs.group class="w-full">
                        <x-inputs.date
                            name="balanceDate"
                            label="Fecha"
                            wire:model="balanceDate"
                        ></x-inputs.date>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="total"
                            label="Total"
                            step="0.01"
                            placeholder="Total"
                            wire:model="balance.total"
                        ></x-inputs.number>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.textarea
                            name="description"
                            label="Description"
                            wire:model="balance.description"
                            >
                            </x-inputs.textarea
                        >
                    </x-inputs.group>
                </div>
            </div>

            @if (isset($balance))
            <div class="mt-5">
                <livewire:balance-calculator :account="$account" :balance="$balance" key="$account->id" />
            </div>
            @endif

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
                wire:click="save"
            >
                <i class="mr-1 icon ion-md-save"></i>
                @lang('crud.common.save')
            </button>
        </div>
    </x-modal>
</div>
