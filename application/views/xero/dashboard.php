<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <?php

                $attributes = array('class' => 'form-inline', 'id' => 'myform');

                echo form_open('', $attributes) ?>
                <div class="form-group" id="data_5">
                    <label class="font-noraml">Date Range</label>

                    <div class="input-daterange input-group" id="datepicker">
                        <input type="text" id="from" class="input-sm form-control" name="start">
                        <span class="input-group-addon">to</span>
                        <input type="text" id="to" class="input-sm form-control" name="end">
                    </div>
                    <button class="btn btn-sm btn-white" type="submit">Update</button>
                </div>

                </form>
            </div>
        </div>
    </div>
</div>


<?php $x = 0;
foreach ($account_data as $item) { ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo $item['type'] ?></h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="flot-chart dashboard-chart">
                                <canvas id="<?php echo $item['type']  ?>" height="80"></canvas>
                                <!-- <canvas id="barChart1"></canvas>-->
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="statistic-box">

                                <div class="row text-center">

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>


    <?php $x++;
} ?>