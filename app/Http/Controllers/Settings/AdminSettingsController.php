<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    public function edit(Request $request)
    {
        return view('admin.settings.edit', [

            'user' => $request->user(),
        ]);
    }
}
