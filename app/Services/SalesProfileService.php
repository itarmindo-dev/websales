<?php

namespace App\Services;

use App\Http\Requests\Admin\SalesProfileRequest;
use App\Models\SalesProfile;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class SalesProfileService
{
    public function save(SalesProfile $profile, SalesProfileRequest $request, ?User $owner = null): SalesProfile
    {
        $validated = $request->validated();
        $data = $this->profileData($validated);
        $existingDocumentation = $profile->documentation_photos ?? [];
        $requestedRemoval = array_intersect(
            $existingDocumentation,
            $validated['remove_documentation_photos'] ?? [],
        );
        $remainingDocumentation = array_values(array_diff($existingDocumentation, $requestedRemoval));
        $uploadedPaths = [];
        $oldPhoto = null;

        if (! $profile->exists) {
            $data['slug'] = $this->uniqueSlug($data['name']);
        }

        if ($owner) {
            $data['user_id'] = $owner->id;
        }

        try {
            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo')->store('sales_photos', 'public');
                $uploadedPaths[] = $data['photo'];
                $oldPhoto = $profile->photo;
            } elseif ($request->boolean('remove_photo') && $profile->photo) {
                $data['photo'] = null;
                $oldPhoto = $profile->photo;
            }

            $newDocumentation = $this->storeDocumentationPhotos($request, $uploadedPaths);
            $data['documentation_photos'] = [...$remainingDocumentation, ...$newDocumentation];
            $profile->fill($data)->save();
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($uploadedPaths);

            throw $exception;
        }

        Storage::disk('public')->delete(array_filter([$oldPhoto, ...$requestedRemoval]));

        return $profile;
    }

    public function delete(SalesProfile $profile): void
    {
        $storedFiles = array_filter([
            $profile->photo,
            ...($profile->documentation_photos ?? []),
        ]);

        $profile->delete();
        Storage::disk('public')->delete($storedFiles);
    }

    private function profileData(array $validated): array
    {
        $data = Arr::except($validated, [
            'photo',
            'documentation_photos',
            'remove_photo',
            'remove_documentation_photos',
            'account_email',
            'account_password',
            'account_password_confirmation',
            'account_enabled',
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
