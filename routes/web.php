<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DrawController;
use App\Http\Controllers\Admin\EntryController as AdminEntryController;
use App\Http\Controllers\Admin\LandingCmsController;
use App\Http\Controllers\Admin\LandingFaqController;
use App\Http\Controllers\Admin\LandingFeatureController;
use App\Http\Controllers\Admin\LandingStepController;
use App\Http\Controllers\Admin\LandingTestimonialController;
use App\Http\Controllers\Admin\LandingWinnerController;
use App\Http\Controllers\Admin\PoolController as AdminPoolController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\WinnerController as AdminWinnerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OtpVerificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/verify-email', [OtpVerificationController::class, 'show'])
        ->middleware('guest.otp')
        ->name('otp.show');
    Route::post('/verify-email', [OtpVerificationController::class, 'verify'])
        ->middleware('guest.otp')
        ->name('otp.verify');
    Route::post('/verify-email/resend', [OtpVerificationController::class, 'resend'])
        ->middleware(['guest.otp', 'throttle:3,1'])
        ->name('otp.resend');

    Route::middleware('verified.email')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/pools/{pool}/enter', [EntryController::class, 'create'])->name('entries.create');
        Route::post('/pools/{pool}/enter', [EntryController::class, 'store'])->name('entries.store');
    });
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });

    Route::middleware('admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/entries', [AdminEntryController::class, 'index'])->name('entries.index');
        Route::get('/entries/{entry}', [AdminEntryController::class, 'show'])->name('entries.show');
        Route::patch('/entries/{entry}/approve', [AdminEntryController::class, 'approve'])->name('entries.approve');
        Route::patch('/entries/{entry}/reject', [AdminEntryController::class, 'reject'])->name('entries.reject');
        Route::get('/pools', [AdminPoolController::class, 'index'])->name('pools.index');
        Route::get('/pools/create', [AdminPoolController::class, 'create'])->name('pools.create');
        Route::post('/pools', [AdminPoolController::class, 'store'])->name('pools.store');
        Route::get('/pools/{pool}/edit', [AdminPoolController::class, 'edit'])->name('pools.edit');
        Route::put('/pools/{pool}', [AdminPoolController::class, 'update'])->name('pools.update');
        Route::patch('/pools/{pool}/toggle', [AdminPoolController::class, 'toggle'])->name('pools.toggle');
        Route::get('/settings', [AdminSettingsController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/winners', [AdminWinnerController::class, 'index'])->name('winners.index');
        Route::get('/draw', [DrawController::class, 'index'])->name('draw.index');
        Route::post('/draw/run', [DrawController::class, 'run'])->name('draw.run');
        Route::post('/draw/reopen', [DrawController::class, 'reopenPools'])->name('draw.reopen');

        Route::prefix('cms')->name('cms.')->group(function () {
            Route::get('/', [LandingCmsController::class, 'index'])->name('index');
            Route::patch('/sections/{section}', [LandingCmsController::class, 'toggleSection'])->name('sections.toggle');
            Route::get('/hero', [LandingCmsController::class, 'hero'])->name('hero');
            Route::put('/hero', [LandingCmsController::class, 'updateHero'])->name('hero.update');
            Route::get('/statistics', [LandingCmsController::class, 'statistics'])->name('statistics');
            Route::get('/jackpot', [LandingCmsController::class, 'jackpot'])->name('jackpot');
            Route::put('/jackpot', [LandingCmsController::class, 'updateJackpot'])->name('jackpot.update');
            Route::get('/download', [LandingCmsController::class, 'download'])->name('download');
            Route::put('/download', [LandingCmsController::class, 'updateDownload'])->name('download.update');
            Route::get('/newsletter', [LandingCmsController::class, 'newsletter'])->name('newsletter');
            Route::put('/newsletter', [LandingCmsController::class, 'updateNewsletter'])->name('newsletter.update');
            Route::get('/footer', [LandingCmsController::class, 'footer'])->name('footer');
            Route::put('/footer', [LandingCmsController::class, 'updateFooter'])->name('footer.update');
            Route::get('/seo', [LandingCmsController::class, 'seo'])->name('seo');
            Route::put('/seo', [LandingCmsController::class, 'updateSeo'])->name('seo.update');
            Route::get('/theme', [LandingCmsController::class, 'theme'])->name('theme');
            Route::put('/theme', [LandingCmsController::class, 'updateTheme'])->name('theme.update');
            Route::get('/analytics', [LandingCmsController::class, 'analytics'])->name('analytics');
            Route::put('/analytics', [LandingCmsController::class, 'updateAnalytics'])->name('analytics.update');
            Route::get('/popup', [LandingCmsController::class, 'popup'])->name('popup');
            Route::put('/popup', [LandingCmsController::class, 'updatePopup'])->name('popup.update');

            Route::resource('steps', LandingStepController::class)->except(['show']);
            Route::resource('features', LandingFeatureController::class)->except(['show']);
            Route::resource('testimonials', LandingTestimonialController::class)->except(['show']);
            Route::resource('faqs', LandingFaqController::class)->except(['show']);
            Route::resource('winners', LandingWinnerController::class)->except(['show']);
        });
    });
});
