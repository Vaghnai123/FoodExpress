<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ProfilePasswordUpdateRequest;
use App\Http\Requests\Frontend\ProfileUpdateRequest;
use App\Traits\FileUploadTrait;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use FileUploadTrait;

    function updateProfile(ProfileUpdateRequest $request) : RedirectResponse {
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with([
            'message' => 'Profile Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    function updatePassword(ProfilePasswordUpdateRequest $request) : RedirectResponse {
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with([
            'message' => 'Password Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    function updateAvatar(Request $request) {
        $user = Auth::user();
        $imagePath = $this->uploadImage($request, 'avatar', $user->avatar);
        if ($imagePath) {
            $user->avatar = $imagePath;
            $user->save();
        }
        return response(['status' => 'success', 'message' => 'Avatar Updated Successfully']);
    }
}
