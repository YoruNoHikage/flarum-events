<?php namespace WIC\Events\Listeners;

use Flarum\Tags\Tag;
use Flarum\Events\PostWillBeSaved;
use Flarum\Events\PostWasDeleted;
use Flarum\Core\Posts\Post;
use Flarum\Core\Posts\CommentPost;
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
        if(!isset($data['attributes']['event'])) {
          return;
        }

        $eventPostRaw = $data['attributes']['event'];

        // TO DO: notify changing event

        $existingEvent = $post->event();
        if(!$eventPostRaw['when']) {
            $existingEvent->delete();
            return;
        }

        if($existingEvent->exists()) {
            $eventPost = $post->event;
            $eventPost->when = new \DateTime($eventPostRaw['when']);
        } else {
            $eventPost = Event::build(new \DateTime($eventPostRaw['when']));
        }

        $whenPostWasSaved = function($post) use ($eventPost) {
            $eventPost->post()->associate($post);
            $eventPost->save();
        };

        Post::saved($whenPostWasSaved);
        CommentPost::saved($whenPostWasSaved); // tmp, Post should handle it for its subclasses
    }

    public function whenPostWasDeleted(PostWasDeleted $event)
    {
        if($eventPost = $event->post->event()) {
            $this->deleteEvent($eventPost);
        }
    }
}
