<?php

namespace LittleGolden\PostLicense\Listeners;

use Flarum\Api\Event\Serializing;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Events\Dispatcher;

class ForumAttributes
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Serializing::class, [$this, 'serializing']);
    }

    public function serializing(Serializing $event)
    {
        if ($event->serializer instanceof ForumSerializer) {
            /**
             * @var $settings SettingsRepositoryInterface
             */
            $settings = app(SettingsRepositoryInterface::class);

            $event->attributes['littlegolden-post-license.require-license'] = (bool)$settings->get('littlegolden-post-license.require-license');
            $event->attributes['littlegolden-post-license.allow-custom-license'] = (bool)$settings->get('littlegolden-post-license.allow-custom-license');
            $event->attributes['littlegolden-post-license.enabled-licenses'] = json_decode($settings->get('littlegolden-post-license.enabled-licenses', '[]'));
        }
    }
}
