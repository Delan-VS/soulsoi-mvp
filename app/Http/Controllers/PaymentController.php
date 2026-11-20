<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Investment;
use App\Models\Farm;

class PaymentController extends Controller
{
    /**
     * Create a Razorpay Order
     */
    public function createOrder(Request $request)
    {
        $request->validate([
            'amount'  => 'required|numeric|min:1',
            'farm_id' => 'required|exists:farms,id',
        ]);

        $keyId = config('services.razorpay.key') ?: 'rzp_test_TcECKiJIopDD76';
        $keySecret = config('services.razorpay.secret') ?: 'kgFVKPDQA1j57HzM2iMe0yDZ';

        try {
            $api = new Api($keyId, $keySecret);

            $order = $api->order->create([
                'receipt'  => 'rcpt_' . (auth()->id() ?? 'guest') . '_' . time(),
                'amount'   => (int) round($request->amount * 100), // Amount in paise (e.g. ₹20,000 = 2000000 paise)
                'currency' => 'INR',
            ]);

            return response()->json([
                'success'  => true,
                'order_id' => $order['id'],
                'amount'   => $order['amount'],
                'currency' => $order['currency'],
                'key'      => $keyId,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Razorpay Error: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Verify payment signature and record investment
     */
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'razorpay_order_id'   => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature'  => 'required|string',
            'farm_id'             => 'required|exists:farms,id',
            'amount'              => 'required|numeric',
        ]);

        $keyId = config('services.razorpay.key') ?: 'rzp_test_TcECKiJIopDD76';
        $keySecret = config('services.razorpay.secret') ?: 'kgFVKPDQA1j57HzM2iMe0yDZ';

        $api = new Api($keyId, $keySecret);

        // 1. Verify Razorpay cryptographic signature
        try {
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment signature verification failed: ' . $e->getMessage()
            ], 400);
        }

        // 2. Fetch farm and calculate investment share
        $farm = Farm::findOrFail($request->farm_id);
        $target = ($farm->funding_target > 0) ? $farm->funding_target : 350000;
        $equityShare = min(100, round(($request->amount / $target) * 100, 2));

        // 3. Record investment
        $investmentData = [
            'user_id'        => auth()->id(),
            'farm_id'        => $farm->id,
            'amount'         => $request->amount,
            'equity_share'   => $equityShare,
            'payment_method' => 'Razorpay',
            'status'         => 'approved',
        ];

        if (\Illuminate\Support\Facades\Schema::hasColumn('investments', 'razorpay_payment_id')) {
            $investmentData['razorpay_order_id'] = $request->razorpay_order_id;
            $investmentData['razorpay_payment_id'] = $request->razorpay_payment_id;
            $investmentData['razorpay_signature'] = $request->razorpay_signature;
        }

        $investment = Investment::create($investmentData);

        // 4. Increment farm raised funding
        $farm->increment('funding_raised', $request->amount);

        return response()->json([
            'success'      => true,
            'message'      => 'Payment verified and investment recorded successfully!',
            'redirect_url' => route('investor.portfolio.track', $farm->id),
        ]);
    }
}