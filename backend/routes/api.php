<?php

use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::post('users', "UsersController@new");
    Route::post('permissions', "PermissionsController@new");
});

Route::group(['middleware' => 'auth:api', 'namespace' => 'App\Http\Controllers'], function () {

    /** Usuários */
    Route::get('users', "UsersController@index");
    Route::get('users/admins', "UsersController@admins");
    Route::get('users/{id}', "UsersController@show");
    Route::post('auth/login', "AuthController@login");
    Route::post('users/{id}', "UsersController@update");
    Route::delete('users/{id}', "UsersController@remove");

    /** Permissões */
    Route::get('permissions', "PermissionsController@index");

    /** Clientes */
    Route::get('clients', "ClientsController@index");
    Route::get('clients/{id}', "ClientsController@show");
    Route::post('clients', "ClientsController@new");
    Route::put('clients/{id}', "ClientsController@update");
    Route::delete('clients/{id}', "ClientsController@remove");

    /** Serviços */
    Route::get('services', "ServicesController@index");
    Route::post('services', "ServicesController@new");
    Route::put('services/{service}', "ServicesController@update");
    Route::delete('services/{service}', "ServicesController@remove");

    /** Serviços por Cliente */
    Route::get('servicesByClients', "ServicesByClientsController@index");
    Route::get('servicesByClients/{client_id}', "ServicesByClientsController@show");
    Route::post('servicesByClients', "ServicesByClientsController@new");
    Route::put('servicesByClients/{services_by_clients}', "ServicesByClientsController@update");
    Route::delete('servicesByClients/{services_by_clients}', "ServicesByClientsController@remove");

    /** Pedidos do Site */
    Route::get('requests', "RequestsController@index");
    // Route::get('requests/{id}', "RequestsController@show");
    Route::post('requests', "RequestsController@new");
    Route::put('requests/{id}', "RequestsController@update");
    Route::delete('requests/{id}', "RequestsController@remove");

    /** Briefings */
    Route::get('briefings', "BriefingsController@index");
    // Route::get('briefings/{id}', "BriefingsController@show");
    Route::post('briefings', "BriefingsController@new");
    Route::put('briefings/{id}', "BriefingsController@update");
    Route::delete('briefings/{id}', "BriefingsController@remove");

    /** Planos */
    Route::get('plans', "PlansController@index");
    Route::get('plans/{id}', "PlansController@show");
    Route::post('plans', "PlansController@new");
    Route::put('plans/{id}', "PlansController@update");
    Route::delete('plans/{id}', "PlansController@remove");

    /** Tickets */
    Route::get('tickets', 'TicketsController@index');
    Route::get('tickets/{id}', 'TicketsController@show');
    Route::post('tickets', 'TicketsController@new');
    Route::patch('tickets/{id}', "TicketsController@update");
    Route::delete('tickets/{id}', 'TicketsController@remove');

    /** Status de Tickets */
    Route::get('statusTicket', 'StatusTicketController@index');
    Route::post('statusTicket', 'StatusTicketController@new');
    Route::patch('statusTicket/{id}', "StatusTicketController@update");
    Route::delete('statusTicket/{id}', 'StatusTicketController@remove');

    /** Acompanhamento de Tickets */
    Route::get('followTicket', 'FollowTicketsController@index');
    Route::get('followTicketById/{id}', 'FollowTicketsController@show');
    Route::post('followTicket', 'FollowTicketsController@new');
    Route::patch('followTicket/{id}', "FollowTicketsController@update");
    Route::delete('followTicket/{id}', 'FollowTicketsController@remove');

    /** Receitas */
    Route::get('inputs', "InputsController@index");
    Route::post('inputs/prevision/{account_id}', "InputsController@showInputsPrevision");
    Route::post('inputs/madeEffective/{account_id}', "InputsController@showInputsMadeEffective");
    Route::post('inputs', "InputsController@new");
    Route::put('inputs/{id}', "InputsController@update");
    Route::delete('inputs/{id}', "InputsController@remove");

    /** Categoria de Receitas */
    Route::get('inputsCategories', "InputsCategoriesController@index");
    Route::post('inputsCategories', "InputsCategoriesController@new");
    Route::put('inputsCategories/{id}', "InputsCategoriesController@update");
    Route::delete('inputsCategories/{id}', "InputsCategoriesController@remove");

    /** Subcategoria de Receitas */
    Route::get('inputsSubcategories', "InputsSubcategoriesController@index");
    Route::get('inputsSubcategories/{id}', "InputsSubcategoriesController@show");
    Route::post('inputsSubcategories', "InputsSubcategoriesController@new");
    Route::put('inputsSubcategories/{id}', "InputsSubcategoriesController@update");
    Route::delete('inputsSubcategories/{id}', "InputsSubcategoriesController@remove");

    /** Despesas */
    Route::get('outputs', "OutputsController@index");
    Route::post('outputs/prevision/{account_id}', "OutputsController@showOutputsPrevision");
    Route::post('outputs/madeEffective/{account_id}', "OutputsController@showOutputsMadeEffective");
    Route::post('outputs', "OutputsController@new");
    Route::put('outputs/{id}', "OutputsController@update");
    Route::delete('outputs/{id}', "OutputsController@remove");

    /** Categoria de Despesas */
    Route::get('outputsCategories', "OutputsCategoriesController@index");
    Route::post('outputsCategories', "OutputsCategoriesController@new");
    Route::put('outputsCategories/{id}', "OutputsCategoriesController@update");
    Route::delete('outputsCategories/{id}', "OutputsCategoriesController@remove");

    /** Subcategoria de Despesas */
    Route::get('outputsSubcategories', "OutputsSubcategoriesController@index");
    Route::get('outputsSubcategories/{id}', "OutputsSubcategoriesController@show");
    Route::post('outputsSubcategories', "OutputsSubcategoriesController@new");
    Route::put('outputsSubcategories/{id}', "OutputsSubcategoriesController@update");
    Route::delete('outputsSubcategories/{id}', "OutputsSubcategoriesController@remove");

    /** Contas Bancárias */
    Route::get('accounts', "AccountsController@index");
    Route::post('accounts', "AccountsController@new");
    Route::post('accounts/madeEffective', "AccountsController@showMadeEffective");
    Route::post('accounts/prevision', "AccountsController@showPrevision");
    Route::post('accounts/recurrencesPrevision/{id}', "AccountsController@showRecurrencesPrevision");
    Route::post('accounts/recurrencesMadeEffective/{id}', "AccountsController@showRecurrencesMadeEffective");
    Route::put('accounts/{id}', "AccountsController@update");
    Route::delete('accounts/{id}', "AccountsController@remove");

    /** Recorrências de Pagamento - Receitas e Despesas */
    Route::get('recurrences', "RecurrencesController@index");
    Route::post('recurrences', "RecurrencesController@new");
    Route::put('recurrences/{id}', "RecurrencesController@update");
    Route::delete('recurrences/{id}', "RecurrencesController@remove");

    Route::post('overview/madeEffective', "OverviewController@show");
    Route::post('overview/prevision', "OverviewController@showPrevision");

    /** Usuários */
    Route::get('notifications/{id}', "NotificationsController@show");
    Route::get('notifications/allUnreaded/{id}', "NotificationsController@showUnreaded");
    Route::post('notifications/{id}', "NotificationsController@new");
    Route::get('notifications/readAll/{id}', "NotificationsController@readAll");
    Route::patch('notifications/read/{id}', "NotificationsController@read");
    Route::patch('notifications/unread/{id}', "NotificationsController@unread");

    /** Resumos para o dashboard */
    Route::get('dashboard', 'DashboardController@dashboard');
});
