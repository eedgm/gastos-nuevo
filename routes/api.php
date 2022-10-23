<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BankController;
use App\Http\Controllers\Api\TypeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\ColorController;
use App\Http\Controllers\Api\IncomeController;
use App\Http\Controllers\Api\AssignController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\ClusterController;
use App\Http\Controllers\Api\PurposeController;
use App\Http\Controllers\Api\ExecutedController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\AccountUsersController;
use App\Http\Controllers\Api\account_userController;
use App\Http\Controllers\Api\BankAccountsController;
use App\Http\Controllers\Api\UserAccountsController;
use App\Http\Controllers\Api\ColorPurposesController;
use App\Http\Controllers\Api\TypeExecutedsController;
use App\Http\Controllers\Api\AccountIncomesController;
use App\Http\Controllers\Api\AccountAssignsController;
use App\Http\Controllers\Api\account_assignController;
use App\Http\Controllers\Api\AssignExpensesController;
use App\Http\Controllers\Api\AssignAccountsController;
use App\Http\Controllers\Api\AccountExpensesController;
use App\Http\Controllers\Api\AccountClustersController;
use App\Http\Controllers\Api\AccountPurposesController;
use App\Http\Controllers\Api\ExpensePurposesController;
use App\Http\Controllers\Api\account_clusterController;
use App\Http\Controllers\Api\account_purposeController;
use App\Http\Controllers\Api\ClusterExpensesController;
use App\Http\Controllers\Api\ClusterAccountsController;
use App\Http\Controllers\Api\PurposeExpensesController;
use App\Http\Controllers\Api\PurposeAccountsController;
use App\Http\Controllers\Api\expense_purposeController;
use App\Http\Controllers\Api\ExpenseExecutedsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('accounts', AccountController::class);

        // Account Expenses
        Route::get('/accounts/{account}/expenses', [
            AccountExpensesController::class,
            'index',
        ])->name('accounts.expenses.index');
        Route::post('/accounts/{account}/expenses', [
            AccountExpensesController::class,
            'store',
        ])->name('accounts.expenses.store');

        // Account Incomes
        Route::get('/accounts/{account}/incomes', [
            AccountIncomesController::class,
            'index',
        ])->name('accounts.incomes.index');
        Route::post('/accounts/{account}/incomes', [
            AccountIncomesController::class,
            'store',
        ])->name('accounts.incomes.store');

        // Account Users
        Route::get('/accounts/{account}/users', [
            AccountUsersController::class,
            'index',
        ])->name('accounts.users.index');
        Route::post('/accounts/{account}/users/{user}', [
            AccountUsersController::class,
            'store',
        ])->name('accounts.users.store');
        Route::delete('/accounts/{account}/users/{user}', [
            AccountUsersController::class,
            'destroy',
        ])->name('accounts.users.destroy');

        // Account Assigns
        Route::get('/accounts/{account}/assigns', [
            AccountAssignsController::class,
            'index',
        ])->name('accounts.assigns.index');
        Route::post('/accounts/{account}/assigns/{assign}', [
            AccountAssignsController::class,
            'store',
        ])->name('accounts.assigns.store');
        Route::delete('/accounts/{account}/assigns/{assign}', [
            AccountAssignsController::class,
            'destroy',
        ])->name('accounts.assigns.destroy');

        // Account Clusters
        Route::get('/accounts/{account}/clusters', [
            AccountClustersController::class,
            'index',
        ])->name('accounts.clusters.index');
        Route::post('/accounts/{account}/clusters/{cluster}', [
            AccountClustersController::class,
            'store',
        ])->name('accounts.clusters.store');
        Route::delete('/accounts/{account}/clusters/{cluster}', [
            AccountClustersController::class,
            'destroy',
        ])->name('accounts.clusters.destroy');

        // Account Purposes
        Route::get('/accounts/{account}/purposes', [
            AccountPurposesController::class,
            'index',
        ])->name('accounts.purposes.index');
        Route::post('/accounts/{account}/purposes/{purpose}', [
            AccountPurposesController::class,
            'store',
        ])->name('accounts.purposes.store');
        Route::delete('/accounts/{account}/purposes/{purpose}', [
            AccountPurposesController::class,
            'destroy',
        ])->name('accounts.purposes.destroy');

        Route::apiResource('assigns', AssignController::class);

        // Assign Expenses
        Route::get('/assigns/{assign}/expenses', [
            AssignExpensesController::class,
            'index',
        ])->name('assigns.expenses.index');
        Route::post('/assigns/{assign}/expenses', [
            AssignExpensesController::class,
            'store',
        ])->name('assigns.expenses.store');

        // Assign Accounts
        Route::get('/assigns/{assign}/accounts', [
            AssignAccountsController::class,
            'index',
        ])->name('assigns.accounts.index');
        Route::post('/assigns/{assign}/accounts/{account}', [
            AssignAccountsController::class,
            'store',
        ])->name('assigns.accounts.store');
        Route::delete('/assigns/{assign}/accounts/{account}', [
            AssignAccountsController::class,
            'destroy',
        ])->name('assigns.accounts.destroy');

        Route::apiResource('banks', BankController::class);

        // Bank Accounts
        Route::get('/banks/{bank}/accounts', [
            BankAccountsController::class,
            'index',
        ])->name('banks.accounts.index');
        Route::post('/banks/{bank}/accounts', [
            BankAccountsController::class,
            'store',
        ])->name('banks.accounts.store');

        Route::apiResource('clusters', ClusterController::class);

        // Cluster Expenses
        Route::get('/clusters/{cluster}/expenses', [
            ClusterExpensesController::class,
            'index',
        ])->name('clusters.expenses.index');
        Route::post('/clusters/{cluster}/expenses', [
            ClusterExpensesController::class,
            'store',
        ])->name('clusters.expenses.store');

        // Cluster Accounts
        Route::get('/clusters/{cluster}/accounts', [
            ClusterAccountsController::class,
            'index',
        ])->name('clusters.accounts.index');
        Route::post('/clusters/{cluster}/accounts/{account}', [
            ClusterAccountsController::class,
            'store',
        ])->name('clusters.accounts.store');
        Route::delete('/clusters/{cluster}/accounts/{account}', [
            ClusterAccountsController::class,
            'destroy',
        ])->name('clusters.accounts.destroy');

        Route::apiResource('colors', ColorController::class);

        // Color Purposes
        Route::get('/colors/{color}/purposes', [
            ColorPurposesController::class,
            'index',
        ])->name('colors.purposes.index');
        Route::post('/colors/{color}/purposes', [
            ColorPurposesController::class,
            'store',
        ])->name('colors.purposes.store');

        Route::apiResource('executeds', ExecutedController::class);

        Route::apiResource('expenses', ExpenseController::class);

        // Expense Executeds
        Route::get('/expenses/{expense}/executeds', [
            ExpenseExecutedsController::class,
            'index',
        ])->name('expenses.executeds.index');
        Route::post('/expenses/{expense}/executeds', [
            ExpenseExecutedsController::class,
            'store',
        ])->name('expenses.executeds.store');

        // Expense Purposes
        Route::get('/expenses/{expense}/purposes', [
            ExpensePurposesController::class,
            'index',
        ])->name('expenses.purposes.index');
        Route::post('/expenses/{expense}/purposes/{purpose}', [
            ExpensePurposesController::class,
            'store',
        ])->name('expenses.purposes.store');
        Route::delete('/expenses/{expense}/purposes/{purpose}', [
            ExpensePurposesController::class,
            'destroy',
        ])->name('expenses.purposes.destroy');

        Route::apiResource('incomes', IncomeController::class);

        Route::apiResource('purposes', PurposeController::class);

        // Purpose Expenses
        Route::get('/purposes/{purpose}/expenses', [
            PurposeExpensesController::class,
            'index',
        ])->name('purposes.expenses.index');
        Route::post('/purposes/{purpose}/expenses/{expense}', [
            PurposeExpensesController::class,
            'store',
        ])->name('purposes.expenses.store');
        Route::delete('/purposes/{purpose}/expenses/{expense}', [
            PurposeExpensesController::class,
            'destroy',
        ])->name('purposes.expenses.destroy');

        // Purpose Accounts
        Route::get('/purposes/{purpose}/accounts', [
            PurposeAccountsController::class,
            'index',
        ])->name('purposes.accounts.index');
        Route::post('/purposes/{purpose}/accounts/{account}', [
            PurposeAccountsController::class,
            'store',
        ])->name('purposes.accounts.store');
        Route::delete('/purposes/{purpose}/accounts/{account}', [
            PurposeAccountsController::class,
            'destroy',
        ])->name('purposes.accounts.destroy');

        Route::apiResource('types', TypeController::class);

        // Type Executeds
        Route::get('/types/{type}/executeds', [
            TypeExecutedsController::class,
            'index',
        ])->name('types.executeds.index');
        Route::post('/types/{type}/executeds', [
            TypeExecutedsController::class,
            'store',
        ])->name('types.executeds.store');

        Route::apiResource('users', UserController::class);

        // User Accounts
        Route::get('/users/{user}/accounts', [
            UserAccountsController::class,
            'index',
        ])->name('users.accounts.index');
        Route::post('/users/{user}/accounts/{account}', [
            UserAccountsController::class,
            'store',
        ])->name('users.accounts.store');
        Route::delete('/users/{user}/accounts/{account}', [
            UserAccountsController::class,
            'destroy',
        ])->name('users.accounts.destroy');
    });
