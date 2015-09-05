import Model from 'flarum/Model';
import mixin from 'flarum/utils/mixin';

export default class Event extends mixin(Model, {
  when: Model.attribute('when', Model.transformDate),
  post: Model.hasOne('post'),
}) {}
