<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use App\DataTables\FaqDataTable;

class FaqController extends Controller
{
    public function index(FaqDataTable $dataTable)
    {
        return $dataTable->render('admin.faq.index');
    }

    public function create()
    {
        return view('admin.faq.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required',
            'status' => 'required|boolean'
        ]);

        Faq::create($request->all());

        return redirect()->route('admin.faq.index')->with([
            'message' => 'FAQ Created Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function edit(Faq $faq)
    {
        return view('admin.faq.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required',
            'status' => 'required|boolean'
        ]);

        $faq->update($request->all());

        return redirect()->route('admin.faq.index')->with([
            'message' => 'FAQ Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function destroy(string $id)
    {
        try{
            $faq = Faq::findOrFail($id);
            $faq->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully']);
        }catch(\Exception $e){
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
