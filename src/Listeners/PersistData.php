<?php namespace WIC\Events\Listeners;

use Flarum\Tags\Tag;
use Flarum\Events\PostWillBeSaved;
use Flarum\Events\PostWasDelete;
use Flarum\Core\Posts\Post;
use Flarum\Core\Settings\SettingsRepository;
use WIC\Events\Event;

class PersistData
{
    protected $settings;

    public function __construct(SettingsRepository $settings)
    {
        $this->settings = $settings;
    }

    public function subscribe($events)
    {
        $events->listen(PostWillBeSaved::class, [$this, 'whenPostWillBeSaved']);
        $events->listen(PostWasDeleted::class, [$this, 'whenPostWasDeleted']);
    }

    public function whenPostWillBeSaved(PostWillBeSaved $event)
    {
        $post = $event->post;
        $data = $event->data;
        if($post->exists && isset($data['attributes']['event'])) {
            $eventPostRaw = $data['attributes']['event'];

            // TO DO: notify changing event

            $eventPost = Event::build(new \DateTime($eventPostRaw['when']));
            $eventPost->post()->associate($post);
            $eventPost->save();
        }
    }

    public function whenPostWasDeleted(PostWasDelete $event)
    {
        if($eventPost = $event->post->event()) {
            $eventPost->detach();
            $eventPost->delete();
        }
    }
}
