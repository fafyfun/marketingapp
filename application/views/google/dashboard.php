<?php if (!empty($google['resultData'])) { ?>

    <div class="row">
        <div class="col-lg-12">

        </div>
    </div>


    <?php $i = 0;
    foreach ($google['resultData'] as $record) {
        $i++; ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo $record['profileName'] ?></h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-3">

                                <ul class="list-group clear-list m-t">
                                    <li class="list-group-item fist-item">
                                <span class="pull-right">
                                    <?php echo $record['totalRecords']['ga:users'] ?>
                                </span>
                                        Users
                                    </li>
                                    <li class="list-group-item">
                                <span class="pull-right">
                                   <?php echo $record['totalRecords']['ga:pageviews'] ?>
                                </span>
                                        Page Views
                                    </li>
                                    <li class="list-group-item">
                                <span class="pull-right">
                                    <?php echo $record['totalRecords']['ga:sessions'] ?>
                                </span>
                                        Sessions
                                    </li>
                                    <li class="list-group-item">
                                <span class="pull-right">
                                    <?php echo number_format($record['totalRecords']['ga:bounceRate'], 2, '.', ''); ?>%
                                </span>
                                        Bounce Rate
                                    </li>
                                    <li class="list-group-item">
                                <span class="pull-right">
                                   <?php echo gmdate("H:i:s", $record['totalRecords']['ga:avgSessionDuration']) ?>
                                </span>
                                        Session duration
                                    </li>
                                    <li class="list-group-item">
                                <span class="pull-right">
                                    <?php echo $record['searchEngine'] ?>
                                </span>
                                        Search Engine Visits
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <!--                                <div class="flot-chart dashboard-chart">
                                    <canvas id="lineChart<?php /*echo $i */ ?>" height="90"></canvas>
                                </div>-->
                                <div class="flot-chart">
                                    <div class="flot-chart-content" id="flot-line-chart-multi<?php echo $i ?>"></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="statistic-box">

                                    <div class="row text-center">

                                        <div class="flot-chart">
                                            <?php if (!empty($record['visitor'])) { ?>
                                                <div class="flot-chart-pie-content"
                                                     id="flot-pie-chart<?php echo $i ?>"></div>
                                            <?php } else {
                                                echo "<div class='flot-chart-pie-content'>No Data Found</div>";
                                            } ?>
                                            <h5>Visitors</h5>
                                        </div>

                                    </div>
                                </div>


                            </div>
                        </div>

                        <a class="btn btn-success btn-facebook"
                           href="<?php echo base_url() ?>google/details/<?php echo $record['profile'] ?>">View
                            More Details </a>

                    </div>
                </div>
            </div>


        </div>

    <?php } ?>

    <div class="row">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <a href="/google/getProfileIDs" class="btn btn-success btn-facebook">
                    <i class="fa fa-google"> </i> Add New Google Account
                </a>
            </div>
        </div>
    </div>

<?php } else {
    $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/google/getProfileIDs';
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
    exit; ?>

    <div class="row">
        <div class="ibox float-e-margins">
            <div class="alert alert-danger">
                Add a Google Account and Select A Profile.
            </div>
        </div>
    </div>


<?php } ?>

