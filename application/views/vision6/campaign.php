
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
                        <th>List ID</th>
                        <th>Creation Time</th>
                        <th>Message Type</th>
                        <th>Send Status</th>
                        <th>Send Time</th>
                        <th>Creator Name</th>
                        <th>Send Contact Count</th>

                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($list as $item){ ?>

                        <tr class="gradeX">
                            <td><?php echo $item['id'] ?></td>
                            <td><?php echo $item['list_id'] ?></td>
                            <td><?php echo date('d M Y, h:i a', $item['creation_time']);  ?></td>
                            <td><?php echo $item['message_type'] ?></td>
                            <td><?php echo $item['send_status'] ?></td>
                            <td><?php echo date('d M Y, h:i a', $item['send_time']); ?></td>
                            <td class="center"><?php echo $item['creator_name'] ?></td>
                            <td class="center"><?php echo $item['send_contact_count'] ?></td>
                            <td class="center"><a href="<?php echo base_url()?>vision6/get_campaign_stats/<?php echo $item['id'] ?>">View</a> </td>
                        </tr>

                    <?php } ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

