@extends('layouts/adminlayout')
@section('content')
@section('title', 'Administrator :: '.TITLE_FOR_PAGES.'Dashboard')
{{ Html::style('public/assets/morris.js-0.4.3/morris.css'); }}
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <!--state overview start-->
        <div class="row state-overview">
            <div class="col-lg-3 col-sm-6">
                <section class="panel">
                    <div class="symbol terques">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="value">
                        <h1 class="count">
                            {{ $user = DB::table('users')->count()  }}
                        </h1>
                        <p>{{ link_to('/admin/user/userlist', "User", array('escape' => false,'class'=>"")) }}</p>
                    </div>
                </section>
            </div>
        </div>

        <!--state overview end-->
        <div id="morris">
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            User ( {{$last_seven_days}} new User registered in the last 7 days )
                        </header>
                        <div class="panel-body">
                            <div id="hero-bar" class="graph"></div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        
    </section>
</section>
<!--main content end-->


{{ Html::script('public/js/count.js'); }}
<script>
    
    countUp({{$user}}, 'count');
            
</script>

{{ Html::script('public/assets/morris.js-0.4.3/morris.min.js'); }}
{{ Html::script('public/assets/morris.js-0.4.3/raphael-min.js'); }}

<script>
            var Script = function() {

            //morris chart

            $(function() {
            // data stolen from http://howmanyleft.co.uk/vehicle/jaguar_'e'_type

            Morris.Bar({
            element: 'hero-bar',
                    data: [
                    {device: 'Jan', geekbench: <?php echo isset($dates[0]) ? $dates[0] : 0 ?>},
                    {device: 'Feb', geekbench: <?php echo isset($dates[1]) ? $dates[1] : 0 ?>},
                    {device: 'Mar', geekbench: <?php echo isset($dates[2]) ? $dates[2] : 0 ?>},
                    {device: 'Apr', geekbench: <?php echo isset($dates[3]) ? $dates[3] : 0 ?>},
                    {device: 'May', geekbench: <?php echo isset($dates[4]) ? $dates[4] : 0 ?>},
                    {device: 'Jun', geekbench: <?php echo isset($dates[5]) ? $dates[5] : 0 ?>},
                    {device: 'July', geekbench: <?php echo isset($dates[6]) ? $dates[6] : 0 ?>},
                    {device: 'Aug', geekbench: <?php echo isset($dates[7]) ? $dates[7] : 0 ?>},
                    {device: 'Sep', geekbench: <?php echo isset($dates[8]) ? $dates[8] : 0 ?>},
                    {device: 'Oct', geekbench: <?php echo isset($dates[9]) ? $dates[9] : 0 ?>},
                    {device: 'Nov', geekbench: <?php echo isset($dates[10]) ? $dates[10] : 0 ?>},
                    {device: 'Dec', geekbench: <?php echo isset($dates[11]) ? $dates[11] : 0 ?>}
                    ],
                    xkey: 'device',
                    ykeys: ['geekbench'],
                    labels: ['Property Owner'],
                    barRatio: 0.4,
                    xLabelAngle: 35,
                    hideHover: 'auto',
                    barColors: ['#6883a3']
            });
            });
            }();

</script>


@stop