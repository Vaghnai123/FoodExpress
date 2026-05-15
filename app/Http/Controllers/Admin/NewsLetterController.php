<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SubscriberDataTable;
use App\Http\Controllers\Controller;
use App\Mail\NewsLetter;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Mail;

class NewsLetterController extends Controller
{
    function index(SubscriberDataTable $dataTable)
    {
        return $dataTable->render('admin.news-letter.index');
    }

    function sendNewsLetter(Request $request)
    {
        $request->validate([
            'subject' => ['required', 'max:255'],
            'message' => ['required']
        ]);

        $subscribers = Subscriber::pluck('email')->toArray();

        foreach ($subscribers as $email) {
            try {
                Mail::to($email)->send(new NewsLetter($request->subject, $request->message));
            } catch (\Exception $e) {
                Log::error("Newsletter failed for email {$email}: " . $e->getMessage());
            }
        }

        return redirect()->back()->with([
            'message' => 'News letter sent successfully!',
            'alert-type' => 'success'
        ]);
    }
}
