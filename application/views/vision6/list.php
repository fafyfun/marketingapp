<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Add Account Info</h5>


            </div>
            <div class="ibox-content">
                <?php

                $attributes = array('class' => 'form-horizontal', 'id' => 'myform');

                echo form_open('', $attributes) ?>

                <div class="form-group">

                    <label class="col-sm-2 control-label">API Key (*)</label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="API Key" name="api_key" class="form-control">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">

                    <label class="col-sm-2 control-label">List Id (*)</label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="List Id" name="list_id" class="form-control">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">

                    <label class="col-sm-2 control-label">List Name (*)</label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="List Name" name="list_name" class="form-control">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">

                    <label class="col-sm-2 control-label">Folder Name (*)</label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="Folder Name" name="folder_name" class="form-control">
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
                <h5>Account List</h5>

            </div>
            <div class="ibox-content">

                <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>List Name</th>
                        <th>List ID</th>
                        <th>Folder Name</th>
                        <th>Contact Count</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($list as $item){ ?>

                        <tr class="gradeX">
                            <td><?php echo $item['name'] ?></td>
                            <td><?php echo $item['id'] ?></td>
                            <td><?php echo $item['folder_name']  ?></td>
                            <td><?php echo $item['contact_count'] ?></td>
                            <td class="center"><a href="<?php echo base_url()?>vision6/list_contact/<?php echo $item['id'] ?>"><i class="fa fa-search text-navy"></i></a>
                                <a onclick="deleteAcc('<?php echo base_url()?>vision6/delete_list/<?php echo $item['id'] ?>','') " ><i class="fa fa-remove text-danger"></i></a>

                            </td>
                        </tr>

                    <?php } ?>

                    </tbody>
                    <tfoot>
                    <tr>
                        <th>List Name</th>
                        <th>List ID</th>
                        <th>Folder Name</th>
                        <th>Contact Count</th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</div>


