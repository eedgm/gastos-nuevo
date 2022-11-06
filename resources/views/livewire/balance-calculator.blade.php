<div>
    <div>
        @can('create', App\Models\Balance::class)
        <button class="button" wire:click="newBalance">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.attach')
        </button>
        @endcan
    </div>
    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-5">
                <h1 class="text-lg bold">Incomes</h1>
                <table class="w-full max-w-full mb-4 bg-transparent">
                    <thead class="text-gray-700">
                        <tr>
                            <th class="w-1 px-4 py-3 text-left">
                                <input
                                    type="checkbox"
                                    wire:model="allSelectedIncomes"
                                    wire:click="toggleFullSelectionIncomes"
                                    title="{{ trans('crud.common.select_all') }}"
                                />
                            </th>
                            <th class="px-4 py-3 text-left">
                                @lang('crud.incomes.inputs.date')
                            </th>
                            <th class="px-4 py-3 text-left">
                                @lang('crud.incomes.inputs.description')
                            </th>
                            <th class="px-4 py-3 text-right">
                                @lang('crud.incomes.inputs.cost')
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        @foreach ($incomes as $income)
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-3 text-left">
                                <input
                                    type="checkbox"
                                    value="{{ $income->id }}"
                                    wire:model="selectedIncome"
                                />
                            </td>
                            <td class="px-4 py-3 text-left">
                                {{ $income->date ? date('Y-m-d', strtotime($income->date)) : '-'}}
                            </td>
                            <td class="px-4 py-3 text-left">
                                {{ $income->description ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                {{ $income->cost ?? '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <h1 class="text-lg bold">Expenses</h1>
                <table class="w-full max-w-full mb-4 bg-transparent">
                    <thead class="text-gray-700">
                        <tr>
                            <th class="w-1 px-4 py-3 text-left">
                                <input
                                    type="checkbox"
                                    wire:model="allSelectedExpenses"
                                    wire:click="toggleFullSelectionExpenses"
                                    title="{{ trans('crud.common.select_all') }}"
                                />
                            </th>
                            <th class="px-4 py-3 text-left">
                                @lang('crud.expenses.inputs.date')
                            </th>
                            <th class="px-4 py-3 text-left">
                                @lang('crud.expenses.inputs.description')
                            </th>
                            <th class="px-4 py-3 text-left">
                                @lang('crud.expenses.inputs.cluster_id')
                            </th>
                            <th class="px-4 py-3 text-left">
                                @lang('crud.expenses.inputs.assign_id')
                            </th>
                            <th class="px-4 py-3 text-right">
                                @lang('crud.expenses.total')
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        @foreach ($expenses as $expense)
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-3 text-left">
                                    <input
                                        type="checkbox"
                                        value="{{ $expense->id }}"
                                        wire:model="selectedExpense"
                                    />
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $expense->date ? date('Y-m-d', strtotime($expense->date)) : '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $expense->description ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($expense->cluster)->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($expense->assign)->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ optional($expense->executeds)->sum('cost') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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

    <table class="w-full max-w-full mb-4 bg-transparent">
        <thead class="text-gray-700">
            <tr>
                <th class="px-4 py-3 text-left">
                    @lang('crud.incomes.inputs.date')
                </th>
                <th class="px-4 py-3 text-left">
                    @lang('crud.incomes.inputs.description')
                </th>
                <th class="px-4 py-3 text-right">
                    @lang('crud.incomes.inputs.cost')
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody class="text-gray-600">
            @foreach ($incomes_result as $income)
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-3 text-left">
                    {{ $income->date ? date('Y-m-d', strtotime($income->date)) : '-'}}
                </td>
                <td class="px-4 py-3 text-left">
                    {{ $income->description ?? '-' }}
                </td>
                <td class="px-4 py-3 text-right">
                    {{ $income->cost }}
                </td>
                <td>
                    <i
                        class="cursor-pointer bx bx-x hover:text-blue-600"
                        wire:click="removeIncome({{ $income->id }})"
                        >
                    </i>
                </td>
            </tr>
            @php $incomes_total += $income->cost @endphp
            @endforeach
        </tbody>
    </table>

    <div class="w-full pr-10 text-right">
        <span class="px-10 py-2 text-white bg-blue-700">Total: $ {{ $incomes_total }}</span>
    </div>

    <table class="w-full max-w-full mb-4 bg-transparent">
        <thead class="text-gray-700">
            <tr>
                <th class="px-4 py-3 text-left">
                    @lang('crud.expenses.inputs.date')
                </th>
                <th class="px-4 py-3 text-left">
                    @lang('crud.expenses.inputs.description')
                </th>
                <th class="px-4 py-3 text-left">
                    @lang('crud.expenses.inputs.cluster_id')
                </th>
                <th class="px-4 py-3 text-left">
                    @lang('crud.expenses.inputs.assign_id')
                </th>
                <th class="px-4 py-3 text-right">
                    @lang('crud.expenses.total')
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody class="text-gray-600">
            @foreach ($expenses_result as $expense)
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-3 text-left">
                    {{ $expense->date ? date('Y-m-d', strtotime($expense->date)) : '-' }}
                </td>
                <td class="px-4 py-3 text-left">
                    {{ $expense->description ?? '-' }}
                </td>
                <td class="px-4 py-3 text-left">
                    {{ optional($expense->cluster)->name ?? '-' }}
                </td>
                <td class="px-4 py-3 text-left">
                    {{ optional($expense->assign)->name ?? '-' }}
                </td>
                <td class="px-4 py-3 text-right">
                    {{ $exptotal = optional($expense->executeds)->sum('cost') }}
                </td>
                <td>
                    <i
                        class="cursor-pointer bx bx-x hover:text-blue-600"
                        wire:click="removeExpense({{ $expense->id }})"
                        >
                    </i>
                </td>
            </tr>
            @php $expenses_total += $exptotal @endphp
            @endforeach
        </tbody>
    </table>

    <div class="w-full pr-10 text-right">
        <span class="px-10 py-2 text-white bg-red-700">Total: $ {{ $expenses_total }}</span>
    </div>

    <div class="w-full pr-10 mt-10 text-right">
        <span class="px-10 py-2 text-white bg-green-700">Balance: $ {{ $incomes_total - $expenses_total }}</span>
    </div>


</div>
