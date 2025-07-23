<!-- Manage Category Start -->
<div class="content-wrapper removeContentwraper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('hrm') ?></h1>
            <small><?php echo display('manage_employee') ?></small>
            <ol class="breadcrumb">
                <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('hrm') ?></a></li>
                <li class="active"><?php echo display('manage_employee') ?></li>
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
                <div class="m-b-10">
                    <?php if ($this->permission->check_label('add_employee')->create()->access()) { ?>
                    <a href="javascript:void(0)" onclick="pageopen('<?php echo base_url('Chrm/add_employee'); ?>')" class="btn custom_btn custom_fontcolor"><?php echo display('add_employee'); ?></a>
                    <?php } 
                    if($this->permission->check_label('manage_employee')->read()->access()){
                    ?>
                    <a href="javascript:void(0)" onclick="pageopen('<?php echo base_url('Chrm/manage_employee'); ?>')" class="btn btn-info"><?php echo display('manage_employee'); ?></a>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="card-header">
                    <?php $image = base_url($image); ?>
                    <div> <?php echo "<img src='" . $image . "' width=100px; height=100px; class=img-circle>"; ?></div>
                </div>
                <div class="card-content">
                    <div class="card-content-member">
                        <h4 class="m-t-0"><?php echo $first_name . "  " . $last_name; ?></h4>
                        <h5><?php echo display('designation') ?>: <?php echo $designation; ?></h5>
                        <p class="m-0"><i class="fa fa-mobile" aria-hidden="true"></i>
                            <?php echo $phone; ?></p>
                    </div>
                    <div class="card-content-languages">
                        <div class="card-content-languages-group"></div>
                        <div class="card-content-languages-group">
                            <table class="table table-hover" width="100%">
                                <caption class="text-center t-s-25"><?php echo display('personal_information') ?>s</caption>
                                <tr>
                                    <th><?php echo display('name') ?></th>
                                    <td><?php echo $first_name . " " . $last_name; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo display('phone') ?></th>
                                    <td><?php echo $phone; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo display('email') ?></th>
                                    <td><?php echo $email; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo display('country') ?></th>
                                    <td><?php echo $country; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo display('city') ?></th>
                                    <td><?php echo $city; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo display('zip') ?></th>
                                    <td><?php echo $zip; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="card-footer-stats">
                            <div>
                                <p></p><span class="stats-small"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-8">
                <div class="row">
                    <div class="col-sm-12 col-md-12 rating-block" >
                        <table class="table table-hover" width="100%">
                            <caption class="text-center f-s-25"><?php echo display('positional_information') ?></caption>
                            <tr>
                                <th><?php echo display('designation') ?></th>
                                <td><?php echo $designation; ?></td>
                            </tr>
                            <tr>
                                <th><?php echo display('phone') ?></th>
                                <td><?php echo $phone; ?></td>
                            </tr>
                            <tr>
                                <th><?php echo display('salary') ?></th>
                                <td><?php echo $hrate; ?></td>
                            </tr>
                        </table>      
                    </div>  
                </div> 
            </div>
        </div> 
    </section>
</div>




