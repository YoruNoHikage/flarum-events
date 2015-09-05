<?php namespace WIC\Events\Listeners;

use Flarum\Events\ApiRelationship;
use Flarum\Events\BuildApiAction;
use Illuminate\Contracts\Events\Dispatcher;
use Flarum\Api\Serializers\PostSerializer;
use Flarum\Api\Actions\Discussions;
use Flarum\Api\Actions\Posts;
use WIC\Event;

class AddApiAttributes
{
    public function subscribe($events)
    {
        $events->listen(ApiRelationship::class, [$this, 'addRelationship']);
        $events->listen(BuildApiAction::class, [$this, 'includeEvent']);
    }

    public function addRelationship(ApiRelationship $event)
    {
        if ($event->serializer instanceof PostSerializer &&
            $event->relationship === 'event') {
            return $event->serializer->hasOne('WIC\Events\Serializers\EventSerializer', 'event');
        }
    }

    public function includeEvent(BuildApiAction $event)
    {
        $action = $event->action;
        if($action instanceof Discussions\ShowAction) {
            $event->addInclude('posts.event');
        }
        if($action instanceof Posts\IndexAction ||
           $action instanceof Posts\ShowAction ||
           $action instanceof Posts\CreateAction ||
           $action instanceof Posts\UpdateAction) {
             $event->addInclude('event');
        }
    }
}
