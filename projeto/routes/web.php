<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::any('{slug}', function () {

    return view('welcome');

});

Route::get('/payment/success', function () {
    return 'Pagamento realizado com sucesso!';
})->name('payment.success');

Route::get('/payment/failure', function () {
    return 'Pagamento falhou.';
})->name('payment.failure');

Route::get('/payment/pending', function () {
    return 'Pagamento pendente.';
})->name('payment.pending');

