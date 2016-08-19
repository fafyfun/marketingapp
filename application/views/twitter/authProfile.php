<?php
/**
 * Created by PhpStorm.
 * User: fawaz
 * Date: 4/12/16
 * Time: 1:59 PM
 */
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Twitter Account</h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">

        <?php if(isset($url)){ ?>
            <div class="col-lg-12">

                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Authenticate Twitter Account
                            <small>Register tiwtter account with our app</small>
                        </h5>

                    </div>
                    <div class="ibox-content">
                        <a class="btn btn-success btn-twitter" href="<?php echo $url ?>">
                            <i class="fa fa-twitter"> </i> Add Twitter Account
                        </a>
                    </div>
                </div>

            </div>


        <?php } ?>

    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Added Account List</h5>
                </div>
                <div class="ibox-content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Account ID</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php

                        $i = 0;

                        foreach ($selectAccount as $item) { $i++ ?>

                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $item->twitter_name ?></td>
                                <td><?php echo $item->twitter_id ?></td>
                                <td><?php echo ($item->status == 1)? 'Enable' : 'Disable' ?></td>
                                <td class="center">
                                    <a onclick="deleteAcc('<?php echo base_url()?>twitter/deleteAccount/<?php echo $item->twitter_id ?>','') " ><i class="fa fa-remove text-danger"></i></a>

                                </td>
                            </tr>

                        <?php  } ?>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
