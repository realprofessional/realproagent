@section('content')

<script src="{{ URL::asset('public/js/jquery.validate.js') }}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $.validator.addMethod("pass", function(value, element) {
            return  this.optional(element) || (/.{8,}/.test(value) && /([0-9].*[a-z])|([a-z].*[0-9])/.test(value));
        }, "Password minimum length must be 8 characters and contain atleast 1 number.");
        $.validator.addMethod("contact", function(value, element) {
            return  this.optional(element) || (/^[0-9-]+$/.test(value));
        }, "Contact Number is not valid.");
        $.validator.addMethod("noSpace", function(value, element) { 
            return value.indexOf(" ") < 0 && value != ""; 
        }, "No space please and don't leave it empty");
        $("#profile-edit-form").validate({
            rules: {
                account_type: {
                    required: true
                }
            }
        });
    });
</script>



<script>
    $(document).ready(function () {
        $.ajaxSetup(
        {
            headers:
                {
                'X-CSRF-Token': $('input[name="_token"]').val()
            }
        });
    });
</script> 


<!-- Styles -->
<style>

    /*    .ui-datepicker-inline {
    width: 17em; what ever width you want
    }*/

    .ui-datepicker { width: 100%; padding: .2em .2em 0; display: none; }
    .ui-datepicker table {width: 100%; font-size: 1.5em; border-collapse: collapse; margin:0 0 .4em; }

    #chartdiv {
        width		: 100%;
        height		: 300px;
        font-size	: 9px;
    }							
</style>

<!-- Resources -->
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

<!-- Chart code -->
<?php $var = json_decode($jsonFinalArray, true);
?>

<!--"allLabels": [{
                "text": "This is chart title",
                "align": "center",
                "bold": true,
                "y": 140
            }],-->

<script>
    var chart = AmCharts.makeChart( "chartdiv", {
        "type": "pie",
        "theme": "light",
        
        "dataProvider": <?php echo $jsonFinalArray; ?>,
        "titleField": "title",
        "valueField": "value",
        "labelRadius": 4,

        "radius": "42%",
        "innerRadius": "60%",
        "labelText": "[[title]]",
        "export": {
            "enabled": false
        }
    } );
</script>


<?php
$user_id = Session::get('user_id');
$user = DB::table('users')
        ->where('id', $user_id)
        ->first();

//print_r($user); exit;
?>
{{ Html::script('public/js/front/jquery.bpopup.js') }}
<div class="acc_deack acc_deack_dashboard">
    <div class="wrapper_new">
        <nav class="breadcrumbs">
            <div class="container">
                <ul>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="<?php echo HTTP_PATH; ?>">Home</a></li>
                    <li class="breadcrumbs__item">Account</li>
                </ul>

                <div class="my_prj_ln">
                    <a href="{{HTTP_PATH}}projectboard/projects">My Transactions</a>
                </div>
            </div>
        </nav>
        <div class="space">


            <div class="container">

                <div class="trs_bbc">
                    <div class="under_title">Transactions Under Contract</div>
                    <div class="under_price">$<?php echo number_format($projectsTransactionCount->count, 2) ?> <span>Gross Volume</span></div>
                    <div class="under_gtr auto_scroll">
                        <ul>
                            <?php
                            if ($projectsTransaction) {
                                foreach ($projectsTransaction as $projectsT) {
                                    ?>
                                    <li>
                                        <label>
                                            <a href="{{HTTP_PATH}}board/{{$projectsT->slug}}">{{$projectsT->project_name}}</a>
                                        </label>
                                        <span>${{number_format($projectsT->transaction_amount, 2)}}</span>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                        <div class="undre_view">
                            <a href="{{HTTP_PATH}}projectboard/projects">View all <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>

                <div class="trs_bbc">
                    <div class="under_title under_title_no">Tasks</div>
                    <div class="under_gtr">
                        <div class="under_tabs">
                            <div class="res_multi">
                                <a id="tab1_li" href="javascript:void(0)" class="singal_res snil active" onclick="opendiv('tab1')">Due Today</a>
                                <a id="tab2_li" href="javascript:void(0)" class="multi_res snil" onclick="opendiv('tab2')">Upcoming Tasks</a>
                            </div>

                            <div class="singal_tab rs active" id="tab1">  
                                <?php
                                if ($dueTaskData) {
                                    foreach ($dueTaskData as $dueTask) {
                                        ?>
                                        <div class="due_todys">
                                            <h5>
                                                <?php echo "<a href=" . HTTP_PATH . "board/" . $dueTask->project_slug . "/" . $dueTask->board_slug . "/" . $dueTask->task_slug . ">". $dueTask->task_name . "</a>" ?>
                                                <?php //echo $dueTask->task_name ?></h5>
                                            <p><?php echo date('F, d Y', strtotime($dueTask->due_date)) ?></p>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <p class="no_rc_dbb">No task to show</p>
                                <?php }
                                ?>
                            </div>

                            <div class="singal_tab rs" id="tab2" style="display:none">
                                <?php
                                if ($upcomingTaskData) {
                                    foreach ($upcomingTaskData as $upcomingTask) {
                                        ?>
                                        <div class="due_todys">
                                            <h5>
                                                <?php echo "<a href=" . HTTP_PATH . "board/" . $upcomingTask->project_slug . "/" . $upcomingTask->board_slug . "/" . $upcomingTask->task_slug . ">". $upcomingTask->task_name . "</a>" ?>
                                            <p><?php echo date('F, d Y', strtotime($upcomingTask->due_date)) ?></p>
                                        </div>

                                        <?php
                                    }
                                } else {
                                    ?>
                                    <p class="no_rc_dbb">No task to show</p>
                                <?php }
                                ?>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="trs_bbc trs_bbc_lsat">
                    <div class="under_title under_title_no">Past Due Tasks</div>
                    <div class="under_gtr">
                        <div class="past_tasks">
                            <?php
                            if ($previousTaskData) {
                                foreach ($previousTaskData as $previousTask) {
                                    ?>
                                    <div class="past_due_tasks">
                                        <label>
                                              <?php echo "<a href=" . HTTP_PATH . "board/" . $previousTask->project_slug . "/" . $previousTask->board_slug . "/" . $previousTask->task_slug . ">". $previousTask->task_name . "</a>" ?>
                                        <span>
                                            <?php echo date('F, d Y', strtotime($previousTask->due_date)) ?>
                                        </span>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <p class="no_rc_dbb">No task to show</p>
                            <?php }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="trs_bbc">
                    <div class="under_title">Goals</div>
                    <div class="under_gtr">
                        <div class="under_graf">
                            <div class="view_graph"> <div id="chartdiv"></div></div>
                            <div class="under_graph_point">
                                <?php
                                if ($var) {
                                    foreach ($var as $v) {
                                        if ($v['title'] != "No Project") {
                                            ?>
                                            <div class="graph_point">
                                                <i></i>
                                                <span> <?php echo $v['value'] . " " . $v['title']; ?> </span>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="trs_bbc">
                    <div class="under_title under_title_no">Calender</div>
                    <div class="under_gtr">
                        <div class="under_calenders">
                            <div id="dtpckr">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="trs_bbc trs_bbc_lsat">
                    <div class="under_title under_title_no">Recently Activity</div>

                    <div class="under_gtr">

                        <div class="recently_unders">
                            <div class="under_recently_days">

                            </div>
                            <?php
                            if ($reminderActivities) {
                                foreach ($reminderActivities as $reminder) {
                                    ?>
                                    <div class="under_recently_days">
                                        <div class="emai_tilae"><?php $reminder->type == 1 ? "Email" : "SMS" ?></div>
                                        <div class="complate_unders">
                                            <label><?php echo date('F, d Y', strtotime($reminder->datetime)) ?></label>
                                            <span>Completed by System</span>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>


                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
<script>
    function opendiv(id) {
        $('.rs').hide();
        $('#' + id).show();
        $('.snil').removeClass('active');
        $('#' + id + '_li').addClass('active');
        $('#how_itseller').removeClass('active');
        $('#how_itbuyer').removeClass('active');
        var tab1 = id.split('b');
        $('#how_itseller').attr('data-content','andr'+tab1[1]);
    }

</script>

<?php
$industry_list = array();
$timelist = array();
$timelistCount = array();
if(!empty($dueTaskDataCalender)){
    foreach ($dueTaskDataCalender as $dueTaskDt){
        $newDate = date('n-j-Y', strtotime($dueTaskDt->dtt));
        
        if(isset($timelist[$newDate])){
            $timelistCount[$newDate] = $timelistCount[$newDate] + 1;
            $timelist[$newDate] = $timelist[$newDate] . "<br>" .
                                  $timelistCount[$newDate] . ":  <a href=".HTTP_PATH."board/".$dueTaskDt->project_slug."/".$dueTaskDt->board_slug."/".$dueTaskDt->slug. ">".$dueTaskDt->task_name."</a>";  
            
        }else{
            $timelistCount[$newDate] = 1;
            $timelist[$newDate] = "<br>" .
                   $timelistCount[$newDate] .":  <a href=".HTTP_PATH."board/".$dueTaskDt->project_slug."/".$dueTaskDt->board_slug."/".$dueTaskDt->slug. ">".$dueTaskDt->task_name."</a>";
            
        }
        
        $industry_list[] =  $newDate;
    }
}


//echo "<pre>"; print_r($timelist); exit;


//$timelist = Array
//    (
//    '4-20-2018' => '04:30 AM To 10:30 PM',
//    '4-24-2018' => '4:00 AM TO 6:00 PM',
//    '4-19-2018' => '3:00 AM TO 7:00 PM',
//    '5-24-2018' => '02:30 PM To 09:00 PM',
//    '5-17-2018' => '04:00 PM To 10:30 PM',
//    '5-30-2018' => '04:30 AM To 06:30 PM',
//    '5-7-2018' => '01:00 AM To 02:00 PM'
//);
$currentdatetime = "";
//$industry_list = array("5-28-2018");
?>

<script>
    $(function () {
        var arrayFromPHP = <?php echo json_encode($timelist); ?>;
        var arrayFromPHPCount = <?php echo json_encode($timelistCount); ?>;
        var currentdatetime = '<?php echo $currentdatetime; ?>';
        $('#dtpckr').datepicker({
            dayNamesMin: ["S", "M", "T", "W", "T", "F", "S"],
            beforeShow: addCustomInformation,
            beforeShowDay: colorize,
            onSelect: function (selectedDate, inst) {
//                alert(selectedDate);
//                
//                alert(inst);

                $(this).data('datepicker').inline = true;

                var d = new Date(selectedDate);
                var month = d.getUTCMonth() + 1; //months from 1-12
                var day = d.getUTCDate();
                var year = d.getUTCFullYear();
                var vlddate = month + '-' + day + '-' + year;
//               alert(vlddate);
                if (arrayFromPHP[vlddate]) {
                    var dttm = 'Due Tasks - '  + arrayFromPHPCount[vlddate] + arrayFromPHP[vlddate];
                } else {
                    var dttm = 'Not Available';
                }
//                alert(dttm);
                
                addCustomInformation(inst, '', dttm);
            },
            onClose: function () {
                $(this).data('datepicker').inline = false;
            },
        });
        function addCustomInformation(input, vald, dttm) {
//            alert(dttm);
            setTimeout(function () {
                if (!dttm) {
                    dttm = currentdatetime;
                } else {

                }
                var buttonPane = $(input)
                .datepicker("widget");
//                alert(JSON.stringify(buttonPane));
                $('.ui-datepicker-calendar').after("<div class='dttm'>" + dttm + "</div>");
//                  $("<div class='dttm'>" + dttm + "</div>").appendTo(buttonPane);
//                  $(buttonPane).after("<div class='dttm'>" + dttm + "</div>");
                  
            });

        }
        var blueDates = ['<?php echo implode("', '", $industry_list); ?>'];
        $(".ui-datepicker-today").find('a').click();
//        alert(JSON.stringify(blueDates));

        function colorize(date) {
//            alert(date);
            mdy = (date.getMonth() + 1) + '-' + date.getDate()  + '-' + date.getFullYear();
            console.log(mdy);
//             alert(mdy);

//alert($.inArray(mdy, blueDates));

            if ($.inArray(mdy, blueDates) > -1) {
                
                return [true, "smallblue"];
            } else {
                return [true, ""];
            }
        }



    });

    function addInfo() {
        $(".ui-datepicker-buttonpane").html("<p>Test</p>");
    }
</script>


<!--  <script>
  $( function() {
    $( "#dtpckr" ).datepicker();
  } );
  </script>-->


@stop