<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Validator;

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
        $slug = Str::slug((string) $this->input('slug'));

        if (str_starts_with($whatsapp, '0')) {
            $whatsapp = '62'.substr($whatsapp, 1);
        }

        $this->merge([
            'name' => trim((string) $this->input('name')),
            'slug' => $slug !== '' ? $slug : null,
            'phone' => $this->trimNullable('phone'),
            'whatsapp_number' => $whatsapp !== '' ? $whatsapp : null,
            'facebook_link' => $this->trimNullable('facebook_link'),
            'instagram_link' => $this->trimNullable('instagram_link'),
            'tagline' => $this->trimNullable('tagline'),
            'slogan' => $this->trimNullable('slogan'),
            'specialties' => $this->trimNullable('specialties'),
            'bio' => $this->trimNullable('bio'),
            'hero_title' => $this->trimNullable('hero_title'),
            'hero_description' => $this->trimNullable('hero_description'),
            'intro_eyebrow' => $this->trimNullable('intro_eyebrow'),
            'intro_title' => $this->trimNullable('intro_title'),
            'intro_emphasis' => $this->trimNullable('intro_emphasis'),
            'footer_title' => $this->trimNullable('footer_title'),
            'footer_description' => $this->trimNullable('footer_description'),
            'account_email' => $this->input('account_email')
                ? Str::lower(trim((string) $this->input('account_email')))
                : null,
            'account_enabled' => $this->boolean('account_enabled'),
        ]);
    }

    public function rules(): array
    {
        $sale = $this->route('sale');

        if (! $sale && $this->routeIs('sales.self.*')) {
            $sale = $this->user()?->salesProfile()->first();
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                $sale ? 'required' : 'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('sales_profiles', 'slug')->ignore($sale?->id),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'whatsapp_number' => ['nullable', 'digits_between:8,16'],
            'facebook_link' => ['nullable', 'url:http,https', 'max:255'],
            'instagram_link' => ['nullable', 'url:http,https', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'slogan' => ['nullable', 'string', 'max:255'],
            'specialties' => ['nullable', 'string', 'max:500'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'photo' => ['nullable', File::image()->types(['jpg', 'jpeg', 'png', 'webp'])->max('2mb')],
            'hero_title' => ['nullable', 'string', 'max:160'],
            'hero_description' => ['nullable', 'string', 'max:600'],
            'intro_eyebrow' => ['nullable', 'string', 'max:80'],
            'intro_title' => ['nullable', 'string', 'max:180'],
            'intro_emphasis' => ['nullable', 'string', 'max:180'],
            'footer_title' => ['nullable', 'string', 'max:160'],
            'footer_description' => ['nullable', 'string', 'max:600'],
            'hero_image' => ['nullable', File::image()->types(['jpg', 'jpeg', 'png', 'webp'])->max('5mb')],
            'footer_image' => ['nullable', File::image()->types(['jpg', 'jpeg', 'png', 'webp'])->max('5mb')],
            'remove_hero_image' => ['nullable', 'boolean'],
            'remove_footer_image' => ['nullable', 'boolean'],
            'documentation_photos' => ['nullable', 'array', 'max:10'],
            'documentation_photos.*' => [File::image()->types(['jpg', 'jpeg', 'png', 'webp'])->max('2mb')],
            'remove_photo' => ['nullable', 'boolean'],
            'remove_documentation_photos' => ['nullable', 'array'],
            'remove_documentation_photos.*' => ['string'],
            'sections' => ['nullable', 'array', 'max:20'],
            'sections.*.id' => ['nullable', 'integer'],
            'sections.*.type' => ['nullable', Rule::in(['image_text', 'video', 'text'])],
            'sections.*.layout' => ['nullable', Rule::in(['media_left', 'media_right', 'full_width', 'video_left', 'video_right'])],
            'sections.*.eyebrow' => ['nullable', 'string', 'max:80'],
            'sections.*.title' => ['nullable', 'string', 'max:180'],
            'sections.*.body' => ['nullable', 'string', 'max:3000'],
            'sections.*.media_url' => ['nullable', 'url:http,https', 'max:1000'],
            'sections.*.media_file' => [
                'nullable',
                File::types(['jpg', 'jpeg', 'png', 'webp', 'mp4', 'webm'])->max('30mb'),
            ],
            'sections.*.button_label' => ['nullable', 'string', 'max:80'],
            'sections.*.button_url' => ['nullable', 'url:http,https', 'max:1000'],
            'sections.*.is_active' => ['nullable', 'boolean'],
            'sections.*.remove_media' => ['nullable', 'boolean'],
            'sections.*._delete' => ['nullable', 'boolean'],
        ];

        if ($this->user()?->can('access-admin')) {
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
            'slug.regex' => 'URL profil hanya boleh berisi huruf kecil, angka, dan tanda hubung.',
            'slug.unique' => 'URL profil tersebut sudah digunakan oleh sales lain.',
            'whatsapp_number.digits_between' => 'Nomor WhatsApp harus berisi 8 sampai 16 digit.',
            'documentation_photos.max' => 'Maksimal 10 foto dokumentasi dapat diunggah sekaligus.',
            'sections.max' => 'Maksimal 20 section dapat ditambahkan ke landing page sales.',
            'sections.*.media_file.max' => 'Ukuran media section maksimal 30 MB.',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            foreach ($this->input('sections', []) as $index => $section) {
                if (filter_var($section['_delete'] ?? false, FILTER_VALIDATE_BOOLEAN)) {
                    continue;
                }

                if (blank($section['type'] ?? null)) {
                    $validator->errors()->add("sections.{$index}.type", 'Pilih jenis section.');
                }

                if (blank($section['title'] ?? null)) {
                    $validator->errors()->add("sections.{$index}.title", 'Judul section wajib diisi.');
                }

                $media = $this->file("sections.{$index}.media_file");
                $mime = $media?->getMimeType() ?? '';
                $type = $section['type'] ?? null;
                $layout = $section['layout'] ?? null;

                $allowedLayouts = match ($type) {
                    'image_text' => ['media_left', 'media_right', 'full_width'],
                    'video' => ['video_left', 'video_right', 'full_width'],
                    'text' => ['full_width'],
                    default => [],
                };

                if ($layout && ! in_array($layout, $allowedLayouts, true)) {
                    $validator->errors()->add("sections.{$index}.layout", 'Tata letak tidak sesuai dengan jenis section.');
                }

                if ($media && $type === 'image_text' && ! str_starts_with($mime, 'image/')) {
                    $validator->errors()->add("sections.{$index}.media_file", 'Section gambar + teks hanya menerima file gambar.');
                }

                if ($media && $type === 'video' && ! str_starts_with($mime, 'video/')) {
                    $validator->errors()->add("sections.{$index}.media_file", 'Section video hanya menerima file MP4 atau WebM.');
                }

                if ($media && $type === 'text') {
                    $validator->errors()->add("sections.{$index}.media_file", 'Section teks tidak menggunakan file media.');
                }

                if (filled($section['button_label'] ?? null) xor filled($section['button_url'] ?? null)) {
                    $validator->errors()->add("sections.{$index}.button_url", 'Label dan URL tombol harus diisi bersama-sama.');
                }
            }
        });
    }

    private function trimNullable(string $key): ?string
    {
        $value = trim((string) $this->input($key));

        return $value !== '' ? $value : null;
    }
}
