<div class="wrap">

    <div class="bdt-sm-container">
        <div class="bdt-sm-section">
            <h4 class="bdt-sm-form-heading">
                <?php _e('Generate License', 'bdt-support-manager') ?>
            </h4>
            <form action="" method="post" id="generate-license-form">
                <table class="form-table">
                    <tr class="row">
                        <th scope="row">
                            <label for="client-name"><?php _e('Client Name', 'bdt-support-manager') ?></label>
                        </th>
                        <td>
                            <input type="text" name="clientName" id="client-name" class="regular-text" placeholder="Md. Tauhid Alam">
                        </td>
                    </tr>
                    <tr class="row">
                        <th scope="row">
                            <label for="client-email"><?php _e('Client Email', 'bdt-support-manager') ?></label>
                        </th>
                        <td>
                            <input type="email" name="clientEmail" id="client-email" class="regular-text" placeholder="tauhid@bdthemes.com">
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="action" value="generate_license">
                <?php wp_nonce_field('generate-license'); ?>
                <?php submit_button(__('Generate License', 'bdt-support-manager'), 'primary', 'submit_event'); ?>

            </form>
        </div>
        <div class="bdt-sm-section bdt-sm-result" id="bdt-sm-result" style="display:none">

        </div>
    </div>
</div>