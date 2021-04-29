import {registerBlockType} from '@wordpress/blocks';
import ServerSideRender from '@wordpress/server-side-render';
import {ColorPaletteControl, LineHeightControl, useBlockProps} from "@wordpress/block-editor";
import {FontSizePicker, PanelBody, SelectControl, TextControl} from "@wordpress/components";
import {InspectorControls} from "@wordpress/editor";
import {__} from "@wordpress/i18n";

registerBlockType('shortcodes-to-blocks/press-notice', {
    apiVersion: 2,
    name: 'shortcodes-to-blocks/press-notice',
    title: __("Press Notice", "shortcodes-to-blocks"),
    description: __("Display simple notice.", "shortcodes-to-blocks"),
    icon: 'warning',
    attributes: {
        'text': {
            'type': 'string',
            'default': 'This is just a notice.'
        },
        'icon': {
            'type': 'string',
            'enum': [
                'warning',
                'info',
                'yes-alt',
                'star-filled',
                'flag'
            ],
            'default': 'warning'
        },
        'class': {
            'type': 'string',
            'default': ''
        },
        'varFontSize': {
            'type': 'integer',
            'default': 16,
            'minimum': 1
        },
        'varLineHeight': {
            'type': 'string',
            'default': ''
        },
        'varColorBackground': {
            'type': 'string',
            'format': 'hex-color',
            'default': ''
        },
        'varColorBorder': {
            'type': 'string',
            'format': 'hex-color',
            'default': ''
        },
        'varColorText': {
            'type': 'string',
            'format': 'hex-color',
            'default': ''
        }
    },
    supports: {
        customClassName: false,
    },
    edit: ({attributes, setAttributes}) => {
        const fontSizes = [
            {
                name: __("Tiny", "shortcodes-to-blocks"),
                slug: 'small',
                size: 10,
            },
            {
                name: __("Small", "shortcodes-to-blocks"),
                slug: 'small',
                size: 14,
            },
            {
                name: __("Normal", "shortcodes-to-blocks"),
                slug: 'normal',
                size: 16,
            },
            {
                name: __("Big", "shortcodes-to-blocks"),
                slug: 'big',
                size: 20,
            }
        ];

        return (
            <div {...useBlockProps()}>
                <ServerSideRender
                    block="shortcodes-to-blocks/press-notice"
                    attributes={attributes}
                />
                <InspectorControls key="settings">
                    <PanelBody title={__("Notice", "shortcodes-to-blocks")}>
                        <TextControl
                            label={__("Notice Text", "shortcodes-to-blocks")}
                            value={attributes.text}
                            onChange={(value) => setAttributes({text: value})}
                        />
                        <SelectControl
                            label={__("Notice Icon", "shortcodes-to-blocks")}
                            value={attributes.icon}
                            options={[
                                {label: __("Warning"), value: 'warning'},
                                {label: __("Info"), value: 'info'},
                                {label: __("Yes"), value: 'yes-alt'},
                                {label: __("Star"), value: 'star-filled'},
                                {label: __("Flag"), value: 'flag'}
                            ]}
                            onChange={(value) => setAttributes({icon: value})}
                        />
                    </PanelBody>
                    <PanelBody title={__("Typography", "shortcodes-to-blocks")}>
                        <FontSizePicker
                            label={__("Font Size", "shortcodes-to-blocks")}
                            value={attributes.varFontSize}
                            onChange={(value) => setAttributes({varFontSize: value})}
                            fallBackFontSize={16}
                            fontSizes={fontSizes}
                        />
                        <LineHeightControl
                            label={__("Line Height", "shortcodes-to-blocks")}
                            value={attributes.varLineHeight}
                            onChange={(value) => setAttributes({varLineHeight: value})}
                        />
                    </PanelBody>
                    <PanelBody title={__("Colors", "shortcodes-to-blocks")}>
                        <ColorPaletteControl
                            label={__("Background", "shortcodes-to-blocks")}
                            value={attributes.varColorBackground}
                            onChange={(value) => setAttributes({varColorBackground: value})}
                        />
                        <ColorPaletteControl
                            label={__("Text", "shortcodes-to-blocks")}
                            value={attributes.varColorText}
                            onChange={(value) => setAttributes({varColorText: value})}
                        />
                        <ColorPaletteControl
                            label={__("Border", "shortcodes-to-blocks")}
                            value={attributes.varColorBorder}
                            onChange={(value) => setAttributes({varColorBorder: value})}
                        />
                    </PanelBody>
                    <PanelBody title={__("Advanced", "shortcodes-to-blocks")}>
                        <TextControl
                            label={__("Additional CSS Class", "shortcodes-to-blocks")}
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
