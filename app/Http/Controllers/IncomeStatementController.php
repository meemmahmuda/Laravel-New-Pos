<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Order;
use App\Models\SalesReturn;
use App\Models\Product;
use App\Models\Expense; // Import the Expense model
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF; 

class IncomeStatementController extends Controller
{
    public function index(Request $request)
    {
        // Get the selected month from the request, default to the current month
        $selectedMonth = $request->input('month', date('Y-m'));

        // Aggregate sales for the entire month (Gross Sales, Discounts)
        $sales = Sale::selectRaw('SUM(total_price) as total_sales, SUM(discount) as total_discounts')
            ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$selectedMonth])
            ->first();

        // Aggregate purchases for the entire month
        $orders = Order::selectRaw('SUM(total_price) as total_purchases')
            ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$selectedMonth])
            ->first();

        // Aggregate sales returns for the entire month
        $salesReturns = SalesReturn::selectRaw('SUM(total_price) as total_returns')
            ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$selectedMonth])
            ->first();

        // Calculate beginning stock (stock at the start of the month)
        $beginningStock = Product::sum('stock');  // Assuming stock is tracked and available

        // Calculate ending stock (stock at the end of the month)
        $endingStock = Product::sum('stock'); // Placeholder, adjust logic to reflect actual end-of-month stock

        // Calculate total operating expenses for the entire month
        $expenses = Expense::selectRaw('SUM(total_expense) as total_expenses')
            ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$selectedMonth])
            ->first();

        // Handle cases where no data is returned
        $totalSales = $sales->total_sales ?? 0;
        $totalDiscounts = $sales->total_discounts ?? 0;
        $totalPurchases = $orders->total_purchases ?? 0;
        $totalSalesReturns = $salesReturns->total_returns ?? 0;
        $totalExpenses = $expenses->total_expenses ?? 0;

        // Define Interest Income and Interest Expense
        $interestIncome = 1000; // Example value
        $interestExpense = 500; // Example value

        // Calculate Net Sales: Gross Sales - Discounts - Sales Returns
        $netSales = $totalSales - $totalDiscounts - $totalSalesReturns;

        // Calculate COGS: Beginning Stock + Purchases - Ending Stock
        $COGS = $beginningStock + $totalPurchases - $endingStock;

        // Calculate Gross Profit: Net Sales - COGS
        $grossProfit = $netSales - $COGS;

        // Calculate Operating Profit: Gross Profit - Operating Expenses
        $operatingProfit = $grossProfit - $totalExpenses;

        // Calculate Net Income Before Taxes: Operating Profit + Interest Income - Interest Expense
        $netIncomeBeforeTaxes = $operatingProfit + $interestIncome - $interestExpense;

        // Calculate Taxes: 15% of Net Income Before Taxes
        $taxes = 0.15 * $netIncomeBeforeTaxes;

        // Calculate Net Income: Net Income Before Taxes - Taxes
        $netIncome = $netIncomeBeforeTaxes - $taxes;

        // Prepare the income statement data for the view
        $incomeStatement = [
            'gross_sales' => $totalSales,
            'discount_amount' => $totalDiscounts,
            'sales_return_amount' => $totalSalesReturns,
            'net_sales' => $netSales,
            'purchase_amount' => $totalPurchases,
            'cogs' => $COGS,
            'gross_profit' => $grossProfit,
            'operating_expenses' => $totalExpenses,
            'operating_profit' => $operatingProfit,
            'interest_income' => $interestIncome,
            'interest_expense' => $interestExpense,
            'net_income_before_taxes' => $netIncomeBeforeTaxes,
            'taxes' => $taxes,
            'net_income' => $netIncome,
        ];

        // Pass the selected month and income statement to the view
        return view('income_statement.index', compact('incomeStatement', 'selectedMonth'));
    }


    public function print(Request $request)
    {
        $selectedMonth = $request->input('month', date('Y-m'));
    
        // Repeat the logic to calculate the income statement
        // Aggregate sales for the entire month (Gross Sales, Discounts)
        $sales = Sale::selectRaw('SUM(total_price) as total_sales, SUM(discount) as total_discounts')
            ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$selectedMonth])
            ->first();
    
        // Aggregate purchases for the entire month
        $orders = Order::selectRaw('SUM(total_price) as total_purchases')
            ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$selectedMonth])
            ->first();
    
        // Aggregate sales returns for the entire month
        $salesReturns = SalesReturn::selectRaw('SUM(total_price) as total_returns')
            ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$selectedMonth])
            ->first();
    
        // Calculate total operating expenses for the entire month
        $expenses = Expense::selectRaw('SUM(total_expense) as total_expenses')
            ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$selectedMonth])
            ->first();
    
        // Handle cases where no data is returned
        $totalSales = $sales->total_sales ?? 0;
        $totalDiscounts = $sales->total_discounts ?? 0;
        $totalPurchases = $orders->total_purchases ?? 0;
        $totalSalesReturns = $salesReturns->total_returns ?? 0;
        $totalExpenses = $expenses->total_expenses ?? 0;
    
        // Define Interest Income and Interest Expense
        $interestIncome = 1000; // Example value
        $interestExpense = 500; // Example value
    
        // Calculate Net Sales: Gross Sales - Discounts - Sales Returns
        $netSales = $totalSales - $totalDiscounts - $totalSalesReturns;
    
        // Calculate COGS: Beginning Stock + Purchases - Ending Stock
        $COGS = Product::sum('stock') + $totalPurchases - Product::sum('stock');
    
        // Calculate Gross Profit: Net Sales - COGS
        $grossProfit = $netSales - $COGS;
    
        // Calculate Operating Profit: Gross Profit - Operating Expenses
        $operatingProfit = $grossProfit - $totalExpenses;
    
        // Calculate Net Income Before Taxes: Operating Profit + Interest Income - Interest Expense
        $netIncomeBeforeTaxes = $operatingProfit + $interestIncome - $interestExpense;
    
        // Calculate Taxes: 15% of Net Income Before Taxes
        $taxes = 0.15 * $netIncomeBeforeTaxes;
    
        // Calculate Net Income: Net Income Before Taxes - Taxes
        $netIncome = $netIncomeBeforeTaxes - $taxes;
    
        // Prepare the income statement data for the PDF
        $incomeStatement = [
            'gross_sales' => $totalSales,
            'discount_amount' => $totalDiscounts,
            'sales_return_amount' => $totalSalesReturns,
            'net_sales' => $netSales,
            'purchase_amount' => $totalPurchases,
            'cogs' => $COGS,
            'gross_profit' => $grossProfit,
            'operating_expenses' => $totalExpenses,
            'operating_profit' => $operatingProfit,
            'interest_income' => $interestIncome,
            'interest_expense' => $interestExpense,
            'net_income_before_taxes' => $netIncomeBeforeTaxes,
            'taxes' => $taxes,
            'net_income' => $netIncome,
        ];
    
        // Generate the PDF
        $pdf = PDF::loadView('income_statement.pdf', compact('incomeStatement', 'selectedMonth'));
    
        return $pdf->download('income_statement_' . $selectedMonth . '.pdf');
    }
    

    
}