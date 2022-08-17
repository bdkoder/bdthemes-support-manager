<?php

namespace Bdt\Support;

/**
 * The Installer class
 */
class Installer
{
    /**
     * Runt the installer
     * 
     * @return void
     */

    public function run()
    {
        $this->add_version();
        $this->create_tables();
    }

    public function add_version()
    {
        $installed = get_option('bdt_support_installed');

        if (!$installed) {
            update_option('bdt_support_installed', time());
        }

        update_option('bdt_support_version', BDT_SUPPORT_VERSION);
    }

    /**
     * Create nessary database tables
     * 
     * @return void
     */
    public function create_tables()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $schema = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}support_manager_logs` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NULL DEFAULT NULL,
            `description` VARCHAR(255) NULL DEFAULT NULL,
            `date` DATETIME NULL DEFAULT NULL,
            `created_by` BIGINT(20) UNSIGNED NOT NULL,
            `created_at` DATETIME NOT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate";


        // $schema2 = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}nas_categories` (
        //     `id` INT NOT NULL AUTO_INCREMENT,
        //     `name` VARCHAR(255) NOT NULL,
        //     `event` INT NOT NULL,
        //     `created_by` BIGINT(20) UNSIGNED NOT NULL,
        //     `created_at` DATETIME NOT NULL,
        //     PRIMARY KEY (`id`)
        // ) $charset_collate";



        if (!function_exists('dbDelta')) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        dbDelta($schema);
        // dbDelta($schema2);
        // dbDelta($schema3);
        // dbDelta($schema4);
    }
}
