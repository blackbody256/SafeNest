<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Payments;
use App\Models\User;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index()
    {
        $totalRevenue = Payments::sum('amount');
        $underwriterCount = User::where('role','underwriter')->count();
        $underwriterCommission = $totalRevenue * 0.05;
         // Assuming a 5% commission rate
        $netRevenue = $totalRevenue - $underwriterCommission; 

        $monthlyRevenue = Payments::whereYear('created_at', now()->year)
        ->whereMonth('created_at', now()->month)
        ->sum('amount');

        $revenueChart = $this->getRevenueChartData();

        $recentPayments = Payments::with(['policy', 'user'])
            ->where('status', 'paid')
            ->orderBy('created_at', 'desc')    //TODO: Add pagination
            ->take(10)
            ->get();

        return view('admin.payments.index', [
            'totalRevenue' => $totalRevenue,
            'monthlyRevenue' => $monthlyRevenue,

            'netRevenue' => $netRevenue,
            
            'underwriterCommission' => $underwriterCommission,
            'revenueChart' => $revenueChart,
            'recentPayments' => $recentPayments,
        ]);
    }

    protected function getRevenueChartData()
    {
        $data = [];
        $labels = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->format('M Y');

            $total = Payments::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('amount');

            $labels[] = $monthName;
            $data[] = $total;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
}

