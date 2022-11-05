<div>

    @foreach ($accounts as $account)
        @php $texpenses = $tincomes = 0; @endphp
        <x-partials.card>
                <x-slot name="title">
                    {{ $account->name }}
                </x-slot>
                <div class="">
                    <livewire:new-income :account="$account" :key="$account->id" />
                </div>
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-3 lg:grid-cols-5">
                    @foreach ($account->balances()->where('reported', true)->orderBy('id', 'desc')->limit(1)->get() as $balance)
                        @if ($balance->reported)
                            <x-badge
                                title="Balance reportado {{ $balance->date->format('M d') }}"
                                total="{{ $balance->total }}"
                                background="bg-gray-700"
                                icon="bx-dollar-circle"
                            />
                        @endif
                    @endforeach

                    <x-badge
                        title="Presupuesto Actual"
                        total="{{ $account->expenses()->where('balance_id', null)->sum('budget') }}"
                        background="bg-green-700"
                        icon="bx-dollar"
                    />

                    <x-badge
                        title="Entradas"
                        total="{{ $tincomes = $account->incomes()->where('balance_id', null)->sum('cost') }}"
                        background="bg-green-700"
                        icon="bx-dollar"
                        add="{{ $account->id }}"
                    />

                    <x-badge
                        title="Gastado a la fecha"
                        total="{{ $texpenses = $account->executeds()->where('balance_id', null)->sum('cost') }}"
                        background="bg-yellow-700"
                        icon="bx-coffee-togo"
                    />

                    <x-badge
                        title="Sobrante"
                        total="{{ $tincomes - $texpenses }}"
                        background="bg-cyan-700"
                        icon="bx-check-double"
                    />
                </div>

        </x-partials.card>
    @endforeach
</div>
