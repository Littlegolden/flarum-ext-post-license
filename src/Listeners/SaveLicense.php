<?php

namespace LittleGolden\PostLicense\Listeners;

use LittleGolden\PostLicense\Validators\LicenseValidator;
use Flarum\Post\Event\Saving;
use Illuminate\Contracts\Events\Dispatcher;

class SaveLicense
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Saving::class, [$this, 'saving']);
    }

    public function saving(Saving $event)
    {
        /**
         * @var $validator LicenseValidator
         */
        $validator = app(LicenseValidator::class);

        $license = array_get($event->data, 'attributes.littleGoldenPostLicense');

        $validator->assertValid([
            'license' => $license,
        ]);

        $event->post->littlegolden_post_license = $license;
    }
}
