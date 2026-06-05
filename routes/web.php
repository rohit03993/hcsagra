<?php

use App\Http\Controllers\AdmissionEnquiryController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/news', [PostController::class, 'index'])->name('posts.index');
Route::get('/news/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
Route::get('/videos', [PageController::class, 'videos'])->name('videos');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store')->middleware('throttle:5,1');
Route::get('/admission-enquiry', [AdmissionEnquiryController::class, 'create'])->name('admission.enquiry');
Route::post('/admission-enquiry', [AdmissionEnquiryController::class, 'store'])->name('admission.enquiry.store')->middleware('throttle:5,1');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('pages.show');
Route::get('/mandatory-disclosure', [PageController::class, 'mandatoryDisclosure'])->name('mandatory-disclosure');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
