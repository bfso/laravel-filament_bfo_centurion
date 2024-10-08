<?php

namespace App\Providers;

use App\Domain\Game\Listeners\StoreQueuedActionFinnishMessage;
use App\Domain\Inventory\Events\CraftingFinished;
use App\Domain\Map\Events\ClaimingFinished;
use App\Domain\Inventory\Listeners\ResolveCraftingQuests;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ClaimingFinished::class => [
            StoreQueuedActionFinnishMessage::class,
        ],
        CraftingFinished::class => [
            StoreQueuedActionFinnishMessage::class,
            ResolveCraftingQuests::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
