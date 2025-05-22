@extends('layout/mainlayout')
@section('content')
<body>

    <div class="search_normal">
        <section class="banner-toggle">
            <div class="warp">
                <div class="card">
                    <p>ระบบสืบค้นข้อมูลรายงานการประชุม บันทึกการประชุม </p>
                    <p>และบันทึกการออกเสียงลงคะแนน ของสำนักงานเลขาธิการวุฒิสภา</p>
                    <div class="warp-toggle">
                        <a class="btn btn-light" href="{{route ('frontend.a_search') }}">ค้นหารายงานการประชุม</a>
                        <a class="btn btn-light active" href="{{route ('frontend.n_search') }}">ค้นหารายงานการประชุมขั้นสูง</a>
                    </div>
                </div>
            </div>
        </section>
        @if ($query)
        <section class="body-content">
            <div class="container">
                <div class="text-center m-5">
                    <h2>ข้อมูลการประชุมวุฒิสภา</h2>
                    
                </div>
                <div class="text-center m-5">
                    <h4>{{ $file_name }} วัน{{ Carbon\carbon::parse($date_meet)->translatedFormat('lที่ j F Y') }}</h4>
                </div>
                <div class="ul">
                    @foreach ($query as $index => $results  )
                    <ul class="link-primary">{{$index+1 }}. <a target="_blank" href="{{ asset ('uploads/pdf/'.$results->name_file) }}" > {{ $results->type_name }} </a></ul>        
                    
                    @endforeach
                </div>
            </div>
        </section>
        @endif
        

</body>
@endsection