<!-- Customer Ledger Start -->
<div class="content-wrapper removeContentwraper" id="bodycontent">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('customer_ledger') ?></h1>
            <small><?php echo display('manage_customer_ledger') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('customer') ?></a></li>
                <li class="active"><?php echo display('customer_ledger') ?></li>
            </ol>
        </div>
    </section>

    <!-- Customer information -->
    <section class="content">
        <!-- Alert Message -->
        <?php
        $message = $this->session->userdata('message');
        if (isset($message)) {
            ?>
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $message ?>                    
            </div>
            <?php
            $this->session->unset_userdata('message');
        }
        $error_message = $this->session->userdata('error_message');
        if (isset($error_message)) {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $error_message ?>                    
            </div>
            <?php
            $this->session->unset_userdata('error_message');
        }
        $CI = & get_instance();
        $CI->load->library('Occational');
        ?>

        <!--        <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-bd lobidrag">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <h4><?php echo display('customer_information') ?></h4>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div style="text-align: center; ">
                                    {company_info}
                                    <h5><u> {company_name}</u></h5>
                                    {/company_info}
        <?php echo display('customer_name') ?> : {customer_name} <br>
        <?php echo display('customer_address') ?> : {customer_address}<br>
        <?php echo display('mobile') ?> : {customer_mobile}
                                </div>
                                <div style="float:right;margin-right:100px">
                                    <table class="table table-striped table-condensed table-bordered">
                                        <tr>
                                            <td> <?php echo display('debit_ammount') ?> </td> <td style="text-align:right !Important;margin-right:20px"> 
        <?php
        echo (($position == 0) ? "$currency {total_debit}" : "{total_debit} $currency")
        ?>
                                            </td> 
                                        </tr>
                                        <tr><td><?php echo display('credit_ammount'); ?></td> <td style="text-align:right !Important;margin-right:20px"> <?php echo (($position == 0) ? "$currency {total_credit}" : "{total_credit} $currency") ?></td> </tr>
                                        <tr><td><?php echo display('balance_ammount'); ?> </td> <td style="text-align:right !Important;margin-right:20px"> <?php echo (($position == 0) ? "$currency {total_balance}" : "{total_balance} $currency") ?></td> </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->

        <!-- Customer Ledger -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title printbtn">
                            <h4><?php echo display('customer_ledger') ?></h4>
                            <div>
                                <a  class="btn btn-success" href="#" onclick="printDiv('printableArea')"><i class="fa fa-print text-white"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body" id="printableArea">
                        <div class="text-center">
                            {company_info}
                            <h5><u> {company_name}</u></h5>
                            {/company_info}
                            <?php echo display('customer_name') ?> : {customer_name} <br>
                            <?php if ($customer_address) { ?>
                                <?php echo display('customer_address') ?> : {customer_address}<br>
                            <?php } ?>
                            <?php if ($customer_mobile) { ?>
                                <?php echo display('mobile') ?> : {customer_mobile}
                            <?php } ?>
                        </div>
                        <div class="table-responsive">
                            <table id="dataTableExample3" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo display('date') ?></th>
                                        <th><?php echo display('invoice_no') ?></th>
                                        <th><?php echo display('receipt_no') ?></th>
                                        <th><?php echo display('description') ?></th>
                                        <th class="text-right m-r-15"><?php echo display('debit') ?></th>
                                        <th class="text-right m-r-15"><?php echo display('credit') ?></th>
                                        <th class="text-right m-r-15"><?php echo display('balance') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($ledgers) {
//                                        echo '<pre>';                                        print_r($ledgers);
                                        ?>
                                        <?php
                                        $debit = $credit = $balance = 0;
                                        foreach ($ledgers as $single) {
                                            # code...
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php
//                                                    echo date('d-M-Y', strtotime($single['date']));
                                                    echo $CI->occational->dateConvertMyformat($single['date']);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($single['invoice_no'] == 'Adjustment') {
                                                        $invoiceurl = 'javascript:void(0)';
                                                    } else {
                                                        $invoiceurl = base_url('Cinvoice/invoice_inserted_data/' . $single['invoice_no']);
                                                    }
                                                    ?>
                                                    <a href="<?php echo $invoiceurl; ?>">
                                                        <?php
                                                        echo $single['invoice_no'];
//                                                        if ($ledger['receipt_no'] == '') {
//                                                            echo $ledger['invoce_no'];
//                                                        }
                                                        ?>
                                                    </a>
                                                </td>
                                                <td>

                                                    <a href="<?php echo base_url() . 'Cinvoice/receipt_inserted_data/' . $single['receipt_no']; ?>">
                                                        <?php echo $single['receipt_no'] ?></a>

                                                </td>
                                                <td><?php echo $single['description'] ?></td>
                                                <td class="text-right"> 
                                                    <?php
                                                    if ($single['d_c'] == 'd') {
                                                        echo (($position == 0) ? "$currency " : " $currency");
                                                        echo number_format($single['amount'], '2', '.', ',');
                                                        $debit += $single['amount'];
                                                    } else {
                                                        $debit += '0.00';
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-right"> 
                                                    <?php
                                                    if ($single['d_c'] == 'c') {
                                                        echo (($position == 0) ? "$currency " : " $currency");
                                                        echo number_format($single['amount'], '2', '.', ',');
                                                        $credit += $single['amount'];
                                                    } else {
                                                        $credit += '0.00';
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-right">
                                                    <?php
                                                    $balance = $debit - $credit;
                                                    echo (($position == 0) ? "$currency " : " $currency");
                                                    echo number_format($balance, 2, '.', ',');
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" align="right"><b><?php echo display('grand_total') ?>:</b></td>
                                        <td align="right">
                                            <b>
                                                <?php
                                                echo (($position == 0) ? "$currency " : "$currency");
                                                echo number_format((@$debit), 2, '.', ',');
                                                ?>
                                            </b>
                                        </td>
                                        <td align="right">
                                            <b>
                                                <?php
                                                echo (($position == 0) ? "$currency " : "$currency");
                                                echo number_format((@$credit), 2, '.', ',');
                                                ?>
                                            </b>
                                        </td>
                                        <td align="right">
                                            <b>
                                                <?php
                                                echo (($position == 0) ? "$currency " : "$currency");
                                                echo number_format((@$balance), 2, '.', ',');
                                                ?>
                                            </b>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" id="customerid" value="{customer_id}">
</div>
<!-- Customer Ledger End  -->
<script src="<?php echo base_url() ?>assets/js/customer.js" type="text/javascript"></script>