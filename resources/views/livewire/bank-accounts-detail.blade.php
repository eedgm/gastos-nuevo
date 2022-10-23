<div>
    <div>
        @can('create', App\Models\Account::class)
        <button class="button" wire:click="newAccount">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\Account::class)
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
                        <x-inputs.text
                            name="account.name"
                            label="Name"
                            wire:model="account.name"
                            maxlength="255"
                            placeholder="Name"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.textarea
                            name="account.description"
                            label="Description"
                            wire:model="account.description"
                            maxlength="255"
                        ></x-inputs.textarea>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.text
                            name="account.number"
                            label="Number"
                            wire:model="account.number"
                            maxlength="255"
                            placeholder="Number"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.select
                            name="account.type"
                            label="Type"
                            wire:model="account.type"
                        >
                            <option value="Ahorro" {{ $selected == 'Ahorro' ? 'selected' : '' }} >Ahorro</option>
                            <option value="Corriente" {{ $selected == 'Corriente' ? 'selected' : '' }} >Corriente</option>
                        </x-inputs.select>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.text
                            name="account.owner"
                            label="Owner"
                            wire:model="account.owner"
                            maxlength="255"
                            placeholder="Owner"
                        ></x-inputs.text>
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
                        @lang('crud.bank_accounts.inputs.name')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.bank_accounts.inputs.description')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.bank_accounts.inputs.number')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.bank_accounts.inputs.type')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.bank_accounts.inputs.owner')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($accounts as $account)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{ $account->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $account->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $account->description ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $account->number ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $account->type ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $account->owner ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $account)
                            <button
                                type="button"
                                class="button"
                                wire:click="editAccount({{ $account->id }})"
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
                    <td colspan="6">
                        <div class="mt-10 px-4">{{ $accounts->render() }}</div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
