<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileImageController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => ['image', 'mimes:png,jpg,jpeg', 'max:2048']
        ]);

        if (!$request->hasFile('image')) {
            return redirect()->back();;
        }

        $image = request()->file("image");
        $imageUrl = $image->store('/images/users', ['disk' => 'public']);

        $user = $request->user();
        $defaultProfile = env('DEFAULT_IMAGE_PROFILE', 'images/users/default.jpg');
        if ($user->image !== $defaultProfile) {
            Storage::disk('local')->delete($user->image);
        }

        $user->image = $imageUrl;
        $user->save();

        session()->flash("toast-notification", [
            "type" => "success",
            "message" => "Update profile successfully!"
        ]);

        return redirect()->back();
    }
}
