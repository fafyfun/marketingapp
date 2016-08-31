<?php if (empty($list)) { ?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Add API</h5>

            </div>
            <div class="ibox-content">

                <?php if (isset($error) && !empty($error)) : ?>
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

                    <div class="col-sm-8">
                        <input type="text" placeholder="API Key" name="api_key" class="form-control">

                    </div>
                    <div class="tooltip-demo col-sm-2">
                        <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="bottom"
                                data-content="Once logged in to MailChimp, click on the Account Name at the top of the left hand side bar and select Account Settings.
                                Click on Extras and a drop down will appear. From here, select API Keys. Under Your API Keys you'll find your API Key listed in the table below."
                                data-original-title="" title="" aria-describedby="popover685511">
                            ?
                        </button>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <input type="hidden" id="namePro" name="namePro" value="">
                        <button class="btn btn-primary" type="submit">Add Account</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php  } else { ?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>API List</h5>

            </div>
            <div class="ibox-content">


                <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                    <tr>
                        <th>API ID</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($list as $item) { ?>

                        <tr class="gradeX">
                            <td><?php echo $item->api_key ?></td>
                            <td class="center">
                                <a href="<?php echo base_url() ?>mailchimpapp/campaign_list/<?php echo $item->id ?>"><i
                                        class="fa fa-search text-navy"></i></a>

                                <a onclick="deleteAcc('<?php echo base_url() ?>mailchimpapp/delete_list/<?php echo $item->id ?>','') "><i
                                        class="fa fa-remove text-danger"></i></a>
                            </td>
                        </tr>

                    <?php } ?>
                </table>

            </div>
        </div>
    </div>
</div>

<?php  } ?>



