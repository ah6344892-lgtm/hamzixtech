<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach([route('home'),route('services.index'),route('projects.index'),route('blog.index'),route('tutorials.index'),route('templates.index'),route('tools.index'),route('ai-tools.index'),route('about'),route('contact'),route('privacy'),route('terms')] as $url)
        <url><loc>{{ $url }}</loc><changefreq>weekly</changefreq><priority>{{ $url === route('home') ? '1.0' : '0.6' }}</priority></url>
    @endforeach
    @foreach($records as [$url,$updatedAt])<url><loc>{{ $url }}</loc>@if($updatedAt)<lastmod>{{ $updatedAt->toAtomString() }}</lastmod>@endif</url>@endforeach
</urlset>
