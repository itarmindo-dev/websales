<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class SalesProfileRequest extends FormRequest
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
            'name' => trim((string) $this->input('name')),
            'phone' => $this->trimNullable('phone'),
            'whatsapp_number' => $whatsapp !== '' ? $whatsapp : null,
            'facebook_link' => $this->trimNullable('facebook_link'),
            'instagram_link' => $this->trimNullable('instagram_link'),
            'tagline' => $this->trimNullable('tagline'),
            'slogan' => $this->trimNullable('slogan'),
            'specialties' => $this->trimNullable('specialties'),
            'bio' => $this->trimNullable('bio'),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'whatsapp_number' => ['nullable', 'digits_between:8,16'],
            'facebook_link' => ['nullable', 'url:http,https', 'max:255'],
            'instagram_link' => ['nullable', 'url:http,https', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'slogan' => ['nullable', 'string', 'max:255'],
            'specialties' => ['nullable', 'string', 'max:500'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'photo' => ['nullable', File::image()->types(['jpg', 'jpeg', 'png', 'webp'])->max('2mb')],
            'documentation_photos' => ['nullable', 'array', 'max:10'],
            'documentation_photos.*' => [File::image()->types(['jpg', 'jpeg', 'png', 'webp'])->max('2mb')],
            'remove_photo' => ['nullable', 'boolean'],
            'remove_documentation_photos' => ['nullable', 'array'],
            'remove_documentation_photos.*' => ['string'],
        ];
    }

    public function messages(): array
    {
        return [
            'whatsapp_number.digits_between' => 'Nomor WhatsApp harus berisi 8 sampai 16 digit.',
            'documentation_photos.max' => 'Maksimal 10 foto dokumentasi dapat diunggah sekaligus.',
        ];
    }

    private function trimNullable(string $key): ?string
    {
        $value = trim((string) $this->input($key));

        return $value !== '' ? $value : null;
    }
}
