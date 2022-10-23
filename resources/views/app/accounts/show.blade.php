<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.accounts.show_title')
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

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.accounts.inputs.name')
                        </h5>
                        <span>{{ $account->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.accounts.inputs.number')
                        </h5>
                        <span>{{ $account->number ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.accounts.inputs.type')
                        </h5>
                        <span>{{ $account->type ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.accounts.inputs.owner')
                        </h5>
                        <span>{{ $account->owner ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.accounts.inputs.bank_id')
                        </h5>
                        <span>{{ optional($account->bank)->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.accounts.inputs.description')
                        </h5>
                        <span>{{ $account->description ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('accounts.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Account::class)
                    <a href="{{ route('accounts.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
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
            @endcan @can('view-any', App\Models\account_user::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Users </x-slot>

                <livewire:account-users-detail :account="$account" />
            </x-partials.card>
            @endcan @can('view-any', App\Models\account_assign::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Assigns </x-slot>

                <livewire:account-assigns-detail :account="$account" />
            </x-partials.card>
            @endcan @can('view-any', App\Models\account_purpose::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Purposes </x-slot>

                <livewire:account-purposes-detail :account="$account" />
            </x-partials.card>
            @endcan @can('view-any', App\Models\account_cluster::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Clusters </x-slot>

                <livewire:account-clusters-detail :account="$account" />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-app-layout>
