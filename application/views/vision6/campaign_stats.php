<?php
/**
 * Created by PhpStorm.
 * User: fawaz
 * Date: 6/22/16
 * Time: 11:38 AM
 */
?>

<div class="row">
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">

                <span class="label label-primary pull-right"></span>
                <h5>Send Date & Time</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo date('d M Y, h:i a', $stats['send_time']) ?></h1>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right"></span>
                <h5>Email Count</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"> <?php echo $stats['email_count']  ?></h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-danger pull-right"></span>
                <h5>Unsent Count</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $stats['unsent_count'];  ?></h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-info pull-right"></span>
                <h5>Open Count</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $stats['opened_count'];  ?></h1>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">

                <span class="label label-primary pull-right"></span>
                <h5>Bounce Count</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $stats['bounce_count'] ?></h1>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right"></span>
                <h5>Unsubscribe Count</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"> <?php echo $stats['unsubscribe_count']  ?></h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-danger pull-right"></span>
                <h5>Deactivated Count</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $stats['deactivated_count'];  ?></h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-info pull-right"></span>
                <h5>Send Status</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo ucfirst( $stats['send_status']);  ?></h1>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Mail Clients</h5>

                <div ibox-tools=""></div>
            </div>
            <div class="ibox-content">
                <div>
                    <canvas id="doughnutDevices1" height="300" width="600" style="width: 516px; height: 240px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Device Statistics</h5>

                <div ibox-tools=""></div>
            </div>
            <div class="ibox-content">
                <div class="text-center">
                    <canvas id="doughnutVisitors1" height="300" width="600"  style="width: 516px; height: 240px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

