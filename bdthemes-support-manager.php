<?php

/**
 * Plugin Name: Bdthemes Support Manager
 * Description: A simple description of our plguin
 * Plugin URI: http://bdthemes.com
 * Author: bdThemes
 * Author URI: http://bdthemes.com
 * Version: 1.0
 * License: GPL2
 * Text Domain: bdt-support-manager
 */
/**
 * Copyright (c) 2014 bdThemes (email: bdkoder@gmail.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */
// don't call the file directly
if (!defined('ABSPATH'))
    exit;

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugins class
 */
final class Bdt_Support
{

    /**
     * Plugin version
     * @var string
     */
    const version = '1.0.1';

    /**
     * class constructor
     */
    private function __construct()
    {
        $this->define_constants();

        register_activation_hook(__FILE__, [$this, 'activate']);

        add_action('plugins_loaded', [$this, 'init_plugin']);
    }

    /**
     * Initializes a singleton instance
     * @staticvar boolean $instance
     * @return \Bdt_Support
     */
    public static function init()
    {
        static $instance = false;

        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     * 
     * @return void
     */
    public function define_constants()
    {
        define('BDT_SUPPORT_VERSION', self::version);
        define('BDT_SUPPORT_FILE', __FILE__);
        define('BDT_SUPPORT_PATH', __DIR__);
        define('BDT_SUPPORT_URL', plugins_url('', BDT_SUPPORT_FILE));
        define('BDT_SUPPORT_ASSETS', BDT_SUPPORT_URL . '/assets');
    }

    /**
     * Initialize the plugin
     * 
     * @return void
     */
    public function init_plugin()
    {


        if (is_admin()) {
            new Bdt\Support\Admin();
        } else {
            // new for frontEnd
            new Bdt\Support\Frontend();
        }
    }


    /**
     * Do stuff upon plugin
     * 
     * @return void
     */
    public function activate()
    {
        $installer = new Bdt\Support\Installer();
        $installer->run();
    }
}

/**
 * 
 * @return \Bdt_Support
 */
function bdt_support()
{
    return Bdt_Support::init();
}

// kick-off the plugin
bdt_support();

