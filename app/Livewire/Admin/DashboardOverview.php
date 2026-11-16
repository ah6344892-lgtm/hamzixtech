<?php

namespace App\Livewire\Admin;

use App\Models\ActivityLog;
use App\Models\ContactMessage;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Template;
use App\Models\Tool;
use App\Models\Tutorial;
use Livewire\Component;

class DashboardOverview extends Component
{
    public string $refreshedAt = '';

    public function mount(): void
    {
        $this->authorizeDashboard();
        $this->refreshedAt = now()->format('H:i:s');
    }

    public function refreshDashboard(): void
    {
        $this->authorizeDashboard();
        $this->refreshedAt = now()->format('H:i:s');
    }

    public function render()
    {
        $user = auth()->user();
        $this->authorizeDashboard();

        $stats = [
            ['label' => 'Published posts', 'value' => Post::published()->count(), 'icon' => 'document-text', 'color' => 'blue', 'route' => 'admin.posts.index', 'permission' => 'view posts'],
            ['label' => 'Draft posts', 'value' => Post::query()->where('status', 'draft')->count(), 'icon' => 'pencil-square', 'color' => 'amber', 'route' => 'admin.posts.index', 'permission' => 'view posts'],
            ['label' => 'Tutorials', 'value' => Tutorial::query()->count(), 'icon' => 'academic-cap', 'color' => 'violet', 'route' => 'admin.tutorials.index', 'permission' => 'view tutorials'],
            ['label' => 'Templates', 'value' => Template::query()->count(), 'icon' => 'rectangle-stack', 'color' => 'cyan', 'route' => 'admin.templates.index', 'permission' => 'view templates'],
            ['label' => 'Tools', 'value' => Tool::query()->count(), 'icon' => 'wrench-screwdriver', 'color' => 'emerald', 'route' => 'admin.tools.index', 'permission' => 'view tools'],
            ['label' => 'Projects', 'value' => Project::query()->count(), 'icon' => 'briefcase', 'color' => 'indigo', 'route' => 'admin.projects.index', 'permission' => 'view projects'],
            ['label' => 'New messages', 'value' => ContactMessage::query()->where('status', 'new')->count(), 'icon' => 'envelope', 'color' => 'rose', 'route' => 'admin.contact-messages.index', 'permission' => 'view contact messages'],
            ['label' => 'Services', 'value' => Service::query()->count(), 'icon' => 'squares-2x2', 'color' => 'sky', 'route' => 'admin.services.index', 'permission' => 'view services'],
        ];

        $stats = collect($stats)->filter(fn (array $stat): bool => $user->can($stat['permission']))->values();
        $activity = $user->can('view activity logs')
            ? ActivityLog::query()->with('user')->latest()->take(8)->get()
            : collect();

        return view('livewire.admin.dashboard-overview', compact('stats', 'activity'));
    }

    private function authorizeDashboard(): void
    {
        abort_unless(auth()->user()?->can('view dashboard'), 403);
    }
}
