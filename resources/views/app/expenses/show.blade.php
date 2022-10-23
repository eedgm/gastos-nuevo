<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.expenses.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('expenses.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.expenses.inputs.date')
                        </h5>
                        <span>{{ $expense->date ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.expenses.inputs.date_to')
                        </h5>
                        <span>{{ $expense->date_to ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.expenses.inputs.budget')
                        </h5>
                        <span>{{ $expense->budget ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.expenses.inputs.description')
                        </h5>
                        <span>{{ $expense->description ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.expenses.inputs.cluster_id')
                        </h5>
                        <span
                            >{{ optional($expense->cluster)->name ?? '-'
                            }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.expenses.inputs.assign_id')
                        </h5>
                        <span
                            >{{ optional($expense->assign)->name ?? '-' }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.expenses.inputs.account_id')
                        </h5>
                        <span
                            >{{ optional($expense->account)->name ?? '-'
                            }}</span
                        >
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('expenses.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Expense::class)
                    <a href="{{ route('expenses.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>

            @can('view-any', App\Models\Executed::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Executeds </x-slot>

                <livewire:expense-executeds-detail :expense="$expense" />
            </x-partials.card>
            @endcan @can('view-any', App\Models\expense_purpose::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Purposes </x-slot>

                <livewire:expense-purposes-detail :expense="$expense" />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-app-layout>
