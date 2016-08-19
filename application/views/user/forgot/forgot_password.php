<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: fawaz
 * Date: 3/4/16
 * Time: 2:49 PM
 */

?>

<div class="container">

    <div class="col-lg-7 registration well"><i class="glyphicon glyphicon-pencil"></i>Forgot Password</div>

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
                    <label for="email">Email</label>
                    <input type="text"  class="form-control" name="email" />
                </div>

                <div class="form-group col-sm-9">
                    <input type="submit" class="btn btn-warning" value="Submit">
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
