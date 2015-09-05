import { extend } from 'flarum/extend';
import app from 'flarum/app';
import CommentPost from 'flarum/components/CommentPost';
import icon from 'flarum/helpers/icon';
import humanTime from 'flarum/helpers/humanTime';

export default function() {
  extend(CommentPost.prototype, 'footerItems', function(items) {
    const { post } = this.props;
    const event = post.event();

    if(event && event.when) {
      items.add('event', (
        <div className="Post-event">
          {icon('calendar')}
          <span>Awesome Event, </span>
          {humanTime(new Date("2015-10-01"))}
        </div>
      ));
    }
  });
}
