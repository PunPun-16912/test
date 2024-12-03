<?php


use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return redirect('/transactions'); 
});

// เปลี่ยนจาก 'indexTransactions' เป็น 'index' หรือกลับกัน
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::put('/transactions/{id}', [TransactionController::class, 'update'])->name('transactions.update');
Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

Route::get('/report/{month}', [TransactionController::class, 'report'])->name('transactions.report');
