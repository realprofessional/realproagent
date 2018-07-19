@section('content')
<div class="stal_page">
    <div class="wrapper">
        <div class="stal_pagebx">
    <div class="page_title">
        <h1><span>{{ $pageDetail->name; }}</span></h1>
    </div>
    <div class="term-content-bx">
        {{ $pageDetail->description; }}
    </div>
        </div>
    </div>
</div>
@stop