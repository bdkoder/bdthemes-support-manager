(function ($) {


    $('.bdts-wrapper').find('.bdt-main-tab li').on('click', function () {
        let $tabIndex = $(this).data('index');
        $('#bdt-main-tab .bdt-content-item').removeClass('bdt-active');
        $('#bdt-main-tab .bdt-content-item:eq(' + $tabIndex + ')').addClass('bdt-active');
    });

    jQuery(document).on('keyup change', '#bdts-domain-search-input', function () {
        var filter = jQuery(this).val();
        jQuery(".bdts-domain-list li").each(function () {
            if (jQuery(this).find('span').text().search(new RegExp(filter, "i")) < 0) {
                jQuery(this).hide();
            } else {
                jQuery(this).show()
            }
        });
    });


    /**
     * APP JS
     */

    var App = {
        alertMsg: function ($title, $text, $icon) {
            Swal.fire({
                title: $title,
                text: $text,
                icon: $icon,
            })
        },
        checkInfo: function (data) {
            var Obj = this;
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: data,
                success: function (data) {
                    let response = JSON.parse(data);
                    console.log(response);

                    if (response == 'field-blank') {
                        Obj.alertMsg('Ops!', 'Field should not be empty!', 'warning')
                        return;
                    }
                    if (response == 'error') {
                        Obj.alertMsg('Ops!', 'Something Wrong or License is not correct!', 'warning')
                        return;
                    }

                    Swal.close();
                    bdtUIkit.modal($('#bdts-modal')).show();
                    $('#bdts-modal-body').html(response);

                },
                error: function (errorThrown) {
                    alert(errorThrown);
                }

            });
        },
        removeDomain: function ($id, $license, $domain) {
            var Obj = this;
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    'action': 'bdts_remove_domain',
                    'license_code': $license,
                    'domain': $domain
                },
                success: function (data) {
                    let response = JSON.parse(data);

                    if (response == 'success') {
                        Obj.alertMsg('Great Job!', 'Domain Removed Successfully.', 'success');
                        $('#' + $id).closest('li').slideUp();
                    }

                }
            });
        },
        saveSettings: function (data) {
             var Obj = this;
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: data,
                // dataType: 'json'
            }).done(function (data) {
                let response = JSON.parse(data);

                if (response == 'success') {
                    Obj.alertMsg('Great Job!', 'Saved Successfully.', 'success');
                } else {
                    Obj.alertMsg('Sorry!', 'Data not Saved!', 'error');
                }
            }).fail(function () {
                alert("The Ajax call itself failed.");
            });
        },
        init: function () {
            var Obj = this;
            /**
             * start check license / clients info
             */
            $('#check-license-form').on('submit', function (event) {
                event.preventDefault();
                let data = $(this).serializeArray();
                Swal.showLoading();
                Obj.checkInfo(data);
            });

            /**
             * Remove Domain
             */
            $(document).on('click', '.bdts-remove-domain', function (event) {
                event.preventDefault();
                $license = $(this).data('license');
                $domain = $(this).data('domain');
                $id = $(this).data('id');
                Swal.showLoading();
                Obj.removeDomain($id, $license, $domain);
            });

            /**
             * Save Settings
             */

            $('#bdts-settings-form').on('submit', function (e) {
                e.preventDefault();
                let data = $(this).serializeArray();
                Swal.showLoading();
                Obj.saveSettings(data);
            });

        }
    }

    App.init();


    //generate-license
    jQuery(document).ready(function ($) {
        $('#generate-license-form').on('submit', function (event) {
            event.preventDefault();
            var data = $(this).serializeArray();
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: data,
                success: function (data) {
                    $('.bdt-sm-result').show();
                    let response = JSON.parse(data);
                    if (response.type == 'field-blank') {
                        $('#bdt-sm-result').html(response.text);
                    }
                    if (response.type == 'cheating') {
                        $('#bdt-sm-result').html(response.text);
                    }
                    if (response.type == 'success') {
                        $('#bdt-sm-result').html(response.text + '<br>' + response.client_email + '<br>' + response.license_code);
                    }

                },
                error: function (errorThrown) {
                    alert(errorThrown);
                }

            });
        });
    });


    function client_view(data) {
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: {
                'action': 'client_view',
                'client_id': data
            },
            success: function (data) {
                let response = JSON.parse(data);
                let licenseObj = JSON.parse(response.license_code);
                let licenseData = licenseObj.data;
                if (licenseData) {
                    $('#company').html(licenseData.company);
                    $('#country').html(licenseData.country);
                    $('#email').html(licenseData.email);
                    $('#name').html(licenseData.name);
                }

            }
        });
    }

    //check-license

    jQuery(document).ready(function ($) {
        $('#check-license-formXXX').on('submit', function (event) {
            event.preventDefault();
            var data = $(this).serializeArray();
            Swal.showLoading();

            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: data,
                success: function (data) {
                    let response = JSON.parse(data);
                    console.log(response);

                    if (response == 'field-blank') {

                        return;
                    }

                    return;

                    if (response.type == 'field-blank') {
                        $('#result-error').html(response.text);
                    }
                    if (response.type == 'cheating') {
                        $('#result-error').html(response.text);
                    }
                    if (response.type == 'success') {
                        $('#result-error').html('');

                        $('#product_name').html(licenseData.product_name);
                        $('#license_title').html(licenseData.license_title);
                        $('#market').html(licenseData.market);
                        $('#has_support').html(licenseData.has_support);
                        $('#entry_time').html(licenseData.entry_time);
                        $('#expiry_time').html(licenseData.expiry_time);
                        $('#support_end_time').html(licenseData.support_end_time);
                        $('#max_domain').html(licenseData.max_domain);
                        $('#status').html(licenseData.status);
                        // $('#active_domains').html(licenseData.active_domains);

                        // console.log(licenseData.active_domains);

                        var countries = licenseData.active_domains;
                        var cList = $('ul.bdts-domain-list')
                        $.each(countries, function (i) {
                            var li = $('<li/>')
                                .addClass('bdt-domain-item')
                                .attr('role', 'menuitem')
                                .appendTo(cList);
                            var aaa = $('<div/>')
                                .addClass('bdt-domain-item-wrap')
                                .html(i + '. ' + countries[i] + '<a class="bdt-domain-remove" data-license="' + licenseData.purchase_key + '" data-domain="' + countries[i] + '" data-id="bdt-domain-' + i + '" id="bdt-domain-' + i + '">remove</a>')
                                .appendTo(li);
                        });





                        client_view(licenseData.id);
                        remove_domain();

                    }

                },
                error: function (errorThrown) {
                    alert(errorThrown);
                }

            });
        });

        function remove_domain() {
            $('.bdt-domain-remove').on('click', function (event) {
                // event.preventDefault();
                $license = $(this).data('license');
                $domain = $(this).data('domain');
                $id = $(this).data('id');


                jQuery.ajax({
                    type: "POST",
                    url: ajaxurl,
                    data: {
                        'action': 'remove_domain',
                        'license': $license,
                        'domain': $domain,
                    },
                    success: function (data) {
                        let response = JSON.parse(data);
                        let responseObj = JSON.parse(response);
                        alert(responseObj.msg);
                        $('#' + $id).closest('.bdt-domain-item').remove();
                    }
                });
            });
        }


    });

})(jQuery);