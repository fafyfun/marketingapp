<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="col-lg-11">
                    <h2><i class="fa fa-google "></i> <?php echo $profileName ?></h2>


                </div> <a class="btn btn-default  dim " href="<?php base_url()?>/google" type="button"><i class="fa fa-arrow-left"></i></a>

            </div>

        </div>

    </div>
</div>


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
                        <input type="text" id="from" class="input-sm form-control" name="start"
                               value="<?php echo $showStart ?>">
                        <span class="input-group-addon">to</span>
                        <input type="text" id="to" class="input-sm form-control" name="end"
                               value="<?php echo $showEnd ?>">
                    </div>
                    <button class="btn btn-sm btn-primary" type="submit">Update</button>
                </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right"></span>
                <h5>Sessions</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $totalRecords['ga:sessions'] ?></h1>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-primary pull-right">HH:MM:SS</span>
                <h5>Avg. Session Duration</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"> <?php echo gmdate("H:i:s", $totalRecords['ga:avgSessionDuration']) ?></h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-danger pull-right">%</span>
                <h5>Bounce Rate</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo number_format($totalRecords['ga:bounceRate'], 2, '.', ''); ?>%</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-info pull-right">%</span>
                <h5>% New Sessions</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo number_format($totalRecords['ga:percentNewSessions'], 2, '.', ''); ?>
                    %</h1>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Users vs Page Views</h5>

                <div class="pull-right">

                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="flot-chart">
                            <?php if($flag){ ?>
                            <div class="flot-chart-content" id="flot-line-chart-multi"></div>
                            <?php }else { ?>
                            No Data Available for Selected Date Range
                            <?php } ?>

                        </div>
                    </div>
                    <div class="col-lg-3">
                        <ul class="stat-list">
                            <li>
                                <h2 class="no-margins"><?php echo $totalRecords['ga:users'] ?></h2>
                                <small>Users</small>

                            </li>
                            <li>
                                <h2 class="no-margins "><?php echo $totalRecords['ga:pageviews'] ?></h2>
                                <small>Page Views</small>

                            </li>

                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Keyword list</h5>
            </div>
            <div class="ibox-content">
                <?php if(!empty($keyword)) { ?>
                <table class="table table-hover no-margins">
                    <thead>
                    <tr>
                        <th>Keyword</th>
                        <th>Session</th>
                        <th>New Session</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($keyword as $value) { ?>
                        <tr>
                            <td><?php echo $value[0] ?></td>
                            <td><?php echo $value[1] ?></td>
                            <td class="text-navy"> <?php echo number_format($value[2], 2, '.', ''); ?>%</td>
                        </tr>
                    <?php } ?>

                    </tbody>
                </table>
                <?php }else{ ?>
                    No Data Found
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Top 10 Landing Pages</h5>
            </div>
            <div class="ibox-content">
                <?php if(!empty($landing)) { ?>
                <table class="table table-hover no-margins">
                    <thead>
                    <tr>
                        <th>URL</th>
                        <th>Session</th>
                        <th>New Session</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($landing as $value) { ?>
                        <tr>
                            <td><?php echo $value[0] ?></td>
                            <td><?php echo $value[1] ?></td>
                            <td class="text-navy"> <?php echo number_format($value[2], 2, '.', ''); ?>%</td>
                        </tr>
                    <?php } ?>

                    </tbody>
                </table>
                <?php }else{ ?>
                    No Data Found
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Country List</h5>
            </div>
            <div class="ibox-content">
                <?php if(!empty($country)) { ?>
                <table class="table table-hover no-margins">
                    <thead>
                    <tr>
                        <th>Country</th>
                        <th>Session</th>
                        <th>New Session</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($country as $value) { ?>
                        <tr>
                            <td><?php echo $value[0] ?></td>
                            <td><?php echo $value[1] ?></td>
                            <td class="text-navy"> <?php echo number_format($value[2], 2, '.', ''); ?>%</td>
                        </tr>
                    <?php } ?>

                    </tbody>
                </table>
                <?php }else{ ?>
                    No Data Found
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Visitors Breakdown</h5>
            </div>
            <div class="ibox-content">
                <?php if (!empty($visitor)){ ?>
                <div class="flot-chart">
                    <div class="flot-chart-pie-content" id="flot-pie-chart-visitors"></div>
                </div>
                <?php }else{ ?>
                No Data Found
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Device Breakdown</h5>
            </div>
            <div class="ibox-content">
                <?php if (!empty($deviceBreak)){ ?>
                <div class="flot-chart">
                    <div class="flot-chart-pie-content" id="flot-pie-chart-device"></div>
                </div>
                <?php }else{ ?>
                    No Data Found
                <?php } ?>

            </div>
        </div>
    </div>

</div>



