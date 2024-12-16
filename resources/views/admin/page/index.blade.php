@extends('admin/layouts/main')
@section('content')
<body id="body">
    <div class="warpper">
        <div class="content d-flex flex-column ">
            <main class="flex-grow-1">
                <div class="section">
                    <div class="section-header mb-3">
                        <h5 class="mb-0"></h5>
                    </div>
                    <div class="section-body d-flex flex-column justify-content-center align-items-center">
                        <img src="{{asset('includes/image/logo.png')}}" width="198" height="198" class="mb-3">
                        <p class="text-center fs-4 text-danger">สำนักงานเลขาธิการวุฒิสภา</p>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
@endsection