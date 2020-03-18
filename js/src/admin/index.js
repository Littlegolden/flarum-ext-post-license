import app from 'flarum/app';
import LicenseSettingsModal from './components/LicenseSettingsModal';

app.initializers.add('littlegolden/post-license', () => {
    app.extensionSettings['littlegolden-post-license'] = () => app.modal.show(new LicenseSettingsModal());
});
