/**
 * External dependencies
 */
import { __ } from '@wordpress/i18n';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import {
	PanelRow,
	ToggleControl,
	RadioControl,
	TextControl,
} from '@wordpress/components';
import { compose } from '@wordpress/compose';
import { withSelect, withDispatch } from '@wordpress/data';

/**
 * Advertising Settings Panel component.
 *
 * Displays a custom panel on the sidebar of the block editor. Adapted from this guide:
 * https://awhitepixel.com/blog/how-to-add-post-meta-fields-to-gutenberg-document-sidebar/
 */
const AdvertisingSettingsPanel = ( {
	/**
	 * The post type.
	 */
	postType,
	/**
	 * Object containing meta field values.
	 */
	postMeta,
	/**
	 * Updates the post's meta in the store.
	 */
	setPostMeta,
	/**
	 * Boolean to indicate whether the post is being saved or published.
	 */
	isSubmitting,
} ) => {
	// Render this component for post type 'post' only
	if ( 'post' !== postType ) return null;

	return (
		<PluginDocumentSettingPanel
			name="advertising-settings-panel"
			title={ __( 'Advertising Settings' ) }
			initialOpen={ true }
		>
			<PanelRow>
				<ToggleControl
					className="advertising-setting"
					label={ __( 'Advertisements' ) }
					checked={ postMeta._co_advertisements }
					disabled={ isSubmitting }
					onChange={ ( value ) =>
						setPostMeta( { _co_advertisements: value } )
					}
				/>
			</PanelRow>
			<PanelRow>
				<RadioControl
					className="advertising-setting"
					label={ __( 'Commercial content type' ) }
					options={ [
						{ label: __( 'None' ), value: 'none' },
						{
							label: __( 'Sponsored content' ),
							value: 'sponsored',
						},
						{
							label: __( 'Partnered content' ),
							value: 'partnered',
						},
						{
							label: __( 'Brought to you by' ),
							value: 'brought-to-you-by',
						},
					] }
					selected={ postMeta._co_commercial_content_type }
					disabled={ isSubmitting }
					onChange={ ( value ) => {
						setPostMeta( { _co_commercial_content_type: value } );
					} }
				/>
			</PanelRow>
			{ postMeta._co_commercial_content_type !== 'none' && (
				<PanelRow>
					<TextControl
						className="advertising-setting"
						label={ __( 'Advertiser name' ) }
						value={ postMeta._co_advertiser_name }
						disabled={ isSubmitting }
						onChange={ ( value ) =>
							setPostMeta( { _co_advertiser_name: value } )
						}
					/>
				</PanelRow>
			) }
		</PluginDocumentSettingPanel>
	);
};

export default compose( [
	withSelect( ( select ) => {
		return {
			postMeta: select( 'core/editor' ).getEditedPostAttribute( 'meta' ),
			postType: select( 'core/editor' ).getCurrentPostType(),
			isSubmitting:
				select( 'core/editor' ).isSavingPost() ||
				select( 'core/editor' ).isPublishingPost(),
		};
	} ),
	withDispatch( ( dispatch ) => {
		return {
			setPostMeta( newMeta ) {
				dispatch( 'core/editor' ).editPost( { meta: newMeta } );
			},
		};
	} ),
] )( AdvertisingSettingsPanel );
