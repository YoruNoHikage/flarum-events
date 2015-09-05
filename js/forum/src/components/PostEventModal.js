import Modal from 'flarum/components/Modal';
import avatar from 'flarum/helpers/avatar';
import username from 'flarum/helpers/username';

export default class PostEventModal extends Modal {
  className() {
    return 'PostEventModal Modal--small';
  }

  title() {
    // return app.trans('events.post_event_modal_title');
    return "Attenders";
  }

  content() {
    return (
      <div className="Modal-body">
        <ul className="PostEventModal-list">
          {// {this.props.post.event().map(user => (
          //   <li>
          //     <a href={app.route.user(user)} config={m.route}>
          //       {avatar(user)}{' '}
          //       {username(user)}
          //     </a>
          //   </li>
          // ))}
        }
        </ul>
      </div>
    );
  }
}
