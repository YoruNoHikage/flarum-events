import { extend } from 'flarum/extend';
import app from 'flarum/app';

import Event from 'events/models/Event';
import Post from 'flarum/models/Post';
import Model from 'flarum/Model';

import addEventItem from 'events/addEventItem';
import addEventControl from 'events/addEventControl';

app.initializers.add('events', (app) => {
  app.store.models.events = Event;

  Post.prototype.event = Model.hasOne('event');

  addEventItem();
  addEventControl();
});
