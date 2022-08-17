<?php

namespace Bdt\Support\Admin;

/**
 * Description of SupportManager
 *
 * @author Shahidul Islam
 */
class SupportManager
{
    //put your code here

    public function plugin_page()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';

        switch ($action) {
            case 'settings':
                $template = __DIR__ . '/views/settings.php';
                break;

            default:
                $template = __DIR__ . '/views/dashboard.php';
                break;
        }

        if (file_exists($template)) {
            include $template;
        }
    }

    public function generate_license()
    {
        $template = __DIR__ . '/views/generate-license.php';

        if (file_exists($template)) {
            include $template;
        }
    }
    public function license_view()
    {
        $template = __DIR__ . '/views/license-view.php';

        if (file_exists($template)) {
            include $template;
        }
    }

    public function settings_page()
    {
        $template = __DIR__ . '/views/settings.php';

        if (file_exists($template)) {
            include $template;
        }
    }
}
