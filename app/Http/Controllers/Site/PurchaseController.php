<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Repositories\CartRepository;
use App\Repositories\CheckoutRepository;
use App\Repositories\CouponRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    protected $courseRepository;

    protected $checkoutRepository;

    protected $cartRepository;

    public function __construct(CartRepository $cartRepository, CheckoutRepository $checkoutRepository)
    {
        $this->cartRepository     = $cartRepository;
        $this->checkoutRepository = $checkoutRepository;
    }

    public function checkout(CouponRepository $couponRepository): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {

        try {

            $carts   = $this->cartRepository->all([
                'user_id' => auth()->id(),
            ]);

            if (count($carts) == 0) {
                Toastr::error(__('No item in your cart.'));

                return redirect()->route('home');
            }

            $image   = 'https://lms.spagreen.net/public/frontend/img/logo.png';

            if (setting('dark_logo') && @is_file_exists(setting('dark_logo')['original_image'])) {
                $image = get_media(setting('dark_logo')['original_image']);
            } elseif (setting('light_logo') && @is_file_exists(setting('light_logo')['original_image'])) {
                $image = get_media(setting('light_logo')['original_image']);
            }

            $trx_id = $carts->first()->trx_id;
            $coupons = $couponRepository->appliedCoupons(['user_id' => auth()->id(),'trx_id' => $trx_id], 'coupon');
            $total_discount = $carts->sum('discount') + $coupons->sum('coupon_discount');
            $amount  = $carts->sum('total_amount') - $total_discount;
            $data    = [
                'user_carts'     => $carts,
                'trx_id'         => $trx_id,
                'amount'         => $amount,
                'gh_price'       => round(convert_price($amount, 'GHS') * 100),
                'image'          => $image,
                'coupons'        => $coupons,
                'total_discount' => $coupons->sum('coupon_discount')
            ];
            return view('frontend.payment_gateway', $data);
        } catch (\Exception $e) {
            Toastr::error($e->getMessage());
            return back();
        }
    }

    public function completeOrder(Request $request): \Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $data                 = $request->all();
        if ($request->opt_b) {
            $userId      = $request->opt_d;
            $trxId       = $request->opt_b;
            $paymentType = 'aamarpay';
        } else {
            $userId      = auth()->id();
            $trxId       = $request->trx_id;
            $paymentType = $request->payment_type;
        }

        $data['trx_id']       = $trxId;
        $data['user_id']      = $userId;
        $data['payment_type'] = $paymentType;

        DB::beginTransaction();
        try {
            $carts = $this->cartRepository->all([
                'user_id' => $userId,
            ]);

            $order = $this->checkoutRepository->completeOrder($data, $carts);

            if (is_string($order)) {
                $data = [
                    'error' => $order,
                ];
                DB::commit();

                if (request()->ajax()) {
                    return response()->json($data);
                } else {
                    Toastr::error($order);

                    return redirect('checkout');
                }
            }

            DB::commit();
            if (request()->ajax()) {
                $data = [
                    'success' => __('purchase_done'),
                    'url'     => url('user/invoice/'.$trxId),
                ];


                return response()->json($data);
            } else {
                Toastr::success(__('Order placed successfully.'));

                if(!$trxId){
                    return redirect('purchase-courses');
                }
                return redirect('user/invoice/'.$trxId);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            if (request()->ajax()) {
                return response()->json([
                    'error' => $e->getMessage(),
                ]);
            } else {
                Toastr::success($e->getMessage());

                return back();
            }
        }
    }

    public function invoice($trx_id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $data = [
                'checkout' => $this->checkoutRepository->checkoutByTrx($trx_id),
            ];

            return view('frontend.successful_order', $data);

        } catch (\Exception $e) {
            Toastr::success($e->getMessage());

            return back();
        }
    }

    public function downloadInvoice($trx_id): \Illuminate\Http\Response
    {
        ini_set('max_execution_time', 1000);
        $logo_url = (setting('dark_logo') && @is_file_exists(setting('dark_logo')['original_image']) ?
            get_media(setting('dark_logo')['original_image']) :
            get_media('images/default/logo/logo-green-black.png'));

        $checkout = $this->checkoutRepository->checkoutByTrx($trx_id);

        if (auth()->id() != $checkout->user_id)
        {
            abort(404);
        }

        $data     = [
            'logo_url'          => $logo_url,
            'checkout'          => $checkout,
            'coupon_discount'   => null,
        ];

        $pdf      = Pdf::loadView('frontend.invoice', $data);

        $pdf_name = "$checkout->invoice_no.pdf";

        return $pdf->download($pdf_name);
    }

    public function refund(Request $request)
    {

    }
}
