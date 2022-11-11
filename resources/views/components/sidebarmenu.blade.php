<nav class="mt-5">
    @can('view-any', App\Models\Expense::class)
        <x-sidebar-link href="{{ route('events') }}" :active="request()->routeIs('events')" icon="{{ 'bx-calendar-event' }}">
            Eventos
        </x-sidebar-link>
    @endcan
    @can('view-any', App\Models\Expense::class)
        <x-sidebar-link href="{{ route('gastos') }}" :active="request()->routeIs('gastos')" icon="{{ 'bxs-dashboard' }}">
            Reportes
        </x-sidebar-link>
    @endcan
    @role('super-admin')
        @can('view-any', App\Models\Expense::class)
            <x-sidebar-link href="{{ route('expenses.index') }}" :active="request()->routeIs('expenses.index')" icon="{{ 'bx-home' }}">
                Todos los Gastos
            </x-sidebar-link>
        @endcan
    @endrole
    @can('view-any', App\Models\Account::class)
        <x-sidebar-link href="{{ route('accounts.index') }}" :active="request()->routeIs('accounts.index')" icon="{{ 'bxs-user-account' }}">
            Cuentas
        </x-sidebar-link>
    @endcan
    @role('super-admin')
        @can('view-any', App\Models\Cluster::class)
            <x-sidebar-link href="{{ route('clusters.index') }}" :active="request()->routeIs('clusters.index')" icon="{{ 'bx-bookmarks' }}">
                Agrupaciones
            </x-sidebar-link>
        @endcan
        @can('view-any', App\Models\Assign::class)
            <x-sidebar-link href="{{ route('assigns.index') }}" :active="request()->routeIs('assigns.index')" icon="{{ 'bx-credit-card' }}">
                Rol de servicio
            </x-sidebar-link>
        @endcan
        @can('view-any', App\Models\Type::class)
            <x-sidebar-link href="{{ route('types.index') }}" :active="request()->routeIs('types.index')" icon="{{ 'bx-user-check' }}">
                Tipos de gastos
            </x-sidebar-link>
        @endcan
        @can('view-any', App\Models\Colors::class)
            <x-sidebar-link href="{{ route('colors.index') }}" :active="request()->routeIs('colors.index')" icon="{{ 'bx-color-fill' }}">
                Colores
            </x-sidebar-link>
        @endcan
        @can('view-any', App\Models\Purposes::class)
            <x-sidebar-link href="{{ route('purposes.index') }}" :active="request()->routeIs('purposes.index')" icon="{{ 'bx-car' }}">
                Propósitos
            </x-sidebar-link>
        @endcan
        @can('view-any', App\Models\User::class)
            <x-sidebar-link href="{{ route('users.index') }}" :active="request()->routeIs('users.index')" icon="{{ 'bx-user-circle' }}">
                Usuarios
            </x-sidebar-link>
        @endcan
    @endrole
    @if (Auth::user()->can('create', Spatie\Permission\Models\Role::class) ||
                Auth::user()->can('create', Spatie\Permission\Models\Permission::class))
        <hr class="mt-3" />
        @can('create', Spatie\Permission\Models\Role::class)
            <x-sidebar-link href="{{ route('roles.index') }}" :active="request()->routeIs('roles.index')" icon="{{ 'bx-tag-alt' }}">
                Roles
            </x-sidebar-link>
        @endcan
        @can('create', Spatie\Permission\Models\Permission::class)
            <x-sidebar-link href="{{ route('permissions.index') }}" :active="request()->routeIs('permissions.index')" icon="{{ 'bx-badge-check
                ' }}">
                Permissions
            </x-sidebar-link>
        @endcan
    @endif
</nav>
