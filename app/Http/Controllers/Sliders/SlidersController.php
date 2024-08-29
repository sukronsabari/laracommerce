<?php

namespace App\Http\Controllers\Sliders;

use App\DataTables\SlidersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\SlidersRequest;
use App\Models\Slider;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlidersController extends Controller
{
    public function index(Request $request): View
    {

        return view('admin.sliders.index');
    }

    public function create(): View
    {
        return view('admin.sliders.create');
    }

    public function store(SlidersRequest $request): RedirectResponse
    {

        $banner = $request->file('banner');
        $bannerPath = $banner->store('/images/banners', ['disk' => 'public']);
        $isActive = $request->is_active === '1' ? true : false;

        Slider::create([...$request->validated(), 'banner' => $bannerPath, 'is_active' => $isActive]);

        return to_route('admin.sliders.index')->with('toast-notification', [
            'type' => 'success',
            'message' => "New slider have been added!",
        ]);
    }

    public function edit(Slider $slider): View
    {
        return view('admin.sliders.edit', [
            'slider' => $slider,
        ]);
    }

    public function update(SlidersRequest $request, Slider $slider): RedirectResponse
    {
        $bannerPath = '';
        $isActive = $request->is_active === '1' ? true : false;

        if ($request->hasFile('banner')) {
            Storage::delete($slider->banner);

            $banner = $request->file('banner');
            $bannerPath = $banner->store('/images/banners', ['disk' => 'public']);
        } else {
            $bannerPath = $slider->banner;
        }

        $slider->update([...$request->validated(), 'banner' => $bannerPath, 'is_active' => $isActive]);

        return to_route('admin.sliders.index')->with('toast-notification', [
            'type' => 'success',
            'message' => "Slider has been updated!",
        ]);
    }
}
