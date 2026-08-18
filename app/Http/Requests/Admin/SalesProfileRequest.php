<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class SalesProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return (bool) $user && ($user->can('access-admin') || $user->can('access-sales'));
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
            'account_email' => $this->input('account_email')
                ? Str::lower(trim((string) $this->input('account_email')))
                : null,
            'account_enabled' => $this->boolean('account_enabled'),
        ]);
    }

    public function rules(): array
    {
        $rules = [
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

        if ($this->user()?->can('access-admin')) {
            $sale = $this->route('sale');
            $ownerId = $sale?->user_id;

            $rules['account_email'] = [
                $ownerId ? 'required' : 'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($ownerId),
                Rule::requiredIf(fn (): bool => $this->filled('account_password')),
            ];
            $rules['account_password'] = [
                $ownerId ? 'nullable' : Rule::requiredIf(fn (): bool => $this->filled('account_email')),
                'confirmed',
                Password::min(12),
            ];
            $rules['account_enabled'] = ['required', 'boolean'];
        }

        return $rules;
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
