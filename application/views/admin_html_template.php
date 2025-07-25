<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo (isset($title)) ? $title : "Online & Offline Inventory System" ?></title>
        <?php
        $CI = & get_instance();
        $CI->load->model('Web_settings');
        $Web_settings = $CI->Web_settings->retrieve_setting_editdata();
        ?>
        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?php
        if (isset($Web_settings[0]['logo'])) {
            echo $Web_settings[0]['favicon'];
        }
        ?>" type="image/x-icon">
        <link rel="apple-touch-icon" type="image/x-icon" href="<?php echo base_url() ?>assets/dist/img/ico/apple-touch-icon-57-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="<?php echo base_url() ?>assets/dist/img/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="<?php echo base_url() ?>assets/dist/img/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="<?php echo base_url() ?>assets/dist/img/ico/apple-touch-icon-144-precomposed.png">
        <!-- Start Global Mandatory Style-->

        <!-- jquery-ui css -->
        <link href="<?php echo base_url() ?>assets/plugins/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        <!-- Bootstrap -->
        <link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <?php
        if ($Web_settings[0]['rtr'] == 1) {
            ?>
            <!-- Bootstrap rtl -->
            <link href="<?php echo base_url() ?>assets/bootstrap-rtl/bootstrap-rtl.min.css" rel="stylesheet" type="text/css"/>
            <?php
        }
        ?>
        <!-- Font Awesome -->
        <link href="<?php echo base_url() ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url() ?>assets/css/cmxform.css" rel="stylesheet" type="text/css"/>
        <!-- Themify icons -->
        <link href="<?php echo base_url() ?>assets/themify-icons/themify-icons.min.css" rel="stylesheet" type="text/css"/>
        <!-- Pe-icon -->
        <link href="<?php echo base_url() ?>assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css"/>
        <!-- Data Tables -->
        <link href="<?php echo base_url() ?>assets/plugins/datatables/dataTables.min.css" rel="stylesheet" type="text/css"/>
        <!-- Theme style -->
        <link href="<?php echo base_url() ?>assets/dist/css/styleBD.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url() ?>assets/css/select2.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url() ?>assets/css/custom.css" rel="stylesheet" type="text/css"/>
        <?php
        if ($Web_settings[0]['rtr'] == 1) {
            ?>
            <!-- Theme style rtl -->
            <link href="<?php echo base_url() ?>assets/dist/css/styleBD-rtl.css" rel="stylesheet" type="text/css"/>
            <?php
        }
        ?>
        <!-- jQuery -->
        <script src="<?php echo base_url() ?>assets/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.validate.min.js" type="text/javascript"></script>
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="se-pre-con"></div>
        <!-- Site wrapper -->
        <div class="wrapper">
            <?php
            $url = $this->uri->segment(2);
            if ($url != "login") {
                $this->load->view('include/admin_header');
            }
            ?>
            <div id="loaded_img" style="display: none; text-align: center; ">
                <img src="<?php echo base_url('assets/dist/img/loader.gif'); ?>" alt="" width="2%" style="position: fixed; left: 55%; top: 50%; z-index: 999; transform: translateY(-50%);">
            </div>
            <div class="">
                {content}
            </div>
            <?php
            if ($url != "login") {
                $this->load->view('include/admin_footer');
            }
            ?>
        </div>
        <!--=========== its for hidden area start=============-->
        <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
        <input type ="hidden" name="CSRF_TOKEN" id="CSRF_TOKEN" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <!--=========== its for hidden area close=============-->
        <!-- ./wrapper -->

        <!-- Start Core Plugins-->
        <!-- jquery-ui --> 
        <script src="<?php echo base_url() ?>assets/plugins/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="<?php echo base_url() ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- SlimScroll -->
        <script src="<?php echo base_url() ?>assets/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <!-- FastClick -->
        <script src="<?php echo base_url() ?>assets/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
        <!-- AdminBD frame -->
        <script src="<?php echo base_url() ?>assets/dist/js/frame.min.js" type="text/javascript"></script>
        <!-- Sparkline js -->
        <script src="<?php echo base_url() ?>assets/plugins/sparkline/sparkline.min.js" type="text/javascript"></script>
        <!-- Counter js -->
        <script src="<?php echo base_url() ?>assets/plugins/counterup/waypoints.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        <!-- dataTables js -->
        <script src="<?php echo base_url() ?>assets/plugins/datatables/dataTables.min.js" type="text/javascript"></script>
        <!-- Dashboard js -->
        <script src="<?php echo base_url() ?>assets/dist/js/dashboard.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/select2.min.js" type="text/javascript"></script>
        <!--=============== its for classyloader circle ===============-->
        <script src="<?php // echo base_url('assets/dist/js/jquery.classyloader.min.js');          ?>"></script>
        <!-- Flot Charts js -->
        <script src="<?php echo base_url(); ?>assets/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/flot/jquery.flot.pie.min.js" type="text/javascript"></script>


        <script type="text/javascript">
            $(".datepicker").datepicker({dateFormat: 'yy-mm-dd'});

            // select 2 dropdown 
            $("select.form-control:not(.dont-select-me)").select2({
                placeholder: "Select option",
                allowClear: true
            });

            //Insert supplier
            $("#insert_supplier").validate();

            //Update supplier
            $("#supplier_update").validate();

            //Update customer
            $("#customer_update").validate();

            //Insert customer
            $("#insert_customer").validate();

            //Update product
            $("#product_update").validate();

            //Insert product
            $("#insert_product").validate();

            //Insert pos invoice
            $("#insert_pos_invoice").validate();

            //Insert invoice
            $("#insert_invoice").validate();

            //Update invoice
            $("#invoice_update").validate();

            //Insert purchase
            $("#insert_purchase").validate();

            //Update purchase
            $("#purchase_update").validate();

            //Add category
            $("#insert_category").validate();

            //Update category
            $("#category_update").validate();

            //Stock report
            $("#stock_report").validate();

            //Stock report
            $("#stock_report_supplier_wise").validate();
            //Stock report
            $("#stock_report_product_wise").validate();

            //Create account
            $("#create_account_data").validate();

            //Update account
            $("#update_account_data").validate();

            //Inflow entry
            $("#inflow_entry").validate();

            //Outflow entry
            $("#outflow_entry").validate();

            //Tax entry
            $("#tax_entry").validate();

            //Update tax
            $("#update_tax").validate();

            //Account summary
            $("#summary_datewise").validate();
            //Comission generate
            $("#commission_generate").validate();

        </script>
        <script type="text/javascript">
//            ======== itsf for expense item list datatables ==============
            var table = $("#expenseItems").DataTable({
                dom: "'<'col-sm-4'l><'col-sm-4 text-center'><'col-sm-4'>Bfrtip",
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                buttons: [{
                        extend: "copy", className: "btn-sm"
                    }
                    , {
                        extend: "csv", title: "ExampleFile", className: "btn-sm"
                    }
                    , {
                        extend: "excel", title: "ExampleFile", className: "btn-sm"
                    }
                    , {
                        extend: "pdf", title: "ExampleFile", className: "btn-sm"
                    }
                    , {
                        extend: "print", className: "btn-sm"
                    },
                ],
                order: [],
                paging: true,
                "searching": true,
                "processing": true,
                "serverSide": true,

                "ajax": {
                    "url": "<?php echo base_url('CExpense/expenseitem_list_custom'); ?>",
                    "type": "POST",
//                    "data": function (data) {
//                        data.item = $('#item').val();
//                    },

                }
            });
            $('#custom_search').click(function () {
                table.ajax.reload();
            });
//              =============== its for expenselist datatables ==================
            var table = $("#expenselist").DataTable({
                dom: "'<'col-sm-4'l><'col-sm-4 text-center'><'col-sm-4'>Bfrtip",
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                buttons: [{
                        extend: "copy", className: "btn-sm"
                    }
                    , {
                        extend: "csv", title: "ExampleFile", className: "btn-sm"
                    }
                    , {
                        extend: "excel", title: "ExampleFile", className: "btn-sm"
                    }
                    , {
                        extend: "pdf", title: "ExampleFile", className: "btn-sm"
                    }
                    , {
                        extend: "print", className: "btn-sm"
                    },
                ],
                order: [],
                paging: true,
                "searching": true,
                "processing": true,
                "serverSide": true,

                "ajax": {
                    "url": "<?php echo base_url('CExpense/expenselist_custom'); ?>",
                    "type": "POST",
                    "data": function (data) {
                        data.item = $('#item').val();
                    },

                }
            });
            $('#custom_search').click(function () {
                table.ajax.reload();
            });
        </script>

        <script>
            $(document).ready(function () {
                $('.content-wrapper').attr('id', 'bodycontent');
            });
            function pageopen(url) {
                var segments = url.split('/');
                var lasturi = segments[6];
//                alert(url);  alert(lasturi);
                if (lasturi == 'pos_invoice') {
                    $("#loaded_img").show();
                    setTimeout(function () {
                        $("#loaded_img").hide();
                    }, 700);
                    $('#bodycontent').load(url);
                    $("#add_item").focus();
                    $('.sidebar-mini').addClass("sidebar-collapse");
                    $(".removeContentwraper").removeClass("content-wrapper");
                } else {
                    $("#loaded_img").show();
                    setTimeout(function () {
                        $("#loaded_img").hide();
                    }, 700);
                    // url = url.replace("http://", "https://");
                    $('#bodycontent').load(url);
                    $(".removeContentwraper").removeClass("content-wrapper");
                    $('.sidebar-mini').removeClass("sidebar-collapse");
//                    ========= its for auto scrol up ==============
                    return $("html, body").animate({
                        scrollTop: 0
                    }, 600), !1
//                    ============== auto scroll up close =========
                }
            }
            //=========== its for special character remove =========
            function special_character_remove(vtext, id) {
//                var specialChars = "<>@!#$%^&*()_+[]{}?:;|'\"\\/~`-=";
                var specialChars = "<?php echo display('security_character'); ?>";
                var check = function (string) {
                    for (i = 0; i < specialChars.length; i++) {
                        if (string.indexOf(specialChars[i]) > -1) {
                            return true
                        }
                    }
                    return false;
                }
                if (check($('#' + id).val()) == false) {
                    // Code that needs to execute when none of the above is in the string
                } else {
                    alert(specialChars + " these special character are not allows");
                    $("#" + id).val('').focus();
//            $("#customer_name").focus();
                }
            }
            //=========== its for only number allow=========
            function onlynumber_allow(vtext, id) {
                var specialChars = "<>@!#$%^&*()_+[]{}?:;|'\"\\/~`-=abcdefghijklmnopqrstuvwxyz"
                var check = function (string) {
                    for (i = 0; i < specialChars.length; i++) {
                        if (string.indexOf(specialChars[i]) > -1) {
                            return true
                        }
                    }
                    return false;
                }
                if (check($('#' + id).val()) == false) {
                    // Code that needs to execute when none of the above is in the string
                } else {
                    alert(specialChars + " these special character are not allows");
                    $("#" + id).val('').focus();
                }
            }
        </script>
    </body>
</html>