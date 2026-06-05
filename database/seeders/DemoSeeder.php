<?php

namespace Database\Seeders;

use App\Enums\PostType;
use App\Models\DeskMessage;
use App\Models\Facility;
use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\Page;
use App\Models\Post;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedPages();

        $setting = SiteSetting::query()->first();
        if ($setting) {
            $setting->update([
                'school_name' => 'Horizon School',
                'tagline' => 'The School That Cares',
                'affiliation_line' => 'Affiliated to CBSE, New Delhi',
                'about_text' => 'Established in 2017, Horizon School has grown into a center of academic excellence and holistic development. With modern infrastructure and dedicated faculty, we inspire young minds to explore, innovate, and achieve their best.',
                'mission_title' => 'Service Before Self',
                'mission_text' => 'We lay highest emphasis on making our students selfless human beings — it is in giving that we receive; it is in serving others that we find peace.',
                'vision_title' => 'Our Vision',
                'vision_text' => 'We are committed to nurturing the inherent potential of each child, creating lifelong learners and future leaders capable of ushering in a better social order.',
                'mission_vision_page_slug' => 'vision-mission',
                'phone' => '+91 98765 43210',
                'phone_secondary' => '+91 98765 43211',
                'email' => 'enquiry@horizonschool.edu',
                'address' => 'Vill. Green Park, Main Bypass Road, Your City – 282001',
                'whatsapp_url' => 'https://wa.me/919876543210',
                'facebook_url' => null,
                'instagram_url' => null,
                'youtube_channel_url' => null,
                'admission_url' => null,
                'fee_payment_url' => route('contact'),
                'careers_url' => route('contact'),
                'mandatory_disclosure_url' => route('pages.show', 'mandatory-disclosure'),
                'show_admission_banner' => true,
                'admission_banner_text' => 'Admission Open 2026–27',
                'logo_path' => 'images/demo/logo.svg',
            ]);
            SiteSetting::clearCache();
        }

        if (HeroSlide::query()->count() === 0) {
            $slides = [
                ['The School That Cares', 'Excellence in academics & character', 'images/demo/hero-1.svg'],
                ['World-Class Campus', 'Modern labs, library & sports', 'images/demo/hero-2.svg'],
                ['Admission Open', 'Join the Horizon family today', 'images/demo/hero-3.svg'],
            ];
            foreach ($slides as $i => [$title, $subtitle, $img]) {
                HeroSlide::create([
                    'title' => $title,
                    'subtitle' => $subtitle,
                    'image_path' => $img,
                    'button_text' => 'Admission Open',
                    'button_url' => route('admission.enquiry'),
                    'sort_order' => $i,
                    'is_published' => true,
                ]);
            }
        }

        $this->seedPosts();
        $this->seedFacilities();
        $this->seedGallery();
        $this->seedDeskMessages();
        $this->seedTestimonials();
    }

    private function seedPosts(): void
    {
        $placeholder = 'images/demo/placeholder.svg';

        $items = [
            [PostType::Announcement, 'Summer Camp Schedule 2026', 'Classes VI–VIII registration open. See circular for dates and activities.'],
            [PostType::Announcement, 'Weekly Test Circular – Classes VI–VIII', 'Unit test timetable published for the current month.'],
            [PostType::Achievement, 'Academic Excellence Award 2025', 'Students felicitated for outstanding performance in session 2024–25.'],
            [PostType::Achievement, 'Green Olympiad Merit Certificates', 'National environment quiz — multiple merit positions secured.'],
            [PostType::Event, 'Inter-School GK Quiz 2026', 'Selected students to represent the school at district level.'],
            [PostType::Event, 'Environment Festival – El Entorno', 'Participation in Inter-DPS environment festival.'],
        ];

        foreach ($items as $i => [$type, $title, $excerpt]) {
            Post::query()->firstOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'type' => $type,
                    'title' => $title,
                    'excerpt' => $excerpt,
                    'body' => "<p>{$excerpt}</p><p>Replace this text in Admin → News &amp; Posts.</p>",
                    'image_path' => $placeholder,
                    'published_at' => now()->subDays($i),
                    'is_published' => true,
                ]
            );
        }
    }

    private function seedFacilities(): void
    {
        if (Facility::query()->count() > 0) {
            return;
        }

        $placeholder = 'images/demo/placeholder.svg';
        $names = ['Smart Classrooms', 'Science Labs', 'Computer Lab', 'Library', 'Sports Ground', 'Music Room', 'Dance Room', 'Indoor Games'];
        foreach ($names as $i => $name) {
            Facility::create([
                'name' => $name,
                'image_path' => $placeholder,
                'description' => 'Modern ' . strtolower($name) . ' for holistic learning.',
                'sort_order' => $i,
                'is_published' => true,
            ]);
        }
    }

    private function seedGallery(): void
    {
        if (GalleryItem::query()->count() > 0) {
            return;
        }

        $placeholder = 'images/demo/placeholder.svg';
        for ($i = 1; $i <= 9; $i++) {
            GalleryItem::create([
                'title' => 'Annual Day ' . $i,
                'album' => 'Events 2025',
                'image_path' => $placeholder,
                'sort_order' => $i,
                'is_published' => true,
            ]);
        }
    }

    private function seedDeskMessages(): void
    {
        if (DeskMessage::query()->count() > 0) {
            return;
        }

        $placeholder = 'images/demo/placeholder.svg';

        DeskMessage::create([
            'role' => 'principal',
            'name' => 'Dr. Gaurav Dubey',
            'designation' => 'Principal',
            'message' => 'Knowledge brings humility; from humility comes worthiness. We strive to help every child perform their duties with excellence and find true happiness in learning.',
            'photo_path' => $placeholder,
            'sort_order' => 0,
            'is_published' => true,
        ]);
        DeskMessage::create([
            'role' => 'chairman',
            'name' => 'Mr. Jitendra Kumar Gupta',
            'designation' => 'Chairman',
            'message' => 'Our endeavour is to provide the very best academics, sports infrastructure, and technology so we nurture the future of our children with care and commitment.',
            'photo_path' => $placeholder,
            'sort_order' => 1,
            'is_published' => true,
        ]);
    }

    private function seedTestimonials(): void
    {
        if (Testimonial::query()->count() > 0) {
            return;
        }

        Testimonial::create([
            'author_name' => 'Mrs. Priya Sharma',
            'author_label' => 'Parent of Class VII-B',
            'quote' => 'Teachers give personalized attention and celebrate small achievements. My child\'s confidence and love for learning have grown tremendously.',
            'sort_order' => 0,
            'is_published' => true,
        ]);
        Testimonial::create([
            'author_name' => 'Mr. Rajesh Verma',
            'author_label' => 'Parent of Class X-A',
            'quote' => 'Excellent balance of academics and co-curricular activities. The campus is safe, modern, and truly student-friendly.',
            'sort_order' => 1,
            'is_published' => true,
        ]);
    }

    private function seedPages(): void
    {
        $pages = [
            'vision-mission' => ['Vision & Mission', '<p>Our mission and vision guide every decision we make for our students.</p>'],
            'principal-message' => ["Principal's Message", '<p>Welcome to Horizon School. We are dedicated to your child\'s success.</p>'],
            'admission-procedure' => ['Admission Procedure', '<p>Contact the admission office or fill the enquiry form online.</p>'],
            'fee-structure' => ['Fee Structure', '<p>Fee details are available at the school office and on request.</p>'],
            'curriculum-overview' => ['Curriculum Overview', '<p>CBSE curriculum with emphasis on conceptual learning and life skills.</p>'],
            'mandatory-disclosure' => ['Mandatory Disclosure', '<p>As per CBSE norms, disclosure documents are maintained at school office.</p>'],
        ];

        foreach ($pages as $slug => [$title, $body]) {
            Page::query()->firstOrCreate(
                ['slug' => $slug],
                ['title' => $title, 'body' => $body, 'is_published' => true, 'sort_order' => 0]
            );
        }
    }
}
