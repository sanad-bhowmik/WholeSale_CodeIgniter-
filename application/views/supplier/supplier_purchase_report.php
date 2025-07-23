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
                <div class="panel panel-default">
                    <div class="panel-body"> 
                        <?php echo form_open('Csupplier/supplier_ledger/', array('class' => 'form-inline',)) ?>
                        <?php $today = date('Y-m-d'); ?>


                        <div class="row">
                            <div class="form-group">
                                <label  class="col-sm-3">Supplier</label>
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
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search-plus" aria-hidden="true"></i>
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
                            <div class="text-center">

                                <h4><?php echo $supplier_name ?></h4>
                                <h5><?php echo display('address') ?>:<?php echo $address ?></h5> 
                            </div> 


                            <table id="dataTableExample3" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?php echo display('date') ?></th>
                                        <th class="text-center"><?php echo display('description') ?></th>
                                        <th class="text-center"><?php echo display('invoice_no') ?></th>
                                        <th class="text-center"><?php echo display('deposite_id') ?></th>
                                        <th class="text-center"><?php echo display('debit') ?></th>
                                        <th class="text-center"><?php echo display('credit') ?></th>
                                        <th class="text-center"><?php echo display('balance') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($ledger) {
//                                        echo '<pre>';                                        print_r($ledgers);die();
                                        $sl = 0;
                                        $debit = $credit = $balance = 0;
                                        foreach ($ledger as $ledger) {
                                            $sl++;
                                            ?>
                                            <tr>
                                                <td><?php echo $sl; ?></td>
                                                <td><?php echo $ledger['description']; ?></td>
                                                <td><a href="<?php echo base_url(); ?>Cpurchase/purchase_details_data/<?php echo $ledger['transaction_id']; ?>"><?php echo $ledger['chalan_no']; ?></a></td>
                                                <td><?php echo @$ledger['deposite_no']; ?></td>
                                                <td align="right">
                                                    <?php
                                                    if ($ledger['d_c'] == 'd') {
                                                        echo (($position == 0) ? "$currency " : " $currency");
                                                        echo number_format($ledger['amount'], 2, '.', ',');
                                                        $debit += $ledger['amount'];
//                                                         $d = 12;
                                                    } else {
                                                        $debit += '0.00';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="right">
                                                    <?php
                                                    if ($ledger['d_c'] == 'c') {
                                                        echo (($position == 0) ? "$currency " : " $currency");
                                                        echo number_format($ledger['amount'], 2, '.', ',');
                                                        $credit += $ledger['amount'];
                                                    } else {
                                                        $credit += '0.00';
                                                    }
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
                                        <td colspan="4" align="right"><b><?php echo display('grand_total') ?>:</b></td>
                                        <td align="right"><b><?php
                                                echo (($position == 0) ? "$currency " : "$currency");
                                                echo number_format((@$debit), 2, '.', ',');
                                                ?></b>
                                        </td>
                                        <td align="right"><b><?php
                                                echo (($position == 0) ? "$currency " : "$currency");
                                                echo number_format((@$credit), 2, '.', ',');
                                                ?></b>
                                        </td>
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