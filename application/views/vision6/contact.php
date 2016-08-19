<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Contact List</h5>

            </div>
            <div class="ibox-content">

                <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <?php foreach($contacts[0] as $key => $value){ ?>

                            <th><?php echo $key ?></th>

                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($contacts as $item){ ?>
                        <tr class="gradeX">
                            <?php foreach( $item as $key => $value){ ?>


                                <td><?php echo $value ?></td>



                            <?php }?>
                        </tr>
                    <?php }?>

                    </tbody>
                    <tfoot>
                    <tr>
                        <?php foreach($contacts[0] as $key => $value){ ?>

                            <th><?php echo $key ?></th>

                        <?php } ?>
                    </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</div>

