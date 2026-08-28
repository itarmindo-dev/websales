<?php

namespace Database\Seeders;

use App\Models\SalesProfile;
use App\Models\User;
use Illuminate\Database\Seeder;

class SalesProfileSeeder extends Seeder
{
    private const DEMO_PASSWORD = 'DemoSales123!';

    public function run(): void
    {
        foreach ($this->profiles() as $data) {
            $account = $data['account'];
            $sections = $data['sections'] ?? [];
            unset($data['account'], $data['sections']);

            $user = User::query()->firstOrNew(['email' => $account['email']]);

            if (! $user->exists) {
                $user->password = self::DEMO_PASSWORD;
            }

            $user->forceFill([
                'name' => $data['name'],
                'is_sales' => true,
                'email_verified_at' => $user->email_verified_at ?? now(),
            ])->save();

            $profile = SalesProfile::query()->where('user_id', $user->id)->first()
                ?? SalesProfile::query()->where('slug', $data['slug'])->whereNull('user_id')->first()
                ?? new SalesProfile;

            $profile->fill([
                ...$data,
                'user_id' => $user->id,
            ])->save();

            foreach ($sections as $sortOrder => $section) {
                $profile->sections()->updateOrCreate(
                    ['sort_order' => $sortOrder],
                    [...$section, 'sort_order' => $sortOrder],
                );
            }
        }

        $this->command?->info('Dummy sales siap. Password akun demo: '.self::DEMO_PASSWORD);
    }

    private function profiles(): array
    {
        return [
            [
                'account' => ['email' => 'budi.sales@example.test'],
                'slug' => 'budi-santoso',
                'name' => 'Budi Santoso',
                'photo' => 'img/team/ca-team-iner1.2.png',
                'hero_image' => 'img/slider/herosales.png',
                'footer_image' => 'img/slider/footersales.png',
                'phone' => '021 555 0101',
                'whatsapp' => '6280000000001',
                'whatsapp_number' => '6280000000001',
                'facebook' => 'https://www.facebook.com/',
                'facebook_link' => 'https://www.facebook.com/',
                'instagram' => 'https://www.instagram.com/',
                'instagram_link' => 'https://www.instagram.com/',
                'tagline' => 'HINO Sales Executive',
                'hero_title' => 'Armada tepat untuk perjalanan bisnis yang lebih jauh.',
                'hero_description' => 'Konsultasi HINO yang dimulai dari kebutuhan nyata: muatan, rute, target operasional, dan rencana pertumbuhan bisnis Anda.',
                'intro_eyebrow' => 'Pendekatan konsultatif',
                'intro_title' => 'Bukan sekadar memilih truk.',
                'intro_emphasis' => 'Menyusun armada yang bekerja.',
                'footer_title' => 'Mari susun armada yang siap bekerja.',
                'footer_description' => 'Ceritakan kebutuhan usaha Anda. Saya akan membantu memetakan pilihan unit HINO yang paling relevan sebelum Anda mengambil keputusan.',
                'slogan' => 'Partner konsultasi armada untuk distribusi dan logistik antarkota.',
                'specialties' => 'HINO 500 Ranger',
                'bio' => "Berpengalaman membantu pelanggan memilih unit berdasarkan jenis muatan, kondisi jalan, dan target operasional.\n\nSiap memberikan informasi produk, simulasi kebutuhan armada, dan pendampingan proses pembelian hingga serah terima unit.",
                'documentation_photos' => [
                    'img/portfolio/portfolio-big-1.3.png',
                    'img/portfolio/ca-project3.3.png',
                    'img/portfolio/ca-project3.4.png',
                ],
                'sections' => [
                    [
                        'type' => 'image_text',
                        'layout' => 'media_left',
                        'eyebrow' => 'Konsultasi berbasis kebutuhan',
                        'title' => 'Unit dipilih dari pekerjaan yang harus diselesaikan.',
                        'body' => 'Jenis muatan, kondisi rute, jarak tempuh, dan target ritase menjadi dasar pembahasan. Dengan konteks yang jelas, rekomendasi unit dan karoseri dapat disusun lebih tepat.',
                        'media_path' => 'img/portfolio/portfolio-big-1.3.png',
                        'media_url' => null,
                        'button_label' => null,
                        'button_url' => null,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'text',
                        'layout' => 'full_width',
                        'eyebrow' => 'Prinsip layanan',
                        'title' => 'Keputusan armada yang baik harus tetap masuk akal ketika bisnis mulai bertumbuh.',
                        'body' => 'Konsultasi tidak berhenti pada spesifikasi. Kesiapan layanan, efisiensi operasional, dan kebutuhan jangka panjang ikut menjadi bagian dari pertimbangan.',
                        'media_path' => null,
                        'media_url' => null,
                        'button_label' => null,
                        'button_url' => null,
                        'is_active' => true,
                    ],
                ],
            ],
        ];
    }
}
