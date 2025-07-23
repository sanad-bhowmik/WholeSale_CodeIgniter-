<!-- Supplier Details Start -->
<div class="content-wrapper removeContentwraper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('supplier_details') ?></h1>
            <small><?php echo display('manage_your_supplier_details') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('supplier') ?></a></li>
                <li class="active"><?php echo display('supplier_details') ?></li>
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


        <!-- Manage Supplier -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('supplier_ledger') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="text-center">
                            <h3>{supplier_name}</h3>
                            <h4>{supplier_mobile}</h4>
                            <h5>{supplier_address}</h5>
                        </div>
                        <div class="table-responsive">
                            <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo display('date') ?></th>
                                        <th><?php echo display('invoice_no') ?></th>
                                        <th><?php echo display('details') ?></th>
                                        <th class="text-right"><?php echo display('ammount') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($purchase_info) {
                                        ?>
                                        {purchase_info}
                                        <tr>
                                            <td>{final_date}</td>
                                            <td>
                                                <a href="<?php echo base_url() . 'Cpurchase/purchase_details_data/{purchase_id}'; ?>">
                                                    {chalan_no}
                                                </a>
                                            </td>
                                            <td>{purchase_details}</td>
                                            <td class="text-right"><?php echo (($position == 0) ? "$currency {grand_total_amount}" : "{grand_total_amount} $currency") ?></td>
                                        </tr>
                                        {/purchase_info}
                                        <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right"><b><?php echo display('grand_total') ?>:</b></td>
                                        <td class="text-right"><b><?php echo (($position == 0) ? "$currency {total_amount}" : "{total_amount} $currency") ?></b></td>
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
<!-- Supplier Details End  -->