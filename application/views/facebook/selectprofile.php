<?php
/**
 * Created by PhpStorm.
 * User: fawaz
 * Date: 4/12/16
 * Time: 1:59 PM
 */
?>

    <div class="row">

        <?php if(isset($link)){ ?>
        <div class="col-lg-12">

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                 </div>
                <div class="ibox-content">
                    <a class="btn btn-success btn-facebook" href="<?php echo $link ?>">
                        <i class="fa fa-facebook"> </i> Sign in with Facebook
                    </a>
                </div>
            </div>

        </div>


        <?php }else{ ?>

        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>
                        <small></small>
                    </h5>

                </div>
                <div class="ibox-content">
                    <?php

                    $attributes = array('class' => 'form-horizontal', 'id' => 'myform');

                    echo form_open('', $attributes) ?>
                    <div class="form-group"><label class="col-sm-2 control-label">Page</label>

                        <div class="col-sm-10">

                            <select id="profile" class="form-control m-b" name="page">
                                <?php foreach ($pages as $value) {

                                    echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';


                                } ?>

                            </select>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary" type="submit">Add Page</button>
                            <a class="btn btn-danger btn-facebook" onclick="deleteAcc('<?php echo base_url()?>facebook/removeApp','') " >
                                <i class="fa fa-facebook"> </i> Remove Facebook Account
                            </a>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Added Page List</h5>
                </div>
                <div class="ibox-content">

                    <?php if(!empty($facebookPages)){ ?>

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

                        foreach ($facebookPages as $item) { $i++ ?>

                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $item->page_name ?></td>
                                <td><?php echo $item->page_id ?></td>
                                <td><?php echo ($item->status == 1)? 'Enable' : 'Disable' ?></td>
                                <td class="center">
                                    <a href="<?php echo base_url()?>facebook/details/<?php echo $item->page_id ?>"><i class="fa fa-search text-navy"></i></a>
                                    <a onclick="deleteAcc('<?php echo base_url()?>facebook/deleteAction/<?php echo $item->page_id ?>','') " ><i class="fa fa-remove text-danger"></i></a>
                                </td>
                            </tr>

                        <?php  } ?>

                        </tbody>
                    </table>

                    <?php  } else{ ?>
                        <div class="text-center" >No Data Found</div>
                    <?php  } ?>

                </div>
            </div>
        </div>
    </div>
    <?php } ?>


