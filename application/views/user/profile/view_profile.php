<?php
/**
 * Created by PhpStorm.
 * User: indika
 * Date: 11/10/15
 * Time: 3:21 PM
 */

?>

<div class="container">

    <div class="row well">

        <div class="col-lg-12 well">
            <ul class="profile">
                <li><img src="<?php echo base_url(); ?>assets/images/user.jpg" class="img-rounded img-responsive user"> </li>
                <li class="name"><?php echo $userDetails->fName.' '. $userDetails->lName ?></li>
 <!--               <li class="detail">General</li>
                <li class="detail">files</li>
                <li class="detail">tasks</li>
                <li class="detail">calendar</li>
                <li class="detail">Conversation</li>
                <li class="detail">Photo</li>-->
                <li class="detail"><a onclick="enableEdit()"><span class="glyphicon glyphicon-edit"></span> Edit Profile</a></li>

            </ul>
        </div>
        <?php if (validation_errors()) : ?>
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <?php echo validation_errors() ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if (isset($error)) : ?>
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <?php echo $error ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-md-3">
            <img src="<?php echo base_url(); ?>assets/images/user.jpg" class="img-rounded img-responsive user">
        </div>
        <div class="col-md-9">
            <br>
            <div id="updateProfileSection" style="<?php echo ((empty($userDetails->fName) || $has_error)?"display:hide":"display:none") ?>">


            <?php echo form_open_multipart() ?>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label>First Name</label>
                            <input type="text" name="fName" placeholder="Enter First Name Here.." class="form-control">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>Last Name</label>
                            <input type="text" name="lName" placeholder="Enter Last Name Here.." class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea placeholder="Enter Address Here.." name="add" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label>City</label>
                            <input type="text" name="city" placeholder="Enter City Name Here.." class="form-control">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>State</label>
                            <input type="text" name="state" placeholder="Enter State Name Here.." class="form-control">
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label>Country</label>
                            <input type="text" name="country" placeholder="Enter Zip Code Here.." class="form-control">
                        </div>

                    </div>
                    <label class="info">Contact Information</label>
                    <div class="row">
                        <div class="form-group col-sm-6 ">
                            <label>Phone Number</label>
                            <input type="text" name="pNumber" placeholder="Enter Phone Number Here.." class="form-control">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Email Address</label>
                            <input type="text" name="emailAdd" readonly value="<?php echo $_SESSION['email'] ?>" placeholder="Enter Email Address Here.." class="form-control">
                        </div>

                    </div>
                    <label class="info">Current Job Information</label>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label>Title</label>
                            <input type="text" name="title" placeholder="Enter Designation Here.." class="form-control">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>Company</label>
                            <input type="text" name="company" placeholder="Enter Company Name Here.." class="form-control">
                        </div>
                    </div>
                    <label class="info">Uploads</label>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="com_logo">Logo</label>
                            <input type="file" class="form-control" name="com_name">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>CV</label>
                            <input  type="file" class="form-control" name="com_cv">
                        </div>
                    </div>

                    <button class="btn login-btn" type="submit">Submit</button>

                </div>
            </form>
            </div>


            <div id="displaInfo" class="well" style="<?php echo ((!empty($userDetails->fName)|| !$has_error)?"display:hide":"display:none") ?>">
                <label class="info">Contact Information</label>
                <table class="contact-info">
                    <tr>
                        <td>Email :</td>
                        <td><?php echo $userDetails->email ?></td>
                    </tr>
                    <tr>
                        <td>Mobile Number :</td>
                        <td><?php echo $userDetails->pNumber ?></td>
                    </tr>
                </table>

                <label class="info">General Information</label>
                <table class="general-info">
                    <tr>
                        <td>First Name :</td>
                        <td><?php echo $userDetails->fName ?></td>
                    </tr>
                    <tr>
                        <td>Last Name :</td>
                        <td><?php echo $userDetails->lName ?></td>
                    </tr>
                    <tr>
                        <td>Current Job Title :</td>
                        <td><?php echo $userDetails->title ?></td>
                    </tr>
                    <tr>
                        <td>Company :</td>
                        <td><?php echo $userDetails->company ?></td>
                    </tr>
                </table>

            </div>
        </div>
    </div>

    <script>
        function enableEdit(){
            $('#displaInfo').hide();
            $('#updateProfileSection').show();

        }
    </script>