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

  // 0.1.0-beta2
  extend(TextEditor.prototype, 'init', function() {
    if(this.props.post) {
      this.event = this.event || this.props.post.event();
    }
  });

  extend(TextEditor.prototype, 'controlItems', function(items) {
    // 0.1.0-beta, remove this after beta2 release
    if(this.props.post && !this.tmpInit && app.forum.attribute('version') === '0.1.0-beta') {
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

  // 0.1.0-beta2
  extend(EditPostComposer.prototype, 'init', function() {
    this.editor.props.post = this.props.post;
  });

  // 0.1.0-beta, remove this after beta2 release
  extend(EditPostComposer.prototype, 'view', function(view) {
    this.editor.props.post = this.props.post;
    return view;
  });
}
