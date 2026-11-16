<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table): void {
            $table->id();
            $table->string('type', 32)->index();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description', 320)->nullable();
            $table->timestamps();
            $table->unique(['type', 'slug']);
        });

        Schema::create('tags', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->string('featured_image_alt')->nullable();
            $table->string('status', 24)->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->boolean('featured')->default(false)->index();
            $table->string('seo_title')->nullable();
            $table->string('seo_description', 320)->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('og_image')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('post_tag', function (Blueprint $table): void {
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['post_id', 'tag_id']);
        });

        Schema::create('tutorials', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->longText('content');
            $table->string('cover_image')->nullable();
            $table->string('cover_image_alt')->nullable();
            $table->string('difficulty', 24)->default('beginner');
            $table->unsignedSmallInteger('estimated_minutes')->nullable();
            $table->json('technologies')->nullable();
            $table->string('status', 24)->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->boolean('featured')->default(false)->index();
            $table->string('seo_title')->nullable();
            $table->string('seo_description', 320)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('tutorial_tag', function (Blueprint $table): void {
            $table->foreignId('tutorial_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['tutorial_id', 'tag_id']);
        });

        Schema::create('templates', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->longText('description');
            $table->longText('features')->nullable();
            $table->longText('requirements')->nullable();
            $table->longText('installation_instructions')->nullable();
            $table->json('technologies')->nullable();
            $table->json('screenshots')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('thumbnail_alt')->nullable();
            $table->string('github_url')->nullable();
            $table->string('demo_url')->nullable();
            $table->string('download_path')->nullable();
            $table->string('version', 40)->nullable();
            $table->string('license')->nullable();
            $table->string('pricing_type', 16)->default('free');
            $table->string('status', 24)->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->date('last_updated_at')->nullable();
            $table->boolean('featured')->default(false)->index();
            $table->string('seo_title')->nullable();
            $table->string('seo_description', 320)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('template_tag', function (Blueprint $table): void {
            $table->foreignId('template_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['template_id', 'tag_id']);
        });

        Schema::create('tools', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->longText('instructions')->nullable();
            $table->string('icon', 80)->nullable();
            $table->boolean('is_implemented')->default(false)->index();
            $table->boolean('is_enabled')->default(false)->index();
            $table->string('status', 24)->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->string('seo_title')->nullable();
            $table->string('seo_description', 320)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tools');
        Schema::dropIfExists('template_tag');
        Schema::dropIfExists('templates');
        Schema::dropIfExists('tutorial_tag');
        Schema::dropIfExists('tutorials');
        Schema::dropIfExists('post_tag');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('categories');
    }
};
