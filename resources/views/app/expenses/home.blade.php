<x-app-layout>
    @section('title', 'Dashboard')

    <div class="py-3" x-data="crudExpenses()" x-init="start">
        <div class="w-full col-span-10 mx-auto sm:col-span-7 sm:px-2 lg:px-4">
            <x-partials.card>

                <x-form
                    method="POST"
                    action="{{ route('expenses.search') }}"
                    class="mt-4"
                    x-on:submit.prevent="filterExpenses(event)"
                >
                    <div class="flex">
                        <x-inputs.group class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/6">
                            <x-inputs.date
                                name="desde"
                                label="Desde"
                                value=""
                                max="255"
                                x-model="formData.desde"
                            ></x-inputs.date>
                        </x-inputs.group>

                        <x-inputs.group class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/6">
                            <x-inputs.date
                                name="hasta"
                                label="Hasta"
                                value=""
                                max="255"
                                x-model="formData.hasta"
                            ></x-inputs.date>
                        </x-inputs.group>
                        <div class="w-full mt-5 sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/6">
                            <button type="submit" class="float-right button button-primary">
                                <i class="mr-1 bx bx-save"></i>
                                <span>Filtrar</span>
                            </button>
                        </div>
                    </div>
                </x-form>
            </x-partials.card>
        </div>

        <div class="w-full col-span-10 mx-auto mt-5 sm:col-span-7 sm:px-2 lg:px-4">

                <table class="w-full bg-white divide-y divide-gray-200 table-auto">
                    <thead class="">
                        <tr>
                            <th colspan="7"></th>
                            <th class="text-white bg-gray-800" colspan="{{ count($types) }}">
                                Gastos
                            </th>
                            <th class="bg-red-500"></th>
                        </tr>
                        <tr>
                            <th class="px-4 py-3 text-left bg-gray-100 cursor-pointer hover:shadow" x-on:click="sort('date')">
                                @lang('crud.expenses_es.inputs.date')
                            </th>
                            <th class="px-4 py-3 text-left bg-gray-100">
                                @lang('crud.expenses_es.inputs.date_to')
                            </th>
                            <th class="px-4 py-3 text-left bg-gray-100">
                                @lang('crud.expenses_es.inputs.account_id')
                            </th>
                            <th class="px-4 py-3 text-left bg-gray-100">
                                @lang('crud.expenses_es.inputs.description')
                            </th>
                            <th class="px-4 py-3 text-left bg-gray-100 cursor-pointer" x-on:click="sort('cluster')">
                                @lang('crud.expenses_es.inputs.cluster_id')
                            </th>
                            {{-- <th class="px-4 py-3 text-left bg-gray-100">
                                @lang('crud.expenses_es.inputs.user_id')
                            </th> --}}
                            <th class="px-4 py-3 text-left bg-gray-100">
                                @lang('crud.expenses_es.inputs.assign_id')
                            </th>
                            <th class="px-4 py-3 text-left bg-gray-100 cursor-pointer" x-on:click="sort('budget')">
                                @lang('crud.expenses_es.inputs.budget')
                            </th>
                            @foreach ($types as $type)
                                <th class="px-4 py-3 text-right text-white bg-gray-500">
                                    {{ $type->name }}
                                </th>
                            @endforeach
                            <th class="bg-red-500">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <template x-for="(expense, id) in gastos" :key="id">
                            <tr class="bg-white odd:bg-gray-100 hover:bg-gray-50">
                                <td class="p-1 text-sm text-center sm:text-md" x-text="expense.date"></td>
                                <td class="p-1 text-sm text-center sm:text-md" x-text="expense.date_to"></td>
                                <td class="p-1 text-sm text-center sm:text-md" x-text="expense.account"></td>
                                <td class="p-1 text-sm text-center sm:text-md" x-text="expense.description"></td>
                                <td class="p-1 text-sm text-center sm:text-md" x-text="expense.cluster"></td>
                                {{-- <td class="p-1 text-sm text-center sm:text-md" x-text="expense.user"></td> --}}
                                <td class="p-1 text-sm text-center sm:text-md" x-text="expense.assign"></td>
                                <td class="p-1 text-sm text-center sm:text-md" x-text="expense.budget_text"></td>
                                @foreach ($types as $type)
                                    <td class="p-1 text-sm text-center bg-gray-300 border-b-2 border-gray-600 sm:text-md" x-text="expense.executeds.{{ $type->object_name }}"></td>
                                @endforeach
                                <td class="p-1 text-sm text-center sm:text-md" x-text="expense.total_text"></td>
                            </tr>
                        </template>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5"></td>
                            <td x-text="total_budget" class="text-center text-red-500 text-md"></td>
                            <td colspan="{{ count($types) }}"></td>
                            <td x-text="total_expense" class="text-center text-red-500 text-md"></td>
                        </tr>
                    </tfoot>
                </table>

        </div>

    </div>

    <script>
        function crudExpenses() {
            return {
                gastos: [],
                token: document.getElementsByName("_token")[0].value,
                total_budget: 0,
                total_expense: 0,
                sortCol:null,
                sortAsc:false,
                formData: {
                    desde: '',
                    hasta: '',
                    _token : this.token,
                },
                start: function() {
                },
                filterExpenses: function() {
                    this.formData._token = this.token
                    this.gastos = []
                    this.total_budget = 0
                    this.total_expense = 0
                    fetch('/expenses/search', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(this.formData)
                    })
                    .then(res => res.json())
                    .then((result) => {
                        for (let p in result) {
                            this.gastos = [...this.gastos, {
                                    id: result[p].id,
                                    date: result[p].date,
                                    date_to: result[p].date_to,
                                    description: result[p].description,
                                    account: result[p].account,
                                    cluster: result[p].cluster,
                                    user: result[p].user,
                                    assign: result[p].assign,
                                    budget: result[p].budget,
                                    budget_text: '$'+result[p].budget,
                                    executeds: result[p].executed,
                                    total: result[p].total,
                                    total_text: '$'+result[p].total
                                }]

                        }

                        this.gastos.map(gasto => {
                            this.total_budget += gasto.budget
                            this.total_expense += gasto.total
                        })

                        this.total_budget = '$'+this.total_budget
                        this.total_expense = '$'+this.total_expense
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });

                },
                sort(col) {
                    if(this.sortCol === col) this.sortAsc = !this.sortAsc;

                    this.sortCol = col;
                    this.gastos.sort((a, b) => {
                        if(a[this.sortCol] < b[this.sortCol]) return this.sortAsc?1:-1;
                        if(a[this.sortCol] > b[this.sortCol]) return this.sortAsc?-1:1;
                            return 0;
                    });
                }
            }
        }

    </script>



</x-app-layout>
