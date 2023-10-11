<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = [
            'message' => 'You have been logout successfully.',
            'alert-type' => 'success',
        ];

        return redirect('/login')->with($notification);
    }

    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('admin.profile_edit', compact('user'));
    }

    public function storeProfile(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;

        if($request->has(('profile_image')))
        {
            $file = $request->file('profile_image');

            $fileName = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $fileName);
            $user->profile_image = $fileName;
        }

        $user->save();

        $notification = [
            'message' => 'Your profile updated successfully.',
            'alert-type' => 'info',
        ];

        return redirect()->route('admin.profile')->with($notification);
    }

    public function changePassword()
    {
        $user = Auth::user();
        return view('admin.password_change', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validateData = $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required',
            'confirm_password' => 'required|same:newpassword',

        ]);

        $hashedPassword = $user()->password;
        if (Hash::check($request->oldpassword, $hashedPassword ))
        {
            $user->password = bcrypt($request->newpassword);
            $user->save();

            session()->flash('message','Password Updated Successfully');
            return redirect()->back();
        }
        else
        {
            session()->flash('message','Old password does not match');
            return redirect()->back();
        }
    }

}
