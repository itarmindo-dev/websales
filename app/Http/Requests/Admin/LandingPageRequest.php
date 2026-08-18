<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class LandingPageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('access-admin') ?? false;
    }

    protected function prepareForValidation(): void
    {
        $whatsapp = preg_replace('/\D+/', '', (string) $this->input('whatsapp_number'));

        if (str_starts_with($whatsapp, '0')) {
            $whatsapp = '62'.substr($whatsapp, 1);
        }

        $this->merge([
            'whatsapp_number' => $whatsapp,
            'tco_enabled' => $this->boolean('tco_enabled'),
            'models_enabled' => $this->boolean('models_enabled'),
            'testimonials_enabled' => $this->boolean('testimonials_enabled'),
            'contact_enabled' => $this->boolean('contact_enabled'),
        ]);
    }

    public function rules(): array
    {
        $image = ['nullable', File::image()->types(['jpg', 'jpeg', 'png', 'webp'])->max('5mb')];

        return [
            'hero_eyebrow' => ['required', 'string', 'max:100'],
            'hero_title' => ['required', 'string', 'max:160'],
            'hero_highlight' => ['required', 'string', 'max:160'],
            'hero_description' => ['required', 'string', 'max:500'],
            'hero_background_upload' => $image,
            'hero_primary_label' => ['required', 'string', 'max:60'],
            'hero_secondary_label' => ['required', 'string', 'max:60'],
            'locations_text' => ['required', 'string', 'max:500'],

            'tco_enabled' => ['required', 'boolean'],
            'tco_kicker' => ['required', 'string', 'max:100'],
            'tco_title' => ['required', 'string', 'max:200'],
            'tco_highlight' => ['required', 'string', 'max:100'],
            'tco_lead' => ['required', 'string', 'max:500'],
            'tco_description' => ['required', 'string', 'max:1000'],
            'tco_benefits_text' => ['required', 'string', 'max:1000'],
            'tco_promo' => ['required', 'string', 'max:500'],

            'models_enabled' => ['required', 'boolean'],
            'models_kicker' => ['required', 'string', 'max:160'],
            'models_title' => ['required', 'string', 'max:160'],
            'models_highlight' => ['required', 'string', 'max:100'],
            'models_description' => ['required', 'string', 'max:1000'],
            'models_note' => ['required', 'string', 'max:255'],
            'models_image_upload' => $image,
            'models_cta_label' => ['required', 'string', 'max:80'],
            'models_cta_subtitle' => ['required', 'string', 'max:120'],

            'testimonials_enabled' => ['required', 'boolean'],
            'testimonials_title' => ['required', 'string', 'max:200'],
            'testimonials_description' => ['required', 'string', 'max:500'],
            'testimonials_watermark_upload' => $image,
            'service_promises_text' => ['required', 'string', 'max:1000'],

            'contact_enabled' => ['required', 'boolean'],
            'contact_kicker' => ['required', 'string', 'max:100'],
            'contact_title' => ['required', 'string', 'max:200'],
            'contact_description' => ['required', 'string', 'max:500'],
            'contact_background_upload' => $image,
            'whatsapp_number' => ['required', 'digits_between:8,16'],
            'whatsapp_label' => ['required', 'string', 'max:30'],
            'website_url' => ['nullable', 'url:http,https', 'max:255'],
            'website_label' => ['nullable', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'business_hours' => ['required', 'string', 'max:100'],
            'contact_cta_label' => ['required', 'string', 'max:80'],
            'dealer_benefits_text' => ['required', 'string', 'max:1000'],

            'remove_hero_background' => ['nullable', 'boolean'],
            'remove_models_image' => ['nullable', 'boolean'],
            'remove_testimonials_watermark' => ['nullable', 'boolean'],
            'remove_contact_background' => ['nullable', 'boolean'],
        ];
    }
}
