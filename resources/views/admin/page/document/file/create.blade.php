@extends('admin/layouts/main')
@section('content')
<body id="body">
    <div class="warpper">
        <div class="content">
            <main>
                <div class="section">
                    <div class="section-header mb-3">
                        <h5 class="mb-0"></h5>
                    </div>
                    <div class="section-body">
                        <form  action="{{ route('admin.document_upload',['id' => $id]) }}" method="POST" enctype="multipart/form-data" class="max-w-sm mx-auto">
                            @csrf
                        <div class="section d-flex mb-3">
                            <div class="col">
                            <input class="form-control" id="file_input" type="file" name="scan">
                            </div>
                            <div class="col">
                            <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#documentModal">
                                <i class="fa-solid fa-square-plus me-1"></i>
                                เพิ่มเอกสาร
                            </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
@endsection