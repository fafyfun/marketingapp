<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Add Account Info</h5>


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

                <div class="form-group <?php echo (form_error('api_key')?'has-error':''); ?> ">
                    <label class="col-sm-2 control-label">API Key (*)</label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="API Key" name="api_key" value="<?php echo set_value('api_key'); ?>" class="form-control">
                        <span class="help-block m-b-none">API Keys are necessary for integrating your account with other dashboard app, If you need more details <a target="_blank" href="http://developers.vision6.com.au/3.0/guide/getting-started">Click here</a></span>
                    </div>



                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group <?php echo (form_error('list_id')?'has-error':''); ?>">

                    <label class="col-sm-2 control-label">List Id (*)</label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="List Id" value="<?php echo set_value('list_id'); ?>" name="list_id" class="form-control">
                        <span class="help-block m-b-none">The ID of the List</span>

                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">

                    <label class="col-sm-2 control-label">List Name</label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="List Name" value="<?php echo set_value('list_name'); ?>" name="list_name" class="form-control">
                        <span class="help-block m-b-none">List Name, This is optional</span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">

                    <label class="col-sm-2 control-label">Folder Name</label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="Folder Name" value="<?php echo set_value('folder_name'); ?>" name="folder_name" class="form-control">
                        <span class="help-block m-b-none">Folder Name, This is optional</span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>


                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                     <button class="btn btn-primary" type="submit">Add List</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>


