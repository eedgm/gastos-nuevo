<div>
    <x-modal wire:model="showingModalAccount">
        <div class="px-6 py-4 text-left">
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
                                    <option data-value="{{ $value }}">{{ $value }}</option>
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
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                        @if (!is_null($account))
                            <div class="text-lg text-black font-ital">
                                Para continuar es necesario Agregar las siguietes características a esta cuenta
                            </div>
                            @can('view-any', App\Models\Assign::class)
                            <x-partials.card class="mt-5">
                                <x-slot name="title"> Assigns </x-slot>

                                <livewire:account-assigns-detail :account="$account" />
                            </x-partials.card>
                            @endcan @can('view-any', App\Models\Purpose::class)
                            <x-partials.card class="mt-5">
                                <x-slot name="title"> Purposes </x-slot>

                                <livewire:account-purposes-detail :account="$account" />
                            </x-partials.card>
                            @endcan @can('view-any', App\Models\Cluster::class)
                            <x-partials.card class="mt-5">
                                <x-slot name="title"> Clusters </x-slot>

                                <livewire:account-clusters-detail :account="$account" />
                            </x-partials.card>
                            @endcan
                        @endif
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
                wire:click="$toggle('showingModalAccount')"
            >
                <i class="mr-1 bx bx-edit-alt"></i>
                @lang('crud.common.update')
            </button>
        </div>
    </x-modal>
</div>
