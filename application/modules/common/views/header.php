<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?php echo !empty($title)? 'Time Track Online Portal - '.$title:'Time Track Online Portal'; ?>  
    </title>
    <link href="<?php echo base_url('assets/fonts/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/plugins/material/material.min.css'); ?>" rel="stylesheet" >
    <link href="<?php echo base_url('assets/css/material_style.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" type="text/css" />    
    <link href="<?php echo base_url('assets/css/plugins.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/responsive.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/page.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/jquery.growl.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/select2.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/select2-bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">-->
    <link href="<?php echo base_url('assets/css/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-datetimepicker.min.css'); ?>">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">

    <script type="text/javascript">
        var base_url = "<?php echo base_url(); ?>";
    </script>
    <link href="<?php echo base_url('assets/css/responsive.css'); ?>" rel="stylesheet" type="text/css" />
    
    <script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
    
</head>
<body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white dark-color logo-dark">

    <div class="page-wrapper">
        <div class="page-header navbar navbar-fixed-top">
            <div class="page-header-inner ">
                <div class="page-logo">
                    <a href="<?php echo base_url('dashboard'); ?>">
                    <span class="logo-default"><img alt="" src="<?php echo base_url('assets/img/logo.png'); ?>"></span>
                    </a>
                </div>
                <ul class="nav navbar-nav navbar-left in" data-toggle="tooltip" title="Expand/Collapse">
                    <li><a href="#" class="menu-toggler sidebar-toggler font-size-20"><i class="fa fa-exchange" aria-hidden="true"></i></a></li>
                </ul>
                <ul class="nav navbar-nav navbar-left in" data-toggle="tooltip" title="Full View">
                    <li><a href="javascript:;" class="fullscreen-click font-size-20"><i class="fa fa-arrows-alt"></i></a></li>
                </ul>
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                    <span></span>
                </a>
                <div class="p-t-05 p-l-20 float-left">
                    <h4><strong>Time Track Online Portal</strong></h4>
                </div>
                <div class="top-menu">

                    <ul class="nav navbar-nav pull-right">
                        <?php if( !empty($this->session->userdata('menu') ) ): ?>
                            <?php foreach ($this->session->userdata('menu') as $menu) :?>
                                <?php if( $menu->{MENU_LINK} == 'notification' ): ?>
                                    <li class="dropdown dropdown-extended dropdown-notification" data-toggle="tooltip" title="Notifications">
                                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                            <i class="material-icons">notifications</i>
                                            <span class="notify"></span>
                                        </a>
                                        
                                        <ul class="dropdown-menu">
                                            <li class="external">
                                                <h3><span class="bold">Notifications</span></h3>
                                                <span class="notify" >
                                                    
                                                </span>
                                            </li>
                                            <li>
                                                <ul class="dropdown-menu-list small-slimscroll-style" data-handle-color="#637283" id="notify_list">
                                                
                                                 
                                                </ul>
                                                <div class="dropdown-menu-footer">
                                                    <a id="show_notifications" class="show_notifications" href="<?php echo base_url( 'notification' ); ?>"> All notifications </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                <?php endif; ?> 
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <li class="dropdown dropdown-user" data-toggle="tooltip" title="My Profile" data-placement="left">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <?php if ( ! empty($this->session->userdata('profile_pic')) ) : ?>
                                    <img alt="" class="img-circle " src="<?php echo base_url( 'uploads/profileimages/'.$this->session->userdata('profile_pic') ); ?>">
                                <?php else : ?>
                                    <img alt="" class="img-circle " src="<?php echo base_url( 'assets/img/prof.png' ); ?>">
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                               <li>
                                    <a href="<?php echo base_url( 'my_account' ); ?>">
                                        <i class="fa fa-user"></i> My Account </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('admin_masters/change_password'); ?>">
                                        <i class="fa fa-key"></i> Change Password
                                    </a>
                                </li>
                                <?php if ($this->session->userdata('total_roles') != 1) : ?>
                                    <li>
                                        <a href="<?php echo base_url('select_user_role'); ?>">
                                            <i class="fa fa-cogs"></i> Change Role
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-quick-sidebar-toggler" data-toggle="tooltip" title="Logout">
                             <a href="<?php echo (base_url('logout')) ?>" id="headerSettingButton" class="mdl-button mdl-js-button mdl-button--icon pull-right" data-upgraded=",MaterialButton">
                               <i class="material-icons">logout</i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="page-container">
            <div class="sidebar-container">
                <div class="sidemenu-container navbar-collapse collapse fixed-menu">
                    <div id="remove-scroll" class="left-sidemenu">
                        <ul class="sidemenu  page-header-fixed slimscroll-style" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                            <li class="sidebar-toggler-wrapper hide">
                                <div class="sidebar-toggler">
                                    <span></span>
                                </div>
                            </li>
                            <li class="sidebar-user-panel">
                                <div class="user-panel">
                                    <div class="pull-left image">
                                        <?php if(!empty($this->session->userdata('profile_pic'))) : ?>
                                        <style type="text/css">
                                            .image {
                                                background: url("<?php echo base_url( 'uploads/profileimages/'.$this->session->userdata('profile_pic') ); ?>") center center no-repeat;
                                                background-size: contain;
                                                width: 75px;
                                                height: 75px;
                                            }
                                        </style>
                                            &nbsp;
                                        <?php else : ?>
                                           <img src="<?php echo base_url( 'assets/img/prof.png' ); ?>" class="img-circle user-img-circle" alt="User Image"> 
                                        <?php endif; ?>
                                    </div>
                                    <div class="pull-left info">
                                        <p>
                                            <?php echo $this->session->userdata('username'); ?>
                                            <?php //print_r($_SESSION); ?>

                                            <?php 
                                                if ( $this->session->userdata('associate_id') ) 
                                                {
                                                    
                                                    $html = '<div class="small">Organizational Unit : <br/>'.$this->session->userdata('org_unit').'</div><br/><div class="small">Functional Area : <br/>'.$this->session->userdata('fun_area').'</div><br/><div class="small">Job Title : <br/>'.$this->session->userdata('job_title').'</div><br/><div class="small">Department : <br/>'.$this->session->userdata('dept').'</div>'; 
                                                }
                                                else
                                                {
                                                    $html = '<div class="small">Organizational Unit :<br/> None</div><br/><div class="small">Functional Area :<br/> None</div><br/><div class="small">Job Title :<br/> None</div><br/><div class="small">Department :<br/> None</div><br/>';
                                                }
                                            ?>
                                            <!-- <i id="user_info" class="fa fa-info-circle" data-container="body" data-toggle="popover" data-placement="left" data-content='<?php //echo $html; ?>'></i>  -->  

                                        </p>
                                        <small><?php echo $this->session->userdata('role_name'); ?></small>
                                    </div>
                                </div>
                            </li>
                               
                            <?php if( !empty($this->session->userdata('menu') ) ): //print_r($this->session->userdata('menu'));exit();?>
                                <?php foreach ($this->session->userdata('menu') as $menu) :?>
                                    <?php if ( empty($menu->parent_id) ) : ?>
                                        <?php $url = $this->uri->segment(1).'/'.$this->uri->segment(2); ?>
                                        <li class="nav-item <?php if($this->uri->segment(1)== $menu->{MENU_LINK} ){echo 'active';} elseif($url == $menu->{MENU_LINK}) { echo 'active'; }?> ">
                                            <?php if( $menu->{MENU_LINK} != '' ): ?>
                                                <a href="<?php echo base_url( $menu->{MENU_LINK} ); ?>" class="nav-link nav-toggle"><i class="material-icons"><?= $menu->{MENU_ICON}; ?></i>
                                                <span class="title"><?= $menu->{MENU_NAME} ?></span></a>
                                            <?php else: ?>
                                                <a href="javascript:void(0);" class="nav-link nav-toggle"><i class="material-icons"><?= $menu->{MENU_ICON}; ?></i>
                                                <span class="title"><?= $menu->{MENU_NAME} ?></span></a>
                                                <ul class="sub-menu">
                                            <?php endif; ?>
                                            <?php foreach ($this->session->userdata('menu') as $menu1) : ?>
                                                <?php if ( ! empty($menu1->parent_id) && $menu->menu_id == $menu1->parent_id ) : ?>
                                                    <!-- <ul class="sub-menu"> -->
                                                        <li class="nav-item  "> <a href="<?php echo base_url( $menu1->{MENU_LINK} ); ?>" class="nav-link nav-toggle"><i class="material-icons"><?= $menu1->{MENU_ICON}; ?></i>
                                                        <span class="title"><?= $menu1->{MENU_NAME} ?></span></a> </li>
                                                    <!-- </ul> -->
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php if( $menu->{MENU_LINK} == '' ): ?>
                                            </ul>
                                            <?php endif; ?>
                                        </li>
                                    <? else: ?>

                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif;?>
                            
                        </ul>
                    </div>
                </div>
            </div>
            <div class="page-content-wrapper">
                <div class="page-content">
                                            
        