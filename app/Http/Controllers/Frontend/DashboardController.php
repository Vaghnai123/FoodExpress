<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Frontend\AddressCreateRequest;
use App\Models\DeliveryArea;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\ProductRating;
use App\Models\Address;
use App\Models\Wishlist;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        $deliveryAreas = DeliveryArea::where('status', 1)->get();
        $userAddresses = Address::where('user_id', auth()->user()->id)->get();
        $reservations = Reservation::where('user_id', auth()->user()->id)->latest()->paginate(10);
        $orders = Order::where('user_id', auth()->user()->id)->latest()->paginate(10);
        $reviews = ProductRating::where('user_id', auth()->user()->id)->latest()->paginate(5);
        $wishlist = Wishlist::with('product')->where('user_id', auth()->user()->id)->latest()->paginate(6);
        $totalOrders = Order::where('user_id', auth()->user()->id)->count();
        $totalCompleteOrders = Order::where('user_id', auth()->user()->id)->where('order_status', 'delivered')->count();
        $totalCancelOrders = Order::where('user_id', auth()->user()->id)->where('order_status', 'declined')->count();
        return view('frontend.dashboard.index', compact('deliveryAreas', 'userAddresses', 'orders','reservations','reviews','wishlist','totalOrders', 'totalCompleteOrders', 'totalCancelOrders'));
    }

    function createAddress(AddressCreateRequest $request)
    {
        $address = new Address();
        $address->user_id = auth()->user()->id;
        $address->delivery_area_id = $request->area;
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name;
        $address->email = $request->email;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->type = $request->type;
        $address->save();

        return redirect()->back()->with([
            'message' => 'Address Created Successfully',
            'alert-type' => 'success'
        ]);
    }

    function updateAddress(string $id, AddressCreateRequest $request)
    {
        $address = Address::findOrFail($id);
        $address->user_id = auth()->user()->id;
        $address->delivery_area_id = $request->area;
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name;
        $address->email = $request->email;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->type = $request->type;
        $address->save();

        return redirect()->back()->with([
            'message' => 'Address Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    function destroyAddress(string $id)
    {
        $address = Address::findOrFail($id);
        if ($address && $address->user_id === auth()->user()->id) {
            $address->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully']);
        }
        return response(['status' => 'error', 'message' => 'something went wrong!']);
    }

    public function downloadInvoice($id)
    {
        $order = Order::with('userAddress', 'orderItems')
            ->where('user_id', auth()->user()->id)
            ->findOrFail($id);

        $pdf = Pdf::setOption(['isRemoteEnabled' => true])
            ->loadView('admin.order.invoice-pdf', compact('order'));

        return $pdf->download('Invoice_#' . $order->invoice_id . '.pdf');
    }
}
