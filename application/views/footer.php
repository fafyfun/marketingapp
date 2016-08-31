<?php
/**
 * Created by PhpStorm.
 * User: fawaz
 * Date: 4/1/16
 * Time: 3:43 PM
 */
?>

<div class="footer">
    <div class="pull-right">
        10GB of <strong>250GB</strong> Free.
    </div>
    <div>
        <strong>Copyright</strong> <a href="www.CoolMarketingPackages.com.au" target="_blank">Cool Marketing
            Dashboard</a> &copy; 2016-2017
    </div>
</div>

</div>

</div>
</div>

<div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Are you sure?</h4>
            </div>
            <div class="modal-body">
                <p><strong>Do you want to</strong> Permenetly Delete this from the Account</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">No</button>
                <a href="" id="deleteA" class="btn btn-primary">Yes</a>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Mainly scripts -->
<script src="<?php echo base_url() ?>/assets/js/jquery-2.1.1.js"></script>
<script src="<?php echo base_url() ?>/assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>/assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url() ?>/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Flot -->
<script src="<?php echo base_url() ?>/assets/js/plugins/flot/jquery.flot.js"></script>
<script src="<?php echo base_url() ?>/assets/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="<?php echo base_url() ?>/assets/js/plugins/flot/jquery.flot.spline.js"></script>
<script src="<?php echo base_url() ?>/assets/js/plugins/flot/jquery.flot.resize.js"></script>
<script src="<?php echo base_url() ?>/assets/js/plugins/flot/jquery.flot.pie.js"></script>

<!-- Peity -->
<script src="<?php echo base_url() ?>/assets/js/plugins/peity/jquery.peity.min.js"></script>
<script src="<?php echo base_url() ?>/assets/js/demo/peity-demo.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url() ?>/assets/js/inspinia.js"></script>
<script src="<?php echo base_url() ?>/assets/js/plugins/pace/pace.min.js"></script>


<script src="<?php echo base_url() ?>/assets/js/plugins/toastr/toastr.min.js"></script>

<!-- jQuery UI -->
<script src="<?php echo base_url() ?>/assets/js/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url() ?>/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- GITTER -->
<script src="<?php echo base_url() ?>/assets/js/plugins/gritter/jquery.gritter.min.js"></script>

<!-- EayPIE -->
<script src="<?php echo base_url() ?>/assets/js/plugins/easypiechart/jquery.easypiechart.js"></script>

<!--    &lt;!&ndash; Sparkline &ndash;&gt;
    <script src="<?php echo base_url() ?>/assets/js/plugins/sparkline/jquery.sparkline.min.js"></script>-->

<!--    &lt;!&ndash; Sparkline demo data  &ndash;&gt;
    <script src="<?php echo base_url() ?>/assets/js/demo/sparkline-demo.js"></script>-->

<!-- ChartJS-->
<script src="<?php echo base_url() ?>/assets/js/plugins/chartJs/Chart.min.js"></script>
<script>
    $('#data_5 .input-daterange').datepicker({
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        endDate: "+1d",
        format: "dd-mm-yyyy",
    });
</script>

<?php if ($page == "Dashboard") {

    if (isset($google['sub']) && $google['sub'] == "Google") {
        $i = 0;
        foreach ($google['resultData'] as $record) {
            $i++;

            ?>


            <script>
                //Flot Multiple Axes Line Chart
                $(function () {
                    var oilprices =<?php echo $record['numUser'] ?>;
                    var exchangerates = <?php echo $record['numPageViews'] ?>;

                    function euroFormatter(v, axis) {
                        return v.toFixed(axis.tickDecimals) + "€";
                    }

                    function doPlot(position) {
                        $.plot($("#flot-line-chart-multi<?php echo $i ?>"), [{
                            data: oilprices,
                            label: "Number of users"
                        }, {
                            data: exchangerates,
                            label: "Number of page views"
                        }], {
                            xaxes: [{
                                mode: 'time'
                            }],
                            legend: {
                                position: 'sw'
                            },
                            colors: ["##1c84c6", "#1ab394"],
                            grid: {
                                color: "#999999",
                                hoverable: true,
                                clickable: true,
                                tickColor: "#D4D4D4",
                                borderWidth: 0,
                                hoverable: true //IMPORTANT! this is needed for tooltip to work,

                            },
                            tooltip: true,
                            tooltipOpts: {
                                content: "%s for %x was %y",
                                xDateFormat: "%y-%0m-%0d",

                                onHover: function (flotItem, $tooltipEl) {
                                    // console.log(flotItem, $tooltipEl);
                                }
                            }

                        });
                    }

                    doPlot("right");

                    $("button").click(function () {
                        doPlot($(this).text());
                    });
                });

            </script>


            <script>
                $(document).ready(function () {

                    //Flot Pie Chart
                    $(function () {

                        var data = [{
                            label: "Returning",
                            data: <?php echo $record['visitor'][0][1] ?>,
                            color: "#d3d3d3",
                        }, {
                            label: "New",
                            data: <?php echo $record['visitor'][1][1] ?>,
                            color: "#1ab394",
                        }];

                        var plotObj = $.plot($("#flot-pie-chart<?php echo $i ?>"), data, {
                            series: {
                                pie: {
                                    show: true
                                }
                            },
                            grid: {
                                hoverable: true
                            },
                            tooltip: true,
                            tooltipOpts: {
                                content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                                shifts: {
                                    x: 20,
                                    y: 0
                                },
                                defaultTheme: false
                            }
                        });

                    });

                });
            </script>

        <?php }
    }

    if (isset($fb['sub']) && $fb['sub'] == "FB") {

        $x = 0;

        foreach ($fb['fbDashboardRecords'] as $item) { ?>


            <script>

                $(function () {
                    var oilprices =<?php echo $item['like'] ?>;
                    var exchangerates = <?php echo $item['reach'] ?>;

                    function euroFormatter(v, axis) {
                        return v.toFixed(axis.tickDecimals) + "€";
                    }

                    function doPlot(position) {
                        $.plot($("#lineChartfb<?php echo $x ?>"), [{
                            data: oilprices,
                            label: "Number of likes"
                        }, {
                            data: exchangerates,
                            label: "Number of page reach"
                        }], {
                            xaxes: [{
                                mode: 'time'
                            }],
                            legend: {
                                position: 'sw'
                            },
                            colors: ["##1c84c6", "#1ab394"],
                            grid: {
                                color: "#999999",
                                hoverable: true,
                                clickable: true,
                                tickColor: "#D4D4D4",
                                borderWidth: 0,
                                hoverable: true //IMPORTANT! this is needed for tooltip to work,

                            },
                            tooltip: true,
                            tooltipOpts: {
                                content: "%s for %x was %y",
                                xDateFormat: "%y-%0m-%0d",

                                onHover: function (flotItem, $tooltipEl) {
                                    // console.log(flotItem, $tooltipEl);
                                }
                            }

                        });
                    }

                    doPlot("right");

                    $("button").click(function () {
                        doPlot($(this).text());
                    });
                });

            </script>


            <?php $x++;
        }
    }


} elseif ($page == "Details") { ?>

    <script>
        //Flot Multiple Axes Line Chart
        $(function () {
            var oilprices =<?php echo $numUser ?>;
            var exchangerates = <?php echo $numPageViews ?>;

            function euroFormatter(v, axis) {
                return v.toFixed(axis.tickDecimals) + "€";
            }

            function doPlot(position) {
                $.plot($("#flot-line-chart-multi"), [{
                    data: oilprices,
                    label: "Number of users"
                }, {
                    data: exchangerates,
                    label: "Number of page views"
                }], {
                    xaxes: [{
                        mode: 'time'
                    }],
                    legend: {
                        position: 'sw'
                    },
                    colors: ["##1c84c6", "#1ab394"],
                    grid: {
                        color: "#999999",
                        hoverable: true,
                        clickable: true,
                        tickColor: "#D4D4D4",
                        borderWidth: 0,
                        hoverable: true //IMPORTANT! this is needed for tooltip to work,

                    },
                    tooltip: true,
                    tooltipOpts: {
                        content: "%s for %x was %y",
                        xDateFormat: "%y-%0m-%0d",

                        onHover: function (flotItem, $tooltipEl) {
                            // console.log(flotItem, $tooltipEl);
                        }
                    }

                });
            }

            doPlot("right");

            $("button").click(function () {
                doPlot($(this).text());
            });
        });

        $(document).ready(function () {

            //Flot Pie Chart
            $(function () {

                var data = [{
                    label: "Returning",
                    data: <?php echo $visitor[0][1] ?>,
                    color: "#d3d3d3",
                }, {
                    label: "New",
                    data: <?php echo $visitor[1][1] ?>,
                    color: "#1ab394",
                }];

                var plotObj = $.plot($("#flot-pie-chart-visitors"), data, {
                    series: {
                        pie: {
                            show: true
                        }
                    },
                    grid: {
                        hoverable: true
                    },
                    tooltip: true,
                    tooltipOpts: {
                        content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                        shifts: {
                            x: 20,
                            y: 0
                        },
                        defaultTheme: false
                    }
                });

            });

//Flot Pie Chart
            $(function () {

                var data = [
                    {
                        label: "Android",
                        data: <?php echo (isset($deviceBreak[1][1])?$deviceBreak[1][1]:0)  ?>,
                        color: "#FD2149",
                    }, {
                        label: "Mac",
                        data: <?php echo (isset($deviceBreak[4][1])?$deviceBreak[4][1]:0)  ?>,
                        color: "#F65452",
                    }, {
                        label: "Mac",
                        data: <?php echo (isset($deviceBreak[5][1])?$deviceBreak[5][1]:0)  ?>,
                        color: "#2958E8",
                    }, {
                        label: "Win",
                        data: <?php echo (isset($deviceBreak[6][1])?$deviceBreak[6][1]:0)  ?>,
                        color: "#1ab394",
                    }, {
                        label: "iOS",
                        data: <?php echo (isset($deviceBreak[7][1])?$deviceBreak[7][1]:0)  ?>,
                        color: "#D10F0F",
                    }];

                var plotObj = $.plot($("#flot-pie-chart-device"), data, {
                    series: {
                        pie: {
                            show: true
                        }
                    },
                    grid: {
                        hoverable: true
                    },
                    tooltip: true,
                    tooltipOpts: {
                        content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                        shifts: {
                            x: 20,
                            y: 0
                        },
                        defaultTheme: false
                    }
                });

            });


        });

    </script>


<?php } elseif ($page == "getId") { ?>

    <script>

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url().'google/getWebProfileId'?>", //Relative or absolute path to response.php file
            data: {'prof_id': <?php echo $profile[0]['id'] ?>},
            success: function (data) {

                var sel = $("#property");
                sel.empty();
                for (var i = 0; i < data.length; i++) {
                    sel.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                }

                $('#namePro').val(data[0].name);
            }
        });


        var profile = 0

        $('#profile').on('change', function () {
            profile = this.value; // or $(this).val()

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo base_url().'google/getWebProfileId'?>", //Relative or absolute path to response.php file
                data: {'prof_id': profile},
                success: function (data) {

                    var sel = $("#property");
                    sel.empty();
                    for (var i = 0; i < data.length; i++) {
                        sel.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                    }

                    $('#namePro').val(data[0].name);
                }
            });

        });

        $('#property').on('change', function () {
            property1 = $(this).find("option:selected").text();

            //alert(property1);

            $('#namePro').val(property1);

        });

    </script>

<?php } elseif ($page == "Facebook") { ?>

    <script>

        $(function () {
            var oilprices =<?php echo $like ?>;
            var exchangerates = <?php echo $reach ?>;

            function euroFormatter(v, axis) {
                return v.toFixed(axis.tickDecimals) + "€";
            }

            function doPlot(position) {
                $.plot($("#lineChart"), [{
                    data: oilprices,
                    label: "Number of likes"
                }, {
                    data: exchangerates,
                    label: "Number of page reach"
                }], {
                    xaxes: [{
                        mode: 'time'
                    }],
                    legend: {
                        position: 'sw'
                    },
                    colors: ["##1c84c6", "#1ab394"],
                    grid: {
                        color: "#999999",
                        hoverable: true,
                        clickable: true,
                        tickColor: "#D4D4D4",
                        borderWidth: 0,
                        hoverable: true //IMPORTANT! this is needed for tooltip to work,

                    },
                    tooltip: true,
                    tooltipOpts: {
                        content: "%s for %x was %y",
                        xDateFormat: "%y-%0m-%0d",

                        onHover: function (flotItem, $tooltipEl) {
                            // console.log(flotItem, $tooltipEl);
                        }
                    }

                });
            }

            doPlot("right");

            $("button").click(function () {
                doPlot($(this).text());
            });
        });


    </script>

<?php } elseif ($page == "Vision6") { ?>

    <!-- Data Tables -->
    <script src="<?php echo base_url() ?>/assets/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/plugins/dataTables/dataTables.tableTools.min.js"></script>

    <script>
        $('.dataTables-example').dataTable({
            responsive: true,
            "dom": 'T<"clear">lfrtip',
            "tableTools": {
                "sSwfPath": "<?php echo base_url() ?>/assets/js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
            },
            columnDefs : [

            ],
            order: [[ 2, "desc" ]]
        });
    </script>

    <script>
        $('input[name=optionsRadios]').change(function () {
            $('form').submit();

        });
    </script>

<?php } elseif ($page == "Campaign") { ?>

    <script>
        $(document).ready(function () {


            var doughnutData = [

                {
                    value:<?php echo $stats['device_statistics']['desktop']['total_count'] ?>,
                    color: "#FD2149",
                    highlight: "#1ab394",
                    label: "Desktop"
                },
                {
                    value:<?php echo $stats['device_statistics']['mobile']['total_count'] ?>,
                    color: "#F65452",
                    highlight: "#1ab394",
                    label: "Mobile"
                }, {
                    value:<?php echo $stats['device_statistics']['mobile']['total_count'] ?>,
                    color: "#2958E8",
                    highlight: "#1ab394",
                    label: "Unknown"
                },

            ];

            var doughnutOptions = {
                segmentShowStroke: true,
                segmentStrokeColor: "#fff",
                segmentStrokeWidth: 2,
                percentageInnerCutout: 45, // This is 0 for Pie charts
                animationSteps: 100,
                animationEasing: "easeOutBounce",
                animateRotate: true,
                animateScale: false,
            };

            var ctx = document.getElementById("doughnutVisitors1").getContext("2d");
            var DoughnutChart = new Chart(ctx).Doughnut(doughnutData, doughnutOptions);

            var doughnutData1 = [


                <?php

                    $color = array();

                  foreach($stats['mail_clients'] as $item){

                    echo '    {
                    value:'.$item['total'].',
                    color: "#'. dechex(rand(0x000000, 0xFFFFFF)).'",
                    highlight:  "#1ab394",
                    label: "'.$item['title'].'"
                },';

                  }

                 ?>

            ];

            var doughnutOptions1 = {
                segmentShowStroke: true,
                segmentStrokeColor: "#fff",
                segmentStrokeWidth: 2,
                percentageInnerCutout: 45, // This is 0 for Pie charts
                animationSteps: 100,
                animationEasing: "easeOutBounce",
                animateRotate: true,
                animateScale: false,
            };

            var ctx = document.getElementById("doughnutDevices1").getContext("2d");
            var DoughnutChart = new Chart(ctx).Doughnut(doughnutData1, doughnutOptions1);


        });
    </script>

<?php } elseif ($page == "MailChimp") { ?>


<?php } elseif ($page == "Xero") { ?>

    <script>

        var sales_count = 1;
        var sales_limit = <?php echo count($sales) ?>;

        if (sales_limit > 10) {
            sales_limit = 10;
        }

        function addMore() {

            sales_id = $("#sales_id").val();

            if (sales_id != 0) {
                if (sales_count < sales_limit) {
                    $("#sales").clone(true).appendTo("#sales_list");
                    sales_count++;

                } else {
                    alert("Only 10 Accounts can be added");
                }
            }

        }

        var expense_count = 1;
        var expense_limit = <?php echo count($expense) ?>;

        if (expense_limit > 10) {
            expense_limit = 10;
        }


        function addExpensesMore() {

            expenses_id = $("#expenses_id").val();

            if (expenses_id != 0) {
                if (expense_count < 10) {
                    $("#expense").clone().appendTo("#expense_list");
                    expense_count++;

                } else {
                    alert("Only 10 Accounts can be added");
                }
            }


        }
    </script>

<?php } elseif ($page == "Xero_Index") { ?>
    <script>
        <?php

         foreach($account_data as $row){ ?>
        var barData = {
            labels: <?php echo json_encode($row['name'])?>,
            datasets: [
                {
                    label: <?php echo json_encode($row['type'])?>,
                    fillColor: "rgba(26,179,148,0.5)",
                    strokeColor: "rgba(26,179,148,0.8)",
                    highlightFill: "rgba(26,179,148,0.75)",
                    highlightStroke: "rgba(26,179,148,1)",
                    data: <?php echo json_encode($row['amount'])?>
                }
            ]
        };

        var barOptions = {
            scaleBeginAtZero: true,
            scaleShowGridLines: true,
            scaleGridLineColor: "rgba(0,0,0,.05)",
            scaleGridLineWidth: 1,
            barShowStroke: true,
            barStrokeWidth: 2,
            barValueSpacing: 5,
            barDatasetSpacing: 1,
            responsive: true,
        }


        var ctx = document.getElementById(<?php echo json_encode($row['type'])?>).getContext("2d");
        var myNewChart = new Chart(ctx).Bar(barData, barOptions);
        <?php
         }


         ?>

    </script>
<?php } //elseif ($page == "Details"){ ?>

<script>
    Userback = window.Userback || {};

    (function (id) {
        if (document.getElementById(id)) {
            return;
        }
        var s = document.createElement('script');
        s.id = id;
        s.src = 'http://app.userback.io/widget.js';
        var parent_node = document.head || document.body;
        parent_node.appendChild(s);
    })('userback-sdk');

    Userback.access_token = '74|85|GdpL4iZmSgDl9yfXc5Rv7WLTTBydXWZE9ppeIoABEdXOMcLYiD';
</script>

<?php

if (isset($error_response)) {

    if ($error_response) { ?>

        <script>

            Command: toastr['success']("<?php echo $error_message ?>")

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "400",
                "hideDuration": "1000",
                "timeOut": "7000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        </script>

    <?php } else { ?>

        <script>

            Command: toastr['error']("<?php echo $error_message ?>")

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "400",
                "hideDuration": "1000",
                "timeOut": "7000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        </script>

    <?php }
} ?>

<script>

    function deleteAcc(dlink, dcontent) {


        $('#myModal6').modal({

            show: true
        });

        $('#deleteA').attr("href", dlink);
    }


</script>

</body>
</html>