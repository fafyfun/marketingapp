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
        <h2>Add Xero Credentials</h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">

            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>
                            <small></small>
                        </h5>

                    </div>
                    <div class="ibox-content">
                        <?php

                        if(!empty($account)){   ?>
                                                <table class="table">
                        <thead>
                        <tr>

                            <th>Name</th>
                            <th>Account ID</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>



                            <tr>
                                <td><?php echo $acc_name ?></td>
                                <td><?php echo $account->consumer_key ?></td>
                                <td><?php echo ($account->status == 1)? 'Enable' : 'Disable' ?></td>
                                <td class="center">

                                    <a href="<?php echo base_url()?>xero/deleteAction/<?php echo $account->id ?>"><i class="fa fa-remove text-danger"></i></a
                                </td>
                            </tr>


                        </tbody>
                    </table>
                        <? }else{
                        $attributes = array('class' => 'form-horizontal', 'id' => 'myform');

                        echo form_open_multipart('', $attributes) ?>
                        <div class="form-group"><label class="col-sm-2 control-label">Consumer Key</label>

                            <div class="col-sm-10">

                                <input type="text" placeholder="Consumer Key" name="consumer_key" class="form-control">

                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group"><label class="col-sm-2 control-label">Shared Secret</label>

                            <div class="col-sm-10">

                                <input type="text" placeholder="Shared Secret" name="shared_secret" class="form-control">

                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group"><label class="col-sm-2 control-label">(.pem) File</label>

                            <div class="col-sm-10">

                                <input type='file' name='userpem' size='20' />

                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group"><label class="col-sm-2 control-label">(.cer) File</label>

                            <div class="col-sm-10">

                                <input type='file' name='uercer' size='20' />

                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-white" type="submit">Cancel</button>
                                <button class="btn btn-primary" type="submit">Save changes</button>
                            </div>
                        </div>
                        </form>
                       <?php } ?>

                    </div>
                </div>
            </div>

    </div>
</div>
