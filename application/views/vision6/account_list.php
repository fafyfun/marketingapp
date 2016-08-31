<?php
/**
 * Created by PhpStorm.
 * User: fawaz
 * Date: 8/30/16
 * Time: 5:21 PM
 */ ?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Account List</h5>

            </div>
            <div class="ibox-content">

                <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>List Name</th>
                        <th>List ID</th>
                        <th>Folder Name</th>
                        <th>Contact Count</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($list as $item){ ?>

    <tr class="gradeX">
        <td><?php echo $item['name'] ?></td>
        <td><?php echo $item['id'] ?></td>
        <td><?php echo $item['folder_name']  ?></td>
        <td><?php echo $item['contact_count'] ?></td>
        <td class="center"><a href="<?php echo base_url()?>vision6/list_contact/<?php echo $item['id'] ?>"><i class="fa fa-search text-navy"></i></a>
            <a onclick="deleteAcc('<?php echo base_url()?>vision6/delete_list/<?php echo $item['id'] ?>','') " ><i class="fa fa-remove text-danger"></i></a>

        </td>
    </tr>

<?php } ?>

</tbody>

</table>

</div>
</div>
</div>
</div>