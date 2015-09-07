import Modal from 'flarum/components/Modal';
import Button from 'flarum/components/Button';

import Event from 'events/models/Event';

export default class ConfigureEventModal extends Modal {
  constructor(...args) {
    super(...args);

    this.event = this.props.event || new Event();

    this.when = m.prop(this.event.when() || '');
  }

  className() {
    return 'ConfigureEventModal Modal--small';
  }

  title() {
    return app.trans('events.configure_event_modal_title');
  }

  content() {
    return (
      <div className="Modal-body">
        <div className="Form Form--centered">
          <div className="Form-group">
            <input
              className="FormControl"
              type="datetime"
              placeholder={app.trans('events.configure_date') + ' : YYYY-MM-DDThh:mm:ss' }
              value={this.when()}
              oninput={m.withAttr('value', this.when)} />
          </div>

          <div className="Form-group">
            {Button.component({
              className: 'Button Button--primary Button--block',
              type: 'submit',
              children: app.trans('events.save_event'),
            })}
          </div>
        </div>
      </div>
    );
  }

  onsubmit(e) {
    e.preventDefault();

    const when = moment(this.when());
    if(!when.isValid()) {
      alert('Event malformed');
      return;
    }
    this.event.pushAttributes({when: when.toDate()});

    if(this.props.onsubmit) this.props.onsubmit(this.event);

    app.modal.close();
  }
}
