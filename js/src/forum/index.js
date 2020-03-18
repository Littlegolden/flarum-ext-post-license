import {extend} from 'flarum/extend';
import app from 'flarum/app';
import DiscussionComposer from 'flarum/components/DiscussionComposer';
import LicensePicker from './components/LicensePicker';
import ReplyComposer from 'flarum/components/ReplyComposer';
import CommentPost from 'flarum/components/CommentPost';
import EditPostComposer from 'flarum/components/EditPostComposer';
import LicenseMeta from './components/LicenseMeta';

function addLicenseField(ComposerComponent) {
    ComposerComponent.prototype.littleGoldenPostLicense = null;

    extend(ComposerComponent.prototype, 'headerItems', function (items) {
        items.add('littlegolden-post-license', LicensePicker.component({
            license: this.littleGoldenPostLicense,
            onchange: license => {
                this.littleGoldenPostLicense = license;
            },
        }));
    });

    extend(ComposerComponent.prototype, 'data', function (data) {
        data.littleGoldenPostLicense = this.littleGoldenPostLicense;
    });
}

app.initializers.add('littlegolden/post-license', () => {
    addLicenseField(ReplyComposer);
    addLicenseField(EditPostComposer);
    addLicenseField(DiscussionComposer);

    extend(EditPostComposer.prototype, 'init', function () {
        this.littleGoldenPostLicense = this.props.post.attribute('littleGoldenPostLicense');
    });

    extend(CommentPost.prototype, 'headerItems', function (items) {
        const license = this.props.post.attribute('littleGoldenPostLicense');

        if (license) {
            items.add('littlegolden-post-license', LicenseMeta.component({
                license,
            }));
        }
    });
});
