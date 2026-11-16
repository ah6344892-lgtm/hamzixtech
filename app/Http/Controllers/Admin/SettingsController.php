<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SettingsController extends Controller
{
    public function edit()
    {
        Gate::authorize('viewAny', SiteSetting::class);
        return view('admin.settings.edit', ['settings'=>SiteSetting::query()->get()->keyBy('key'),'socialLinks'=>SocialLink::query()->orderBy('sort_order')->get()]);
    }

    public function update(Request $request)
    {
        Gate::authorize('manage settings');
        $data = $request->validate([
            'home_headline' => ['nullable','string','max:180'],
            'home_introduction' => ['nullable','string','max:1000'],
            'about_introduction' => ['nullable','string','max:10000'],
            'contact_email' => ['nullable','email','max:190'],
            'whatsapp_number' => ['nullable','string','max:30','regex:/^[+0-9 ()-]*$/'],
            'whatsapp_message' => ['nullable','string','max:300'],
            'privacy_policy' => ['nullable','string','max:30000'],
            'terms' => ['nullable','string','max:30000'],
            'social' => ['nullable','array'],
            'social.*.label' => ['nullable','string','max:100'],
            'social.*.url' => ['nullable','url:http,https','max:2048'],
            'social.*.enabled' => ['nullable','boolean'],
        ]);
        SiteSetting::write('home.headline',$data['home_headline'] ?? '', 'general');
        SiteSetting::write('home.introduction',$data['home_introduction'] ?? '', 'general');
        SiteSetting::write('about.introduction',$data['about_introduction'] ?? '', 'general');
        SiteSetting::write('contact.email',$data['contact_email'] ?? '', 'general');
        SiteSetting::write('contact.whatsapp',preg_replace('/\D+/','',$data['whatsapp_number'] ?? ''), 'general');
        SiteSetting::write('contact.whatsapp_message',$data['whatsapp_message'] ?? '', 'general');
        SiteSetting::write('legal.privacy_policy',$data['privacy_policy'] ?? '', 'legal');
        SiteSetting::write('legal.terms',$data['terms'] ?? '', 'legal');
        foreach (SocialLink::query()->get() as $link) {
            $values = $data['social'][$link->platform] ?? [];
            $link->label = $values['label'] ?? $link->label;
            $link->url = $values['url'] ?? null;
            $link->enabled = (bool) ($values['enabled'] ?? false) && filled($link->url);
            $link->save();
        }
        ActivityLogger::record('settings.updated', null, 'Updated site settings');
        return back()->with('success','Site settings updated.');
    }
}
