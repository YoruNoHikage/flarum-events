<?php namespace WIC\Events;

use Flarum\Support\Extension as BaseExtension;
use Illuminate\Events\Dispatcher;

class Extension extends BaseExtension
{
    public function listen(Dispatcher $events)
    {
        $events->subscribe('WIC\Events\Listeners\AddClientAssets');
        $events->subscribe('WIC\Events\Listeners\AddModelRelationship');
        $events->subscribe('WIC\Events\Listeners\AddApiAttributes');
        $events->subscribe('WIC\Events\Listeners\PersistData');
    }
}
