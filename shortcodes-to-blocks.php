<?php

/*
Plugin Name:       Shortcodes To Block
Plugin URI:        https://github.com/dev4press/shortcodes-to-blocks
Description:       Example plugin for adding Block Editor blocks to replace shortcodes, and add settings for shortcodes attributes.
Author:            Milan Petrovic
Author URI:        https://www.dev4press.com/
Text Domain:       shortcodes-to-blocks
Version:           1.0
Requires at least: 5.7
Tested up to:      5.8
Requires PHP:      7.0
License:           GPLv3 or later
License URI:       https://www.gnu.org/licenses/gpl-3.0.html

== Copyright ==
Copyright 2008 - 2021 Milan Petrovic (email: support@dev4press.com)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>
*/

use Dev4Press\Plugin\ShortcodesToBlocks\Basic\Plugin;

const SHORTCODES_TO_BLOCKS_VERSION = '1.0';

$shortcodes_to_blocks_dirname_basic = dirname( __FILE__ ) . '/';
$shortcodes_to_blocks_urlname_basic = plugins_url( '/', __FILE__ );

define( 'SHORTCODES_TO_BLOCKS_PATH', $shortcodes_to_blocks_dirname_basic );
define( 'SHORTCODES_TO_BLOCKS_URL', $shortcodes_to_blocks_urlname_basic );

require_once( SHORTCODES_TO_BLOCKS_PATH . 'core/autoload.php' );

Plugin::instance();
