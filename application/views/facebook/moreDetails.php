<div class="row">
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right"></span>
                <h5>Total Reach</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo (empty($totalReach)) ? 0 : $totalReach ?></h1>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-primary pull-right"></span>
                <h5>Total Likes</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"> <?php echo (empty($totalLike)) ? 0 : $totalLike ?></h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-danger pull-right"></span>
                <h5>Page Engaged</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo (empty($page_engaged_users)) ? 0 : $page_engaged_users ?></h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-info pull-right"></span>
                <h5>Page Views</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo (empty($page_views_total)) ? 0 : $page_views_total ?></h1>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Page Reach vs Page Likes</h5>

                <div class="pull-right">

                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="flot-chart">
                            <div class="flot-chart-content" id="lineChart"></div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Top 10 Pages</h5>
            </div>
            <div class="ibox-content">

                <?php if (!empty($postList)) { ?>
                    <table class="table table-hover no-margins">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Reach</th>
                            <th>Likes</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($postList as $value) { ?>

                            <tr>
                                <td><?php echo $value['message'] ?></td>
                                <td> <?php echo $value['reach']; ?> </td>
                                <td> <?php echo $value['like']; ?> </td>
                                <td><?php echo $value['time'] ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>

                <?php } else { ?>
                    <div class="text-center">No Data Found</div>
                <?php } ?>


            </div>
        </div>
    </div>
</div>


