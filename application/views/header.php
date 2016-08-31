<?php
/**
 * Created by PhpStorm.
 * User: fawaz
 * Date: 4/1/16
 * Time: 3:43 PM
 */
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Digital Glare | Dashboard</title>

    <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Morris -->
    <link href="<?php echo base_url() ?>assets/css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="<?php echo base_url() ?>assets/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="<?php echo base_url() ?>assets/css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet">

    <!-- Data Tables -->
    <link href="<?php echo base_url() ?>assets/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">

</head>

<body>
<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <!--                  <div class="dropdown profile-element"> <span>
                                              <img alt="image" class="img-circle" src="img/profile_small.jpg" />
                                               </span>
                                          <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                              <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">David Williams</strong>
                                               </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                                          <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                              <li><a href="profile.html">Profile</a></li>
                                              <li><a href="contacts.html">Contacts</a></li>
                                              <li><a href="mailbox.html">Mailbox</a></li>
                                              <li class="divider"></li>
                                              <li><a href="login.html">Logout</a></li>
                                          </ul>
                                      </div>-->
                    <div class="logo-element">
                        DG
                    </div>
                </li>
                <!--                <li <?php /*echo ( $this->router->class =='dashboard')?  'class="active"':'' */ ?> >
                    <a href=""><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li <?php /*echo ( $this->router->class =='dashboard' && $this->router->method == 'index')?  'class="active"':'' */ ?> ><a href="/">Dashboard</a></li>
                        
                    </ul>
                </li>-->
                <li <?php echo ($this->router->class == 'google') ? 'class="active"' : '' ?>>
                    <a href=""><i class="fa fa-google"></i> <span class="nav-label">Google Analytics</span><span
                            class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li <?php echo ($this->router->class == 'google' && $this->router->method == 'index') ? 'class="active"' : '' ?>>
                            <a href="/google/index">Dashboard</a></li>
                        <li <?php echo ($this->router->class == 'google' && $this->router->method == 'getProfileIDs') ? 'class="active"' : '' ?>>
                            <a href="/google/getProfileIDs">Add Accounts</a></li>
                    </ul>
                </li>
                <li <?php echo ($this->router->class == 'facebook') ? 'class="active"' : '' ?>>
                    <a href="#"><i class="fa fa-facebook-square"></i> <span class="nav-label">Facebook</span><span
                            class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li <?php echo ($this->router->class == 'facebook' && $this->router->method == 'dashboard') ? 'class="active"' : '' ?>>
                            <a href="/facebook/dashboard">Dashboard</a></li>
                        <li <?php echo ($this->router->class == 'facebook' && $this->router->method == 'selectProfile') ? 'class="active"' : '' ?>>
                            <a href="/facebook/selectProfile">Add Pages</a></li>
                    </ul>
                </li>
                <li <?php echo ($this->router->class == 'twitter') ? 'class="active"' : '' ?>>
                    <a href="#"><i class="fa fa-twitter-square"></i> <span class="nav-label">Twitter</span><span
                            class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li <?php echo ($this->router->class == 'twitter' && $this->router->method == 'dashboard') ? 'class="active"' : '' ?>>
                            <a href="/twitter/dashboard">Dashboard</a></li>
                        <li <?php echo ($this->router->class == 'twitter' && $this->router->method == 'accounts') ? 'class="active"' : '' ?>>
                            <a href="/twitter/accounts">Add Accounts</a></li>
                    </ul>
                </li>
                <li <?php echo ($this->router->class == 'mailchimpapp') ? 'class="active"' : '' ?>>
                    <a href="#"><i class="fa fa-envelope-o"></i> <span class="nav-label">MailChimp</span><span
                            class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li <?php echo ($this->router->class == 'mailchimpapp' && $this->router->method == 'campaign_list') ? 'class="active"' : '' ?>>
                            <a href="/mailchimpapp/campaign_list">Campaign List</a></li>
                        <li <?php echo ($this->router->class == 'mailchimpapp' && $this->router->method == 'list_forms') ? 'class="active"' : '' ?>>
                            <a href="/mailchimpapp/list_forms">Add Account</a></li>

                    </ul>
                </li>
                <li <?php echo ($this->router->class == 'vision6') ? 'class="active"' : '' ?>>
                    <a href="#"><i class="fa fa-envelope"></i> <span class="nav-label">Vision6</span><span
                            class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li <?php echo ($this->router->class == 'vision6' && $this->router->method == 'campaign_list') ? 'class="active"' : '' ?>>
                            <a href="/vision6/campaign_list">Campaign List</a></li>
                        <li <?php echo ($this->router->class == 'vision6' && $this->router->method == 'account_list') ? 'class="active"' : '' ?>>
                            <a href="/vision6/campaign_list">Account List</a></li>
                        <li <?php echo ($this->router->class == 'vision6' && $this->router->method == 'list_forms') ? 'class="active"' : '' ?>>
                            <a href="/vision6/list_forms">Add Account</a></li>
                    </ul>
                </li>
                <li <?php echo ($this->router->class == 'xero') ? 'class="active"' : '' ?>>
                    <a href="#"><i class="fa fa-money"></i> <span class="nav-label">Xero</span><span
                            class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li <?php echo ($this->router->class == 'xero' && $this->router->method == 'index') ? 'class="active"' : '' ?>>
                            <a href="/xero/">Dashboard</a></li>
                        <li <?php echo ($this->router->class == 'xero' && $this->router->method == 'set_account_type') ? 'class="active"' : '' ?>>
                            <a href="/xero/set_account_type">Set Account Type</a></li>
                        <li <?php echo ($this->router->class == 'xero' && $this->router->method == 'addaccount') ? 'class="active"' : '' ?>>
                            <a href="/xero/addaccount">Connect with Xero</a></li>

                    </ul>
                </li>
                <?php if ($_SESSION['sadmin'] == 1) { ?>
                    <li class="">
                        <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Users</span><span
                                class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                            <li><a href="/users">View Users</a></li>
                            <li><a href="/users/add">Add New User</a></li>
                        </ul>
                    </li>
                <?php } else { ?>

                    <li class="">
                        <a href="#"><i class="fa fa-users"></i> <span class="nav-label">My Account</span><span
                                class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                            <li><a href="/users/profile/">Edit My Account</a></li>

                        </ul>
                    </li>

                <?php } ?>


                <!--            <li>
                               <a href="mailbox.html"><i class="fa fa-envelope"></i> <span class="nav-label">Mailbox </span><span class="label label-warning pull-right">16/24</span></a>
                               <ul class="nav nav-second-level">
                                   <li><a href="mailbox.html">Inbox</a></li>
                                   <li><a href="mail_detail.html">Email view</a></li>
                                   <li><a href="mail_compose.html">Compose email</a></li>
                                   <li><a href="email_template.html">Email templates</a></li>
                               </ul>
                           </li>
                           <li>
                               <a href="widgets.html"><i class="fa fa-flask"></i> <span class="nav-label">Widgets</span> </a>
                           </li>
                           <li>
                               <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Forms</span><span class="fa arrow"></span></a>
                               <ul class="nav nav-second-level">
                                   <li><a href="form_basic.html">Basic form</a></li>
                                   <li><a href="form_advanced.html">Advanced Plugins</a></li>
                                   <li><a href="form_wizard.html">Wizard</a></li>
                                   <li><a href="form_file_upload.html">File Upload</a></li>
                                   <li><a href="form_editors.html">Text Editor</a></li>
                               </ul>
                           </li>
                           <li>
                               <a href="#"><i class="fa fa-desktop"></i> <span class="nav-label">App Views</span>  <span class="pull-right label label-primary">SPECIAL</span></a>
                               <ul class="nav nav-second-level">
                                   <li><a href="contacts.html">Contacts</a></li>
                                   <li><a href="profile.html">Profile</a></li>
                                   <li><a href="projects.html">Projects</a></li>
                                   <li><a href="project_detail.html">Project detail</a></li>
                                   <li><a href="file_manager.html">File manager</a></li>
                                   <li><a href="calendar.html">Calendar</a></li>
                                   <li><a href="faq.html">FAQ</a></li>
                                   <li><a href="timeline.html">Timeline</a></li>
                                   <li><a href="pin_board.html">Pin board</a></li>
                               </ul>
                           </li>
                           <li>
                               <a href="#"><i class="fa fa-files-o"></i> <span class="nav-label">Other Pages</span><span class="fa arrow"></span></a>
                               <ul class="nav nav-second-level">
                                   <li><a href="search_results.html">Search results</a></li>
                                   <li><a href="lockscreen.html">Lockscreen</a></li>
                                   <li><a href="invoice.html">Invoice</a></li>
                                   <li><a href="login.html">Login</a></li>
                                   <li><a href="register.html">Register</a></li>
                                   <li><a href="404.html">404 Page</a></li>
                                   <li><a href="500.html">500 Page</a></li>
                                   <li><a href="empty_page.html">Empty page</a></li>
                               </ul>
                           </li>
                           <li>
                               <a href="#"><i class="fa fa-globe"></i> <span class="nav-label">Miscellaneous</span><span class="label label-info pull-right">NEW</span></a>
                               <ul class="nav nav-second-level">
                                   <li><a href="toastr_notifications.html">Notification</a></li>
                                   <li><a href="nestable_list.html">Nestable list</a></li>
                                   <li><a href="timeline_2.html">Timeline v.2</a></li>
                                   <li><a href="forum_main.html">Forum view</a></li>
                                   <li><a href="google_maps.html">Google maps</a></li>
                                   <li><a href="code_editor.html">Code editor</a></li>
                                   <li><a href="modal_window.html">Modal window</a></li>
                                   <li><a href="validation.html">Validation</a></li>
                               </ul>
                           </li>
                           <li>
                               <a href="#"><i class="fa fa-flask"></i> <span class="nav-label">UI Elements</span><span class="fa arrow"></span></a>
                               <ul class="nav nav-second-level">
                                   <li><a href="typography.html">Typography</a></li>
                                   <li><a href="icons.html">Icons</a></li>
                                   <li><a href="draggable_panels.html">Draggable Panels</a></li>
                                   <li><a href="buttons.html">Buttons</a></li>
                                   <li><a href="video.html">Video</a></li>
                                   <li><a href="tabs_panels.html">Tabs & Panels</a></li>
                                   <li><a href="notifications.html">Notifications & Tooltips</a></li>
                                   <li><a href="badges_labels.html">Badges, Labels, Progress</a></li>
                               </ul>
                           </li>

                           <li>
                               <a href="grid_options.html"><i class="fa fa-laptop"></i> <span class="nav-label">Grid options</span></a>
                           </li>
                           <li>
                               <a href="#"><i class="fa fa-table"></i> <span class="nav-label">Tables</span><span class="fa arrow"></span></a>
                               <ul class="nav nav-second-level">
                                   <li><a href="table_basic.html">Static Tables</a></li>
                                   <li><a href="table_data_tables.html">Data Tables</a></li>
                                   <li><a href="jq_grid.html">jqGrid</a></li>
                               </ul>
                           </li>
                           <li>
                               <a href="#"><i class="fa fa-picture-o"></i> <span class="nav-label">Gallery</span><span class="fa arrow"></span></a>
                               <ul class="nav nav-second-level">
                                   <li><a href="basic_gallery.html">Basic Gallery</a></li>
                                   <li><a href="carousel.html">Bootstrap Carusela</a></li>

                               </ul>
                           </li>
                           <li>
                               <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">Menu Levels </span><span class="fa arrow"></span></a>
                               <ul class="nav nav-second-level">
                                   <li>
                                       <a href="#">Third Level <span class="fa arrow"></span></a>
                                       <ul class="nav nav-third-level">
                                           <li>
                                               <a href="#">Third Level Item</a>
                                           </li>
                                           <li>
                                               <a href="#">Third Level Item</a>
                                           </li>
                                           <li>
                                               <a href="#">Third Level Item</a>
                                           </li>

                                       </ul>
                                   </li>
                                   <li><a href="#">Second Level Item</a></li>
                                   <li>
                                       <a href="#">Second Level Item</a></li>
                                   <li>
                                       <a href="#">Second Level Item</a></li>
                               </ul>
                           </li>
                           <li>
                               <a href="css_animation.html"><i class="fa fa-magic"></i> <span class="nav-label">CSS Animations </span><span class="label label-info pull-right">62</span></a>
                           </li>
                           <li class="landing_link">
                               <a target="_blank" href="Landing_page/index.html"><i class="fa fa-star"></i> <span class="nav-label">Landing Page</span> <span class="label label-warning pull-right">NEW</span></a>
                           </li>
                           <li class="special_link">
                               <a href="package.html"><i class="fa fa-database"></i> <span class="nav-label">Package</span></a>
                           </li>-->
            </ul>

        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <!--                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                                        <form role="search" class="navbar-form-custom" method="post" action="search_results.html">
                                            <div class="form-group">
                                                <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                                            </div>
                                        </form>-->
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <span
                            class="m-r-sm text-muted welcome-message">Welcome <?php echo ucfirst($_SESSION['first_name']); ?></span>
                    </li>
                    <!--                    <li class="dropdown">
                                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                                <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                                            </a>
                                            <ul class="dropdown-menu dropdown-messages">
                                                <li>
                                                    <div class="dropdown-messages-box">
                                                        <a href="profile.html" class="pull-left">
                                                            <img alt="image" class="img-circle" src="img/a7.jpg">
                                                        </a>
                                                        <div class="media-body">
                                                            <small class="pull-right">46h ago</small>
                                                            <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                                            <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <div class="dropdown-messages-box">
                                                        <a href="profile.html" class="pull-left">
                                                            <img alt="image" class="img-circle" src="img/a4.jpg">
                                                        </a>
                                                        <div class="media-body ">
                                                            <small class="pull-right text-navy">5h ago</small>
                                                            <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                                            <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <div class="dropdown-messages-box">
                                                        <a href="profile.html" class="pull-left">
                                                            <img alt="image" class="img-circle" src="img/profile.jpg">
                                                        </a>
                                                        <div class="media-body ">
                                                            <small class="pull-right">23h ago</small>
                                                            <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                                            <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <div class="text-center link-block">
                                                        <a href="mailbox.html">
                                                            <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                                        </a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                                <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                                            </a>
                                            <ul class="dropdown-menu dropdown-alerts">
                                                <li>
                                                    <a href="mailbox.html">
                                                        <div>
                                                            <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                                            <span class="pull-right text-muted small">4 minutes ago</span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="profile.html">
                                                        <div>
                                                            <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                                            <span class="pull-right text-muted small">12 minutes ago</span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="grid_options.html">
                                                        <div>
                                                            <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                                            <span class="pull-right text-muted small">4 minutes ago</span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <div class="text-center link-block">
                                                        <a href="notifications.html">
                                                            <strong>See All Alerts</strong>
                                                            <i class="fa fa-angle-right"></i>
                                                        </a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>-->


                    <li>
                        <a href="http://dashboard.digitalglare.com.au/users/logout">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>

            </nav>
        </div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">

                        <div class="col-lg-6">
                            <h2>
                                <i class="fa <?php echo $breadcrumb['icon'] ?>"></i>
                                <?php if (!empty($breadcrumb['head_url'])) { ?>
                                    <a href="<?php echo base_url().$breadcrumb['head_url'] ?>"/> <?php echo $breadcrumb['title'] ?> </a>
                                    <?php }else{
                                            echo $breadcrumb['title'];
                                    }
                                if (!empty($breadcrumb['sub'])) { ?>
                                <i class="fa fa-angle-double-right"></i> <?php echo $breadcrumb['sub'] ?> </h2>

                            <?php } ?>

                        </div>
                        <?php if (!empty($breadcrumb['date'])) { ?>
                            <div class="col-lg-6">
                                <div class="pull-right">
                                    <?php

                                    $attributes = array('class' => 'form-inline', 'id' => 'myform');

                                    echo form_open('', $attributes) ?>
                                    <div class="form-group" id="data_5">
                                        <label class="font-noraml">Date Range</label>

                                        <div class="input-daterange input-group" id="datepicker">
                                            <input type="text" id="from" class="input-sm form-control" name="start"
                                                   value="<?php echo $showStart ?>">
                                            <span class="input-group-addon">to</span>
                                            <input type="text" id="to" class="input-sm form-control" name="end"
                                                   value="<?php echo $showEnd ?>">
                                        </div>
                                        <button class="btn btn-sm btn-primary" type="submit">Update</button>
                                    </div>

                                    </form>

                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>

        <div class="wrapper wrapper-content">