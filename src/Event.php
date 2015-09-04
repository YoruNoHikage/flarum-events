<?php namespace WIC\Events;

use Flarum\Core\Model;
use Flarum\Core\Posts\Post;
use Flarum\Core\Support\ValidatesBeforeSave;

class Event extends Model
{
    // use ValidatesBeforeSave;

    protected $table = 'events';

    protected $dates = ['when'];

    protected $rules = [
        'when' => 'required|datetime'
    ];

    /**
     * Boot the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        // static::deleted(function ($tag) {
        //     $tag->discussions()->detach();
        //
        //     Permission::where('permission', 'like', "tag{$tag->id}.%")->delete();
        // });
    }

    /**
     * Create a new event.
     *
     * @param dateTime $when
     * @return static
     */
    public static function build($when)
    {
        $event = new static;

        $event->when = $when;

        return $event;
    }

    public function post()
    {
        return $this->belongsTo('Flarum\Core\Posts\Post');
    }

}
