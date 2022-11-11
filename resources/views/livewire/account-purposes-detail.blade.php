<div>
    <div class="flex justify-end -mt-10">
        @can('create', App\Models\Purpose::class)
        <button class="button" wire:click="newPurpose">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.attach')
        </button>
        @endcan
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-5">
                <div>
                    <x-inputs.group class="w-full">
                        <x-inputs.datalist name="purpose_id" label="Purpose" required wire:model="purpose_id">
                            @foreach($purposesForSelect as $value => $label)
                            <option>{{ $label }}</option>
                            @endforeach
                        </x-inputs.datalist>
                    </x-inputs.group>
                    <div x-show="$wire.newProposal">
                        <x-inputs.group class="w-full">
                            <x-inputs.select
                                name="color_id"
                                label="Colors"
                                wire:model="color_id"
                            >
                                <option value="null" disabled>Select Color</option>
                                @foreach($colors as $value => $label)
                                <option value="{{ $value }}"  >{{ $label }}</option>
                                @endforeach
                            </x-inputs.select>
                        </x-inputs.group>
                    </div>
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

    <div class="block w-full mt-4 overflow-auto scrolling-touch">
        @foreach ($accountPurposes as $purpose)
            <div
                class="inline-flex items-center px-3 py-1 text-xs font-bold text-red-700 bg-red-200 rounded-full leading-sm"
            >
                {{ $purpose->name ?? '-' }}
                @can('delete-any', App\Models\Purpose::class)
                    <i
                        class="bx bx-x"
                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                        wire:click="detach({{ $purpose->id }})"
                        >
                    </i>
                @endcan
            </div>
        @endforeach
    </div>
</div>
