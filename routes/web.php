<?php

function make_router($r, $path, $controller) {
    $r->get($path, $controller . '@index');
    $r->get($path . '/{id:[0-9]+}', $controller . '@show');
    $r->post($path, $controller . '@store');
    $r->delete($path . '/{id:[0-9]+}', $controller . '@destroy');
    $r->put($path . '/{id:[0-9]+}', $controller . '@update');
}


$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'api'], function () use ($router) {

    make_router($router, 'clientes', 'ClienteController');
    make_router($router, 'mesas', 'MesaController');
    make_router($router, 'pedidos', 'PedidoController');
    make_router($router, 'productos', 'ProductoController');
    make_router($router, 'reservas', 'ReservaController');

    $router->get('pedidos-por-reserva/{id:[0-9]+}', 'PedidoController@showPorReserva');

    $router->get('reserva-por-nombre-cliente', 'ReservaController@buscarPorCliente');

});