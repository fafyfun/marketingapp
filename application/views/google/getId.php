<?php
/**
 * Created by PhpStorm.
 * User: fawaz
 * Date: 4/8/16
 * Time: 10:34 AM
 */



?>

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Select Google Profile</h2>

                </div>
                <div class="col-lg-2">

                </div>
</div>
        <div class="wrapper wrapper-content animated fadeInRight">

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <?php

                            if(isset($profile['error'])){
                                if(isset($profile['error']['message']))
                                    echo' <h5><small>'.$profile['error']['message'].'</small></h5>';
                                else
                                    echo' <h5><small>There was an issue, Please remove the account and access again</small></h5>';
                            }
                            ?>

                            <!--<div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#">Config option 1</a>
                                    </li>
                                    <li><a href="#">Config option 2</a>
                                    </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>-->
                        </div>
                        <div class="ibox-content">
                            <?php

                            if(isset($profile['error'])){
                           echo'
                    <a class="btn btn-success btn-facebook" href="'.base_url().'google/revokeToken">
                        <i class="fa fa-google"> </i> Remove Google Account
                    </a>
                ';
                            }else{

                            if(!empty($profile)){

                            $attributes = array('class' => 'form-horizontal', 'id' => 'myform');

                            echo form_open('',$attributes) ?>
                                <div class="form-group"><label class="col-sm-2 control-label">Account</label>

                                    <div class="col-sm-10">

                                        <select id="profile" class="form-control m-b" name="profile">

                                            <?php foreach ($profile as $value){

                                                echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';


                                            }?>

                                    </select>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group"><label class="col-sm-2 control-label">Property</label>

                                    <div class="col-sm-10">

                                        <select id="property" class="form-control m-b" name="property">

                                        </select>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <input type="hidden" id="namePro" name="namePro" value="">
                                        <button class="btn btn-white" type="submit">Cancel</button>
                                        <button class="btn btn-primary" type="submit">Save changes</button>
                                    </div>
                                </div>
                            </form>
                            <?php
                            }else{
                                echo'
                    <a class="btn btn-success btn-facebook" href="'.base_url().'/google/callback">
                        <i class="fa fa-google"> </i> Authenticate Google Account
                    </a>
                ';
                            }
                            }?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Added Profile List</h5>
                        </div>
                        <div class="ibox-content">

                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Account ID</th>
                                    <th>Web ID</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php

                                $i = 0;

                                foreach ($selectProfile as $item) { $i++ ?>

                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo $item->namePro ?></td>
                                        <td><?php echo $item->account_id ?></td>
                                        <td><?php echo $item->web_id ?></td>
                                        <td><?php echo ($item->status == 1)? 'Enable' : 'Disable' ?></td>
                                        <td class="center">
                                            <a href="<?php echo base_url()?>google/details/<?php echo $item->web_id ?>"><i class="fa fa-search text-navy"></i></a>
                                            <a onclick="deleteAcc('<?php echo base_url()?>google/deleteAcc/<?php echo $item->web_id ?>','') " ><i class="fa fa-remove text-danger"></i></a>
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

