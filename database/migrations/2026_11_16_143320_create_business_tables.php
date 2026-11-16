<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->longText('description');
            $table->string('icon', 80)->nullable();
            $table->string('featured_image')->nullable();
            $table->string('featured_image_alt')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0)->index();
            $table->string('status', 24)->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->boolean('featured')->default(false)->index();
            $table->string('seo_title')->nullable();
            $table->string('seo_description', 320)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->longText('description');
            $table->string('main_image')->nullable();
            $table->string('main_image_alt')->nullable();
            $table->json('gallery')->nullable();
            $table->json('technologies')->nullable();
            $table->string('demo_url')->nullable();
            $table->string('source_url')->nullable();
            $table->date('completed_at')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0)->index();
            $table->boolean('featured')->default(false)->index();
            $table->string('status', 24)->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->string('seo_title')->nullable();
            $table->string('seo_description', 320)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->index();
            $table->string('subject');
            $table->string('project_type', 80)->nullable();
            $table->longText('message');
            $table->string('status', 24)->default('new')->index();
            $table->text('internal_notes')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('site_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->string('value_type', 24)->default('text');
            $table->string('group', 60)->default('general')->index();
            $table->timestamps();
        });

        Schema::create('social_links', function (Blueprint $table): void {
            $table->id();
            $table->string('platform', 40)->unique();
            $table->string('label')->nullable();
            $table->string('url')->nullable();
            $table->boolean('enabled')->default(false)->index();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('site_settings');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('services');
    }
};
