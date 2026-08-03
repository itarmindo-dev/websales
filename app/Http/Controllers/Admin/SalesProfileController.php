<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalesProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SalesProfileController extends Controller
{
    public function index()
    {
        $sales = SalesProfile::latest()->get();
        return view('admin.sales.index', compact('sales'));
    }

    public function create()
    {
        return view('admin.sales.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'whatsapp_number' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'facebook_link' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'instagram_link' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'tagline' => 'nullable|string|max:255',
            'slogan' => 'nullable|string|max:255',
            'specialties' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'documentation_photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = collect($validated)->except(['photo', 'documentation_photos'])->toArray();
        $data['slug'] = Str::slug($validated['name']) . '-' . uniqid();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('sales_photos', 'public');
        }

        if ($request->hasFile('documentation_photos')) {
            $docPhotos = [];
            foreach ($request->file('documentation_photos') as $file) {
                if ($file->isValid()) {
                    $docPhotos[] = $file->store('sales_docs', 'public');
                }
            }
            $data['documentation_photos'] = $docPhotos;
        }

        SalesProfile::create($data);

        return redirect()->route('admin.sales.index')->with('success', 'Halaman Sales berhasil di-generate!');
    }

    public function edit(SalesProfile $sale)
    {
        return view('admin.sales.edit', compact('sale'));
    }

    public function update(Request $request, SalesProfile $sale)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'whatsapp_number' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'facebook_link' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'instagram_link' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'tagline' => 'nullable|string|max:255',
            'slogan' => 'nullable|string|max:255',
            'specialties' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'documentation_photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = collect($validated)->except(['photo', 'documentation_photos'])->toArray();
        
        if ($request->hasFile('photo')) {
            if ($sale->photo) Storage::disk('public')->delete($sale->photo);
            $data['photo'] = $request->file('photo')->store('sales_photos', 'public');
        }

        if ($request->hasFile('documentation_photos')) {
            $docPhotos = is_array($sale->documentation_photos) ? $sale->documentation_photos : [];
            foreach ($request->file('documentation_photos') as $file) {
                if ($file->isValid()) {
                    $docPhotos[] = $file->store('sales_docs', 'public');
                }
            }
            $data['documentation_photos'] = $docPhotos;
        }

        $sale->update($data);
        return redirect()->route('admin.sales.index')->with('success', 'Profile Sales diupdate.');
    }

    public function destroy(SalesProfile $sale)
    {
        if ($sale->photo) Storage::disk('public')->delete($sale->photo);
        // also delete docs if needed
        $sale->delete();
        return redirect()->route('admin.sales.index')->with('success', 'Profile dihapus.');
    }
}
