<?php

namespace LittleGolden\PostLicense\Listeners;

use Flarum\Api\Event\Serializing;
use Flarum\Api\Serializer\PostSerializer;
use Illuminate\Contracts\Events\Dispatcher;

class ShowLicense
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Serializing::class, [$this, 'serializing']);
    }

    public function serializing(Serializing $event)
    {
        if ($event->serializer instanceof PostSerializer) {
            $event->attributes['littleGoldenPostLicense'] = $event->model->littlegolden_post_license;
        }
    }
}
