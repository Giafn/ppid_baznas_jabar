<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kantor = [
            'nama_kantor' => 'PPID BAZNAS RI',
            'alamat_kantor' => 'Gedung BAZNAS Lantai 1 Jl. Matraman Raya No. 134, DKI Jakarta',
            'telepon_kantor' => '085174130851',
            'email_kantor' => 'ppid@baznasjabar.org'
        ];

        Setting::create(
            [
                "key" => "informasi_kantor",
                "value" => json_encode($kantor)
            ]
        );

        Setting::create(
            [
                "key" => "embed_map",
                "value" => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.5019171098693!2d107.62300777499684!3d-6.949966293050279!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e7b3c42c14c7%3A0x389214b28df6157b!2sBAZNAS%20Provinsi%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1723359887611!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>'
            ]
        );

        Setting::create(
            [
                "key" => "sosial_media",
                "value" => json_encode(
                    [
                        "instagram" => "https://www.instagram.com/baznasjabar/?hl=id",
                        "facebook" => "https://www.facebook.com/Baznasjawabarat/?locale=id_ID",
                        "youtube" => "https://www.youtube.com/@baznasjabar3816",
                        "whatsapp" => "https://wa.me/6281122335272",
                        "twitter" => ""
                    ]
                )
            ]
        );
    }
}
