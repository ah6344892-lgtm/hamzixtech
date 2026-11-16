<?php

namespace App\Authorization;

class PermissionCatalog
{
    /** @return array<string, list<string>> */
    public static function groups(): array
    {
        return [
            'dashboard' => ['view dashboard'],
            'posts' => ['view posts', 'create posts', 'edit posts', 'delete posts', 'publish posts', 'manage post categories', 'manage post tags'],
            'tutorials' => ['view tutorials', 'create tutorials', 'edit tutorials', 'delete tutorials', 'publish tutorials', 'manage tutorial categories', 'manage tutorial tags'],
            'templates' => ['view templates', 'create templates', 'edit templates', 'delete templates', 'publish templates', 'manage template categories', 'manage template tags'],
            'tools' => ['view tools', 'create tools', 'edit tools', 'delete tools', 'publish tools', 'manage tools'],
            'services' => ['view services', 'create services', 'edit services', 'delete services', 'publish services', 'manage services'],
            'projects' => ['view projects', 'create projects', 'edit projects', 'delete projects', 'publish projects', 'manage projects', 'manage project categories'],
            'ai' => ['view AI tools', 'manage AI tools', 'view AI usage'],
            'contact_messages' => ['view contact messages', 'reply contact messages', 'delete contact messages'],
            'users' => ['view users', 'create users', 'edit users', 'delete users', 'deactivate users', 'assign user roles'],
            'roles' => ['manage roles', 'manage permissions'],
            'media' => ['view media', 'manage media'],
            'settings' => ['manage settings'],
            'activity_logs' => ['view activity logs'],
            'redirects' => ['manage redirects'],
        ];
    }

    /** @return list<string> */
    public static function all(): array
    {
        return array_values(array_unique(array_merge(...array_values(self::groups()))));
    }

    /** @return list<string> */
    public static function administratorDefaults(): array
    {
        return array_values(array_filter(self::all(), fn (string $permission): bool => ! in_array($permission, [
            'manage roles', 'manage permissions', 'manage settings', 'view activity logs', 'view AI usage',
        ], true)));
    }

    /** @return list<string> */
    public static function managerDefaults(): array
    {
        return [
            'view dashboard',
            'view posts', 'create posts', 'edit posts', 'publish posts', 'manage post categories', 'manage post tags',
            'view tutorials', 'create tutorials', 'edit tutorials', 'publish tutorials', 'manage tutorial categories', 'manage tutorial tags',
            'view templates', 'create templates', 'edit templates', 'publish templates', 'manage template categories', 'manage template tags',
            'view tools', 'manage tools',
            'view services', 'create services', 'edit services', 'publish services', 'manage services',
            'view projects', 'create projects', 'edit projects', 'publish projects', 'manage projects', 'manage project categories',
            'view contact messages', 'reply contact messages', 'view media', 'manage media',
        ];
    }

    /** @return list<string> */
    public static function employeeDefaults(): array
    {
        return ['view dashboard', 'view posts', 'view tutorials', 'view templates', 'view tools', 'view services', 'view projects'];
    }
}
