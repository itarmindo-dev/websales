<?php

namespace App\Http\Controllers;

use App\Models\LandingPageSetting;
use App\Models\SalesProfile;
use App\Models\Testimonial;
use App\Models\TruckModel;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        $settings = LandingPageSetting::query()->firstOrFail();

        return view('index', [
            'settings' => $settings,
            'truckModels' => $settings->models_enabled
                ? TruckModel::query()->where('is_active', true)->orderBy('sort_order')->orderBy('name')->get()
                : collect(),
            'testimonials' => $settings->testimonials_enabled
                ? Testimonial::query()->where('is_active', true)->orderBy('sort_order')->orderBy('name')->get()
                : collect(),
        ]);
    }

    public function salesProfile(string $slug): View
    {
        $sale = SalesProfile::query()->where('slug', $slug)->firstOrFail();

        return view('pages.sales', compact('sale'));
    }
}
