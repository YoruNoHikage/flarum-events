<?php namespace WIC\Events\Listeners;

use Flarum\Events\RegisterLocales;
use Flarum\Events\BuildClientView;
use Illuminate\Contracts\Events\Dispatcher;

class AddClientAssets
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(RegisterLocales::class, [$this, 'addLocale']);
        $events->listen(BuildClientView::class, [$this, 'addAssets']);
    }

    public function addLocale(RegisterLocales $event)
    {
        $event->addTranslations('en', __DIR__.'/../../locale/en.yml');
    }

    public function addAssets(BuildClientView $event)
    {
        $event->forumAssets([
            __DIR__.'/../../js/forum/dist/extension.js',
            __DIR__.'/../../less/forum/extension.less'
        ]);

        $event->forumBootstrapper('events/main');

        $event->forumTranslations([
            'events.no_event',
            'events.configure_event_modal_title',
            'events.configure_date',
            'events.save_event',
            'events.post_event_modal_title',
        ]);

        // $event->adminAssets([
        //     __DIR__.'/../../js/admin/dist/extension.js',
        //     __DIR__.'/../../less/admin/extension.less'
        // ]);
        //
        // $event->adminBootstrapper('events/main');
        //
        // $event->adminTranslations([
        //     // 'events.hello_world'
        // ]);
    }
}
