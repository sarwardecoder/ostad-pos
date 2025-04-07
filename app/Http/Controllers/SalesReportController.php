<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesReportController extends Controller
{

public function index()
{
    $salesReport = Invoice::with('products')
        ->select('id', 'customer_name', 'invoice_date')
        ->get()
        ->map(function ($invoice) {
            $totalAmount = $invoice->products->sum(function ($product) {
                return $product->quantity * $product->price;
            });

            return [
                'Invoice ID' => $invoice->id,
                'Customer' => $invoice->customer_name,
                'Date' => $invoice->invoice_date->format('Y-m-d'),
                'Total Items' => $invoice->products->sum('quantity'),
                'Total Amount' => number_format($totalAmount, 2),
            ];
        });

    return response()->json($salesReport);
}

}

