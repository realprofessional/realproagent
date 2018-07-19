@section('title', 'Administrator :: '.TITLE_FOR_PAGES.'City List')
@extends('layouts/adminlayout')
@section('content')
<script src="{{ URL::asset('public/js/datepicker/jquery-ui.js') }}"></script>
{{ Html::style('public/js/datepicker/jquery-ui.css'); }}
<script>
    
    
    $(function() {
        var date=new Date();
        $("#searchByDateFrom").datepicker({
            defaultDate: "+1w", 
            changeMonth: true,
            format: 'dd-mm-yyyy',
            numberOfMonths: 1,
            
            //minDate: 'mm-dd-yyyy',
            maxDate: new Date(),
            
            changeYear: true,
            onClose: function(selectedDate) {
                $("#searchByDateTo").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#searchByDateTo").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            format: 'dd-mm-yyyy',
            numberOfMonths: 1,
            maxDate: new Date(),
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

    $from_date = $_REQUEST['from_date'];
} else {
    $from_date = "";
}
if (isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date'])) {
    $to_date = $_REQUEST['to_date'];
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
                        {{ html_entity_decode(Html::link(HTTP_PATH.'admin/admindashboard', '<i class="fa fa-dashboard"></i> Dashboard' , array('id' => ''), true)) }}
                    </li>
                    <li>
                        <i class="fa fa-compass"></i> City
                    </li>
                    <li class="active">City List</li>
                </ul>
                <section class="panel">
                    <header class="panel-heading">
                        Search City
                    </header>
                    <div class="panel-body">
                        {{ View::make('elements.actionMessage')->render() }}
                        {{ Form::open(array('url' => 'admin/cityList', 'method' => 'post', 'id' => 'adminAdd', 'files' => true,'class'=>'form-inline')) }}
                        <div class="form-group align_box">
                            <label class="sr-only" for="search">Your Keyword</label>
                            {{ Form::text('search', $search, array('class' => 'required search_fields form-control','placeholder'=>"Your Keyword")) }}
                        </div>
                        <div class="form-group align_box">
                            <label class="" for="searchByDateFrom"> Search By Date:-  From</label>
                            {{ Form::text('from_date', $from_date, array('class' => 'required search_fields form-control', 'id'=>'searchByDateFrom','placeholder'=>"From")) }}
                        </div>
                        <div class="form-group align_box">
                            <label class="" for="searchByDateTo">To</label>
                            {{ Form::text('to_date', $to_date, array('class' => 'required search_fields form-control', 'id'=>'searchByDateTo','placeholder'=>"To")) }}
                        </div>
                        <span class="hint" style="margin:5px 0">Search City by typing their Name.</span>
                        {{ Form::submit('Search', array('class' => "btn btn-success")) }}
                        {{ Form::reset('Clear Filter', array('class' => "btn btn-success reset_form")) }}
                        {{ Form::close() }}
                    </div>
                </section>
            </div>
        </div>
        <div id="middle-content">
            @include('admin/cityajax_index')
        </div>
    </section>
</section>
<script>
jQuery(document).ready(function(){
    
    jQuery('.reset_form').click(function(){
        
       window.location.href= '<?php echo HTTP_PATH; ?>admin/cityList'; 
        
    });
    
});

</script>
@stop