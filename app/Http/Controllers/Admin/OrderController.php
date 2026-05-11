<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DeclinedOrderDataTable;
use App\DataTables\DeliveredOrderDataTable;
use App\DataTables\InProcessOrderDataTable;
use App\DataTables\OrderDataTable;
use App\DataTables\PendingOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderPlacedNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    function index(OrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.index');
    }

    function pendingOrderIndex(PendingOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.pending-order-index');
    }

    function inProcessOrderIndex(InProcessOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.inprocess-order-index');
    }

    function deliveredOrderIndex(DeliveredOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.delivered-order-index');
    }

    function declinedOrderIndex(DeclinedOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.declined-order-index');
    }

    function show($id): View
    {
        $order = Order::findOrFail($id);
        $notification = OrderPlacedNotification::where('order_id', $order->id)->update(['seen' => 1]);
        
        return view('admin.order.show', compact('order'));
    }

    function getOrderStatus(string $id): Response
    {
        $order = Order::select(['order_status', 'payment_status'])->findOrFail($id);

        return response($order);
    }

    function orderStatusUpdate(Request $request, string $id)
    {
        $request->validate([
            'payment_status' => ['required', 'in:pending,completed'],
            'order_status' => ['required', 'in:pending,in_process,delivered,declined']
        ]);

        $order = Order::findOrFail($id);
        $order->payment_status = $request->payment_status;
        $order->order_status = $request->order_status;
        $order->save();

        if ($request->ajax()) {
            return response(['message' => 'Order Status Updated!']);
        } else {
            toastr()->success('Status Updated Successfully!');

            return redirect()->back();
        }
    }

    function destroy(string $id): Response
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }

    public function downloadInvoice($id)
    {
        $order = Order::with('userAddress', 'orderItems')->findOrFail($id);

        $pdf = Pdf::setOption(['isRemoteEnabled' => true])->loadView('admin.order.invoice-pdf', compact('order'));

        return $pdf->download('Invoice_#' . $order->invoice_id . '.pdf');
    }
}
