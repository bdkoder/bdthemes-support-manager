<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Check License', 'bdt-support-manager') ?></h1>

    <div class="bdt-card bdt-card-default">
        <div class="bdt-card-body">
            <form method="post" id="check-license-form">
                <div class="bdt-sm-form">
                    <div class="uk-margin">
                        <div class="uk-inline">
                            <span class="uk-form-icon" uk-icon="icon: user"></span>
                            <input class="bdt-input bdt-form-width-medium" type="text" name="license" id="license" placeholder="Email/License">
                        </div>
                    </div>
                    <div>
                        <input type="hidden" name="action" value="license_view">
                        <?php wp_nonce_field('check-license'); ?>
                        <?php submit_button(__('Check License', 'bdt-support-manager'), ['bdt-button bdt-button-primary'], 'submit_event'); ?>
                    </div>
                    <small>example-A1303F9A-E077577C-E49BF7E4-979C6373</small>
                    <div id="result-error">
                    </div>
                </div>
            </form>
        </div>

        <div class="bdt-card-body">
            <table class="bdt-sm-table">
                <h4>License Code - <span id="purchase_key"></span></h4>
                <tr class="row">
                    <td>
                        <label><?php _e('Company', 'bdt-support-manager') ?></label>
                    </td>
                    <td>
                        <div id="company" class="regular-text">-</div>
                    </td>
                    <td>
                        <label><?php _e('Country', 'bdt-support-manager') ?></label>
                    </td>
                    <td>
                        <div id="country" class="regular-text">-</div>
                    </td>
                </tr>
                <tr class="row">
                    <td>
                        <label><?php _e('Email', 'bdt-support-manager') ?></label>
                    </td>
                    <td>
                        <div id="email" class="regular-text">-</div>
                    </td>
                    <td>
                        <label><?php _e('Name', 'bdt-support-manager') ?></label>
                    </td>
                    <td>
                        <div id="name" class="regular-text">-</div>
                    </td>
                </tr>
                <tr class="row">
                    <td colspan="4">

                    </td>
                </tr>
                <tr class="row">
                    <td>
                        <label><?php _e('Product Name', 'bdt-support-manager') ?></label>
                    </td>
                    <td>
                        <div id="product_name" class="regular-text">-</div>
                    </td>
                    <td>
                        <label><?php _e('License Title', 'bdt-support-manager') ?></label>
                    </td>
                    <td>
                        <div id="license_title" class="regular-text">-</div>
                    </td>
                </tr>
                <tr class="row">
                    <td>
                        <label><?php _e('Market', 'bdt-support-manager') ?></label>
                    </td>
                    <td>
                        <div id="market" class="regular-text">-</div>
                        <small>
                            E: "Envato"
                            F: "FastSpring"
                            J: "JVZoo"
                            O: "Others"
                            P: "Paddle"
                            W: "WooCommerce"
                        </small>
                    </td>
                    <td>
                        <label><?php _e('Support', 'bdt-support-manager') ?></label>
                    </td>
                    <td>
                        <div id="has_support" class="regular-text">-</div>
                    </td>
                </tr>
                <tr class="row">
                    <td>
                        <label><?php _e('Entry Time', 'bdt-support-manager') ?></label>
                    </td>
                    <td>
                        <div id="entry_time" class="regular-text">-</div>
                    </td>
                    <td>
                        <label><?php _e('License Expire Date', 'bdt-support-manager') ?></label>
                    </td>
                    <td>
                        <div id="expiry_time" class="regular-text">-</div>
                    </td>
                </tr>
                <tr class="row">
                    <td>
                        <label><?php _e('Support End Time', 'bdt-support-manager') ?></label>
                    </td>
                    <td>
                        <div id="support_end_time" class="regular-text">-</div>
                    </td>
                    <td>
                        <label><?php _e('Max Domains', 'bdt-support-manager') ?></label>
                    </td>
                    <td>
                        <div id="max_domain" class="regular-text">-</div>
                    </td>
                </tr>
                <tr class="row">

                    <td>
                        <label><?php _e('Status', 'bdt-support-manager') ?></label>
                    </td>
                    <td colspan="3">
                        <div id="status" class="regular-text">-</div>
                        <small>A: "Active"
                            I: "Inactive"
                            R: "Refunded"
                            W: "Free"</small>
                    </td>
                </tr>
                <tr class="row">
                    <td>
                        <label><?php _e('Active Domains', 'bdt-support-manager') ?></label>
                    </td>
                    <td colspan="3">
                        <div id="active_domains" class="regular-text bdt-sm-active-domains-wrap">
                            <ul class="bdt-domain-list">

                            </ul>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

    </div>

    

</div>