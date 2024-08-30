<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\AdministrasiPidum;
use App\Models\IdentitasTersangka;
use App\Models\TahapanAdministrasi;
use App\Models\TahapanPerkara;
use App\Policies\ActivityPolicy;
use App\Policies\AuthlogPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\CommentPolicy;
use App\Policies\ExceptionPolicy;
use App\Policies\IdentitasTersangkaPolicy;
use App\Policies\NewsLetterPolicy;
use App\Policies\PostPolicy;
use App\Policies\SeoDetailPolicy;
use App\Policies\SettingPolicy;
use App\Policies\ShareSnippetPolicy;
use App\Policies\TagPolicy;
use App\Policies\TahapanAdministrasiPolicy;
use Firefly\FilamentBlog\Models\Setting;
use Spatie\Activitylog\Models\Activity;
// use Rappasoft\LaravelAuthenticationLog\Models\AuthenticationLog;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use BezhanSalleh\FilamentExceptions\Models\Exception;
use Firefly\FilamentBlog\Models\Category;
use Firefly\FilamentBlog\Models\Comment;
use Firefly\FilamentBlog\Models\NewsLetter;
use Firefly\FilamentBlog\Models\Post;
use Firefly\FilamentBlog\Models\SeoDetail;
use Firefly\FilamentBlog\Models\ShareSnippet;
use Firefly\FilamentBlog\Models\Tag;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Exception::class => ExceptionPolicy::class,
        Category::class => CategoryPolicy::class,
        Comment::class => CommentPolicy::class,
        NewsLetter::class => NewsLetterPolicy::class,
        Post::class => PostPolicy::class,
        SeoDetail::class => SeoDetailPolicy::class,
        Setting::class => SettingPolicy::class,
        ShareSnippet::class => ShareSnippetPolicy::class,
        Tag::class => TagPolicy::class,
        Activity::class => ActivityPolicy::class,
        TahapanAdministrasi::class => TahapanAdministrasiPolicy::class,
        TahapanPerkara::class => TahapanAdministrasiPolicy::class,
        AdministrasiPidum::class => TahapanAdministrasiPolicy::class,
        IdentitasTersangka::class => IdentitasTersangkaPolicy::class,
        // AuthenticationLog::class => AuthlogPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
