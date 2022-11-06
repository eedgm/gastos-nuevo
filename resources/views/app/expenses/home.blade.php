<x-app-layout>
    @section('title', 'Dashboard')

    <div class="py-3" x-data="crudExpenses()" x-init="start">
        <x-partials.card>

            <x-form
                method="POST"
                action="{{ route('expenses.search') }}"
                class="mt-4"
                x-on:submit.prevent="filterExpenses(event)"
            >
                <div class="flex flex-wrap">
                    <x-inputs.group class="w-full lg:w-3/12">
                        <x-inputs.date
                            name="desde"
                            label="Desde"
                            value=""
                            max="255"
                            x-model="formData.desde"
                        ></x-inputs.date>
                    </x-inputs.group>

                    <x-inputs.group class="w-full lg:w-3/12">
                        <x-inputs.date
                            name="hasta"
                            label="Hasta"
                            value=""
                            max="255"
                            x-model="formData.hasta"
                        ></x-inputs.date>
                    </x-inputs.group>

                    <x-inputs.group class="w-full lg:w-3/12">
                        <x-inputs.select name="account_id" label="Cuentas" x-model="formData.account_id">
                            <option>Cuentas</option>
                            <template x-for="(option, i) in accounts_filter" :key="i">
                                <option
                                    :value="i"
                                    x-text="option"
                                ></option>
                            </template>
                        </x-inputs.select>
                    </x-inputs.group>

                    <div class="w-full mt-5 lg:w-3/12">
                        <button type="submit" class="float-right button button-primary">
                            <i class="mr-1 bx bx-save"></i>
                            <span>Filtrar</span>
                        </button>
                    </div>
                </div>
            </x-form>
        </x-partials.card>

        <div class="block w-full col-span-10 mx-auto mt-4 overflow-auto scrolling-touch sm:col-span-7 sm:px-2 lg:px-4">

                <table class="w-full bg-white divide-y divide-gray-200 table-auto">
                    <thead class="">
                        <tr>
                            <th colspan="8"></th>
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
                            <th></th>
                            @foreach ($types as $type)
                                <th class="px-4 py-3 text-right text-white bg-gray-500">
                                    {{ $type->name }}
                                </th>
                            @endforeach
                            <th class="text-white bg-red-500">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <template x-for="(expense, id) in gastos" :key="id">
                            <tr class="bg-white odd:bg-gray-100 hover:bg-gray-50">
                                <td class="p-1 text-sm text-center sm:text-md" x-text="expense.date"></td>
                                <td class="p-1 text-sm text-center sm:text-md" x-text="expense.date_to"></td>
                                <td class="p-1 text-sm text-center sm:text-md" x-text="expense.account_name"></td>
                                <td class="p-1 text-sm text-center sm:text-md" x-text="expense.description"></td>
                                <td class="p-1 text-sm text-center sm:text-md" x-text="expense.cluster_name"></td>
                                {{-- <td class="p-1 text-sm text-center sm:text-md" x-text="expense.user"></td> --}}
                                <td class="p-1 text-sm text-center sm:text-md" x-text="expense.assign_name"></td>
                                <td class="p-1 text-sm text-center sm:text-md" x-text="expense.budget_text"></td>
                                <td><i @click="showEventModal(expense.id)"class="text-green-600 cursor-pointer bx bx-plus hover:shadow"></i></td>
                                @foreach ($types as $type)
                                    <td class="p-1 text-sm text-center bg-gray-300 border-b-2 border-gray-600 sm:text-md" x-text="expense?.executeds?.{{ $type->object_name }}"></td>
                                @endforeach
                                <td class="p-1 text-sm text-center sm:text-md" x-text="expense.total_text"></td>
                            </tr>
                        </template>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6"></td>
                            <td x-text="total_budget" class="text-center text-red-500 text-md"></td>
                            <td></td>
                            <td colspan="{{ count($types) }}"></td>
                            <td x-text="total_expense" class="text-center text-red-500 text-md"></td>
                        </tr>
                    </tfoot>
                </table>

        </div>


        <!-- Modal -->
        <input type="hidden" id="user_id" value="{{ $user_id }}">
        <x-modal-events></x-modal-events>
        <!-- /Modal -->

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
                openEventModal: false,
                title_events: 'Agregar eventos',
                button_text: 'Guardar Evento',
                button_exp_text: 'Agregar',
                clusters: {},
                assigns: {},
                purposes: {},
                colors: {},
                types: {},
                accounts: {},
                accounts_filter: {},
                addGastos: false,
                update: false,
                updateExp: false,
                executeds: [],
                event_object: {
                    id: '',
                    date: '',
                    date_to: '',
                    description: '',
                    cluster_id: '',
                    assign_id: '',
                    purpose_id: '',
                    account_id: '',
                    budget: '',
                    _token : this.token,
                    user_id: '',
                    google_calendar: '',
                },
                expense_object: {
                    id: '',
                    type_id: '',
                    cost: '',
                    description: '',
                },
                formData: {
                    desde: '',
                    hasta: '',
                    account_id: '',
                    _token : this.token,
                },
                start: function() {
                    fetch('/user/accounts/')
                    .then(res => res.json())
                    .then((result) => {
                        console.table(result);
                        this.accounts_filter = result
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
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
                        for (let p in result.events) {
                            this.gastos = [...this.gastos, {
                                    id: result.events[p].id,
                                    date: result.events[p].date,
                                    date_to: result.events[p].date_to,
                                    description: result.events[p].description,
                                    account_id: result.events[p].account,
                                    account_name: result.events[p].account_name,
                                    cluster_id: result.events[p].cluster,
                                    cluster_name: result.events[p].cluster_name,
                                    user_id: result.events[p].user,
                                    assign_id: result.events[p].assign,
                                    assign_name: result.events[p].assign_name,
                                    purpose: result.events[p].purpose,
                                    purpose_id: result.events[p].purpose_id,
                                    budget: result.events[p].budget,
                                    budget_text: '$ '+result.events[p].budget,
                                    executeds: result.events[p].executed,
                                    total: result.events[p].total,
                                    total_text: '$ ' + parseFloat(result.events[p].total).toFixed(2)
                                }]

                        }

                        this.clusters = result.clusters
                        this.assigns = result.assigns
                        this.purposes = result.purposes
                        this.colors = result.colors
                        this.types = result.types
                        this.accounts = result.accounts

                        this.gastos.map(gasto => {
                            this.total_budget += gasto.budget
                            this.total_expense += gasto.total
                        })

                        this.total_budget = '$'+this.total_budget
                        this.total_expense = '$'+ parseFloat(this.total_expense).toFixed(2)
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });

                },
                showEventModal(id) {
                    // open the modal

                    this.openEventModal = true;
                    this.refreshGastos()
                    // this.event_object.date = new Date(this.year, this.month, date).toDateString();
                    this.update = true
                    let event = this.gastos.find(e => (e.id === id))
                    this.title_events = 'Actualizar evento'
                    this.button_text = 'Actualizar Evento'
                    this.executeds = []
                    this.event_object = {
                        id: event.id,
                        date: this.getFormattedDate(event.date),
                        date_to: event.date_to ? this.getFormattedDate(event.date_to) : '',
                        description: event.description,
                        cluster_id: event.cluster_id,
                        assign_id: event.assign_id,
                        purpose_id: event.purpose_id,
                        account_id: event.account_id,
                        budget: event.budget,
                        user_id: event.user_id,
                        google_calendar: event.google_calendar,
                    }

                    fetch('/events/executeds/'+id)
                    .then(res => res.json())
                    .then((result) => {
                        for (let p in result) {
                            this.executeds = [...this.executeds, {
                                id: result[p].id,
                                type_id: result[p].type_id,
                                cost: result[p].cost,
                                description: result[p].description
                            }]
                        }
                        console.table(this.executeds)
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });

                },
                refreshGastos() {
                    this.addGastos = false
                    this.button_exp_text = 'Add'
                    this.updateExp = false
                    this.expense_object.type_id = ''
                    this.expense_object.cost = ''
                    this.expense_object.id = ''
                    this.expense_object.description = ''
                },

                addExecuteds(id) {
                    this.expense_object._token = this.token
                    fetch('/events/executeds/add/'+id, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(this.expense_object)
                    })
                    .then(res => res.json())
                    .then((result) => {
                        this.executeds.push({
                            id: result,
                            type_id: this.expense_object.type_id,
                            cost: this.expense_object.cost,
                            description: this.expense_object.description
                        });

                        this.filterExpenses()

                        const notyf = new Notyf({dismissible: true})
                        this.notify('success', 'Gasto añadido')
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
                },

                editExecuteds(id) {
                    this.addGastos = true
                    this.button_exp_text = 'Update'
                    this.updateExp = true
                    executeds = this.executeds.filter(e => e.id == id);
                    this.expense_object.type_id = executeds[0]['type_id']
                    this.expense_object.cost = executeds[0]['cost']
                    this.expense_object.id = executeds[0]['id']
                    this.expense_object.description = executeds[0]['description']
                },

                updateExecuteds(id) {
                    this.expense_object._token = this.token
                    fetch('/events/executeds/update/'+id, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(this.expense_object)
                    })
                    .then(() => JSON.parse(JSON.stringify(this.expense_object)))
                    .then((result) => {
                        const updatedData = this.executeds.map(x => x.id === id ? {
                            id: id,
                            type_id: this.expense_object.type_id,
                            cost: this.expense_object.cost,
                            description: this.expense_object.description
                        } : x);

                        this.executeds = updatedData

                        this.refreshGastos()

                        this.filterExpenses()

                        this.notify('success', 'Gasto actualizado')

                    })
                },

                deleteExecuteds(id) {
                    if (!confirm('Are you sure?')) {
                        return false
                    }

                    let data = { _token: this.token }
                    fetch('/events/executeds/delete/'+id, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(() => JSON.parse(JSON.stringify(data)))
                    .then((result) => {
                        const updatedData = this.executeds.filter(item => item.id !== id)
                        this.executeds = updatedData
                        this.notify('error', 'Gasto eliminado')
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
                },
                getFormattedDate(date) {
                    if (date === 'now') {
                        const dt = new Date();
                        const padL = (nr, len = 2, chr = `0`) => `${nr}`.padStart(2, chr);
                        return `${
                            dt.getFullYear()}-${
                            padL(dt.getMonth()+1)}-${
                            padL(dt.getDate())} ${
                            padL(dt.getHours())}:00:00`
                    }
                    const dt = new Date(date);
                        const padL = (nr, len = 2, chr = `0`) => `${nr}`.padStart(2, chr);
                        return `${
                            dt.getFullYear()}-${
                            padL(dt.getMonth()+1)}-${
                            padL(dt.getDate())} ${
                            padL(dt.getHours())}:00:00`
                },

                notify(e, message) {
                    const notyf = new Notyf({dismissible: true})
                    if (e == 'success') {
                        notyf.success(message)
                    } else if (e == 'error') {
                        notyf.error(message)
                    }
                },
            }
        }

    </script>



</x-app-layout>
