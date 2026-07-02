<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

// हाम्रा इभेन्ट र लिस्नरहरू
use App\Events\PaymentVerified;
use App\Listeners\GenerateReceipt;
use App\Listeners\ActivateRegistrationIfPaid;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // Laravel को डिफल्ट इभेन्ट (यदि चाहियो भने)
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        // हाम्रो PaymentVerified इभेन्टको लिस्नरहरू
        PaymentVerified::class => [
            GenerateReceipt::class,
            ActivateRegistrationIfPaid::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}