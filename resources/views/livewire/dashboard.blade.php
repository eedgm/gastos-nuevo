<div>

    @foreach ($accounts as $account)
        <x-partials.card>
                <x-slot name="title">
                    {{ $account->name }}
                </x-slot>
                <div class="grid grid-cols-3 gap-3">
                    @foreach ($account->balances as $balance)
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
                        total="{{ $account->expenses->sum('budget') }}"
                        background="bg-green-700"
                        icon="bx-dollar"
                    />

                    <x-badge
                        title="Gastado a la fecha"
                        total="{{ $account->executeds->sum('cost') }}"
                        background="bg-yellow-700"
                        icon="bx-coffee-togo"
                    />
                </div>

        </x-partials.card>
    @endforeach
</div>
