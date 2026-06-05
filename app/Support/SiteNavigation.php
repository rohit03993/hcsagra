<?php

namespace App\Support;

class SiteNavigation
{
    /**
     * Mobile menu structure (DPS-inspired).
     *
     * @return array<int, array{label: string, url?: string, children?: array<int, array{label: string, url: string}>}>
     */
    public static function menu(): array
    {
        return [
            ['label' => 'Home', 'url' => route('home')],
            [
                'label' => 'About us',
                'children' => [
                    ['label' => 'Vision & Mission', 'url' => route('pages.show', 'vision-mission')],
                    ['label' => "Principal's Message", 'url' => route('pages.show', 'principal-message')],
                    ['label' => 'Faculty', 'url' => route('pages.show', 'faculty')],
                ],
            ],
            [
                'label' => 'Admissions',
                'children' => [
                    ['label' => 'Admission Enquiry', 'url' => route('admission.enquiry')],
                    ['label' => 'Admission Procedure', 'url' => route('pages.show', 'admission-procedure')],
                    ['label' => 'Fee Structure', 'url' => route('pages.show', 'fee-structure')],
                ],
            ],
            [
                'label' => 'Academics',
                'children' => [
                    ['label' => 'Curriculum Overview', 'url' => route('pages.show', 'curriculum-overview')],
                    ['label' => 'Academic Calendar', 'url' => route('pages.show', 'academic-calendar')],
                ],
            ],
            ['label' => 'Achievements', 'url' => route('posts.index', ['type' => 'achievement'])],
        ];
    }

    public static function footerColumns(): array
    {
        return [
            'About' => [
                ['label' => 'Vision & Mission', 'url' => route('pages.show', 'vision-mission')],
                ['label' => "Principal's Message", 'url' => route('pages.show', 'principal-message')],
            ],
            'Admissions' => [
                ['label' => 'Procedure', 'url' => route('pages.show', 'admission-procedure')],
                ['label' => 'Fee Structure', 'url' => route('pages.show', 'fee-structure')],
            ],
            'Campus' => [
                ['label' => 'Gallery', 'url' => route('gallery')],
                ['label' => 'Videos', 'url' => route('videos')],
                ['label' => 'Contact', 'url' => route('contact')],
            ],
        ];
    }
}
