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
            unset($data['account']);

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
        }

        $this->command?->info('Dummy sales siap. Password seluruh akun demo: '.self::DEMO_PASSWORD);
    }

    private function profiles(): array
    {
        return [
            [
                'account' => ['email' => 'budi.sales@example.test'],
                'slug' => 'budi-santoso',
                'name' => 'Budi Santoso',
                'photo' => 'img/team/ca-team-iner1.2.png',
                'phone' => '021 555 0101',
                'whatsapp' => '6280000000001',
                'whatsapp_number' => '6280000000001',
                'facebook' => 'https://www.facebook.com/',
                'facebook_link' => 'https://www.facebook.com/',
                'instagram' => 'https://www.instagram.com/',
                'instagram_link' => 'https://www.instagram.com/',
                'tagline' => 'HINO Sales Executive',
                'slogan' => 'Partner konsultasi armada untuk distribusi dan logistik antarkota.',
                'specialties' => 'HINO 500 Ranger',
                'bio' => "Berpengalaman membantu pelanggan memilih unit berdasarkan jenis muatan, kondisi jalan, dan target operasional.\n\nSiap memberikan informasi produk, simulasi kebutuhan armada, dan pendampingan proses pembelian hingga serah terima unit.",
                'documentation_photos' => [
                    'img/portfolio/portfolio-big-1.3.png',
                    'img/portfolio/ca-project3.3.png',
                    'img/portfolio/ca-project3.4.png',
                ],
            ],
        ];
    }
}
