<!-- Supplier Ledger Start -->
<div class="content-wrapper removeContentwraper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('supplier_ledger') ?></h1>
            <small><?php echo display('manage_supplier_ledger') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('supplier') ?></a></li>
                <li class="active"><?php echo display('supplier_ledger') ?></li>
            </ol>
        </div>
    </section>

    <!-- Supplier information -->
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
        ?>


        <div class="row">
            <div class="col-sm-12">
                <div class="m-b-10 float_right">
                    <?php if ($this->permission->check_label('add_supplier')->create()->access()) { ?>
                        <a href="javascript:void(0)" onclick="pageopen('<?php echo base_url('Csupplier'); ?>')" class="btn btn-success"><?php echo display('add_supplier'); ?></a>
                        <?php
                    }
                    if ($this->permission->check_label('manage_supplier')->read()->access()) {
                        ?>
                        <a href="javascript:void(0)" onclick="pageopen('<?php echo base_url('Csupplier/manage_supplier'); ?>')" class="btn btn-info"><?php echo display('manage_supplier'); ?></a>
                        <?php
                    }
                    if ($this->permission->check_label('supplier_payment_ledger')->read()->access()) {
                        ?>
                        <a href="javascript:void(0)" onclick="pageopen('<?php echo base_url('Csupplier/supplier_payment'); ?>')" class="btn custom_btn custom_fontcolor"><?php echo display('supplier_payment'); ?></a>
                        <?php
                    }
                    if ($this->permission->check_label('supplier_sales_details')->read()->access()) {
                        ?>
                        <a href="javascript:void(0)" onclick="pageopen('<?php echo base_url('Csupplier/supplier_sales_details_all'); ?>')" class="btn btn-warning"><?php echo display('supplier_sales_details'); ?></a>
                    <?php } ?>
                    <button class="btn custom_btn custom_fontcolor default" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Filter
                    </button>
                </div>
            </div>
            <div class="col-sm-12 collapse" id="collapseExample">
                <div class="panel panel-default">
                    <div class="panel-body"> 
                        <?php echo form_open('Csupplier/supplier_ledger/', array('class' => 'form-inline',)) ?>
                        <?php $today = date('Y-m-d'); ?>
                        <div class="row">
                            <div class="form-group">
                                <label  class="col-sm-3 m-r-5">Supplier</label>
                                <div class="col-sm-2">
                                    <select name="supplier_id"  class="form-control">
                                        <option value=""><?php echo display('select_supplier') ?></option>
                                        <?php
                                        if ($supplier) {
                                            ?>
                                            {supplier}
                                            <option value="{supplier_id}">{supplier_name} 
                                            </option>
                                            {/supplier}
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2"><?php echo display('from') ?></label>
                                <div class="col-sm-1">
                                    <input type="text" name="from_date"  value="" class="datepicker form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label"><?php echo display('to') ?></label>
                                <div class="col-sm-1">
                                    <input type="text" name="to_date" value="" class="datepicker form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2 text-right">
                                    <button type="submit" class="btn custom_btn custom_fontcolor"><i class="fa fa-search-plus" aria-hidden="true"></i>
                                        <?php echo display('search') ?></button>
                                </div>
                            </div>
                        </div>  

                        <?php echo form_close() ?>            
                    </div>
                </div>
            </div>
        </div>

        <!-- Supplier ledger -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('supplier_ledger') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">

                            <table id="dataTableExample3" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?php echo display('sl') ?></th>
                                        <th class="text-center"><?php echo display('supplier_name') ?></th>
                                        <th class="text-right"><?php echo display('total_debit') ?></th>
                                        <th class="text-right"><?php echo display('total_credit') ?></th>
                                        <th class="text-right"><?php echo display('total_balance') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($ledgers) {
                                        $sl = 0;
                                        $debit = $credit = $balance = 0;
                                        foreach ($ledgers as $ledger) {
                                            $sql = 'SELECT (SELECT SUM(amount) FROM supplier_ledger sl '
                                                    . 'WHERE sl.supplier_id = "' . @$ledger['supplier_id'] . '" '
                                                    . 'AND d_c = "d") debit, (SELECT SUM(amount) '
                                                    . 'FROM supplier_ledger sl WHERE sl.supplier_id = "' . @$ledger['supplier_id'] . '" '
                                                    . 'AND d_c = "c") credit';
                                            $result = $this->db->query($sql)->result();
                                            $sl++;
                                            ?>
                                            <tr>
                                                <td><?php echo $sl; ?></td>
                                                <td>
                                                    <a href="<?php echo base_url() . 'Csupplier/supplier_ledger_info/' . $ledger['supplier_id']; ?>">
                                                        <?php echo $ledger['supplier_name']; ?>
                                                    </a>
                                                    <?php // echo $ledger['supplier_name']; ?></td>
                                                <td align="right">
                                                    <?php
                                                    echo (($position == 0) ? "$currency " : " $currency");
                                                    $debit = isset($result[0]->debit) && $result[0]->debit !== null ? (float) $result[0]->debit : 0.00;
                                                    echo number_format($debit, 2, '.', ',');
                                                    // echo number_format($result[0]->debit, '2', '.', ',');
                                                    $debit += $result[0]->debit;
//                                                    if ($ledger['d_c'] == 'd') {
//                                                        echo (($position == 0) ? "$currency " : " $currency");
//                                                        echo number_format($ledger['amount'], 2, '.', ',');
//                                                        $debit += $ledger['amount'];
////                                                         $d = 12;
//                                                    } else {
//                                                        $debit += '0.00';
//                                                    }
                                                    ?>
                                                </td>
                                                <td align="right">
                                                    <?php
                                                    echo (($position == 0) ? "$currency " : " $currency");
                                                    echo number_format($result[0]->credit, '2', '.', ',');
                                                    $credit += $result[0]->credit;
//                                                    if ($ledger['d_c'] == 'c') {
//                                                        echo (($position == 0) ? "$currency " : " $currency");
//                                                        echo number_format($ledger['amount'], 2, '.', ',');
//                                                        $credit += $ledger['amount'];
//                                                    } else {
//                                                        $credit += '0.00';
//                                                    }
                                                    ?>
                                                </td>
                                                <td align='right'>
                                                    <?php
                                                    $balance = $debit - $credit;
                                                    echo (($position == 0) ? "$currency " : " $currency");
                                                    echo number_format($balance, 2, '.', ',');
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" align="right"><b><?php echo display('grand_total') ?>:</b></td>
                                        <td align="right"><b><?php
                                                echo (($position == 0) ? "$currency " : "$currency");
                                                echo number_format((@$debit), 2, '.', ',');
                                                ?></b></td>
                                        <td align="right"><b><?php
                                                echo (($position == 0) ? "$currency " : "$currency");
                                                echo number_format((@$credit), 2, '.', ',');
                                                ?></b></td>
                                        <td align="right"><b><?php
                                                echo (($position == 0) ? "$currency " : "$currency");
                                                echo number_format((@$balance), 2, '.', ',');
                                                ?></b></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Supplier Ledger End  -->
<script src="<?php echo base_url() ?>assets/js/supplier.js" type="text/javascript"></script>