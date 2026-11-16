<?php

use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\PublicSiteController;
use Illuminate\Support\Facades\Route;

Route::controller(PublicSiteController::class)->group(function (): void {
    Route::get('/', 'home')->name('home');
    Route::get('/services', 'services')->name('services.index');
    Route::get('/services/{service:slug}', 'service')->name('services.show');
    Route::get('/projects', 'projects')->name('projects.index');
    Route::get('/projects/{project:slug}', 'project')->name('projects.show');
    Route::get('/blog', 'posts')->name('blog.index');
    Route::get('/blog/category/{slug}', 'category')->name('blog.category');
    Route::get('/blog/tag/{slug}', 'tag')->name('blog.tag');
    Route::get('/blog/{post:slug}', 'post')->name('blog.show');
    Route::get('/tutorials', 'tutorials')->name('tutorials.index');
    Route::get('/tutorials/{tutorial:slug}', 'tutorial')->name('tutorials.show');
    Route::get('/templates', 'templates')->name('templates.index');
    Route::get('/templates/{template:slug}', 'template')->name('templates.show');
    Route::get('/templates/{template:slug}/download', [PublicSiteController::class, 'downloadTemplate'])->name('templates.download');
    Route::get('/tools', 'tools')->name('tools.index');
    Route::get('/tools/{tool:slug}', 'tool')->name('tools.show');
    Route::post('/tools/{tool:slug}/run', 'runTool')->name('tools.run');
    Route::get('/ai-tools', 'aiTools')->name('ai-tools.index');
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store');
    Route::get('/privacy-policy', 'privacy')->name('privacy');
    Route::get('/terms', 'terms')->name('terms');
    Route::get('/search', 'search')->name('search');
    Route::get('/sitemap.xml', 'sitemap')->name('sitemap');
});

Route::get('/robots.txt', fn () => response("User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /login\nSitemap: ".route('sitemap')."\n", 200, ['Content-Type' => 'text/plain']))->name('robots');

Route::middleware(['auth', 'active'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/posts', [\App\Http\Controllers\Admin\ResourceController::class, 'index'])->defaults('resource', 'posts')->name('posts.index');
    Route::get('/posts/create', [\App\Http\Controllers\Admin\ResourceController::class, 'create'])->defaults('resource', 'posts')->name('posts.create');
    Route::post('/posts', [\App\Http\Controllers\Admin\ResourceController::class, 'store'])->defaults('resource', 'posts')->name('posts.store');
    Route::get('/posts/{id}/edit', [\App\Http\Controllers\Admin\ResourceController::class, 'edit'])->defaults('resource', 'posts')->name('posts.edit');
    Route::put('/posts/{id}', [\App\Http\Controllers\Admin\ResourceController::class, 'update'])->defaults('resource', 'posts')->name('posts.update');
    Route::delete('/posts/{id}', [\App\Http\Controllers\Admin\ResourceController::class, 'destroy'])->defaults('resource', 'posts')->name('posts.destroy');
    foreach (['tutorials', 'templates', 'tools', 'services', 'projects', 'categories', 'tags', 'ai-tools'] as $resource) {
        Route::get('/'.$resource, [\App\Http\Controllers\Admin\ResourceController::class, 'index'])->defaults('resource', $resource)->name($resource.'.index');
        Route::get('/'.$resource.'/create', [\App\Http\Controllers\Admin\ResourceController::class, 'create'])->defaults('resource', $resource)->name($resource.'.create');
        Route::post('/'.$resource, [\App\Http\Controllers\Admin\ResourceController::class, 'store'])->defaults('resource', $resource)->name($resource.'.store');
        Route::get('/'.$resource.'/{id}/edit', [\App\Http\Controllers\Admin\ResourceController::class, 'edit'])->defaults('resource', $resource)->name($resource.'.edit');
        Route::put('/'.$resource.'/{id}', [\App\Http\Controllers\Admin\ResourceController::class, 'update'])->defaults('resource', $resource)->name($resource.'.update');
        Route::delete('/'.$resource.'/{id}', [\App\Http\Controllers\Admin\ResourceController::class, 'destroy'])->defaults('resource', $resource)->name($resource.'.destroy');
    }
    Route::get('/contact-messages', [\App\Http\Controllers\Admin\ContactMessagesController::class, 'index'])->name('contact-messages.index');
    Route::patch('/contact-messages/{message}', [\App\Http\Controllers\Admin\ContactMessagesController::class, 'update'])->name('contact-messages.update');
    Route::delete('/contact-messages/{message}', [\App\Http\Controllers\Admin\ContactMessagesController::class, 'destroy'])->name('contact-messages.destroy');
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/roles', [\App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [\App\Http\Controllers\Admin\RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [\App\Http\Controllers\Admin\RoleController::class, 'store'])->name('roles.store');
    Route::put('/roles/{role}', [\App\Http\Controllers\Admin\RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [\App\Http\Controllers\Admin\RoleController::class, 'destroy'])->name('roles.destroy');
    Route::get('/permissions', [\App\Http\Controllers\Admin\RoleController::class, 'index'])->name('permissions.index');
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
    Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/media', [\App\Http\Controllers\Admin\MediaController::class, 'index'])->name('media.index');
    Route::post('/media', [\App\Http\Controllers\Admin\MediaController::class, 'store'])->name('media.store');
    Route::delete('/media/{asset}', [\App\Http\Controllers\Admin\MediaController::class, 'destroy'])->name('media.destroy');
});

Route::fallback(function () {
    $redirect = \App\Models\Redirect::query()->where('from_path', '/'.ltrim(request()->path(), '/'))->where('enabled', true)->first();
    return $redirect ? redirect($redirect->to_path, $redirect->status_code) : abort(404);
});
