<div>
    <div>
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
                        <x-inputs.select
                            name="purpose_id"
                            label="Purpose"
                            wire:model="purpose_id"
                        >
                            <option value="null" disabled>Please select the Purpose</option>
                            @foreach($purposesForSelect as $value => $label)
                            <option value="{{ $value }}"  >{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.text
                            name="purpose_name"
                            label="Name"
                            wire:model="purpose_name"
                            maxlength="255"
                            placeholder="Purpose Name"
                        ></x-inputs.text>
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
        <table class="w-full max-w-full mb-4 bg-transparent">
            <thead class="text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.account_purposes.inputs.purpose_id')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($accountPurposes as $purpose)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        {{ $purpose->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 70px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('delete-any', App\Models\Purpose::class)
                            <button
                                class="button button-danger"
                                onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                wire:click="detach({{ $purpose->id }})"
                            >
                                <i
                                    class="mr-1 icon ion-md-trash text-primary"
                                ></i>
                                @lang('crud.common.detach')
                            </button>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <div class="px-4 mt-10">
                            {{ $accountPurposes->render() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
