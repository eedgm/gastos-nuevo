<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.balances.edit_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('balances.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-form
                    method="PUT"
                    action="{{ route('balances.update', $balance) }}"
                    class="mt-4"
                >
                    @include('app.balances.form-inputs')

                    <div class="mt-10">
                        <a href="{{ route('balances.index') }}" class="button">
                            <i
                                class="mr-1 icon ion-md-return-left text-primary"
                            ></i>
                            @lang('crud.common.back')
                        </a>

                        <a href="{{ route('balances.create') }}" class="button">
                            <i class="mr-1 icon ion-md-add text-primary"></i>
                            @lang('crud.common.create')
                        </a>

                        <button
                            type="submit"
                            class="float-right button button-primary"
                        >
                            <i class="mr-1 icon ion-md-save"></i>
                            @lang('crud.common.update')
                        </button>
                    </div>
                </x-form>
            </x-partials.card>
        </div>

        <x-partials.card class="mt-5">
            <x-slot name="title">
                Balances
            </x-slot>

            <livewire:balance-calculator :account="$balance->account" :balance="$balance" />
        </x-partials.card>
    </div>
</x-app-layout>
