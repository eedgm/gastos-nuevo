<div>
    <x-partials.card class="w-6/12">
        <div>
            <x-slot name="title">
                Entradas
            </x-slot>

            @foreach ($accounts as $account)
                <h1 class="text-lg bolder" name="title">
                    {{ $account->name }}
                </h1>

                <div class="block w-full mt-4 overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead class="text-gray-700">
                            <tr>
                                <th class="px-4 py-1 text-left bg-lime-400 ">
                                    @lang('crud.account_incomes.inputs.date')
                                </th>
                                <th class="px-4 py-1 text-right">
                                    @lang('crud.account_incomes.inputs.cost')
                                </th>
                                <th class="px-4 py-1 text-left">
                                    @lang('crud.account_incomes.inputs.description')
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @foreach ($account->incomes()->limit(3)->orderBy('id', 'desc')->get() as $income)
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-1 text-left">
                                    {{ $income->date->format('Y-m-d') ?? '-' }}
                                </td>
                                <td class="px-4 py-1 text-right">
                                    $ {{ $income->cost ?? '-' }}
                                </td>
                                <td class="px-4 py-1 text-left">
                                    {{ $income->description ?? '-' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            @endforeach
        </div>
    </x-partials.card>
</div>
