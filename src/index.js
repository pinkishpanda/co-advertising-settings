/**
 * External dependencies
 */
import { registerPlugin } from '@wordpress/plugins';

/**
 * Internal dependencies
 */
import AdvertisingSettingsPanel from './advertising';
import './index.scss';

/**
 * Registers the sidebar plugin.
 */
registerPlugin( 'advertising-settings-panel', {
	icon: 'megaphone',
	render: () => {
		return <AdvertisingSettingsPanel />;
	},
} );
