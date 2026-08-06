<?php

namespace App\Http\Controllers;

use App\Models\SalesProfile;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        return view('index');
    }

    public function salesProfile(string $slug): View
    {
        $sale = SalesProfile::query()->where('slug', $slug)->firstOrFail();

        return view('pages.sales', compact('sale'));
    }
}
