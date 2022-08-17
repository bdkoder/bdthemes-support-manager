<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('', 'bdt-support-manager') ?></h1>

    <div class="bdts-wrapper">
        <div class="bdts-section bdt-flex bdt-padding-large">
            <div class="bdts-menu">
                <div>
                    <img src="">
                </div>
                <ul class="bdt-tab-left bdt-tab bdt-main-tab" data-bdt-tab="{connect:'#bdt-main-tab'}">
                    <li data-index="0" class="bdt-active">
                        <a href="#">
                            <span class="dashicons dashicons-admin-users"></span>
                        </a>
                    </li>
                    <li data-index="1">
                        <a href="#">Item</a>
                    </li>
                    <li data-index="2">
                        <a href="#">Settings</a>
                    </li>
                </ul>
            </div>
            <div class="bdts-content">
                <ul id="bdt-main-tab" class="bdt-switcher bdt-margin">
                    <li class="bdt-content-item bdt-active">
                        <div class="bdts-form-wrapper">
                            <form method="post" id="check-license-form">
                                <div class="bdt-margin">
                                    <input class="bdt-input bdt-form-width-medium bdt-form-large" type="text" name="identity" placeholder="Email/License">
                                </div>
                                <div>
                                    <input type="hidden" name="action" value="info_detect">
                                    <?php wp_nonce_field('check-info'); ?>
                                    <?php submit_button(__('Check License', 'bdt-support-manager'), ['bdt-button bdt-button-primary'], 'submit_event'); ?>
                                </div>
                            </form>
                        </div>
                    </li>
                    <li class="bdt-content-item">Content 2</li>
                    <li class="bdt-content-item">
                        Settings
                        <form class="bdt-form-horizontal bdt-margin-large" id="bdts-settings-form" method="POST">

                            <div class="bdt-margin">
                                <label class="bdt-form-label" for="api_key">API KEY</label>
                                <div class="bdt-form-controls">
                                    <?php
                                    $get_option = get_option('bdts_settings');
                                    $get_option = $get_option;
                                    ?>
                                    <input class="bdt-input bdt-w-100" id="api_key" type="text" placeholder="API KEY" name="api_key" 
                                    value="<?php
                                    if(isset($get_option['api_key'])){
                                        echo $get_option['api_key'];
                                    }
                                    ?>">
                                </div>
                            </div>
                            <div class="bdt-margin">
                                <label class="bdt-form-label" for="api_end_point">API EndPoint</label>
                                <div class="bdt-form-controls">
                                    <input class="bdt-input bdt-w-100" id="api_end_point" type="text" placeholder="API KEY" name="api_end_point" 
                                    value="<?php
                                    if(isset($get_option['api_end_point'])){
                                        echo $get_option['api_end_point'];
                                    }
                                    ?>">
                                </div>
                            </div>
                            <input type="hidden" name="action" value="bdts_save_settings">
                            <?php wp_nonce_field('save-settings'); ?>
                            <div class="bdt-margin">
                                <div class="bdt-form-controls">
                                    <?php submit_button(__('SAVE SETTINGS', 'bdt-support-manager'), ['bdt-w-100 bdt-button bdt-button-primary'], 'submit_event'); ?>
                                </div>
                            </div>

                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- This is a button toggling the modal -->
    <button class="bdt-button bdt-button-default bdt-margin-small-right" type="button" bdt-toggle="target: #bdts-modal">Open</button>

    <!-- This is an anchor toggling the modal -->
    <a href="#bdts-modal" bdt-toggle>Open</a>

    <!-- This is the modal -->
    <div id="bdts-modal" bdt-modal>
        <div class="bdt-modal-dialog">
            <button class="bdt-modal-close-default" type="button" bdt-close></button>
            <div class="bdt-modal-header">
                <h2 class="bdt-modal-title">Details</h2>
            </div>
            <div class="bdt-modal-body" id="bdts-modal-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
            <div class="bdt-modal-footer bdt-text-right">
                <button class="bdt-button bdt-button-default bdt-modal-close" type="button">Close</button>
                <button class="bdt-button bdt-button-primary" type="button">Save</button>
            </div>
        </div>
    </div>

</div>