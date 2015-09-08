<?php namespace WIC\Events\Listeners;

use Flarum\Events\ModelAllow;
use Flarum\Core\Posts\Post;

class ConfigureEventPermissions
{
    public function subscribe($events)
    {
        $events->listen(ModelAllow::class, [$this, 'allowEventPermissions']);
    }

    public function allowEventPermissions(ModelAllow $event)
    {
        if($event->model instanceof Post && $event->action === 'event') {
            // if user is the post author, (s)he can do it !
            return $event->actor->id === $event->model->user_id;
        }
    }
}
