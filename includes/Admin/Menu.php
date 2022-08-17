<?php

/**
 * Description of Menu
 *
 * @author Shahidul Islam
 */

namespace Bdt\Support\Admin;

class Menu
{
    public $support_manager;
    public function __construct($support_manager)
    {
        $this->support_manager = $support_manager;
        add_action('admin_menu', [$this, 'admin_menu']);
    }
    public function admin_menu()
    {
        $parent_slug = 'bdt-sm';
        $capability = 'manage_options';


        if (current_user_can('bdt_support_team')) {
            add_menu_page(__('Support Manager', 'bdt-support-manager'), __('Support Manager', 'bdt-support-manager'), 'bdt_support_team', $parent_slug, [$this->support_manager, 'plugin_page'], 'dashicons-groups', 0);
            add_submenu_page($parent_slug, __('Dashboard', 'bdt-support-manager'), __('Dashboard', 'bdt-support-manager'), 'bdt_support_team', $parent_slug, [$this->support_manager, 'plugin_page']);
        } else {
            add_menu_page(__('Support Manager', 'bdt-support-manager'), __('Support Manager', 'bdt-support-manager'), $capability, $parent_slug, [$this->support_manager, 'plugin_page'], 'dashicons-groups', 0);
            add_submenu_page($parent_slug, __('Dashboard', 'bdt-support-manager'), __('Dashboard', 'bdt-support-manager'), $capability, $parent_slug, [$this->support_manager, 'plugin_page']);
        }
    }

}
