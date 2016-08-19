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
                            <input type="text" id="to" class="input-sm form-control" name="end" >
                        </div>
                        <button class="btn btn-sm btn-white" type="submit">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<?php $x=0; foreach ($fb['fbDashboardRecords'] as $item) {?>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo $item['profileName'] ?></h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-3">
                            <ul class="list-group clear-list m-t">
                                <li class="list-group-item fist-item">
                                <span class="pull-right">
                                    <?php echo $item['totalReach'] ?>
                                </span>
                                    <span class="label label-success"> </span> Total Reach
                                </li>
                                <li class="list-group-item">
                                <span class="pull-right">
                                   <?php echo $item['totalLike'] ?>
                                </span>
                                    <span class="label label-info"> </span> Total Likes
                                </li>
                                <li class="list-group-item">
                                <span class="pull-right">
                                    <?php echo  $item['page_views_total']; ?>
                                </span>
                                    <span class="label"> </span> Page Visits
                                </li>
                                <li class="list-group-item">
                                <span class="pull-right">
                                    <?php echo $item['page_engaged_users']; ?>
                                </span>
                                    <span class="label"> </span> People Engaged
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <div class="flot-chart dashboard-chart">
                                <canvas id="lineChartfb<?php echo $x ?>" height="80"></canvas>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="statistic-box">

                                <div class="row text-center">
                                    <!--<div class="col-lg-6">
                    <canvas id="doughnutVisitors<?php /*echo $i */?>" width="120" height="120"></canvas>
                    <h5 >Visitors</h5>
                </div>
                <div class="col-lg-6">
                    <canvas id="doughnutDevices<?php /*echo $i */?>" width="120" height="120"></canvas>
                    <h5 >Devices</h5>
                </div>-->
                                </div>
                            </div>

                            <a href="<?php echo base_url() ?>facebook/details/<?php echo $item['profileId'] ?>"> View More Details </a>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>



    <?php $x++; } ?>
