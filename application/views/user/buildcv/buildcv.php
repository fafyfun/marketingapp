<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
    <div class="col-lg-8 registration well"><i class="glyphicon glyphicon-pencil"></i> Add Job Post</div>

    <div class="col-lg-8 well">
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
        <div class="col-md-12">
            <?php echo form_open_multipart() ?>
            <div class="form-group">
                <label for="summery">Career Objective / Summery</label>
              <textarea class="form-control"  id="summery" name="summery" placeholder="Career Objective / Summery" ></textarea>
            </div>
            <div class="form-group">
                <label for="proExperience">Professional Experience</label>
              <textarea class="form-control"  id="proExperience" name="proExperience" placeholder="Professional Experience" ></textarea>
            </div>
            <div class="form-group">
                <label for="perStrengths">Personal Strengths</label>
              <textarea class="form-control"  id="perStrengths" name="perStrengths" placeholder="Personal Strengths" ></textarea>
            </div>
            <div class="form-group">
                <label for="acaQualification">Academic Qualification</label>
              <textarea class="form-control"  id="acaQualification" name="acaQualification" placeholder="Academic Qualification" ></textarea>
            </div>
            <div class="form-group">
                <label for="skills">Skills</label>
              <textarea class="form-control"  id="skills" name="skills" placeholder="Skills" ></textarea>
            </div>
            <div class="form-group">
                <label for="projExperience">Project Experience</label>
              <textarea class="form-control"  id="projExperience" name="projExperience" placeholder="Project Experience" ></textarea>
            </div>
            <div class="form-group">
                <label for="extracurricular">Extracurricular Activities</label>
              <textarea class="form-control"  id="extracurricular" name="extracurricular" placeholder="Extracurricular Activities" ></textarea>
            </div>
            <div class="form-group">
                <label for="achievements">Achievements</label>
              <textarea class="form-control"  id="achievements" name="achievements" placeholder="Achievements" ></textarea>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-default" value="Register">
            </div>
            </form>
        </div>
    </div><!-- .row -->
</div><!-- .container -->