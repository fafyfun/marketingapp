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
        <h2>Set Xero Accounts</h2>
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

                    $attributes = array('class' => 'form-horizontal', 'id' => 'myform');

                    echo form_open_multipart('', $attributes) ?>

                    <div class="col-sm-12" id="sales_list">
                        <div class="row" id="sales">
                            <div class="form-group col-sm-6"><label class="col-sm-2 control-label">Sales</label>

                                <div class="col-sm-10">

                                    <select id="profile" class="form-control m-b" name="sales_id[]">
                                        <option value="0">Select Code</option>
                                        <?php foreach ($sales as $value) {

                                            echo '<option value="' . $value->AccountID . '_' . $value->Code . '">' . $value->Code . ' - ' . $value->Name . '</option>';


                                        } ?>

                                    </select>
                                </div>

                            </div>
                            <div class="form-group col-sm-6"><label class="col-sm-2 control-label">Name</label>

                                <div class="col-sm-10">

                                    <input type="text" placeholder="Name" name="sales_name[]"
                                           class="form-control">
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-1">
                            <button onclick="addMore()" class="btn btn-primary" type="button">Add More</button>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="col-sm-12" id="expense_list">
                        <div class="row" id="expense">
                        <div class="form-group col-sm-6"><label class="col-sm-2 control-label">Expenses</label>

                            <div class="col-sm-10">

                                <select id="profile" class="form-control m-b" name="expenses_id[]">
                                    <option value="0">Select Code</option>
                                    <?php foreach ($expense as $value) {

                                        echo '<option value="' . $value->AccountID . '_' . $value->Code . '">' . $value->Code . ' - ' . $value->Name . '</option>';


                                    } ?>

                                </select>
                            </div>

                        </div>
                        <div class="form-group col-sm-6"><label class="col-sm-2 control-label">Name</label>

                            <div class="col-sm-10">

                                <input type="text" placeholder="Name" name="expenses_name[]"  class="form-control">
                            </div>

                        </div>

                            </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-1">
                            <button onclick="addExpensesMore()" class="btn btn-primary" type="button">Add More</button>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <div class="col-sm-4">
                            <button class="btn btn-white" type="submit">Cancel</button>
                            <button class="btn btn-primary" type="submit">Save changes</button>
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
                    <h5>Account Codes</h5>

                </div>
                <div class="ibox-content">

                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Account ID</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Account Type</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php $x=1; foreach($accounts as $item){ ?>

                            <tr class="gradeX">
                                <td><?php echo $x ?></td>
                                <td><?php echo $item->account_id ?></td>
                                <td><?php echo $item->account_code ?></td>
                                <td><?php echo $item->account_name  ?></td>
                                <td><?php echo $item->type  ?></td>
                                <td class="center">
                                    <a href="<?php echo base_url()?>xero/deleteAction/<?php echo $item->page_id ?>"><i class="fa fa-remove text-danger"></i></a>
                                    </td>
                            </tr>

                        <?php $x++; } ?>

                        </tbody>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Account ID</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Account Type</th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>

</div>
