<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LandingPageRequest;
use App\Models\LandingPageSetting;
use App\Models\Testimonial;
use App\Models\TruckModel;
use App\Support\PublicUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Throwable;

class LandingPageController extends Controller
{
    private const IMAGE_FIELDS = [
        'hero_background' => 'hero_background_upload',
        'models_image' => 'models_image_upload',
        'testimonials_watermark' => 'testimonials_watermark_upload',
        'contact_background' => 'contact_background_upload',
    ];

    public function edit(): View
    {
        return view('admin.landing.edit', [
            'settings' => LandingPageSetting::query()->firstOrFail(),
            'truckModelCount' => TruckModel::query()->count(),
            'testimonialCount' => Testimonial::query()->count(),
        ]);
    }

    public function update(LandingPageRequest $request): RedirectResponse
    {
        $settings = LandingPageSetting::query()->firstOrFail();
        $validated = $request->validated();
        $data = Arr::except($validated, [
            'locations_text',
            'tco_benefits_text',
            'service_promises_text',
            'dealer_benefits_text',
            ...array_values(self::IMAGE_FIELDS),
            ...array_map(fn (string $field): string => 'remove_'.$field, array_keys(self::IMAGE_FIELDS)),
        ]);
        $data['locations'] = $this->lines($validated['locations_text']);
        $data['tco_benefits'] = $this->lines($validated['tco_benefits_text']);
        $data['service_promises'] = $this->lines($validated['service_promises_text']);
        $data['dealer_benefits'] = $this->lines($validated['dealer_benefits_text']);
        $newImages = [];
        $oldImages = [];

        try {
            foreach (self::IMAGE_FIELDS as $databaseField => $uploadField) {
                if ($request->hasFile($uploadField)) {
                    $data[$databaseField] = PublicUpload::store($request->file($uploadField), 'landing');
                    $newImages[] = $data[$databaseField];
                    $oldImages[] = $settings->{$databaseField};
                } elseif ($request->boolean('remove_'.$databaseField)) {
                    $data[$databaseField] = null;
                    $oldImages[] = $settings->{$databaseField};
                }
            }

            $settings->update($data);
        } catch (Throwable $exception) {
            PublicUpload::deleteMany($newImages);

            throw $exception;
        }

        PublicUpload::deleteMany($oldImages);

        return to_route('admin.landing.edit')->with('success', 'Landing page berhasil diperbarui.');
    }

    private function lines(string $value): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $value))));
    }
}
