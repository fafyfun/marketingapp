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

    <div class="row">
        <h2><?php echo $profileName ?></h2>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right"></span>
                    <h5>Total Reach</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo  $totalReach?></h1>
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
                    <h1 class="no-margins"> <?php echo $totalLike  ?></h1>
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
                    <h1 class="no-margins"><?php echo $page_engaged_users;  ?></h1>
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
                    <h1 class="no-margins"><?php echo $page_views_total;  ?></h1>
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
                        <div class="col-lg-9">
                            <div class="flot-chart dashboard-chart">
                                <canvas id="lineChart" height="40"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-3">
<!--                            <ul class="stat-list">
                                <li>
                                    <h2 class="no-margins"><?php /*echo $totalRecords['ga:users'] */?></h2>
                                    <small>Users</small>

                                </li>
                                <li>
                                    <h2 class="no-margins "><?php /*echo $totalRecords['ga:pageviews'] */?></h2>
                                    <small>Page Views</small>

                                </li>

                            </ul>-->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="row">

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Top 10 Pages</h5>
                    </div>
                    <div class="ibox-content">
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
                            <?php foreach ($postList  as $value) { ?>

                                <tr>
                                    <td><?php echo $value['message'] ?></td>
                                    <td> <?php echo  $value['reach'];  ?> </td>
                                    <td> <?php echo  $value['like'];  ?> </td>
                                    <td><?php echo $value['time']  ?></td>
                                </tr>
                            <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


