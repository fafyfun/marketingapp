
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
                                     Total Reach
                                </li>
                                <li class="list-group-item">
                                <span class="pull-right">
                                   <?php echo (empty($item['totalLike'])? 0 : $item['totalLike'])  ?>
                                </span>
                                     Total Likes
                                </li>
                                <li class="list-group-item">
                                <span class="pull-right">
                                    <?php echo  $item['page_views_total']; ?>
                                </span>
                                     Page Visits
                                </li>
                                <li class="list-group-item">
                                <span class="pull-right">
                                    <?php echo $item['page_engaged_users']; ?>
                                </span>
                                    People Engaged
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-8">
                            <div class="flot-chart">
                                <div class="flot-chart-content" id="lineChartfb<?php echo $x ?>"></div>
                            </div>
                        </div>

                    </div>

                    <a class="btn btn-success btn-facebook" href="<?php echo base_url() ?>facebook/details/<?php echo $item['profileId'] ?>">View
                        More Details </a>
                </div>

            </div>
        </div>

    </div>



    <?php $x++; } ?>
<div class="row">
    <div class="ibox float-e-margins">
        <div class="ibox-content">
            <a href="/facebook/selectProfile" class="btn btn-success btn-facebook">
                <i class="fa fa-facebook"> </i> Add New Facebook Page
            </a>
        </div>
    </div>
</div>