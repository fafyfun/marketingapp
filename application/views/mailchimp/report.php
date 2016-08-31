<div class="row">

    <div class="row">
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>List</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo $list['recipients']['list_name']?></h1>


                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Subject Line</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo $list['settings']['subject_line']?></h1>

                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">

                    <h5>Email Sent</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo $list['emails_sent']?></h1>

                </div>
            </div>
        </div>

    </div>

</div>
<div class="row">
    <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">$</span>
                <h5>Total Orders</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $list['report_summary']['ecommerce']['total_orders']?></h1>
                <small>E-Commerce</small>

            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">$</span>
                <h5>Total Spent</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $list['report_summary']['ecommerce']['total_spent']?></h1>
                <small>E-Commerce</small>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">$</span>
                <h5>Total Revenue</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $list['report_summary']['ecommerce']['total_revenue']?></h1>
                <small>E-Commerce</small>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right"><?php echo $list['report_summary']['open_rate']*100?>%</span>
                <h5>Open rate</h5>
            </div>
            <div class="ibox-content">
                <div class="progress">
                    <div style="width: <?php echo $list['report_summary']['open_rate']*100?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo $list['report_summary']['open_rate']*100?>" role="progressbar" class="progress-bar progress-bar-success">
                        <span class="sr-only"><?php echo $list['report_summary']['open_rate']*100?>%" Complete (success)</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right"><?php echo $list['report_summary']['click_rate']*100?>%</span>
                <h5>Click rate</h5>
            </div>
            <div class="ibox-content">
                <div class="progress">
                    <div style="width: <?php echo $list['report_summary']['click_rate']*100?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo $list['report_summary']['click_rate']*100?>" role="progressbar" class="progress-bar progress-bar-success">
                        <span class="sr-only"><?php echo $list['report_summary']['click_rate']*100?>%" Complete (success)</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Opened</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $report['opens']['opens_total']?></h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Clicked</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $report['clicks']['clicks_total']?></h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Soft Bounced</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $report['bounces']['soft_bounces']?></h1>

            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Unsubscribed</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $report['unsubscribed']?></h1>

            </div>
        </div>
    </div>

</div>