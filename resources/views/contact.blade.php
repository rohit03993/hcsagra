@extends('layouts.app')

@section('seo')
    <x-seo title="Contact Us" :description="'Contact ' . $settings->school_name . ' — phone, email, address and admission enquiry.'" />
@endsection

@section('content')
    <div class="site-container py-8 lg:py-12">
        <x-site-contact-section />
    </div>
@endsection
