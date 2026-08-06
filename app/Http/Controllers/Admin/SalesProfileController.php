<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SalesProfileRequest;
use App\Models\SalesProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class SalesProfileController extends Controller
{
    public function index(): View
    {
        return view('admin.sales.index', [
            'sales' => SalesProfile::query()->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.sales.create');
    }

    public function store(SalesProfileRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $data = $this->profileData($validated);
        $data['slug'] = $this->uniqueSlug($data['name']);
        $uploadedPaths = [];

        try {
            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo')->store('sales_photos', 'public');
                $uploadedPaths[] = $data['photo'];
            }

            $data['documentation_photos'] = $this->storeDocumentationPhotos($request, $uploadedPaths);
            SalesProfile::query()->create($data);
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($uploadedPaths);

            throw $exception;
        }

        return to_route('admin.sales.index')->with('success', 'Profil sales berhasil dibuat.');
    }

    public function edit(SalesProfile $sale): View
    {
        return view('admin.sales.edit', compact('sale'));
    }

    public function update(SalesProfileRequest $request, SalesProfile $sale): RedirectResponse
    {
        $validated = $request->validated();
        $data = $this->profileData($validated);
        $existingDocumentation = $sale->documentation_photos ?? [];
        $requestedRemoval = array_intersect(
            $existingDocumentation,
            $validated['remove_documentation_photos'] ?? [],
        );
        $remainingDocumentation = array_values(array_diff($existingDocumentation, $requestedRemoval));
        $uploadedPaths = [];
        $oldPhoto = null;

        try {
            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo')->store('sales_photos', 'public');
                $uploadedPaths[] = $data['photo'];
                $oldPhoto = $sale->photo;
            } elseif ($request->boolean('remove_photo') && $sale->photo) {
                $data['photo'] = null;
                $oldPhoto = $sale->photo;
            }

            $newDocumentation = $this->storeDocumentationPhotos($request, $uploadedPaths);
            $data['documentation_photos'] = [...$remainingDocumentation, ...$newDocumentation];
            $sale->update($data);
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($uploadedPaths);

            throw $exception;
        }

        Storage::disk('public')->delete(array_filter([$oldPhoto, ...$requestedRemoval]));

        return to_route('admin.sales.index')->with('success', 'Profil sales berhasil diperbarui.');
    }

    public function destroy(SalesProfile $sale): RedirectResponse
    {
        $storedFiles = array_filter([
            $sale->photo,
            ...($sale->documentation_photos ?? []),
        ]);

        $sale->delete();
        Storage::disk('public')->delete($storedFiles);

        return to_route('admin.sales.index')->with('success', 'Profil sales berhasil dihapus.');
    }

    private function profileData(array $validated): array
    {
        $data = Arr::except($validated, [
            'photo',
            'documentation_photos',
            'remove_photo',
            'remove_documentation_photos',
        ]);

        $data['whatsapp'] = $data['whatsapp_number'] ?? null;
        $data['facebook'] = $data['facebook_link'] ?? null;
        $data['instagram'] = $data['instagram_link'] ?? null;

        return $data;
    }

    private function storeDocumentationPhotos(SalesProfileRequest $request, array &$uploadedPaths): array
    {
        $paths = [];

        foreach ($request->file('documentation_photos', []) as $photo) {
            $path = $photo->store('sales_docs', 'public');
            $paths[] = $path;
            $uploadedPaths[] = $path;
        }

        return $paths;
    }

    private function uniqueSlug(string $name): string
    {
        $baseSlug = Str::slug($name) ?: 'sales';
        $slug = $baseSlug;
        $suffix = 2;

        while (SalesProfile::query()->where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }
}
