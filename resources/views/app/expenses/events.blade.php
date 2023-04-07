@extends('layouts.events')
@section('title', 'Eventos')

@section('content')
<div x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak>
    <div class="mx-auto sp-0 lg:px-4 lg:py-2">

        <!-- <div class="mb-4 text-xl font-bold text-gray-800">
            Schedule Tasks
        </div> -->

        <div class="overflow-hidden bg-white rounded-lg shadow">

            <div class="hidden">
                <span class="text-white bg-blue-500 border-blue-200"></span>
                <span class="text-red-800 bg-red-100 border-red-200"></span>
                <span class="text-yellow-800 bg-yellow-100 border-yellow-200"></span>
                <span class="text-green-800 bg-green-100 border-green-200"></span>
                <span class="text-purple-800 bg-purple-100 border-purple-200"></span>
                <span class="text-gray-800 bg-gray-100 border-gray-200"></span>
            </div>

            <div class="flex items-center justify-between px-6 py-2">
                <div>
                    <span x-text="MONTH_NAMES[month]" class="text-lg font-bold text-gray-800"></span>
                    <span x-text="year" class="ml-1 text-lg font-normal text-gray-600"></span>
                </div>
                <div class="px-1 pt-2 border rounded-lg">
                    <button
                        type="button"
                        class="inline-flex items-center p-1 leading-none transition duration-100 ease-in-out rounded-lg cursor-pointer hover:bg-gray-200"


                        @click="month--; getNoOfDays()">
                        <svg class="inline-flex w-6 h-6 leading-none text-gray-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <div class="inline-flex h-6 border-r"></div>
                    <button
                        type="button"
                        class="inline-flex items-center p-1 leading-none transition duration-100 ease-in-out rounded-lg cursor-pointer hover:bg-gray-200"


                        @click="month++; getNoOfDays()">
                        <svg class="inline-flex w-6 h-6 leading-none text-gray-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="mt-5">
                <div class="flex flex-wrap mt-[-20px;]">
                    <template x-for="(day, index) in DAYS" :key="index">
                        <div class="w-[14.28%] p-0 lg:px-2 lg:py-2">
                            <div
                                x-text="day"
                                class="text-xs font-bold tracking-wide text-center text-gray-600 uppercase lg:text-sm"></div>
                        </div>
                    </template>
                </div>

                <div class="flex flex-wrap border-t border-l">
                    <template x-for="blankday in blankdays">
                        <div
                            class="w-[14.28%] p-0 text-center border-b border-r lg:px-2 lg:pt-2 h-[160px]"
                        ></div>
                    </template>
                    <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                        <div class="w-[14.28%] h-[160px] relative lg:px-2 lg:pt-2 p-1 border-b border-r">
                            <div
                                @click="showEventModal(date)"
                                x-text="date"
                                class="inline-flex items-center justify-center w-6 h-6 leading-none text-center transition duration-100 ease-in-out rounded-full cursor-pointer"
                                :class="{'bg-red-500 text-white': isToday(date) == true, 'text-gray-700 hover:bg-red-200': isToday(date) == false }"
                            ></div>
                            <div class="h-[90%] lg:h-[80%] overflow-y-auto scrolling-touch">
                                <template x-for="event in events.filter(e => new Date(e.date).toDateString() === new Date(year, month, date).toDateString() )">
                                    <div
                                        class="p-0 mt-2 border rounded-lg cursor-pointer"
                                        :class="event.purpose"
                                        @click="showEventModal(date, event.id)"
                                    >
                                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
                                            <p x-text="event.account" class="text-white bg-gradient-to-l from-blue-300 via-blue-600 to-gray-700 rounded truncate col-span-1 lg:col-span-2 -mt-[5px] lg:-mt-[8px] p-0 md:px-1 lg:px-2 text-[7px] lg:text-[9px]"></p>
                                            <p x-text="event.cluster" class="text-white bg-gradient-to-l from-blue-300 via-silver-600 to-gray-700 rounded truncate col-span-1 lg:col-span-2 -mt-[5px] lg:-mt-[8px] p-0 md:px-1 lg:px-2 text-[7px] lg:text-[9px]"></p>
                                        </div>
                                        <p x-text="event.description" class="pl-3 text-xs leading-tight truncate lg:text-sm"></p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <input type="hidden" id="user_id" value="{{ $user_id }}">
    <x-modal-events></x-modal-events>
    <!-- /Modal -->
</div>

<script>
    const MONTH_NAMES = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    const DAYS = ['Dom', 'Lun', 'Mar', 'Mier', 'Jue', 'Vier', 'Sab'];

    function app() {
        return {
            month: '',
            year: '',
            no_of_days: [],
            blankdays: [],
            days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            clusters: {},
            assigns: {},
            purposes: {},
            colors: {},
            types: {},
            accounts: {},
            events: [],
            executeds: [],
            event_title: '',
            event_date: '',
            event_theme: 'blue',
            openEventModal: false,
            title_events: 'Agregar eventos',
            button_text: 'Guardar Evento',
            button_exp_text: 'Agregar',
            update: false,
            updateExp: false,
            token: document.getElementsByName("_token")[0].value,
            addGastos: false,
            total_executed: 0,
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
            initDate() {
                let today = new Date();
                this.month = today.getMonth();
                this.year = today.getFullYear();
                this.datepickerValue = new Date(this.year, this.month, today.getDate()).toDateString();
            },

            isToday(date) {
                const today = new Date();
                const d = new Date(this.year, this.month, date);

                return today.toDateString() === d.toDateString() ? true : false;
            },

            showEventModal(date, id = null) {
                // open the modal

                this.openEventModal = true;
                this.refreshGastos()
                this.executeds = []
                // this.event_object.date = new Date(this.year, this.month, date).toDateString();
                if (id) {
                    this.update = true
                    let event = this.events.find(e => (e.id === id))
                    this.title_events = 'Actualizar evento'
                    this.button_text = 'Actualizar Evento'
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
                        this.total_executed = this.executeds.reduce((accumulator, object) => {
                            return parseFloat(accumulator) + parseFloat(object.cost);
                        }, 0);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });


                } else {
                    this.update = false
                    this.title_events = 'Agregar Evento'
                    this.button_text = 'Guardar Evento'
                    this.event_object = {
                        id: '',
                        date: this.getFormattedDate(new Date(this.year, this.month, date).toDateString()),
                        date_to: '',
                        description: '',
                        cluster_id: '',
                        assign_id: '',
                        purpose_id: '',
                        account_id: '',
                        budget: '',
                        _token : this.token,
                        user_id: document.querySelector('#user_id').value,
                    }
                }

            },

            start() {
                this.events = []
                fetch('/events/all/'+this.month+'/'+this.year)
                .then(res => res.json())
                .then((result) => {
                    for (let p in result.events) {
                        this.events = [...this.events, {
                            id: result.events[p].id,
                            date: result.events[p].date,
                            date_to: result.events[p].date_to,
                            description: result.events[p].description,
                            cluster_id: result.events[p].cluster,
                            cluster: result.events[p].cluster_name,
                            assign_id: result.events[p].assign,
                            purpose: result.events[p].purpose,
                            purpose_id: result.events[p].purpose_id,
                            budget: result.events[p].budget,
                            account_id: result.events[p].account,
                            account: result.events[p].account_name,
                            user_id: result.events[p].user,
                            google_calendar: result.events[p].google_calendar
                        }]
                    }

                    this.clusters = result.clusters
                    this.assigns = result.assigns
                    this.purposes = result.purposes
                    this.colors = result.colors
                    this.types = result.types
                    this.accounts = result.accounts
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
            },

            addEvent() {
                if (this.event_object.description == '') {
                    return;
                }

                this.event_object._token = this.token
                this.event_object.date = this.getFormattedDate(this.event_object.date)
                this.event_object.date_to = this.event_object.date_to ? this.getFormattedDate(this.event_object.date_to) : ''
                fetch('/events/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.event_object)
                })
                .then(res => res.json())
                .then((result) => {
                    this.events.push({
                        id: result,
                        date: this.event_object.date,
                        date_to: this.event_object.date_to,
                        description: this.event_object.description,
                        cluster_id: this.event_object.cluster_id,
                        cluster: this.getClusterName(this.event_object.cluster_id),
                        assign_id: this.event_object.assign_id,
                        purpose: this.colors[this.event_object.purpose_id],
                        purpose_id: this.event_object.purpose_id,
                        account_id: this.event_object.account_id,
                        account: this.getAccountName(this.event_object.account_id),
                        budget: this.event_object.budget
                    });
                    console.table(this.events)
                    this.notify('success', 'Nuevo evento añadido')
                })
                .catch((error) => {
                    console.error('Error:', error);
                });

                this.openEventModal = false;
            },

            updateEvent(id) {
                if (this.event_object.description == '') {
                    return;
                }

                this.event_object._token = this.token
                this.event_object.date = this.getFormattedDate(this.event_object.date)
                this.event_object.date_to = this.event_object.date_to ? this.getFormattedDate(this.event_object.date_to) : ''
                fetch('/events/update/'+id, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.event_object)
                })
                .then(() => JSON.parse(JSON.stringify(this.event_object)))
                .then((result) => {
                    const updatedData = this.events.map(x => x.id === id ? {
                        id: id,
                        date: this.event_object.date,
                        date_to: this.event_object.date_to,
                        description: this.event_object.description,
                        cluster_id: this.event_object.cluster_id,
                        cluster: this.getClusterName(this.event_object.cluster_id),
                        assign_id: this.event_object.assign_id,
                        purpose: this.colors[this.event_object.purpose_id],
                        purpose_id: this.event_object.purpose_id,
                        account_id: this.event_object.account_id,
                        account: this.getAccountName(this.event_object.account_id),
                        budget: this.event_object.budget
                    } : x);

                    this.events = updatedData

                    this.notify('success', 'Evento actualizado')
                })
                .catch((error) => {
                    console.error('Error:', error);
                });

                this.openEventModal = false;
            },

            deleteEvent(id) {
                if (!confirm('Are you sure?')) {
                    this.openEventModal = false;
                    return false
                }

                let data = { _token: this.token }
                fetch('/events/delete/'+id, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(() => JSON.parse(JSON.stringify(data)))
                .then((result) => {
                    let event = this.events.find(element => element.id === id)
                    const updatedData = this.events.filter(item => item.id !== id)
                    this.events = updatedData
                    this.notify('error', 'Evento eliminado')
                })
                .catch((error) => {
                    console.error('Error:', error);
                });

                this.openEventModal = false;
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

                    this.total_executed = this.executeds.reduce((accumulator, object) => {
                        return parseFloat(accumulator) + parseFloat(object.cost);
                    }, 0);

                    const notyf = new Notyf({dismissible: true})
                    this.notify('success', 'Gasto añadido')

                    this.refreshGastos()
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
                this.total_executed = this.executeds.reduce((accumulator, object) => {
                    return parseFloat(accumulator) + parseFloat(object.cost);
                }, 0);
            },

            updateDetails() {
                let account = this.event_object.account_id

                fetch('/events/accounts/details/'+account)
                .then(res => res.json())
                .then((result) => {
                    this.clusters = result.clusters
                    this.assigns = result.assigns
                    this.purposes = result.purposes
                })
                .catch((error) => {
                    console.error('Error:', error);
                });

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

                    this.total_executed = this.executeds.reduce((accumulator, object) => {
                        return parseFloat(accumulator) + parseFloat(object.cost);
                    }, 0);

                    this.refreshGastos()

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
                    this.total_executed = this.executeds.reduce((accumulator, object) => {
                        return parseFloat(accumulator) + parseFloat(object.cost);
                    }, 0);
                    this.notify('error', 'Gasto eliminado')
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

            notify(e, message) {
                const notyf = new Notyf({dismissible: true})
                if (e == 'success') {
                    notyf.success(message)
                } else if (e == 'error') {
                    notyf.error(message)
                }
            },

            getNoOfDays() {
                if (this.month < 0) {
                    this.month = 11
                    this.year--
                }
                if (this.month > 11) {
                    this.month = 0
                    this.year++
                }

                let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();

                // find where to start calendar day of week
                let dayOfWeek = new Date(this.year, this.month).getDay();
                let blankdaysArray = [];
                for ( var i=1; i <= dayOfWeek; i++) {
                    blankdaysArray.push(i);
                }

                let daysArray = [];
                for ( var i=1; i <= daysInMonth; i++) {
                    daysArray.push(i);
                }

                this.start()

                this.blankdays = blankdaysArray;
                this.no_of_days = daysArray;
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

            getAccountName(id) {
                return this.accounts[id]
            },
            getClusterName(id) {
                return this.clusters[id]
            }
        }
    }

</script>

@endsection
