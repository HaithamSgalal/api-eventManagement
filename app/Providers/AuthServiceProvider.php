<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Event;
use App\Models\Attendee;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Gate::define('update-event' , function (User $user , Event $event) {
        //     return $user->id === $event->user_id ; 
        // });

        // Gate::define('delete-attendee' , function(User $user , Event $event , Attendee $attendee){
        //     return $event->user_id = $user->id || $attendee->user_id = $user->id ; 
        // });
    }
}
