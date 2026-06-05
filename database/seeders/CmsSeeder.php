<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::query()->firstOrCreate([], [
            'school_name' => 'Horizon School',
            'tagline' => 'The School That Cares',
            'affiliation_line' => 'Affiliated to CBSE, New Delhi',
            'about_text' => 'Established with a vision of academic excellence and holistic development, we nurture young minds to explore, innovate, and achieve their best.',
            'mission_title' => 'Service Before Self',
            'mission_text' => 'We emphasize making our students selfless human beings who serve others and find peace in giving.',
            'vision_title' => 'Our Vision',
            'vision_text' => 'Committed to nurturing the inherent potential of each child and creating lifelong learners and future leaders.',
            'mission_vision_page_slug' => 'vision-mission',
            'phone' => '',
            'email' => '',
            'address' => '',
            'show_admission_banner' => true,
            'admission_banner_text' => 'Admission Open',
        ]);
    }
}
