<?php $x=0; foreach ($fbDashboardRecords as $item) {?>



    <div class="row  border-bottom white-bg dashboard-header">
    <div class="col-sm-3">
        <h2><?php echo $item['profileName'] ?></h2>
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



<?php $x++; } ?>


