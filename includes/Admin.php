<?php

namespace Bdt\Support;

/**
 * The admin class
 */
class Admin
{
    public function __construct()
    {
        $support_manager = new Admin\SupportManager();
        $this->dispatch_actions($support_manager);

        new Admin\Menu($support_manager);
    }
    public function dispatch_actions($support_manager)
    {

        add_role(
            'bdt_support_team',
            __('Bdt Support Team'),
            array(
                'read'         => true,  // true allows this capability
                'edit_posts'   => false,
            )
        );

        add_action('admin_enqueue_scripts', [$this, 'load_admin_scripts']);

        add_action('wp_ajax_generate_license', 'generate_license');
        add_action('wp_ajax_info_detect', 'info_detect');
        add_action('wp_ajax_client_view', 'client_view');
        add_action('wp_ajax_bdts_remove_domain', 'remove_domain');
        add_action('wp_ajax_bdts_save_settings', 'save_settings');
    }
    public function load_admin_scripts()
    {
        $suffix                    = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
        wp_enqueue_script('bdt-support-manager-js', BDT_SUPPORT_ASSETS . '/js/admin/support-manager.js', ['jquery'], false, true);
        wp_enqueue_style('bdt-support-manager-css', BDT_SUPPORT_ASSETS . '/css/admin/support-manager.css', [], false, 'all');

        wp_enqueue_style('bdt-uikit', 'https://bdthemes.com/wp-content/plugins/bdthemes-element-pack/assets/css/bdt-uikit.css', [], '3.13.1');
        wp_enqueue_script('bdt-uikit', 'https://bdthemes.com/wp-content/plugins/bdthemes-element-pack/assets/js/bdt-uikit.min.js', ['jquery'], '3.13.1', true);
         
        wp_enqueue_style('sweetalert2-css', '//cdn.jsdelivr.net/npm/sweetalert2@11.4.20/dist/sweetalert2.min.css', [], '');
        wp_enqueue_script('sweetalert2-js', '//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js', ['jquery'], '', true);

    }
}
