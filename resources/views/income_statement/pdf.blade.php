@extends('layouts.master')
@section('title', 'Income Statement PDF')

@section('content')
<div class="container">
    <h1>Income Statement for {{ date('F, Y', strtotime($selectedMonth)) }}</h1>

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Details</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Gross Sales</td>
                <td>TK {{ number_format($incomeStatement['gross_sales'], 2) }}</td>
            </tr>
            <tr>
                <td>(-) Discounts</td>
                <td>TK {{ number_format($incomeStatement['discount_amount'], 2) }}</td>
            </tr>
            <tr>
                <td>(-) Sales Returns</td>
                <td>TK {{ number_format($incomeStatement['sales_return_amount'], 2) }}</td>
            </tr>
            <tr style="font-weight: bold;">
                <td>Net Sales</td>
                <td>TK {{ number_format($incomeStatement['net_sales'], 2) }}</td>
            </tr>
            <tr>
                <td>(-) Purchases</td>
                <td>TK {{ number_format($incomeStatement['purchase_amount'], 2) }}</td>
            </tr>
            <tr>
                <td>Cost of Goods Sold (COGS)</td>
                <td>TK {{ number_format($incomeStatement['cogs'], 2) }}</td>
            </tr>
            <tr style="font-weight: bold;">
                <td>Gross Profit</td>
                <td>TK {{ number_format($incomeStatement['gross_profit'], 2) }}</td>
            </tr>
            <tr>
                <td>(-) Operating Expenses</td>
                <td>TK {{ number_format($incomeStatement['operating_expenses'], 2) }}</td>
            </tr>
            <tr style="font-weight: bold;">
                <td>Operating Profit (EBIT)</td>
                <td>TK {{ number_format($incomeStatement['operating_profit'], 2) }}</td>
            </tr>
            <tr>
                <td>(+) Interest Income</td>
                <td>TK {{ number_format($incomeStatement['interest_income'], 2) }}</td>
            </tr>
            <tr>
                <td>(-) Interest Expense</td>
                <td>TK {{ number_format($incomeStatement['interest_expense'], 2) }}</td>
            </tr>
            <tr style="font-weight: bold;">
                <td>Net Income Before Taxes (EBT)</td>
                <td>TK {{ number_format($incomeStatement['net_income_before_taxes'], 2) }}</td>
            </tr>
            <tr>
                <td>(-) Taxes (15%)</td>
                <td>TK {{ number_format($incomeStatement['taxes'], 2) }}</td>
            </tr>
            <tr style="font-weight: bold;">
                <td>Net Income/Loss</td>
                <td>TK {{ number_format($incomeStatement['net_income'], 2) }}</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
