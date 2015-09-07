import { extend, override } from 'flarum/extend';
import app from 'flarum/app';

import fullTime from 'flarum/helpers/fullTime';
import ItemList from 'flarum/utils/ItemList';

import DiscussionComposer from 'flarum/components/DiscussionComposer';
import ReplyComposer from 'flarum/components/ReplyComposer';
import EditPostComposer from 'flarum/components/EditPostComposer';
import TextEditor from 'flarum/components/TextEditor';
import Button from 'flarum/components/Button';

import ConfigureEventModal from 'events/components/ConfigureEventModal';

export default function() {
  TextEditor.prototype.configureEvent = function() {
    app.modal.show(
      new ConfigureEventModal({
        event: this.event,
        onsubmit: (event) => {
          this.event = event;
        },
      })
    );
  };

  extend(TextEditor.prototype, 'controlItems', function(items) {
    // tmp, should be in constructor or initProps
    if(this.props.post && !this.tmpInit) {
      this.tmpInit = true;
      this.event = this.event || this.props.post.event();
    } else {
      this.event = this.event || false;
    }
    items.add('event', (
      Button.component({
        children: this.event ? fullTime(this.event.when()) : app.trans('events.no_event'),
        icon: 'calendar',
        className: 'Button',
        onclick: this.configureEvent.bind(this),
      })
    ));

    return items;
  });

  const dataExtended = function(data) {
    const event = this.editor.event;
    if(event) {
      data.event = event.data.attributes;
    }
    return data;
  };

  extend(ReplyComposer.prototype, 'data', dataExtended);
  extend(DiscussionComposer.prototype, 'data', dataExtended);
  extend(EditPostComposer.prototype, 'data', dataExtended);

  extend(EditPostComposer.prototype, 'view', function(view) { // tmp, should be in constructor or initProps
    this.editor.props.post = this.props.post;
    return view;
  });
}
