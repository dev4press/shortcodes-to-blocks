import {registerBlockType} from '@wordpress/blocks';
import ServerSideRender from '@wordpress/server-side-render';
import {useBlockProps} from '@wordpress/block-editor';
import {PanelBody, TextControl, ToggleControl} from '@wordpress/components';
import {InspectorControls} from '@wordpress/editor';
import {__} from '@wordpress/i18n';

registerBlockType('shortcodes-to-blocks/press-meta', {
    apiVersion: 2,
    name: 'shortcodes-to-blocks/press-meta',
    title: __('Press Meta', 'shortcodes-to-blocks'),
    description: __('Display simple meta links.', 'shortcodes-to-blocks'),
    icon: 'menu-alt',
    attributes: {
        'title': {
            'type': 'string',
            'default': 'Meta Links'
        },
        'class': {
            'type': 'string',
            'default': ''
        },
        'showSiteAdmin': {
            'type': 'boolean',
            'default': true
        },
        'showProfileEdit': {
            'type': 'boolean',
            'default': true
        },
        'showLogIn': {
            'type': 'boolean',
            'default': true
        },
        'showLogOut': {
            'type': 'boolean',
            'default': true
        },
        'showRegister': {
            'type': 'boolean',
            'default': true
        },
        'showHomePage': {
            'type': 'boolean',
            'default': true
        },
        'showRSSPosts': {
            'type': 'boolean',
            'default': true
        },
        'showRSSComments': {
            'type': 'boolean',
            'default': true
        }
    },
    supports: {
        customClassName: false,
    },
    edit: ({attributes, setAttributes}) => {
        return (
            <div {...useBlockProps()}>
                <ServerSideRender
                    block='shortcodes-to-blocks/press-meta'
                    attributes={attributes}
                />
                <InspectorControls key='settings'>
                    <PanelBody title={__('Display', 'shortcodes-to-blocks')}>
                        <TextControl
                            label={__('Title', 'shortcodes-to-blocks')}
                            value={attributes.title}
                            onChange={(value) => setAttributes({title: value})}
                        />
                    </PanelBody>
                    <PanelBody title={__('Links', 'shortcodes-to-blocks')}>
                        <ToggleControl
                            label={__('Show Site Admin', 'shortcodes-to-blocks')}
                            checked={attributes.showSiteAdmin}
                            onChange={(value) => setAttributes({showSiteAdmin: value})}
                        />
                        <ToggleControl
                            label={__('Show Profile Edit', 'shortcodes-to-blocks')}
                            checked={attributes.showProfileEdit}
                            onChange={(value) => setAttributes({showProfileEdit: value})}
                        />
                        <ToggleControl
                            label={__('Show Log In', 'shortcodes-to-blocks')}
                            checked={attributes.showLogIn}
                            onChange={(value) => setAttributes({showLogIn: value})}
                        />
                        <ToggleControl
                            label={__('Show Log Out', 'shortcodes-to-blocks')}
                            checked={attributes.showLogOut}
                            onChange={(value) => setAttributes({showLogOut: value})}
                        />
                        <ToggleControl
                            label={__('Show Register', 'shortcodes-to-blocks')}
                            checked={attributes.showRegister}
                            onChange={(value) => setAttributes({showRegister: value})}
                        />
                        <ToggleControl
                            label={__('Show Home Page', 'shortcodes-to-blocks')}
                            checked={attributes.showHomePage}
                            onChange={(value) => setAttributes({showHomePage: value})}
                        />
                        <ToggleControl
                            label={__('Show RSS Posts', 'shortcodes-to-blocks')}
                            checked={attributes.showRSSPosts}
                            onChange={(value) => setAttributes({showRSSPosts: value})}
                        />
                        <ToggleControl
                            label={__('Show RSS Comments', 'shortcodes-to-blocks')}
                            checked={attributes.showRSSComments}
                            onChange={(value) => setAttributes({showRSSComments: value})}
                        />
                    </PanelBody>
                    <PanelBody title={__('Advanced', 'shortcodes-to-blocks')}>
                        <TextControl
                            label={__('Additional CSS Class', 'shortcodes-to-blocks')}
                            value={attributes.class}
                            onChange={(value) => setAttributes({class: value})}
                        />
                    </PanelBody>
                </InspectorControls>
            </div>
        )
    },
    save: () => {
        return null
    }
});
