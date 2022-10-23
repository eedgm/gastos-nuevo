<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.accounts.edit_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('accounts.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-form
                    method="PUT"
                    action="{{ route('accounts.update', $account) }}"
                    class="mt-4"
                >
                    @include('app.accounts.form-inputs')

                    <div class="mt-10">
                        <a href="{{ route('accounts.index') }}" class="button">
                            <i
                                class="
                                    mr-1
                                    icon
                                    ion-md-return-left
                                    text-primary
                                "
                            ></i>
                            @lang('crud.common.back')
                        </a>

                        <a href="{{ route('accounts.create') }}" class="button">
                            <i class="mr-1 icon ion-md-add text-primary"></i>
                            @lang('crud.common.create')
                        </a>

                        <button
                            type="submit"
                            class="button button-primary float-right"
                        >
                            <i class="mr-1 icon ion-md-save"></i>
                            @lang('crud.common.update')
                        </button>
                    </div>
                </x-form>
            </x-partials.card>

            @can('view-any', App\Models\Expense::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Expenses </x-slot>

                <livewire:account-expenses-detail :account="$account" />
            </x-partials.card>
            @endcan @can('view-any', App\Models\Income::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Incomes </x-slot>

                <livewire:account-incomes-detail :account="$account" />
            </x-partials.card>
            @endcan @can('view-any', App\Models\User::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Users </x-slot>

                <livewire:account-users-detail :account="$account" />
            </x-partials.card>
            @endcan @can('view-any', App\Models\Assign::class)
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
        </div>
    </div>
</x-app-layout>
