<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use App\Models\ApprovedPolicy;
use App\Models\Policy;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the customer's payments.
     */
    public function index()
    {
        // Update payment statuses first
        Payments::updatePaymentStatuses();
        
        $payments = Payments::with(['policy', 'approvedPolicy'])
            ->where('user_id', Auth::id())
            ->orderBy('due_date')
            ->get();
            
        return view('customer.payments.index', [
            'payments' => $payments,
            'title' => 'My Payments',
            'activePage' => 'mypayments',
            'navName' => 'My Payments',
            'activeButton' => 'laravel'
        ]);
    }
    
    /**
     * Generate payment schedule for an approved policy
     */
    public static function generatePaymentSchedule($approvedPolicyId)
    {
        // Get the approved policy with related data
        $approvedPolicy = ApprovedPolicy::with('policy')
            ->findOrFail($approvedPolicyId);
            
        $policy = $approvedPolicy->policy;
        $userId = $approvedPolicy->User_ID;
        $policyId = $approvedPolicy->Policy_ID;
        $startDate = Carbon::now();
        $endDate = $approvedPolicy->expires_at;
        
        // Calculate number of months from start to expiration
        $diffInMonths = $startDate->diffInMonths($endDate);
        
        // Ensure at least one payment
        $numPayments = max(1, $diffInMonths);
        $premium = floatval($policy->Premium);
        
        // Calculate monthly payment amount
        $paymentAmount = $premium / $numPayments;
        
        // Generate payment schedule
        $payments = [];
        for ($i = 0; $i < $numPayments; $i++) {
            $dueDate = $startDate->copy()->addMonths($i);
            
            // Create payment record
            $payment = Payments::create([
                'user_id' => $userId,
                'policy_id' => $policyId,
                'approved_policy_id' => $approvedPolicyId,
                'amount' => $paymentAmount,
                'due_date' => $dueDate,
                'status' => 'pending'
            ]);
            
            $payments[] = $payment;
        }
        
        return $payments;
    }
    
    /**
     * Process a payment for a specific payment record
     */
    public function makePayment($paymentId)
    {
        $payment = Payments::where('user_id', Auth::id())
            ->findOrFail($paymentId);
            
        // Check if already paid
        if ($payment->status === 'paid') {
            return redirect()->back()->with('error', 'This payment has already been processed.');
        }
        
        // Update payment status to paid
        $payment->status = 'paid';
        $payment->payment_date = Carbon::now();
        $payment->save();
        
        return redirect()->back()->with('success', 'Payment processed successfully!');
    }
    
    /**
     * Get payment summary for a specific approved policy
     */
    public static function getPaymentSummary($approvedPolicyId)
    {
        Payments::updatePaymentStatuses();
        
        $payments = Payments::where('approved_policy_id', $approvedPolicyId)->get();
        
        $totalAmount = $payments->sum('amount');
        $paidAmount = $payments->where('status', 'paid')->sum('amount');
        $pendingAmount = $payments->whereIn('status', ['pending', 'overdue'])->sum('amount');
        $overdueCount = $payments->where('status', 'overdue')->count();
        
        return [
            'total' => $totalAmount,
            'paid' => $paidAmount,
            'pending' => $pendingAmount,
            'overdueCount' => $overdueCount,
            'nextPayment' => $payments->where('status', '!=', 'paid')
                ->sortBy('due_date')
                ->first()
        ];
    }

    /**
     * View payments for a specific policy
     */
    public function viewPolicyPayments($approvedPolicyId)
    {
        // Update payment statuses first
        Payments::updatePaymentStatuses();
        
        $approvedPolicy = ApprovedPolicy::with('policy')
            ->where('User_ID', Auth::id())
            ->findOrFail($approvedPolicyId);
            
        $payments = Payments::where('approved_policy_id', $approvedPolicyId)
            ->orderBy('due_date')
            ->get();
            
        return view('customer.payments.view', [
            'approvedPolicy' => $approvedPolicy,
            'payments' => $payments,
            'title' => 'Policy Payments',
            'activePage' => 'mypayments',
            'navName' => 'Policy Payments',
            'activeButton' => 'laravel'
        ]);
    }

/**
 * Update approved policy in case its expiry status needs to be checked
 */
    public static function checkPolicyExpiryStatus()
    {
        $now = Carbon::now();
        
        // Get all active policies with expired payment schedules
        $policies = ApprovedPolicy::where('Status', 'active')
            ->where('expires_at', '<', $now)
            ->get();
            
        foreach ($policies as $policy) {
            // Check if all payments have been made
            $allPaymentsMade = Payments::where('approved_policy_id', $policy->Approved_Policy_ID)
                ->where('status', '!=', 'paid')
                ->count() === 0;
                
            // If all payments are complete, set to expired
            // Otherwise, set to inactive due to non-payment
            $policy->Status = $allPaymentsMade ? 'expired' : 'inactive';
            $policy->save();
        }
    }

        /**
     * This method should be called by a scheduler to check payment and policy statuses
     */
    public static function runScheduledChecks()
    {
        // Update payment statuses (overdue)
        Payments::updatePaymentStatuses();
        
        // Check policy expiry status
        self::checkPolicyExpiryStatus();
    }

}