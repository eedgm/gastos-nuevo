<div>
    <a
        class="ml-3 text-2xl leading-5 text-center text-blue-700 cursor-pointer hover:underline"
        wire:click="newEvent"
        >
        <i class="bx bx-plus"></i>
        <span class="block ml-2 -mt-[5px] text-xs">Evento</span>
    </a>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <h2 class="w-full pb-2 mb-6 text-2xl font-bold text-gray-800 border-b">{{ $modalTitle }}</h2>

            <div class="flex flex-wrap mt-5">
                <div class="w-full px-4 mb-4">
                    <label class="mb-1 text-sm font-bold tracking-wide text-gray-800">Evento</label>
                    <input
                        class="w-full px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded-lg appearance-none focus:outline-none focus:bg-white focus:border-blue-500"
                        type="text"
                        wire:model="expense.description"
                    >
                </div>

                <x-inputs.group class="w-full px-4 mb-4 lg:w-4/12">
                    <x-inputs.datetime
                        name="expense.date"
                        label="Fecha"
                        wire:model.lazy="expenseDate"
                    ></x-inputs.datetime>
                </x-inputs.group>

                <x-inputs.group class="w-full px-4 mb-4 lg:w-4/12">
                    <x-inputs.datetime
                        name="expense.date_to"
                        label="Hasta"
                        wire:model="expenseDateTo"
                    ></x-inputs.datetime>
                </x-inputs.group>

                <x-inputs.group class="w-full px-4 mb-4 lg:w-4/12">
                    <x-inputs.number
                        name="expense.budget"
                        label="Presupuesto ($)"
                        wire:model="expense.budget"
                        step="0.01"
                    ></x-inputs.number>
                </x-inputs.group>

                <x-inputs.group class="w-full lg:w-3/12">
                    <x-inputs.select name="cluster_id" label="Cuentas" wire:model="expense.account_id" wire:change="updateAccountDetails(event.target[event.target.selectedIndex].value)">
                        <option>Cuentas</option>
                        @foreach($accounts as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-inputs.select>
                </x-inputs.group>

                <x-inputs.group class="w-full lg:w-3/12">
                    <x-inputs.select name="cluster_id" label="Agrupación" wire:model="expense.cluster_id">
                        <option>Agrupación</option>
                        @if(!empty($clusters))
                            @foreach($clusters as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        @endif
                    </x-inputs.select>
                </x-inputs.group>

                <x-inputs.group class="w-full lg:w-3/12">
                    <x-inputs.select name="assign_id" label="Rol" wire:model="expense.assign_id">
                        <option>Rol</option>
                        @if(!empty($assigns))
                            @foreach($assigns as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        @endif
                    </x-inputs.select>
                </x-inputs.group>

                <x-inputs.group class="w-full lg:w-3/12">
                    <x-inputs.select name="purpose_id" label="Propósito" wire:model="purpose_id">
                        <option>Propósito</option>
                        @if(!empty($purposes))
                            @foreach($purposes as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        @endif
                    </x-inputs.select>
                </x-inputs.group>
                <div class="flex w-full mt-1 ml-5 ">
                    <input
                        class="mt-1 mr-3"
                        type="checkbox"
                        id="google_calendar"
                        wire:model="expense.google_calendar"
                    >
                    <label for="google_calendar">Publicar en Google Calendar?</label>
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
                wire:click="save"
            >
                <i class="mr-1 icon ion-md-save"></i>
                @lang('crud.common.save')
            </button>
        </div>
    </x-modal>

</div>
