<!-- Product js php -->
<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/product.js.php" ></script>

<!-- Stock report start -->
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        document.body.style.marginTop = "0px";
        document.getElementsByClassName("dt-buttons btn-group")[0].style.display = "none";
        window.print();
        document.body.innerHTML = originalContents;
        document.location.href = '<?php echo base_url('Creport/stock_report_product_wise/1'); ?>';
    }
</script>
<?php
$CI = & get_instance();
$CI->load->library('Occational');
?>
<!-- Stock List Supplier Wise Start -->
<div class="content-wrapper removeContentwraper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('stock_report_product_wise') ?></h1>
            <small><?php echo display('stock_report_product_wise') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('stock') ?></a></li>
                <li class="active"><?php echo display('stock_report_product_wise') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">
        <!-- Manage Product report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body"> 
                        <?php echo form_open('Creport/stock_report_product_wise/2', array('class' => 'form-vertical', 'id' => 'stock_report_product_wise')); ?>
                        <?php
                        date_default_timezone_set("Asia/Dhaka");
                        $today = date('Y-m-d');
                        ?>

                        <div class="form-group row">
                            <label for="supplier_id" class="col-sm-3 col-form-label"><?php echo display('select_supplier') ?>: <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="supplier_id" name="supplier_id" required="">
                                    <option value=""><?php echo display('select_one') ?></option>
                                    {supplier_list}
                                    <option value="{supplier_id}">{supplier_name} </option>
                                    {/supplier_list}
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="product_id" class="col-sm-3 col-form-label"><?php echo display('select_product') ?>: <i class="text-danger"></i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="product_id" name="product_id">

                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="from_date" class="col-sm-3 col-form-label"><?php echo display('from') ?>: <i class="text-danger"></i></label>
                            <div class="col-sm-6">
                                <input type="text" id="from_date" name="from_date" value="" class="datepicker form-control"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="to_date" class="col-sm-3 col-form-label"><?php echo display('to') ?>: <i class="text-danger"></i></label>
                            <div class="col-sm-6">
                                <input type="text" id="to_date" name="to_date" value="" class="datepicker form-control "/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn custom_btn custom_fontcolor"><?php echo display('search') ?></button>
                                <a  class="btn btn-warning" href="#" onclick="printDiv('printableArea')"><?php echo display('print') ?></a>
                            </div>
                        </div>

                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title printbtn">
                            <h4><?php echo display('stock_report_product_wise') ?></h4>
                            <div class="">
                                <a href="<?php echo base_url('Creport/stock_report_product_wise/1'); ?>" class="btn custom_btn custom_fontcolor m-r-5"><?php echo display('all'); ?></a>
                                <a  class="btn btn-success" href="#" onclick="printDiv('printableArea')"><i class="fa fa-print text-white"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="printableArea m-l-2">
                            <div class="text-center">
                                <?php
                                if ($supplier_info) {
                                    ?>
                                    {supplier_info}
                                    <h3> {supplier_name} </h3>
                                    <h4><?php echo display('address') ?> : {address} </h4>
                                    <h4 ><?php echo display('phone') ?> : {mobile} </h4>
                                    {/supplier_info}
                                    <h4><?php echo display('product_name') ?>:{product_name}</h4>
                                    <?php
                                }
                                ?>	
                                <h4>
                                    <?php echo display('stock_date') ?> : <?php echo $CI->occational->dateConvertMyformat($date); ?>
                                </h4>
                                <h4><?php echo display('print_date') ?>: <?php echo date("Y-m-d h:i:s"); ?> </h4>
                            </div>

                            <div class="table m-t-10">
                                <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="5%"><?php echo display('date') ?></th>
                                            <th class="text-center" width="10%"><?php echo display('product') ?></th>
                                            <th class="text-center" width="10%"><?php echo display('price') ?></th>
                                            <th class="text-center" width="10%"><?php echo display('quantity_per_cartoon') ?></th>
                                            <th class="text-center" width="5%"><?php echo display('in_ctn') ?></th>
                                            <th class="text-center" width="10%"><?php echo display('out_ctn') ?></th>
                                            <th class="text-center" width="10%"><?php echo display('in_quantity') ?></th>
                                            <th class="text-center" width="10%"><?php echo display('out_quantity') ?></th>
                                            <th class="text-center" width="10%"><?php echo display('total_purchase_tk') ?></th>
                                            <th class="text-center" width="10%"><?php echo display('total_sales_tk') ?></th>
                                            <th class="text-center" width="10%"><?php echo display('stock') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
//                                        dd($stok_report);
                                        if ($stok_report) {
                                            ?>
                                            {stok_report}
                                            <tr>
                                                <td>{date}</td>
                                                <td align="center">
                                                    <a href="<?php echo base_url() . 'Cproduct/product_details/{product_id}'; ?>">{product_name} ( {product_model} )</a>	
                                                </td>
                                                <td class="text-right"><?php echo (($position == 0) ? "$currency {supplier_price}" : "{supplier_price} $currency") ?></td>
                                                <td align="center">{cartoon_quantity}</td>
                                                <td align="center">{totalPrhcsCtn}</td>
                                                <td align="center">{totalSalesCtn}</td>
                                                <td>{totalPurchaseQnty}</td>
                                                <td class=''>{totalSalesQnty}</td>
                                                <td class='text-right'><?php echo (($position == 0) ? "$currency {in_taka}" : "{in_taka} $currency") ?></td>
                                                <td class='text-right'><?php echo (($position == 0) ? "$currency {out_taka}" : "{out_taka} $currency") ?></td>
                                                <td align="center">{SubTotalStock}</td>
                                            </tr>
                                            {/stok_report}
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" align="right"><b><?php echo display('grand_total') ?>:</b></td>

                                            <td><td align="center"><b>{sub_total_in}</b></td></td>

                                            <td align="center"><b>{sub_total_out}</b></td>

                                            <td class='text-center'><b>{SubTotalinQnty}</b></td>

                                            <td class='text-center'><b>{SubTotaloutQnty}</b></td>

                                            <td><b><?php echo (($position == 0) ? "$currency {sub_total_in_taka}" : "{sub_total_in_taka} $currency") ?></b></td>

                                            <td><b><?php echo (($position == 0) ? "$currency {sub_total_out_taka}" : "{sub_total_out_taka} $currency") ?></b></td>

                                            <td align="center"><b>{sub_total_stock}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="text-right"><?php echo $links ?></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Stock List Supplier Wise End -->

<!-- Stock Product By Supplier -->
<script type="text/javascript">
    $('#supplier_id').change(function (e) {
        var supplier_id = $(this).val();
        $.ajax({
            type: "post",
            async: false,
            url: '<?php echo base_url('Creport/get_product_by_supplier') ?>',
            data: {supplier_id: supplier_id},
            success: function (data) {
                if (data) {
                    $("#product_id").html(data);
                } else {
                    $("#product_id").html("Product not found !");
                }
            },
            error: function () {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    });
    $(".datepicker").datepicker({dateFormat: 'yy-mm-dd'});
</script>