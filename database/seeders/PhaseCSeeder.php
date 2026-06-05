<?php

namespace Database\Seeders;

use App\Models\DisclosureDocument;
use App\Models\Page;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class PhaseCSeeder extends Seeder
{
    public function run(): void
    {
        $setting = SiteSetting::query()->first();
        if ($setting) {
            $setting->update([
                'default_meta_description' => 'Horizon School — CBSE affiliated school offering quality education, modern campus, and holistic development. Admission open.',
                'mandatory_disclosure_url' => route('mandatory-disclosure'),
            ]);
            SiteSetting::clearCache();
        }

        Page::query()->firstOrCreate(
            ['slug' => 'mandatory-disclosure'],
            [
                'title' => 'Mandatory Disclosure',
                'body' => '<p>Documents published as per CBSE mandatory disclosure requirements.</p>',
                'meta_description' => 'CBSE mandatory disclosure documents for Horizon School.',
                'is_published' => true,
            ]
        );

        if (DisclosureDocument::query()->count() === 0) {
            $docs = [
                'Affiliation Letter',
                'Trust Registration',
                'Building Safety Certificate',
                'Fee Structure',
                'Academic Calendar',
            ];
            foreach ($docs as $i => $title) {
                DisclosureDocument::create([
                    'title' => $title,
                    'pdf_path' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
                    'sort_order' => $i,
                    'is_published' => true,
                ]);
            }
        }
    }
}
