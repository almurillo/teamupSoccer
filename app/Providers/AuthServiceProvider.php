<?php

namespace App\Providers;
use App\Post;
use App\User;
use App\Team;
use App\Member;
use App\Policies\PostPolicy;
use App\Policies\TeamPolicy;
use App\Policies\MemberPolicy;


use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Post::class => PostPolicy::class,
        Team::class => TeamPolicy::class,
        Member::class => MemberPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-team', function ($user, $member) {
        if($user->id == $member->user_id ){
          return true;
        }
    });


    }

}
