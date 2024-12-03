<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  // นำเข้า Illuminate\Http\Request
use App\Models\Transaction;

class TransactionController extends Controller
{
    // แสดงรายการการใช้จ่ายและคำนวณยอดรวม
    public function index(Request $request)
    {
        $month = $request->input('month');
        if ($month) {
            $transactions = Transaction::whereMonth('expense_date', date('m', strtotime($month)))
                                        ->whereYear('expense_date', date('Y', strtotime($month)))
                                        ->get();
        } else {
            $transactions = Transaction::all();
        }
    
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;
    
        return view('transactions.index', compact('transactions', 'totalIncome', 'totalExpense', 'balance'));
    }
    

    // บันทึกข้อมูลการใช้จ่ายใหม่
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'expense_date' => 'required|date',
        ]);

        Transaction::create([
            'type' => $validated['type'],
            'title' => $validated['title'],
            'amount' => $validated['amount'],
            'expense_date' => $validated['expense_date'],
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction added successfully.');
    }

    // ลบข้อมูลการใช้จ่าย
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}
