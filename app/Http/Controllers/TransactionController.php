<?php
namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function transaction()
    {
        // Fetch all sales and eager load the related user and salesItems
        $sales = Sale::with('user', 'salesItems.item')->get();

        // Calculate totals
        $totalTransactions = $sales->count();
        $totalItems = $sales->reduce(function ($carry, $sale) {
            return $carry + $sale->salesItems->sum('quantity');
        }, 0);
        $totalSpent = $sales->sum('total_price');

        // Pass sales data and totals to the view
        return view('Transaction.Transaction', compact('sales', 'totalTransactions', 'totalItems', 'totalSpent'));
    }

    public function show($id)
    {
        // Fetch the sale record by id, including related user and salesItems
        $sale = Sale::with('user', 'salesItems.item')->findOrFail($id);

        // Return the detail view with the sale data
        return view('Transaction.detail', compact('sale'));
    }
}
