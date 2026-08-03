<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesProfile;

class PageController extends Controller
{
    public function index()
    {
        return view('index'); // the existing index.blade.php
    }

    public function salesProfile($slug)
    {
        $sale = SalesProfile::where('slug', $slug)->firstOrFail();
        return view('pages.sales', compact('sale'));
    }
}
