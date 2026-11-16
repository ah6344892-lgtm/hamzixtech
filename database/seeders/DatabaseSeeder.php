<?php

namespace Database\Seeders;

use App\Authorization\PermissionCatalog;
use App\Models\SiteSetting;
use App\Models\Tool;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (PermissionCatalog::all() as $name) {
            Permission::findOrCreate($name, 'web');
        }

        $sets = [
            'Super Admin' => PermissionCatalog::all(),
            'Admin' => PermissionCatalog::administratorDefaults(),
            'Manager' => PermissionCatalog::managerDefaults(),
            'Employee' => PermissionCatalog::employeeDefaults(),
        ];

        foreach ($sets as $name => $permissions) {
            Role::findOrCreate($name, 'web')->syncPermissions($permissions);
        }

        foreach ([
            ['general', 'about.introduction', 'HamzixTech focuses on modern websites, software, and useful technology resources. The goal is to make digital experiences clear, practical, and maintainable.', 'text'],
            ['general', 'home.headline', 'Modern websites and software, built with care.', 'text'],
            ['general', 'home.introduction', 'We build digital experiences and useful technology resources with clarity, thoughtful design, and a reliable foundation.', 'text'],
            ['general', 'contact.email', '', 'text'],
            ['general', 'contact.whatsapp', '', 'text'],
            ['general', 'contact.whatsapp_message', '', 'text'],
            ['legal', 'legal.privacy_policy', '', 'text'],
            ['legal', 'legal.terms', '', 'text'],
        ] as [$group, $key, $value, $type]) {
            SiteSetting::query()->firstOrCreate(['key' => $key], [
                'group' => $group,
                'value' => $value,
                'value_type' => $type,
            ]);
        }

        foreach (['facebook', 'linkedin', 'github', 'youtube', 'instagram'] as $order => $platform) {
            \App\Models\SocialLink::query()->firstOrCreate(['platform' => $platform], [
                'label' => ucfirst($platform), 'url' => null, 'enabled' => false, 'sort_order' => $order,
            ]);
        }

        foreach ([
            ['json-formatter', 'JSON Formatter', 'Format and validate JSON in your browser session.'],
            ['text-utilities', 'Text Utilities', 'Change text case, trim outer spaces, and count characters and words.'],
            ['slug-generator', 'Slug Generator', 'Turn a phrase into a clean URL slug.'],
            ['url-encoder-decoder', 'URL Encoder / Decoder', 'Encode or decode URL component text.'],
        ] as $order => [$slug, $title, $description]) {
            Tool::query()->firstOrCreate(['slug' => $slug], [
                'title' => $title,
                'description' => $description,
                'instructions' => 'Input is processed on the server for this request and is not stored.',
                'is_implemented' => true,
                'is_enabled' => true,
                'status' => 'published',
                'published_at' => now(),
                'seo_title' => $title.' | HamzixTech Tools',
                'seo_description' => $description,
            ]);
        }

        $this->call(ExampleContentSeeder::class);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
