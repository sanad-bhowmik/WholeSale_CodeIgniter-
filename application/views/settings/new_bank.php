<!-- Add new bank start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_new_bank') ?></h1>
            <small><?php echo display('add_new_bank') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('bank') ?></a></li>
                <li class="active"><?php echo display('add_new_bank') ?></li>
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
        <!-- New bank -->
        <div class="row">
            <div class="col-sm-12">
                <div class="m-b-10 float_right">
                    <?php if ($this->permission->check_label('bank_transection')->read()->access()) { ?>
                        <a href="javascript:void(0)" onclick="pageopen('<?php echo base_url('Csettings/bank_transaction'); ?>')" class="btn btn-success"><?php echo display('bank_transection'); ?></a>
                        <?php
                    }
                    if ($this->permission->check_label('bank_list')->update()->access()) {
                        ?>
                        <a href="javascript:void(0)" onclick="pageopen('<?php echo base_url('Csettings/bank_list'); ?>')" class="btn custom_btn custom_fontcolor"><?php echo display('bank_list'); ?></a>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_new_bank') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Csettings/add_new_bank', array('class' => 'form-vertical', 'id' => 'insert_deposit')) ?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="bank_name" class="col-sm-3 col-form-label"><?php echo display('bank_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="bank_name" id="bank_name" required="" placeholder="<?php echo display('bank_name') ?>" tabindex='1'  onkeyup="special_character_remove(this.value, 'bank_name')"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ac_name" class="col-sm-3 col-form-label"><?php echo display('ac_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="ac_name" id="ac_name" required="" placeholder="<?php echo display('ac_name') ?>"  tabindex='2' onkeyup="special_character_remove(this.value, 'ac_name')"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ac_no" class="col-sm-3 col-form-label"><?php echo display('ac_no') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="ac_no" id="ac_no" required="" placeholder="<?php echo display('ac_no') ?>"  tabindex='3'/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="branch" class="col-sm-3 col-form-label"><?php echo display('branch') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="branch" id="branch" required="" placeholder="<?php echo display('branch') ?>"  tabindex='4'/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="signature_pic" class="col-sm-3 col-form-label"><?php echo display('signature_pic') ?> <i class="text-danger"></i></label>
                            <div class="col-sm-6">
                                <input type="file" class="form-control" name="signature_pic" id="signature_pic"  placeholder="<?php echo display('signature_pic') ?>"  tabindex='5'/>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="reset" class="btn btn-danger" value="<?php echo display('reset') ?>" />
                                <input type="submit" id="add-deposit" class="btn custom_btn custom_fontcolor" name="add-deposit" value="<?php echo display('save') ?>"  tabindex='6'/>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new bank end -->



