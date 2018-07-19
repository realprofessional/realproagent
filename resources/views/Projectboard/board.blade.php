@section('content')

<script src="{{ URL::asset('public/js/jquery.validate.js') }}"></script>
<script src="{{ URL::asset('public/js/datepicker/jquery-ui.js') }}"></script>
{{ Html::style('public/js/datepicker/jquery-ui.css'); }}
<script type="text/javascript">
    $(document).ready(function () {
        $.validator.addMethod("pass", function (value, element) {
            return  this.optional(element) || (/.{8,}/.test(value) && /([0-9].*[a-z])|([a-z].*[0-9])/.test(value));
        }, "Password minimum length must be 8 characters and contain atleast 1 number.");
        $.validator.addMethod("contact", function (value, element) {
            return  this.optional(element) || (/^[0-9-]+$/.test(value));
        }, "Contact Number is not valid.");
        $.validator.addMethod("noSpace", function (value, element) {
            return value.indexOf(" ") < 0 && value != "";
        }, "No space please and don't leave it empty");
        $("#addproject").validate();
    });

    function createproject() {
        $('#create_popup').toggle();
    }
</script>
<script>
    
    
    $(function() {
        var date=new Date();
        $("#searchByDateFrom").datepicker({
            //defaultDate: "+1w",
            changeMonth: true,
            format: 'yyyy-mm-dd',
            numberOfMonths: 1,
            
            //minDate: 'mm-dd-yyyy',
            // minDate: new Date(),
            
            changeYear: true,
            onClose: function(selectedDate) {
                $("#searchByDateTo").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#searchByDateTo").datepicker({
            //defaultDate: "+1w",
            changeMonth: true,
            format: 'yyyy-mm-dd',
            numberOfMonths: 1,
            minDate: new Date(),
            changeYear: true,
            onClose: function(selectedDate) {
                //$("#searchByDateFrom").datepicker("option", "minDate", selectedDate);
            }
        });

    });
</script>
<?php
$user_id = Session::get('user_id');
$user = DB::table('users')
        ->where('id', $user_id)
        ->first();
?>
{{ Html::script('public/js/front/jquery.bpopup.js') }}
<div class="acc_deack_new_">
    <div class="wrapper_new">
        <nav class="breadcrumbs">
            <div class="container">
                <ul>
                    <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="<?php echo HTTP_PATH; ?>">Account</a></li>
                    <li class="breadcrumbs__item">My Transactions</li>
                </ul>
            </div>
        </nav>
        <div class="space">
            <div class="container two_part3">
                <!--<div class="main_container">-->

                <div class="widget__header">
                    <h1 class="widget__title">My Transactions</h1> 
<!--                    <span style="float: right;">
                        <a id="add_project" href="javascript:void();" onclick="addproject();">+</a>
                    </span>-->
                </div>
                @if ($project)
                <!--{{ Form::open(array('url' => 'prospect/list', 'method' => 'post', 'id' => 'adminAdd', 'files' => true,'class'=>"form-inline form")) }}-->
                <div class="profile">
                    {{ View::make('elements.actionMessage')->render() }}
                    <div class="project_list">
                        <div class="projects_section">
                            @foreach($project as $pro)
                            <div class="project_sec">
                                <div class="project_name">
                                    <a href="{{HTTP_PATH}}board/{{$pro->slug}}">{{$pro->project_name}}</a>
                                </div>
                            </div> 
                            @endforeach

                            <div class="project_sec special_div">
                                <div class="project_name create_pro">
                                    <a id="create_project" class="new_prjbtnnn" href="javascript:void();" onclick="createproject();"><span><i class="fa fa-plus"></i></span>Create New Project</a>


                                </div>
                                <div id="create_popup" class="pop-over" style="display: none;">
                                    <div data-reactroot="">
                                        <div class="pop-over-header">
                                            <span class="pop-over-header-title">Create</span>
                                            <a href="#" class="pop-over-header-close-btn icon-sm icon-close" onclick="createproject();">X</a>
                                        </div>
                                        <div>
                                            {{ Form::open(array('url' => 'projectboard/createProject', 'method' => 'post', 'id' => 'addproject', 'files' => true,'class'=>"form-inline form")) }}
                                            <div class="pop-over-content new-pop-over">
                                                <div>
                                                    <div>
                                                        <div class="section_right">
                                                            <div class="form-group">
                                                                <div class="col-lg-10">
                                                                    {{ Form::text('project_name', Input::old('project_name'), array('class' => 'required form-control ',"placeholder"=>"Property Address")) }}
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-lg-10">
                                                                    <div class="creat_project_board">
                                                                        <span>
                                                                            {{Form::select('admin_project_id', [null=>'Select Transaction List'] + $array_boardd,Input::old('admin_project_id'),array('class'=>'required form-control','id'=>'admin_project_id'))}}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <?php global $transactionTypeArray; ?>
                                                                <div class="col-lg-10">
                                                                    <div class="creat_project_board">
                                                                        <span>
                                                                            {{Form::select('transaction', [null=>'Select Buyer or Seller Transaction'] + $transactionTypeArray,Input::old('transaction'),array('class'=>'required form-control','id'=>'transaction'))}}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-lg-10">
                                                                    {{ Form::text('transaction_amount', Input::old('transaction_amount'), array('min' => 1, 'class' => 'required form-control ',"placeholder"=>"Sales Price")) }}
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-lg-10">
                                                                    <div class="creat_project_board">
                                                                        <span>
                                                                            {{Form::select('transaction_type', [null=>'Select Type of Sale'] + $transactionsArr,Input::old('transaction_type'),array('class'=>'required form-control','id'=>'transaction_type'))}}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-lg-10">
                                                                    {{ Form::text('start_date', '', array('class' => 'required  form-control', 'id'=>'searchByDateFrom','placeholder'=>"Under Contact Date", "autocomplete" => 'off')) }}
                                                                </div>
                                                            </div>
                                                            <div class="form-group
                                                                <div class="col-lg-10">
                                                                    {{ Form::text('end_date', '' , array('class' => 'required  form-control', 'id'=>'searchByDateTo','placeholder'=>"Settlement Date", "autocomplete" => 'off')) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="section_right">
                                                            <?php global $additionalField; ?>
                                                            <?php
                                                            if ($additionalField) {
                                                                foreach ($additionalField as $key => $value) {
                                                                    ?>
                                                                    <div class="form-group">
                                                                        <div class="col-lg-10">
                                                                            {{ Form::text('additional['.$key.']', "", array('class' => 'form-control ',"placeholder"=>"$value")) }}
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>

                                                        <div class="form-group top_space">
                                                            <div class="col-lg-offset-2 col-lg-10">
                                                                {{ Form::submit('Create', array('class' => "btn btn-success")) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{ Form::close(); }}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row_pagination">
                        <div class="dataTables_paginate paging_bootstrap pagination custom_stye_pagination">
                            <?php
                            $pageination = $project->perPage();
                            if ($pageination > $project->total()) {
                                $pageination = $project->total();
                            }

                            $count = $pageination;
                            $main_count = 1;
                            $counts = $project->total() - $project->count();
                            $count = ($project->total() - $counts) + $count;

                            if (isset($_REQUEST['page']) && $_REQUEST['page'] != '') {

                                if ($_REQUEST['page'] == '1') {
                                    $count = $pageination;
                                    $main_count = 1;
                                } else {

                                    $main_count = ($_REQUEST['page'] - 1) * $project->perPage() + 1;
                                    $count = ($_REQUEST['page'] - 1) * $project->perPage() + $pageination;
                                    $count = $project->perPage() * $_REQUEST['page'];
                                    if ($count > $project->total()) {
                                        $count = $project->total();
                                    }
                                }
                            } else {

                                $count = $pageination;
                            }
                            ?>
                            <div class="left_shift_area">No. of Records {{$main_count}} - {{$count}} of {{$project->total()}}</div>
                            <div class="pagination_area">{{ $project->appends(Input::except('page'))->render() }}</div>
                        </div>
                    </div>

                    @if ($invitedProjects)

                    <div class="widget__header  nbew_c" style="margin-top: 30px;">
                        <h1 class="widget__title">Other Projects</h1> 
    <!--                    <span style="float: right;">
                            <a id="add_project" href="javascript:void();" onclick="addproject();">+</a>
                        </span>-->
                    </div>

                    <div class="profile">
    <!--                    <p class="user_invite_prjtx"> Other Projects </p>-->
                        <div class="project_list">
                            <div class="projects_section">
                                @foreach($invitedProjects as $pro)

                                <div class="project_sec">
                                    <div class="project_name">
                                        <a href="{{HTTP_PATH}}board/{{$pro->project_slug}}">{{$pro->project_name}}</a>
                                    </div>
                                </div> 

                                @endforeach


                            </div>
                        </div>
                    </div> 
                    @endif

                    <!--{{ Form::close() }}--> 
                    @else
                    <div class="no_record">
                        <div>
                            Projects not available
                        </div>
                    </div>
                    @endif

                    <!--</div>-->
                </div>


            </div>
        </div>
    </div>

    @stop