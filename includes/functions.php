<?php

$get_option = get_option('bdts_settings');
if (isset($get_option['api_key'])) {
    define("API_KEY", $get_option['api_key']);
} else {
    define("API_KEY", 'XXXX-XXXX-XXXXXXX-XXXXXXXX');
}
if (isset($get_option['api_end_point'])) {
    define("API_ENDPOINT", $get_option['api_end_point']);
} else {
    define("API_ENDPOINT", 'https://test.com/wp-json/api/');
}


class BDTS_APP {
    public $CURLOPT_URL = API_ENDPOINT;
    public $API_KEY     = API_KEY;

    public function __construct() {
    }

    public function throw_error() {
        $msg = 'error';
        echo wp_json_encode($msg);
        wp_die();
    }

    /**
     * Get the Name of Product
     * By ID & License
     *
     * @return void
     */
    public function product_details($license, $product_id) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => $this->CURLOPT_URL . 'product/view',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,

            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,

            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => array(
                'api_key'          => $this->API_KEY,
                'license_code'     => $license,
                'product_id'       => $product_id,
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);

        curl_close($curl);

        return $response['data'];
    }

    /**
     * Get the details of License
     *
     * @return void
     */
    public function license_details($license) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => $this->CURLOPT_URL . 'license/view',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,

            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,

            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => array(
                'api_key'          => $this->API_KEY,
                'license_code'     => $license,
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);

        curl_close($curl);

        if (($response['status'] !== true) || (!isset($response['data']) || (isset($response['data']) && empty($response['data'])))) {
            return 'error';
        }

        $response = $response['data'];

        /**
         * Get Information of Clients
         */
        $client_info = false;
        if (isset($response['client_id'])) {
            $client_info = $this->get_client_info($response['client_id']);
        }


        $status = '';
        if ($response['status'] == 'A') {
            $status = '<span class="bdt-text-success bdt-text-bold"> Active </span>';
        } elseif ($response['status'] == 'R') {
            $status = '<span class="bdt-text-danger bdt-text-bold"> Refunded </span>';
        } elseif ($response['status'] == 'I') {
            $status = '<span class="bdt-text-warning bdt-text-bold"> In-Active </span>';
        } elseif ($response['status'] == 'W') {
            $status = '<span class="bdt-text-success bdt-text-bold"> Free </span>';
        } else {
            $status = '<span class="bdt-text-danger bdt-text-bold" bdt-title="Please Contact License Manager."> Unknown Error </span>';
        }

        $market = '';
        if ($response['market'] == 'E') {
            $market = '<span class="bdt-text-success bdt-text-bold"> Envato </span>';
        } elseif ($response['market'] == 'J') {
            $market = '<span class="bdt-text-danger bdt-text-bold"> JVZoo </span>';
        } elseif ($response['market'] == 'F') {
            $market = '<span class="bdt-text-warning bdt-text-bold"> FastSpring </span>';
        } elseif ($response['market'] == 'P') {
            $market = '<span class="bdt-text-success bdt-text-bold"> Paddle </span>';
        } elseif ($response['market'] == 'W') {
            $market = '<span class="bdt-text-success bdt-text-bold"> WooCommerce </span>';
        } else {
            $market = '<span class="bdt-text-danger bdt-text-bold" bdt-title="Please Contact License Manager."> Unknown </span>';
        }

        $has_support = '';
        if ($response['has_support'] == 'U') {
            $has_support = '<span class="bdt-text-success bdt-text-bold"> Lifetime </span>';
        } elseif ($response['has_support'] == 'Y') {
            $has_support = '<span class="bdt-text-success bdt-text-bold"> Yes </span>';
        } else {
            $has_support = '<span class="bdt-text-danger bdt-text-bold" bdt-title="Please Contact License Manager."> Unknown </span>';
        }
        $domain_list = '';
        if (empty($response['active_domains'])) {
            $domain_list = '<strong class="bdt-text-danger">Domain Not Found.</strong>';
        }
        foreach ($response['active_domains'] as $index => $item) {
            $rand_data = rand(100, 1000);
            $domain_list .= '<li><div>
                <span>' . $item . ' </span>
                <a href="javascript:void(0);" id="bdts-' . $index . '-' .  $rand_data . '"  data-id="bdts-' . $index . '-' .  $rand_data . '" class="bdts-remove-domain bdt-background-danger" data-license="' . $response['purchase_key'] . '" data-domain="' . $item . '">Remove</a></div>
            </li>';
        }

        $result = '';

        /** 
         * Inject Clients Personal Information
         */
        if ($client_info !== false) {
            $result .= $client_info;
        }

        $result .= '<h3 class="bdt-margin bdt-padding-small bdt-text-center">License Information</h3>';

        $result .= '<table class="bdt-table bdt-table-striped">
                    <tbody>
                        <tr>
                            <td>
                                <strong>License Code</strong>
                            </td>
                            <td colspan="3">' . $response['purchase_key'] . ' (' . $status . ')</td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Product Name</strong>
                            </td>
                            <td colspan="3"><strong class="bdt-text-success"> ' . $response['product_name'] . ' </strong><i>(' . $response['license_title'] . ')</i></td>
                        </tr>
                        <tr>
                            <td>
                            <strong>Buy From</strong>
                            </td>
                            <td>' . $market . '</td>
                            <td>
                            <strong>Support</strong>
                            </td>
                            <td>' . $has_support . '</td>
                        </tr>
                        <tr>
                            <td>
                            <strong>Purchase Date</strong>
                            </td>
                            <td>' . date('d M, Y', strtotime($response['entry_time'])) . '</td>
                            <td>
                            <strong>Expire Date</strong>
                            </td>
                            <td>' . ($response['expiry_time'] !== null ? date('d M, Y', strtotime($response['expiry_time'])) : 'Lifetime') . '</td>
                        </tr>
                        <tr>
                            <td>
                            <strong>Support End</strong>
                            </td>
                            <td>' . ($response['support_end_time'] !== null ? date('d M, Y', strtotime($response['support_end_time'])) : 'Lifetime') . '</td>
                            <td>
                            <strong>Max Domain</strong>
                            </td>
                            <td>' . $response['max_domain'] . '</td>
                        </tr>
                    </tbody>
                </table>
                <h3 class="bdt-margin bdt-padding-small bdt-text-center">Active Domain\'s</h3>
                <div class="bdt-margin">
                    <input id="bdts-domain-search-input" class="bdt-input bdt-form-width-large bdts-domain-search-input" type="text" placeholder="Search Domain">
                </div>
                <ol class="bdt-list bdt-list-striped bdt-margin-remove-left bdt-padding-small bdt-padding-remove-left bdts-domain-list">
                ' . $domain_list . '
                </ol>';

        return $result;
    }

    /**
     * Get the License List
     *
     * @return void
     */
    public function get_licenses($email) {
        if (!isset($email)) {
            $this->throw_error();
        }

        if (empty($email)) {
            $this->throw_error();
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => $this->CURLOPT_URL . 'license/view-all-by-email',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,

            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,

            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS => array(
                'api_key' => $this->API_KEY,
                'email'   => $email,
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response, true);

        if ($response['status'] !== true) {
            $this->throw_error();
        }

        /**
         * Get Information of Clients
         */

        $client_info = false;
        if (isset($response['data']['licenses'][0]['client_id'])) {
            $client_info = $this->get_client_info($response['data']['licenses'][0]['client_id']);
        }

        $result = '';

        /** 
         * Inject Clients Personal Information
         */

        // if ($client_info !== false) {
        //     $result .= $client_info;
        // }

        foreach ($response['data']['licenses'] as $key => $item) {
            $key += 1;
            $status = '';
            if ($item['status'] == 'A') {
                $status = '<span class="bdt-text-success bdt-text-bold"> Active </span>';
            } elseif ($item['status'] == 'R') {
                $status = '<span class="bdt-text-danger bdt-text-bold"> Refunded </span>';
            } elseif ($item['status'] == 'I') {
                $status = '<span class="bdt-text-warning bdt-text-bold"> In-Active </span>';
            } elseif ($item['status'] == 'W') {
                $status = '<span class="bdt-text-success bdt-text-bold"> Free </span>';
            } else {
                $status = '<span class="bdt-text-danger bdt-text-bold" bdt-title="Please Contact License Manager."> Unknown Error </span>';
            }

            $market = '';
            if ($item['market'] == 'E') {
                $market = '<span class="bdt-text-success bdt-text-bold"> Envato </span>';
            } elseif ($item['market'] == 'J') {
                $market = '<span class="bdt-text-danger bdt-text-bold"> JVZoo </span>';
            } elseif ($item['market'] == 'F') {
                $market = '<span class="bdt-text-warning bdt-text-bold"> FastSpring </span>';
            } elseif ($item['market'] == 'P') {
                $market = '<span class="bdt-text-success bdt-text-bold"> Paddle </span>';
            } elseif ($item['market'] == 'W') {
                $market = '<span class="bdt-text-success bdt-text-bold"> WooCommerce </span>';
            } else {
                $market = '<span class="bdt-text-danger bdt-text-bold" bdt-title="Please Contact License Manager."> Unknown </span>';
            }

            $has_support = '';
            if ($item['has_support'] == 'U') {
                $has_support = '<span class="bdt-text-success bdt-text-bold"> Lifetime </span>';
            } elseif ($item['has_support'] == 'Y') {
                $has_support = '<span class="bdt-text-success bdt-text-bold"> Yes </span>';
            } else {
                $has_support = '<span class="bdt-text-danger bdt-text-bold" bdt-title="Please Contact License Manager."> Unknown </span>';
            }

            $product_details = $this->product_details($item['purchase_key'], $item['product_id']);

            $result .= '<h3 class="bdt-background-primary bdt-padding-small bdt-panel">License NO - ' . $key . ' </h3>';
            // $result .= '<table class="bdt-table bdt-table-striped"><tbody>
            //             <tr>
            //                 <td>
            //                     <strong>License Code</strong>
            //                 </td>
            //                 <td colspan="3">' . $item['purchase_key'] . ' (' . $status . ')</td>
            //             </tr>
            //             <tr>
            //                 <td>
            //                     <strong>License Title</strong>
            //                 </td>
            //                 <td colspan="3"><strong class="bdt-text-success"> ' . $product_details['product_name'] . ' </strong><i>(' . $item['license_title'] . ')</i></td>
            //             </tr>
            //             <tr>
            //                 <td>
            //                 <strong>Buy From</strong>
            //                 </td>
            //                 <td>' . $market . '</td>
            //                 <td>
            //                 <strong>Support</strong>
            //                 </td>
            //                 <td>' . $has_support . '</td>
            //             </tr>
            //             <tr>
            //                 <td>
            //                 <strong>Purchase Date</strong>
            //                 </td>
            //                 <td>' . date('d M, Y', strtotime($item['entry_time'])) . '</td>
            //                 <td>
            //                 <strong>Expire Date</strong>
            //                 </td>
            //                 <td>' . ($item['expiry_time'] !== null ? date('d M, Y', strtotime($item['expiry_time'])) : 'Lifetime') . '</td>
            //             </tr>
            //             <tr>
            //                 <td>
            //                 <strong>Support End</strong>
            //                 </td>
            //                 <td>' . ($item['support_end_time'] !== null ? date('d M, Y', strtotime($item['support_end_time'])) : 'Lifetime') . '</td>
            //                 <td>
            //                 <strong>Max Domain</strong>
            //                 </td>
            //                 <td>' . $item['max_domain'] . '</td>
            //             </tr>
            //             ';

            // $result .= '</tbody> </table>';
            $result .= $this->license_details($item['purchase_key']);
        }


        return $result;
    }

    /**
     * Get Information of Client
     *
     * @return void
     */
    public function get_client_info($client_id) {
        if (empty($client_id)) {
            $this->throw_error();
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->CURLOPT_URL . 'client/view',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,

            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,

            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'api_key' => $this->API_KEY,
                'client_id' => $client_id,
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response, true);

        if ($response['status'] !== true) {
            return false;
        }

        $status = '';

        if ($response['data']['status'] == 'A') {
            $status = '<span class="bdt-text-success bdt-text-bold"> Active </span>';
        } else {
            $status = '<span class="bdt-text-danger bdt-text-bold"> In-active </span>';
        }

        $result = '<h3 class="bdt-margin bdt-padding-small bdt-text-center">Client Personal Information</h3>';
        $result .= '<table class="bdt-table bdt-table-striped">
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Client Status</strong>
                                </td>
                                <td colspan="3">' . $status . '</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Name</strong>
                                </td>
                                <td>' . $response['data']['name'] . '</td>
                                <td>
                                    <strong>Email</strong>
                                </td>
                                <td>' . $response['data']['email'] . '</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Entry Time</strong>
                                </td>
                                <td>' . $response['data']['entry_time'] . '</td>
                                <td>
                                    <strong>Company</strong>
                                </td>
                                <td>' . $response['data']['company'] . '</td>
                            </tr>
                        </tbody>
                    </table>';
        return $result;
    }

    /**
     * Detect Clients Info by Email/License
     * If Email then will call the License List method
     * If License then call the License Details method
     *
     * @param [type] $data
     * @return void
     */
    public function detect_info($data) {

        if (empty($data['identity'])) {
            $msg = 'field-blank';
            echo wp_json_encode($msg);
            wp_die();
        }

        if (!wp_verify_nonce($_REQUEST['_wpnonce'], 'check-info')) {
            echo wp_json_encode('nonce_expired');
            wp_die();
            // $this->throw_error();
        }

        /**
         * Filer Input and send them Individual Path
         */

        if (filter_var($_POST["identity"], FILTER_VALIDATE_EMAIL)) {
            /**
             * Filter got Email
             * Trying to get Info By Email
             * Call Separate method get_licenses
             */

            $result = $this->get_licenses(sanitize_email($_POST["identity"]));
        } else {
            /**
             * Filter got License Key
             * Trying to get Info of License
             * Call Separate method license_details
             */

            $result = $this->license_details(sanitize_text_field($_POST["identity"]));
        }

        echo wp_json_encode($result);
        wp_die();
    }

    /**
     * Remove Domain
     * Verify License & Domain Name
     *
     * @return void
     */
    public function remove_domain($data) {

        if (!isset($data['license_code']) || !isset($data['domain'])) {
            $this->throw_error();
        }

        if (empty($data['license_code']) || empty($data['domain'])) {
            $this->throw_error();
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => $this->CURLOPT_URL . 'license/remove_domain',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,

            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,

            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => array(
                'api_key'          => $this->API_KEY,
                'license_code'     => $data['license_code'],
                'domain'           => $data['domain']
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);

        if (isset($response['status']) && $response['status'] !== true) {
            $this->throw_error();
        }

        $response = 'success';

        echo wp_json_encode($response);

        wp_die();
    }

    /**
     * Save Settings
     *
     * @return void
     */

    public function save_settings($data) {
        /* hit bottom of screen event  */

        $option    = 'bdts_settings';
        $new_value = new stdClass();
        $new_value = $data;

        // print_r($new_value);

        // if ((!isset($option) || $option == '') || (!isset($new_value) || $new_value = '')) {

        //     $response = 'error';
        //     echo wp_json_encode($response);
        //     wp_die();
        // }

        // print_r($new_value);
        // exit();

        update_option($option, $new_value);

        $response = 'success';
        echo wp_json_encode($response);
        wp_die();
    }
}




function info_detect() {
    $bdts_app = new BDTS_APP();
    $bdts_app->detect_info($_POST);
}

function remove_domain() {
    $bdts_app = new BDTS_APP();
    $bdts_app->remove_domain($_POST);
}

function save_settings() {
    $bdts_app = new BDTS_APP();
    $bdts_app->save_settings($_POST);
}
