@extends('layouts.adminapp', [
    'activePage' => 'payments',
    'title' => 'Payments Dashboard',
    'navName' => 'Payment Monitoring',
    'activeButton' => 'laravel'
])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Payment Stats Cards -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-money-coins text-success"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Total Revenue</p>
                                    <p class="card-title">${{ number_format($totalRevenue, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-credit-card text-info"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">This Month</p>
                                    <p class="card-title">${{ number_format($monthlyRevenue, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Chart -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Revenue Overview</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" height="100"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Payments -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Recent Transactions</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Payment ID</th>
                                        <th>Policy</th>
                                        <th>User</th>
                                        <th>Amount</th>
                                        
                                        <th>Date</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($recentPayments as $payment)
<tr>
    <td>{{ $payment->id }}</td>
    <td>{{ $payment->policy->Policy_ID ?? 'N/A' }}</td>
    <td>{{ $payment->user->name ?? 'N/A' }}</td>
    <td>${{ number_format($payment->amount, 2) }}</td>
    <td>{{ $payment->created_at->format('M d, Y') }}</td>
</tr>
@endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart');

    if (!ctx) {
        console.error('Revenue chart element not found');
        return;
    }

    const revenueLabels = JSON.parse('{!! json_encode($revenueChart["labels"]) !!}');
    const revenueData = JSON.parse('{!! json_encode($revenueChart["data"]) !!}');

    new Chart(ctx.getContext('2d'), {
        type: 'line',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Monthly Total Payments',
                data: revenueData,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#fff',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + parseFloat(value).toLocaleString();
                        }
                    },
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '$' + parseFloat(context.raw).toLocaleString();
                        }
                    }
                },
                legend: {
                    display: false
                }
            }
        }
    });
});


</script>
@endpush
@endsection