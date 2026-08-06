<?php

namespace App\Http\Controllers;

use App\Models\SalesProfile;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        $salesQuery = SalesProfile::query();

        return view('dashboard', [
            'salesCount' => (clone $salesQuery)->count(),
            'salesWithPhotoCount' => (clone $salesQuery)->whereNotNull('photo')->count(),
            'salesWithWhatsappCount' => (clone $salesQuery)
                ->where(function ($query) {
                    $query->whereNotNull('whatsapp_number')->orWhereNotNull('whatsapp');
                })
                ->count(),
            'recentSales' => $salesQuery->latest()->limit(5)->get(),
        ]);
    }
}
