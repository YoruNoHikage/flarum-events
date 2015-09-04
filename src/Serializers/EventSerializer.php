<?php
namespace WIC\Events\Serializers;

use Flarum\Api\Serializers\Serializer;

class EventSerializer extends Serializer
{
    protected $type = 'event';

    protected function getDefaultAttributes($event)
    {
        return [
            'when'  => $event->when,
        ];
    }

    /**
     * @return callable
     */
    // protected function attenders()
    // {
    //     return $this->hasMany('Flarum\Api\Serializers\UserBasicSerializer');
    // }
}
