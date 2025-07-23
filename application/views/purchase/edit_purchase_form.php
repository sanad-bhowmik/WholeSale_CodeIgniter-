<!-- Product Purchase js -->
<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/product_purchase.js.php" ></script>
<!-- Supplier Js -->
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/supplier.js.php" ></script>
<!-- Purchase js -->
<script src="<?php echo base_url() ?>my-assets/js/admin_js/purchase.js" type="text/javascript"></script>


<!-- Edit Purchase Start -->
<div class="content-wrapper removeContentwraper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('purchase_edit') ?></h1>
            <small><?php echo display('purchase_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('purchase') ?></a></li>
                <li class="active"><?php echo display('purchase_edit') ?></li>
            </ol>
        </div>
    </section>

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

        <!-- Purchase report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('purchase_edit') ?></h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Cpurchase/purchase_update', array('class' => 'form-vertical', 'id' => 'purchase_update')) ?>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="description" class="col-sm-3 col-form-label"><?php echo display('supplier') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                        <select name="supplier_id" id="edit_supplier_sss" class="form-control " required=""  tabindex='1'> 
                                            <option value=" "><?php echo display('select_one'); ?></option>
                                            <?php foreach ($all_supplier as $supplier) { ?>
                                                <option value="<?php echo $supplier['supplier_id']; ?>" <?php echo (($supplier_id == $supplier['supplier_id']) ? 'selected' : ''); ?>>
                                                    <?php echo $supplier['supplier_name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div> 
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="purchase_date" class="col-sm-4 col-form-label"><?php echo display('purchase_date') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input type="text" tabindex="2" class="form-control datepicker" name="purchase_date" id="purchase_date" value="{purchase_date}" required />
                                        <input type="hidden" name="purchase_id" value="{purchase_id}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="product_name" class="col-sm-3 col-form-label"><?php echo display('invoice_no') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-9">
                                        <input type="text" tabindex="3" class="form-control" name="chalan_no" placeholder="<?php echo display('invoice_no') ?>" required value="{chalan_no}" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label"><?php echo display('details') ?></label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" tabindex="4" id="adress" name="purchase_details" placeholder=" <?php echo display('details') ?>">{purchase_details}</textarea>
                                    </div>
                                </div> 
                            </div>
                        </div>

                        <div class="table-responsive m-t-10">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?php echo display('item_information') ?></th>
                                        <th class="text-center"><?php echo display('cartoon') ?> </th>
                                        <th class="text-center"><?php echo display('item_cartoon') ?> </th>
                                        <th class="text-center"><?php echo display('quantity') ?> </th>
                                        <th class="text-center"><?php echo display('rate') ?></th>
                                        <th class="text-center"><?php echo display('total') ?></th>
                                        <th class="text-center"><?php echo display('action') ?></th>
                                    </tr>
                                </thead>
                                <?php // d($purchase_info); ?>
                                <tbody id="addPurchaseItem">

                                    <?php
                                    $sl = 0;
                                    foreach ($purchase_info as $purchase) {
                                        $sl++;
                                        ?>
                                        <tr>

                                            <td class="span3 supplier_item_load">     
                                                <?php
//                                                $product_id = {product_id};
                                                ?>
                                                <!--<select name="product_name" id="product_id" class="editproductSelection form-control">--> 
                                                <select name="product_id[]" id="product_id" class="editproductSelection form-control" onchange="editproductSelection(<?php echo $sl; ?>, this.value)"> 
                                                    <option value=" "><?php echo display('select_one'); ?></option>
                                                    <?php foreach ($get_suppliersitems as $item) { ?>
                                                        <option value="<?php echo $item->product_id; ?>" <?php echo (($purchase['product_id'] == $item->product_id) ? 'selected' : ''); ?>>
                                                            <?php echo $item->product_name . " - (" . $item->product_model . ")"; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td class="text-right">
                                                <input type="number" name="cartoon[]" onkeyup="quantity_calculate(<?php echo $sl; ?>);" onchange="quantity_calculate(<?php echo $sl; ?>);" value="<?php echo $purchase['cartoon']; ?>" required  id="qty_item_<?php echo $sl; ?>" class="form-control text-right qty_calculate" min="0" />
                                            </td>
                                            <td class="text-right">   
                                                <input type="text" name="cartoon_item[]" value="<?php echo $purchase['cartoon_quantity']; ?>" readonly="readonly" id="ctnqntt_<?php echo $sl; ?>" class="ctnqntt<?php echo $sl; ?> form-control text-right" />
                                            </td>
                                            <td class="text-right">
                                                <input type="text" name="product_quantity[]" value="<?php echo $purchase['quantity']; ?>" readonly="readonly" id="total_qntt_<?php echo $sl; ?>" class="form-control text-right" />
                                            </td>
                                            <td>
                                                <input type="text" name="product_rate[]"  value="<?php echo $purchase['rate']; ?>" onkeyup="quantity_calculate(<?php echo $sl; ?>);" onchange="quantity_calculate(<?php echo $sl; ?>);" id="price_item_<?php echo $sl; ?>" class="form-control price_item<?php echo $sl; ?> text-right" min="0" />
                                            </td>
                                            <td class="text-right">
                                                <input class="form-control total_price text-right" type="text" name="total_price[]" id="total_price_<?php echo $sl; ?>" value="<?php echo $purchase['total_amount']; ?>" tabindex="-1" readonly="readonly" />
                                            </td>
                                            <td>
                                                <button class="btn btn-danger text-right" type="button" value="Delete" onclick="deleteRow(this)" tabindex="7"><?php echo display('delete') ?></button>
                                                <input type="hidden" name="purchase_detail_id[]" value="<?php echo $purchase['purchase_detail_id']; ?>"/>
                                            </td> 
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3">
                                            <?php echo display('if_you_update_purchase_first_select_supplier_then_product_and_then_cartoon') ?>                        
                                        </td>
                                        <td>
                                            <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url(); ?>"/>
                                        </td>
                                        <td class="text-right"><b><?php echo display('grand_total') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="grandTotal" value="{grand_total}" tabindex="-1" class="text-right form-control" name="grand_total_price" tabindex="-1" value="0.00" readonly="readonly" />
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <input type="submit" id="add-purchase" class="btn custom_btn custom_fontcolor btn-large" name="add-purchase" value="<?php echo display('save_changes') ?>" tabindex="8" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit Purchase End -->

<script src="<?php echo base_url() ?>assets/js/purchase.js" type="text/javascript"></script>
