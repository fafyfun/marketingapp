
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Campaign List</h5>

            </div>
            <div class="ibox-content">

                <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>List Name</th>
                        <th>Send Title</th>
                        <th>Creation Time</th>
                        <th>Message Type</th>
                        <th>Send Status</th>
                        <th>Send Time</th>
                        <th>Send Contact Count</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($list as $item){ ?>

                        <tr class="gradeX">
                            <td><?php echo $item['id'] ?></td>
                            <td><?php echo $item['recipients']['list_name'] ?></td>
                            <td><?php echo $item['settings']['title'] ?></td>
                            <td><?php echo $item['create_time'];  ?></td>
                            <td><?php echo $item['type'] ?></td>
                            <td><?php echo $item['status'] ?></td>
                            <td><?php echo $item['send_time']; ?></td>
                            <td class="center"><?php echo $item['emails_sent'] ?></td>
                            <td class="center"><a href="<?php echo base_url()?>mailchimpapp/view_campaign_report/<?php echo $item['id'] ?>"><i class="fa fa-search text-navy"></i></a> </td>
                        </tr>

                    <?php } ?>

                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>List ID</th>
                        <th>Creation Time</th>
                        <th>Message Type</th>
                        <th>Send Status</th>
                        <th>Send Time</th>
                        <th>Creator Name</th>
                        <th>Send Contact Count</th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</div>

