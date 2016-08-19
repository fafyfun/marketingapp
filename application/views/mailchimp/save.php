<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Set MailChimp Account</h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Add API</h5>

            </div>
            <div class="ibox-content">

                <?php if (isset($error) && !empty($error) ) : ?>
                    <div class="col-md-12">
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php

                $attributes = array('class' => 'form-horizontal', 'id' => 'myform');

                echo form_open('', $attributes) ?>

                <div class="form-group">

                    <label class="col-sm-2 control-label">API Key</label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="API Key" name="api_key" class="form-control">
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
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>API List</h5>

            </div>
            <div class="ibox-content">



                <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>API ID</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                  <?php foreach($list as $item){ ?>

                        <tr class="gradeX">
                            <td><?php echo $item->api_key ?></td>
                            <td class="center">
                                <a href="<?php echo base_url()?>mailchimpapp/campaign_list/<?php echo $item->id ?>"><i class="fa fa-search text-navy"></i></a>
                                
                                <a onclick="deleteAcc('<?php echo base_url()?>mailchimpapp/delete_list/<?php echo $item->id  ?>','') " ><i class="fa fa-remove text-danger"></i></a>
                            </td>
                        </tr>

                    <?php } ?>

                    </tbody>
                    <tfoot>
                    <tr>
                        <th>API ID</th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</div>
    </div>


