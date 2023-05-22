<div class="mt-1 text-right">
    <a
        href="#"
        class="px-4 py-1.5 text-white bg-sky-500 cursor-pointer rounded-md hover:bg-sky-800"
        wire:click="newInvitation"
        >
        <i class="text-base align-middle bx bx-envelope"></i>
        Invite
    </a>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4 text-left">
            <div class="text-xl font-bold border-b border-gray-200">{{ $modalTitle }}</div>

            @if (session()->has('message'))
                <div class="p-3 mt-2 text-lg italic text-white bg-green-500 shadow-md rounded-xl">
                    {{ session('message') }}
                </div>
            @endif

            <div class="mt-5">
                <div class="grid grid-cols-1 lg:grid-cols-4">
                    <x-inputs.group class="col-span-1 lg:col-span-2">
                        <x-inputs.email
                            name="email"
                            label="Email"
                            maxlength="255"
                            placeholder="email@email.com"
                            required
                            wire:model="email"
                        ></x-inputs.email>
                    </x-inputs.group>

                    <x-inputs.group>
                        <x-inputs.select name="permission" label="Permiso" wire:model="permission">
                            <option value="null" disabled>Tipo de permiso</option>
                            <option value="3">Auxiliar</option>
                            <option value="4">Instituto</option>
                            <option value="5">Secretario</option>
                        </x-inputs.select>
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
                wire:click="send"
            >
                <i class="mr-1 bx bx-send"></i>
                Enviar
            </button>
        </div>
    </x-modal>
</div>
