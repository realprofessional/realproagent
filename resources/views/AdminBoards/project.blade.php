@section('title', 'Administrator :: '.TITLE_FOR_PAGES.'Default Project List')
@section('content')

<script src="{{ URL::asset('public/js/jquery.validate.js') }}"></script>
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
<?php
$user_id = Session::get('user_id');
$user = DB::table('users')
        ->where('id', $user_id)
        ->first();
?>
{{ Html::script('public/js/front/jquery.bpopup.js') }}




<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <ul id="breadcrumb" class="breadcrumb">
                    <li>
                        {{ html_entity_decode(Html::link(HTTP_PATH.'admin/admindashboard', '<i class="fa fa-dashboard"></i> Dashboard' , array('id' => ''), true)) }}
                    </li>
                    <li>
                        <i class="fa fa-random"></i> Admin Projects
                    </li>
                    <li class="active">Admin Project List</li>
                </ul>
            </div>
        </div>
        <div id="middle-content">
            <div class="container two_part3">
                <!--<div class="main_container">-->

                <div class="widget__header">
                    <!--                    <h1 class="widget__title">My Transactions</h1> -->
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
                                    <a href="{{HTTP_PATH}}admin/adminboards/list/{{$pro->slug}}">{{$pro->project_name}}</a>
                                </div>
                            </div> 
                            @endforeach

                            <div class="project_sec">
                                <div class="project_name create_pro">
                                    <a id="create_project" class="new_prjbtnnn" href="javascript:void();" onclick="createproject();"><span><i class="fa fa-plus"></i></span>Create New Project</a>

                                    <div id="create_popup" class="pop-over" style="display: none;">
                                        <div data-reactroot="">
                                            <div class="pop-over-header">
                                                <span class="pop-over-header-title">Create</span>
                                                <a href="#" class="pop-over-header-close-btn icon-sm icon-close" onclick="createproject();">X</a>
                                            </div>
                                            <div>
                                                {{ Form::open(array('url' => 'admin/adminboards/createProject', 'method' => 'post', 'id' => 'addproject', 'files' => true,'class'=>"form-inline form")) }}
                                                <div class="pop-over-content">
                                                    <div>
                                                        <div>
                                                            <div class="form-group">
                                                                {{ Html::decode(Form::label('project_name', "Project Name <span class='require'></span>",array('class'=>"control-label col-lg-2"))) }}
                                                               
                                                                    {{ Form::text('project_name', Input::old('project_name'), array('class' => 'required form-control ',"placeholder"=>"Project Name")) }}
                                                               
                                                            </div>
                                                            <div class="form-group">
                                                             
                                                                    {{ Form::submit('Create', array('class' => "btn btn-success")) }}
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{ Form::close() }}
                                            </div>
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
                        <div class="pagination_area">    {{ $project->appends(Input::except('page'))->render() }}</div>
                    </div>


                </div>


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
    </section>
</section>




@stop