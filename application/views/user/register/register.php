<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">

    <div class="col-lg-7 registration well"><i class="glyphicon glyphicon-pencil"></i> Registration</div>

    <div class="col-lg-7 well">

        <div class="row">
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
            <?php echo form_open() ?>
            <div class="col-sm-12">
                <div class="form-group col-sm-9">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter a username">
                    <p class="help-block">At least 4 characters, letters or numbers only</p>
                </div>
                <div class="form-group col-sm-9">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                    <p class="help-block">A valid email address</p>
                </div>
                <div class="form-group col-sm-9">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter a password">
                    <p class="help-block">At least 6 characters</p>
                </div>
                <div class="form-group col-sm-9">
                    <label for="password_confirm">Confirm password</label>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm your password">
                    <p class="help-block">Must match your password</p>
                </div>

                <div class="form-group col-sm-9">
                    <input type="submit" class="btn btn-warning" value="Register">
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
