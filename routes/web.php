<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\PageController;

// Public Landing Page & Download Showcase
Route::get('/', [PageController::class, 'home'])->name('home');

// Google Play Console Compliant Legal & Policy Pages
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/privacy', [PageController::class, 'privacy']); // Alias for short URL

Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/terms-of-service', [PageController::class, 'terms']); // Alias for short URL
Route::get('/terms-and-conditions', [PageController::class, 'terms']); // Alias

// Google Play Mandatory Public Account & Data Deletion Portal
Route::get('/delete-account', [PageController::class, 'deleteAccount'])->name('delete-account');
Route::get('/data-deletion', [PageController::class, 'deleteAccount'])->name('data-deletion'); // Alias
Route::post('/delete-account-request', [PageController::class, 'submitDeleteAccountRequest'])->name('delete-account.submit');

// Community Guidelines & Safe Dating
Route::get('/community-guidelines', [PageController::class, 'communityGuidelines'])->name('community-guidelines');
Route::get('/safety', [PageController::class, 'communityGuidelines']); // Alias

// In-App Purchase & Refund Policy
Route::get('/refund-policy', [PageController::class, 'refundPolicy'])->name('refund-policy');

// Contact Us & Grievance Redressal
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');
