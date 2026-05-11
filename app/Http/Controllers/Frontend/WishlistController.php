<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class WishlistController extends Controller
{
    function store(string $productId): Response
    {
        if (!Auth::check()) {
            throw ValidationException::withMessages(['Please login for add product in wishlist']);
        }

        $productAlreadyExist = Wishlist::where(['user_id' => auth()->user()->id, 'product_id' => $productId])->exists();
        if ($productAlreadyExist) {
            throw ValidationException::withMessages(['Product is already add to wishlist ']);
        }

        $wishlist = new Wishlist();
        $wishlist->user_id = auth()->user()->id;
        $wishlist->product_id = $productId;
        $wishlist->save();

        return response(['status' => 'success', 'message' => 'Product added to wishlist!']);
    }

    public function destroy(string $id)
    {
        if(!Auth::check()){
            return response(['status' => 'error', 'message' => 'Please login!'], 401);
        }

        $wishlist = Wishlist::where('id', $id)->where('user_id', auth()->user()->id)->first();

        if(!$wishlist){
            return response(['status' => 'error', 'message' => 'Item not found!'], 404);
        }

        $wishlist->delete();

        return response(['status' => 'success', 'message' => 'Product removed from wishlist!']);
    }
}
