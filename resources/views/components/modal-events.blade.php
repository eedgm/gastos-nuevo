<div style=" background-color: rgba(0, 0, 0, 0.8)" class="absolute top-0 bottom-0 left-0 right-0 z-40 w-full h-full" x-show.transition.opacity="openEventModal">
    <div class="absolute left-0 right-0 max-w-6xl p-4 mx-auto mt-10 overflow-hidden">
        <div class="absolute top-0 right-0 inline-flex items-center justify-center w-10 h-10 text-gray-500 bg-white rounded-full shadow cursor-pointer hover:text-gray-800"
            x-on:click="openEventModal = !openEventModal">
            <i class="text-2xl bx bx-x"></i>
        </div>

        <div class="flex flex-wrap p-8 overflow-hidden bg-white rounded-lg shadow">

            <h2 class="w-full pb-2 mb-6 text-2xl font-bold text-gray-800 border-b" x-text="title_events"></h2>
            @csrf
            <div class="w-full px-4 mb-4">
                <label class="mb-1 text-sm font-bold tracking-wide text-gray-800">Evento</label>
                <input
                    class="w-full px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded-lg appearance-none focus:outline-none focus:bg-white focus:border-blue-500"
                    type="text"
                    x-model="event_object.description"
                >
            </div>

            <div class="w-full px-4 mb-4 lg:w-4/12">
                <label class="mb-1 text-sm font-bold tracking-wide text-gray-800">Fecha</label>
                <input
                    class="w-full px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded-lg appearance-none focus:outline-none focus:bg-white focus:border-blue-500"
                    type="datetime-local"
                    x-model="event_object.date"
                    >
            </div>
            <div class="w-full mb-4 lg:w-4/12">
                <label class="mb-1 text-sm font-bold tracking-wide text-gray-800">Hasta</label>
                <input
                    class="w-full px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded-lg appearance-none focus:outline-none focus:bg-white focus:border-blue-500"
                    type="datetime-local"
                    x-model="event_object.date_to"
                    >
            </div>

            <div class="w-full px-4 lg:w-4/12">
                <label class="mb-1 text-sm font-bold tracking-wide text-gray-800">Presupuesto ($)</label>
                <input class="w-full px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded-lg appearance-none focus:outline-none focus:bg-white focus:border-blue-500" type="text" x-model="event_object.budget">
            </div>

            <x-inputs.group class="w-full lg:w-3/12">
                <x-inputs.select name="cluster_id" label="Cuentas" x-model="event_object.account_id" x-on:change="updateDetails()">
                    <option>Cuentas</option>
                    <template x-for="(option, i) in accounts" :key="i">
                        <option
                            :value="i"
                            x-text="option"
                        ></option>
                    </template>
                </x-inputs.select>
            </x-inputs.group>

            <x-inputs.group class="w-full lg:w-3/12">
                <x-inputs.select name="cluster_id" label="Agrupación" x-model="event_object.cluster_id">
                    <option>Agrupación</option>
                    <template x-for="(option, i) in clusters" :key="i">
                        <option
                            :value="i"
                            x-text="option"
                        ></option>
                    </template>
                </x-inputs.select>
            </x-inputs.group>

            <x-inputs.group class="w-full lg:w-3/12">
                <x-inputs.select name="assign_id" label="Rol" x-model="event_object.assign_id">
                    <option>Rol</option>
                    <template x-for="(option, i) in assigns" :key="i">
                        <option
                            :value="i"
                            x-text="option"
                        ></option>
                    </template>
                </x-inputs.select>
            </x-inputs.group>

            <x-inputs.group class="w-full lg:w-3/12">
                <x-inputs.select name="purpose_id" label="Propósito" x-model="event_object.purpose_id">
                    <option>Propósito</option>
                    <template x-for="(option, i) in purposes" :key="i">
                        <option
                            :value="i"
                            x-text="option"
                        ></option>
                    </template>
                </x-inputs.select>
            </x-inputs.group>
            <div class="flex w-full mt-1 ml-5 ">
                <input
                    class="mt-1 mr-3"
                    type="checkbox"
                    id="google_calendar"
                    x-model="event_object.google_calendar"
                >
                <label for="google_calendar">Publicar en Google Calendar?</label>
            </div>

            <div class="flex w-full mt-3 ml-5 ">
                <div class="mt-3 wfull lg:w-4/12">Gastos <i class="bx " :class="{'bx-hide' : addGastos, 'bx-plus' : !addGastos}" x-on:click="addGastos = !addGastos"></i></div>
                <div class="flex flex-wrap w-full lg:w-8/12" x-show="addGastos">
                    <x-inputs.group class="w-full lg:w-4/12">
                        <x-inputs.select name="types_id" x-model="expense_object.type_id">
                            <option>Tipos</option>
                            <template x-for="(option, i) in types" :key="i">
                                <option
                                    :value="i"
                                    x-text="option"
                                ></option>
                            </template>
                        </x-inputs.select>
                    </x-inputs.group>
                    <div class="w-full px-4 my-2 lg:w-4/12">
                        <input
                            class="w-full px-4 py-1 text-gray-700 bg-green-200 border-gray-200 rounded-lg appearance-none border-1 focus:outline-none focus:bg-white focus:border-blue-500"
                            type="number"
                            x-model="expense_object.cost"
                            placeholder="Costo ($)"
                        >
                    </div>
                    <div class="w-full px-4 my-2 lg:w-4/12">
                        <input
                            class="w-full px-4 py-1 text-gray-700 bg-green-200 border-gray-200 rounded-lg appearance-none border-1 focus:outline-none focus:bg-white focus:border-blue-500"
                            type="text"
                            x-model="expense_object.description"
                            placeholder="Descripción"
                        >
                    </div>
                    <div class="w-full lg:w-4/12">
                        <button
                            type="button"
                            class="px-4 py-1 mt-2 font-semibold text-white bg-green-500 border border-gray-700 rounded-lg shadow-sm hover:bg-green-700"
                            :class="{'bg-blue-300 text-black border-blue-700': updateExp}"
                            @click="updateExp ? updateExecuteds(expense_object.id) : addExecuteds(event_object.id)"
                            x-text="button_exp_text"
                            >
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-full mx-auto mt-5 overflow-hidden border-b border-gray-200 shadow sm:rounded-lg" x-show="executeds.length > 0">
                <table class="min-w-full bg-white divide-y divide-gray-200 table-auto">
                    <thead class="text-white bg-gray-800">
                        <tr>
                            <th class="p-2">Tipo</th>
                            <th class="p-2">Costo</th>
                            <th class="p-2">Descripción</th>
                            <th class="p-2"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <template x-for="(executed, id) in executeds" :key="id">
                            <tr>
                                <td class="p-1 text-sm text-center sm:text-md" x-text="types[executed.type_id]"></td>
                                <td class="p-1 text-sm text-center sm:text-md" x-text="executed.cost"></td>
                                <td class="p-1 text-sm text-center sm:text-md" x-text="executed.description"></td>
                                <td class="p-1 text-sm text-center sm:text-md">
                                    <i x-on:click="editExecuteds(executed.id)" class="text-green-600 cursor-pointer bx bx-edit hover:shadow"></i>
                                    <i x-on:click="deleteExecuteds(executed.id)" class="text-red-600 cursor-pointer bx bx-trash hover:shadow"></i>
                                </td>
                            </tr>
                        </template>
                        <tr class="bg-red-50">
                            <td class="p-1 text-sm text-center sm:text-md">Total</td>
                            <td class="p-1 text-sm text-center sm:text-md"  x-text="total_executed">&nbsp;</td>
                            <td class="p-1 text-sm text-center sm:text-md">&nbsp;</td>
                            <td class="p-1 text-sm text-center sm:text-md">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="w-full mt-8 text-center lg:text-right">
                <button
                    x-show="update"
                    class="px-2 py-1 mr-2 text-xs text-white bg-red-500 border border-red-700 rounded-lg shadow-sm lg:text-md lg:px-4 lg:py-2"
                    x-on:click="deleteEvent(event_object.id)"
                    >
                    Eliminar
                </button>
                <button type="button" class="px-2 py-1 mr-2 text-xs font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm lg:text-md lg:px-4 lg:py-2 hover:bg-gray-100" @click="openEventModal = !openEventModal">
                    Cancelar
                </button>
                <button
                    type="button"
                    class="px-2 py-1 text-xs font-semibold text-white bg-gray-800 border border-gray-700 rounded-lg shadow-sm lg:text-md lg:px-4 lg:py-2 hover:bg-gray-700"
                    :class="{'bg-blue-300 text-black border-blue-700': update}"
                    @click="update ? updateEvent(event_object.id) : addEvent()"
                    x-text="button_text"
                    >
                </button>
            </div>
        </div>
    </div>
</div>
