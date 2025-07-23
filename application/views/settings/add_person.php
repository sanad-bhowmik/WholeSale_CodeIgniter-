<!-- Add Prerson start -->
<div class="content-wrapper removeContentwraper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_person') ?></h1>
            <small><?php echo display('add_person') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('personal_loan') ?></a></li>
                <li class="active"><?php echo display('add_person') ?></li>
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
        <div class="row">
            <div class="col-sm-12">
                <div class="m-b-10 float_right">
                    <?php if ($this->permission->check_label('manage_person')->read()->access()) { ?>
                    <a href="javascript:void(0)" onclick="pageopen('<?php echo base_url('Csettings/manage_person'); ?>')" class="btn btn-success"><?php echo display('manage_person'); ?></a>
                        <?php
                    }
                    if ($this->permission->check_label('add_loan')->create()->access()) {
                        ?>
                    <a href="javascript:void(0)" onclick="pageopen('<?php echo base_url('Csettings/add_loan'); ?>')" class="btn btn-info"><?php echo display('add_loan'); ?></a>
                        <?php
                    }
                    if ($this->permission->check_label('manage_loan')->read()->access()) {
                        ?>
                        <a href="javascript:void(0)" onclick="pageopen('<?php echo base_url('Csettings/manage_loan'); ?>')" class="btn custom_btn custom_fontcolor"><?php echo display('manage_loan'); ?></a>
                        <?php
                    }
                    if ($this->permission->check_label('add_payment')->create()->access()) {
                        ?>
                        <a href="javascript:void(0)" onclick="pageopen('<?php echo base_url('Csettings/add_payment'); ?>')" class="btn btn-warning"><?php echo display('add_payment'); ?></a>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-12">               
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_person') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Csettings/submit_person', array('class' => 'form-vertical', 'id' => 'inflow_entry')) ?>
                    <div class="panel-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label text-right"><?php echo display('name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="name" id="name" required="" placeholder="<?php echo display('name') ?>" tabindex="1" onkeyup="special_character_remove(this.value, 'name')"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-sm-3 col-form-label text-right"><?php echo display('phone') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="phone" id="phone" required="" placeholder="<?php echo display('phone') ?>" tabindex="2" onkeyup="onlynumber_allow(this.value, 'phone')"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-sm-3 col-form-label text-right"><?php echo display('address') ?> <i class="text-danger"></i></label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="address" id="address"  placeholder="<?php echo display('address') ?>" tabindex="3"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="reset" class="btn btn-danger" value="<?php echo display('reset') ?>"  tabindex="4"/>
                                <input type="submit" id="add-deposit" class="btn custom_btn custom_fontcolor" name="add-deposit" value="<?php echo display('save') ?>" tabindex="5"/>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add Prerson end -->



