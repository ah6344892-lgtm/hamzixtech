<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Super Admin receives the full permission set through the role seeder.
        // Policies remain active for every role, including last-admin safeguards.
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Permission::class, PermissionPolicy::class);
        View::composer('layouts.app', function ($view): void {
            $view->with([
                'siteContactEmail' => SiteSetting::read('contact.email') ?: config('hamzixtech.contact_email'),
                'siteWhatsApp' => SiteSetting::read('contact.whatsapp') ?: config('hamzixtech.whatsapp_number'),
                'siteWhatsAppMessage' => SiteSetting::read('contact.whatsapp_message') ?: config('hamzixtech.whatsapp_message'),
                'siteSocialLinks' => SocialLink::visible()->orderBy('sort_order')->get(),
            ]);
        });
        Event::listen(Login::class, function (Login $event): void {
            $event->user->forceFill(['last_login_at' => now()])->save();
        });
    }
}
