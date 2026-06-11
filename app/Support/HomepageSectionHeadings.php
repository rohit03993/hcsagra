<?php

namespace App\Support;

class HomepageSectionHeadings
{
    /** @return array<string, array{subtitle: string, title: string}> */
    public static function defaults(): array
    {
        return [
            'about' => [
                'subtitle' => 'About Our School',
                'title' => 'A Place to Learn & Grow',
            ],
            'news' => [
                'subtitle' => 'News & Notices',
                'title' => 'School Updates',
            ],
            'mission' => [
                'subtitle' => 'Our Purpose',
                'title' => 'Mission & Vision',
            ],
            'leadership' => [
                'subtitle' => 'Leadership Messages',
                'title' => 'Director & Principal',
            ],
            'facilities' => [
                'subtitle' => 'Our Campus',
                'title' => 'School Facilities',
            ],
            'gallery' => [
                'subtitle' => 'Campus Life',
                'title' => 'Photo Gallery',
            ],
            'testimonials' => [
                'subtitle' => 'Parent Feedback',
                'title' => 'What Parents Say',
            ],
            'videos' => [
                'subtitle' => 'Watch & Explore',
                'title' => 'School Videos',
            ],
            'contact' => [
                'subtitle' => 'Reach us',
                'title' => 'Contact Us',
            ],
        ];
    }

    public static function keys(): array
    {
        return array_keys(static::defaults());
    }
}
