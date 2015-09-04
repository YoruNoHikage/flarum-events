<?php namespace WIC\Events\Listeners;
use Flarum\Events\ModelRelationship;
use Flarum\Core\Posts\Post;
use Illuminate\Contracts\Events\Dispatcher;

class AddModelRelationship
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(ModelRelationship::class, [$this, 'addRelationship']);
    }

    public function addRelationship(ModelRelationship $event)
    {
        if ($event->model instanceof Post &&
            $event->relationship === 'event') {
            return $event->model->hasOne('WIC\Events\Event', 'post_id', 'id');
        }
    }
}
