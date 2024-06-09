<?php

namespace App\Repositories;

use App\Models\OfflineMethod;
use App\Models\Wallet;
use App\Traits\ImageTrait;
use App\Traits\PaymentTrait;
use App\Traits\SendNotification;

class WalletRepository
{
    use PaymentTrait,ImageTrait,SendNotification;

    public function all($data = [], $with = [])
    {
        if (! arrayCheck('paginate', $data)) {
            $data['paginate'] = setting('paginate');
        }

        return Wallet::with($with)->when(arrayCheck('user_id', $data), function ($query) {
            $query->where('user_id', auth()->id());
        })->latest()->paginate($data['paginate']);
    }

    public function store($request)
    {
        $image_response = arrayCheck('image', $request) ? $this->saveImage($request['image'], 'single_file') : [];

        return Wallet::create([
            'user_id'         => $request['user_id'],
            'walletable_id'   => getArrayValue('walletable_id',$request),
            'walletable_type' => getArrayValue('walletable_type',$request),
            'amount'          => $request['amount'],
            'source'          => $request['source'],
            'type'            => $request['type'],
            'payment_method'  => getArrayValue('payment_method',$request),
            'payment_details' => getArrayValue('payment_details',$request,[]),
            'trx_id'          => getArrayValue('trx_id',$request),
            'status'          => $request['status'],
            'image'           => getArrayValue('trx_id',$request,[]),
        ]);
    }

    public function updateWallet($user, $amount, $type)
    {
        if ($type == 1) {
            $user->balance += $amount;
        } else {
            $user->balance -= $amount;
        }

        $user->save();

        return $user;
    }

    public function walletRecharge($data)
    {
        $source                    = 'wallet_recharge';
        $amount                    = arrayCheck('total', $data) ? $data['total'] : $data['amount'];
        $payment_details           = [];

        if (arrayCheck('id', $data)) {
            $source                   = 'offline_recharge';
            $offline_payment          = OfflineMethod::find($data['id']);
            $payment_details['name']  = $offline_payment->name;
            $payment_details['image'] = $offline_payment->image;
            $payment_details['type']  = $offline_payment->type;
        } else {
            $payment_details = $this->methodCheck($data, []);
        }

        $currency                  = new CurrencyRepository();

        if (session()->has('currency')) {
            $user_currency = session()->get('currency');
        } else {
            $user_currency = setting('default_currency');
        }
        $active_currency           = $currency->get($user_currency);
        //remove shipping charges
        $wallet['user_id']         = auth()->id();
        $wallet['walletable_id']   = null;
        $wallet['amount']          = $amount / $active_currency->exchange_rate;
        $wallet['source']          = $source;
        $wallet['type']            = 'income';
        $wallet['status']          = 'pending';
        $wallet['image']           = arrayCheck('file', $data) ? $data['file'] : [];
        $wallet['trx_id']          = arrayCheck('trx_id', $data) ? $data['trx_id'] : null;
        $wallet['payment_method']  = $data['payment_type'];
        $wallet['payment_details'] = $payment_details;

        if (array_key_exists('payment_type', $payment_details) && $payment_details['payment_type'] == 'aamarpay') {
            $token                = \Illuminate\Support\Facades\DB::table('payment_methods')->where('trx_id', $data['opt_b'])->first();
            $data['payment_type'] = 'aamarpay';
            $wallet['amount']     = $token->amount;
        }

        $this->store($wallet);

        $repo                      = new UserRepository();

        $this->sendNotification($repo->find(1), 'New Wallet Request Is Created.', 'success', url('wallet/recharge-requests'), '');

        return $payment_details;
    }

    public function changeStatus($data)
    {
        $wallet         = Wallet::find($data['id']);
        $wallet->status = $data['status'];
        $wallet->save();

        $this->updateWallet($wallet->user, $wallet->amount, $data['status']);

        return $wallet;
    }
}
