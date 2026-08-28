<?php

namespace App\Http\Controllers;

use App\Models\LandingPageSetting;
use App\Models\SalesProfile;
use App\Models\Testimonial;
use App\Models\TruckModel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(Request $request): View
    {
        $settings = LandingPageSetting::query()->firstOrFail();
        $salesSource = null;

        if ($request->filled('sales')) {
            $salesSource = SalesProfile::query()
                ->select([
                    'id',
                    'user_id',
                    'slug',
                    'name',
                    'phone',
                    'whatsapp',
                    'whatsapp_number',
                ])
                ->where('slug', $request->string('sales')->trim()->toString())
                ->first();
        }

        return view('index', [
            'settings' => $settings,
            'salesSource' => $salesSource,
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
        $sale = SalesProfile::query()
            ->with(['sections' => fn ($query) => $query->where('is_active', true)])
            ->where('slug', $slug)
            ->firstOrFail();

        $defaultWhatsapp = LandingPageSetting::query()->value('whatsapp_number');

        return view('pages.sales', compact('sale', 'defaultWhatsapp'));
    }
}
