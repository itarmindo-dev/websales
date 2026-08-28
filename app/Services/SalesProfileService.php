<?php

namespace App\Services;

use App\Http\Requests\Admin\SalesProfileRequest;
use App\Models\SalesProfile;
use App\Models\SalesProfileSection;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
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
        $filesToDelete = $requestedRemoval;

        if (filled($validated['slug'] ?? null)) {
            $data['slug'] = $validated['slug'];
        } elseif (! $profile->exists) {
            $data['slug'] = $this->uniqueSlug($data['name']);
        }

        if ($owner) {
            $data['user_id'] = $owner->id;
        }

        try {
            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo')->store('sales_photos', 'public');
                $uploadedPaths[] = $data['photo'];
                $filesToDelete[] = $profile->photo;
            } elseif ($request->boolean('remove_photo') && $profile->photo) {
                $data['photo'] = null;
                $filesToDelete[] = $profile->photo;
            }

            $this->storeLandingImage($profile, $request, $data, $uploadedPaths, $filesToDelete, 'hero_image', 'sales_heroes');
            $this->storeLandingImage($profile, $request, $data, $uploadedPaths, $filesToDelete, 'footer_image', 'sales_footers');

            $newDocumentation = $this->storeDocumentationPhotos($request, $uploadedPaths);
            $data['documentation_photos'] = [...$remainingDocumentation, ...$newDocumentation];
            $profile->fill($data)->save();

            if ($request->has('sections')) {
                $filesToDelete = [
                    ...$filesToDelete,
                    ...$this->syncSections($profile, $request, $validated['sections'] ?? [], $uploadedPaths),
                ];
            }
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($uploadedPaths);

            throw $exception;
        }

        Storage::disk('public')->delete(array_filter($filesToDelete));

        return $profile;
    }

    public function delete(SalesProfile $profile): void
    {
        $storedFiles = array_filter([
            $profile->photo,
            $profile->hero_image,
            $profile->footer_image,
            ...($profile->documentation_photos ?? []),
            ...$profile->sections()->pluck('media_path')->all(),
            ...$profile->sections()->pluck('thumbnail_path')->all(),
        ]);

        $profile->delete();
        Storage::disk('public')->delete($storedFiles);
    }

    private function profileData(array $validated): array
    {
        $data = Arr::except($validated, [
            'photo',
            'hero_image',
            'footer_image',
            'remove_hero_image',
            'remove_footer_image',
            'documentation_photos',
            'remove_photo',
            'remove_documentation_photos',
            'account_email',
            'account_password',
            'account_password_confirmation',
            'account_enabled',
            'slug',
            'sections',
        ]);

        $data['whatsapp'] = $data['whatsapp_number'] ?? null;
        $data['facebook'] = $data['facebook_link'] ?? null;
        $data['instagram'] = $data['instagram_link'] ?? null;

        return $data;
    }

    private function storeLandingImage(
        SalesProfile $profile,
        SalesProfileRequest $request,
        array &$data,
        array &$uploadedPaths,
        array &$filesToDelete,
        string $field,
        string $directory,
    ): void {
        if ($request->hasFile($field)) {
            $data[$field] = $request->file($field)->store($directory, 'public');
            $uploadedPaths[] = $data[$field];
            $filesToDelete[] = $profile->{$field};

            return;
        }

        if ($request->boolean("remove_{$field}") && $profile->{$field}) {
            $data[$field] = null;
            $filesToDelete[] = $profile->{$field};
        }
    }

    private function syncSections(
        SalesProfile $profile,
        SalesProfileRequest $request,
        array $sections,
        array &$uploadedPaths,
    ): array {
        $existingSections = $profile->sections()->get()->keyBy('id');
        $filesToDelete = [];
        $sortOrder = 0;

        foreach ($sections as $index => $sectionData) {
            $section = null;
            $sectionId = isset($sectionData['id']) ? (int) $sectionData['id'] : null;

            if ($sectionId) {
                $section = $existingSections->get($sectionId);

                if (! $section) {
                    throw ValidationException::withMessages([
                        "sections.{$index}.id" => 'Section tidak ditemukan pada profil sales ini.',
                    ]);
                }
            }

            if (filter_var($sectionData['_delete'] ?? false, FILTER_VALIDATE_BOOLEAN)) {
                if ($section) {
                    $filesToDelete[] = $section->media_path;
                    $filesToDelete[] = $section->thumbnail_path;
                    $section->delete();
                }

                continue;
            }

            $section ??= new SalesProfileSection;
            $type = $sectionData['type'] ?? 'text';
            $mediaPath = $section->media_path;
            $thumbnailPath = $section->thumbnail_path;
            $uploadedMedia = $request->file("sections.{$index}.media_file");
            $uploadedThumbnail = $request->file("sections.{$index}.thumbnail_file");

            if ($uploadedMedia) {
                $mediaPath = $uploadedMedia->store('sales_sections', 'public');
                $uploadedPaths[] = $mediaPath;
                $filesToDelete[] = $section->media_path;
            } elseif ($request->boolean("sections.{$index}.remove_media") || $type === 'text') {
                $filesToDelete[] = $section->media_path;
                $mediaPath = null;
            }

            if ($uploadedThumbnail) {
                $thumbnailPath = $uploadedThumbnail->store('sales_section_thumbnails', 'public');
                $uploadedPaths[] = $thumbnailPath;
                $filesToDelete[] = $section->thumbnail_path;
            } elseif ($request->boolean("sections.{$index}.remove_thumbnail") || $type !== 'video') {
                $filesToDelete[] = $section->thumbnail_path;
                $thumbnailPath = null;
            }

            $section->fill([
                ...Arr::only($sectionData, [
                    'type',
                    'layout',
                    'eyebrow',
                    'title',
                    'body',
                    'media_url',
                    'thumbnail_url',
                    'button_label',
                    'button_url',
                ]),
                'layout' => $sectionData['layout'] ?? 'media_left',
                'media_path' => $mediaPath,
                'media_url' => $type === 'text' ? null : ($sectionData['media_url'] ?? null),
                'thumbnail_path' => $type === 'video' ? $thumbnailPath : null,
                'thumbnail_url' => $type === 'video' ? ($sectionData['thumbnail_url'] ?? null) : null,
                'sort_order' => $sortOrder++,
                'is_active' => $request->boolean("sections.{$index}.is_active"),
            ]);

            $profile->sections()->save($section);
        }

        return array_filter($filesToDelete);
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
