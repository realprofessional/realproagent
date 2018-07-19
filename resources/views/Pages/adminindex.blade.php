@section('title', 'Administrator :: '.TITLE_FOR_PAGES.'Content management')
@extends('layouts/adminlayout')
@section('content')

<script src="{{ URL::asset('public/assets/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>



<script>
    $(function() {
        $("#searchByDateFrom").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            format: 'dd-mm-yy',
            numberOfMonths: 1,
            //minDate: 'mm-dd-yyyy',
            maxDate: 'dd-mm-yy',
            changeYear: true,
            onClose: function(selectedDate) {
                $("#searchByDateTo").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#searchByDateTo").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            format: 'dd-mm-yy',
            numberOfMonths: 1,
            maxDate: 'dd-dd-yy',
            changeYear: true,
            onClose: function(selectedDate) {
                $("#searchByDateFrom").datepicker("option", "maxDate", selectedDate);
            }
        });

    });
</script>
<?php
if (isset($_REQUEST['search']) && !empty($_REQUEST['search'])) {
    $search = $_REQUEST['search'];
} else {
    $search = "";
}
if (isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date'])) {
    $_REQUEST['from_date'];

    $from_date = date('d-m-y', strtotime($_REQUEST['from_date']));
} else {
    $from_date = "";
}
if (isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date'])) {
    $to_date = date('d-m-y', strtotime($_REQUEST['to_date']));
} else {
    $to_date = "";
}
?>
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">


                <ul id="breadcrumb" class="breadcrumb">
                    <li>
                        {{ html_entity_decode(Html::link(HTTP_PATH.'admin/admindashboard', '<i class="fa fa-dashboard"></i> Dashboard', array('id' => ''), true)) }}
                    </li>
                    <li>
                        <i class="fa fa-files-o"></i> Content management </li>
                    <li class="active">Pages List</li>
                </ul>
                <section class="panel">
                    <header class="panel-heading">
                        Search Pages
                    </header>
                    <div class="panel-body">

                        {{ View::make('elements.actionMessage')->render() }}
                        {{ Form::open(array('url' => 'admin/page/pagelist', 'method' => 'post', 'id' => 'adminAdd', 'files' => true,'class'=>'form-inline')) }}
                        <div class="form-group align_box">
                            <label class="sr-only" for="search">Your Keyword</label>
                            {{ Form::text('search', $search, array('class' => 'required search_fields form-control','placeholder'=>"Your Keyword")) }}
                            
                        </div>

                        <span class="hint" style="margin:5px 0">Search Pages by typing their name</span>
                        <!--                        <div class="form-group align_box">
                                                    <div class="clr"></div>
                                                    {{ Form::text('from_date', $from_date, array('class' => 'required default-date-picker search_fields form-control ','id'=>"searchByDateFrom",'readonly','placeholder'=>"From Date")) }}
                                                    <span> To </span>
                                                    {{ Form::text('to_date', $to_date, array('class' => 'required default-date-picker search_fields form-control','id'=>"searchByDateTo","readonly",'placeholder'=>"To Date")) }}
                                                </div>-->

                        {{ Form::submit('Search', array('class' => "btn btn-success")) }}
                         {{ Form::reset('Clear Filter', array('class' => "btn btn-success reset_form")) }}
                        {{ Form::close() }}
                    </div>
                </section>

            </div>
        </div>
        <div id="middle-content">
            @include('Pages/ajax_index')
        </div>
    </section>
</section>
<script>
jQuery(document).ready(function(){
    
    jQuery('.reset_form').click(function(){
        
       window.location.href= '<?php echo HTTP_PATH; ?>admin/page/pagelist'; 
        
    });
    
});

</script>
@stop