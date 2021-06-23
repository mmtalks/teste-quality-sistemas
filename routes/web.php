<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return view('index');
});

$router->get('/dependentes/{pessoa_id}', function () use ($router) {
    return view('dependentes');
});

$router->get('/lista', function () use ($router) {
    return view('lista');
});

$router->get('/form', function () use ($router) {
    return view('form');
});

$router->get('/form/{pessoa_id}', function () use ($router) {
    return view('form_edit');
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/listagem-de-pessoas', 'PessoasController@listagemPessoas');
    $router->get('/pessoa', 'PessoasController@pessoa');
    $router->get('/dependentes-por-pessoa', 'DependentesController@dependentesPorPessoa');

    $router->post('/adicionar-dependente', 'DependentesController@adicionarDependente');
    $router->post('/adicionar-pessoa', 'PessoasController@adicionarPessoa');

    $router->delete('/deletar-pessoa', 'PessoasController@deletarPessoa');
    $router->delete('/deletar-dependente', 'DependentesController@deletarDependente');

    $router->put('/atualizar-pessoa', 'PessoasController@atualizarPessoa');
    
});