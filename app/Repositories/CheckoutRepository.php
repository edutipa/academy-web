<?php

namespace App\Repositories;

use App\Models\AppliedCoupon;
use App\Models\Checkout;
use App\Models\Enroll;
use App\Traits\PaymentTrait;
use App\Traits\RandomStringTrait;
use App\Traits\SendNotification;
use Illuminate\Support\Facades\Auth;

class CheckoutRepository
{
    use PaymentTrait, SendNotification, RandomStringTrait;

    public function store($request)
    {
        return Checkout::create($request);
    }

    public function unpaidCheckout($user_id)
    {
        return Checkout::where('user_id', $user_id)->where('status', 0)->first();
    }

    public function checkoutByTrx($trx_id)
    {
        return Checkout::with('enrolls.enrollable')->with('user')->where('trx_id', $trx_id)->first();
    }

    public function update($request, $trx_id)
    {
        $city = Checkout::where('trx_id', $trx_id)->update($request);

        return true;
    }

    public function completeOrder($data, $carts)
    {
        // dd("inside_complete_order");
        $user                    = auth()->user();

        $payment_details         = $this->methodCheck($data);

        if (! $this->successStatusCheck($data, $payment_details)) {
            return __('transaction_cant_be_completed');
        }

        if ($data['payment_type'] == 'aamarpay') {
            $data['trx_id'] = $data['opt_b'];
        }

        $coupon_discount         = 0;
        if (setting('coupon_system')) {
            $coupons         = AppliedCoupon::where('user_id', $user->id)->where('status', 0)->get();
            $coupon_discount = count($coupons) > 0 ? $coupons->sum('coupon_discount') : 0;
        }

        $prefix                  = setting('invoice_prefix') ?: 'OVOY';

        $payable_amount          = $carts->sum('total_amount') - $coupon_discount ;

        $system_commission       = $payable_amount * floatval(setting('system_commission')) / 100;

        $organization_commission = $payable_amount             - $system_commission;

        $data                    = [
            'user_id'                 => $user->id,
            'billing_address'         => null,
            'shipping_address'        => null,
            'trx_id'                  => $data['trx_id'],
            'sub_total'               => $carts->sum('sub_total'),
            'tax'                     => $carts->sum('tax'),
            'discount'                => $carts->sum('discount'),
            'coupon_discount'         => $coupon_discount,
            'total_amount'            => $carts->sum('total_amount'),
            'payable_amount'          => $payable_amount,
            'invoice_no'              => $prefix.'-'.$this->generate_random_string(10, 'number'),
            'invoice_date'            => date('Y-m-d H:i:s'),
            'payment_type'            => $data['payment_type'],
            'payment_details'         => $payment_details,
            'status'                  => 1,
            'system_commission'       => $system_commission,
            'organization_commission' => $organization_commission,
        ];

        $checkout                = $this->store($data);

        $enrolls                 = [];

        foreach ($carts as $cart) {

            $payable_amount          = $cart->total_amount - $cart->discount;

            $system_commission       = $payable_amount * floatval(setting('system_commission')) / 100;

            $organization_commission = $payable_amount     - $system_commission;

            $enrolls[]               = [
                'checkout_id'             => $checkout->id,
                'price'                   => $cart->price,
                'quantity'                => $cart->quantity,
                'coupon_discount'         => $cart->coupon_discount,
                'discount'                => $cart->discount,
                'tax'                     => $cart->tax,
                'shipping_cost'           => $cart->shipping_cost,
                'sub_total'               => $cart->sub_total,
                'enrollable_id'           => $cart->cartable_id,
                'enrollable_type'         => $cart->cartable_type,
                'system_commission'       => $system_commission,
                'organization_commission' => $organization_commission,
            ];
            $cart->delete();
        }
        Enroll::insert($enrolls);

        if ($data['payment_type'] == 'wallet') {
            $wallet_repo = new WalletRepository();

            $wallet      = $wallet_repo->store([
                'user_id'         => $user->id,
                'checkout_id'     => $checkout->id,
                'amount'          => $checkout->payable_amount,
                'source'          => 'course_purchase',
                'type'            => 'expense',
                'payment_method'  => 'wallet',
                'payment_details' => [],
                'trx_id'          => $checkout->trx_id,
                'status'          => 1,
            ]);

            $wallet_repo->updateWallet($user, $checkout->payable_amount, 2);
        }
        if (setting('coupon_system')) {
            $coupons = AppliedCoupon::where('user_id', $user->id)->where('status', 0)->update(['status' => 1]);
        }
        // $users = call_user_func(config('notifiable.on_purchase'));
        // $this->sendNotification($users, __('course_purchased'), 'success', route('course.purchase'), __('See it in Details'));
        return $checkout;
    }
}
