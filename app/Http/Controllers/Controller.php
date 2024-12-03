<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
    public function store(Request $request) {
        $request->validate([
            'type' => 'required|in:income,expense',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
        ]);
    
        Transaction::create($request->all());
        return response()->json(['message' => 'Transaction created successfully'], 201);
    }
    
    public function update(Request $request, $id) {
        $transaction = Transaction::findOrFail($id);
        $transaction->update($request->all());
        return response()->json(['message' => 'Transaction updated successfully']);
    }
    
    public function destroy($id) {
        Transaction::findOrFail($id)->delete();
        return response()->json(['message' => 'Transaction deleted successfully']);
    }
    
    public function index(Request $request)
{
    $query = Transaction::query();

    if (request('month')) {
        $month = request('month');
        $query->whereMonth('expense_date', '=', date('m', strtotime($month)))
              ->whereYear('expense_date', '=', date('Y', strtotime($month)));
    }

    $transactions = $query->orderBy('expense_date', 'desc')->get();

    return view('transactions.index', compact('transactions'));
}


    public function report($month) {
        $transactions = Transaction::whereMonth('expense_date', $month)->get();
        $income = $transactions->where('type', 'income')->sum('amount');
        $expense = $transactions->where('type', 'expense')->sum('amount');
        $balance = $income - $expense;
    
        return response()->json([
            'income' => $income,
            'expense' => $expense,
            'balance' => $balance,
        ]);
    }
    
    
}
