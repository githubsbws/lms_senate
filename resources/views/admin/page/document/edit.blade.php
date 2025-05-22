@extends('admin/layouts/main2')
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
                        <form  action="{{ route('admin.document_update', ['file_id' => $file->id, 'page_number' => $textfile->page_number]) }}" method="POST" enctype="multipart/form-data" class="max-w-sm mx-auto">
                            @csrf
                        <div class="section d-flex mb-3">
                            <div class="col">
                                <div class="block w-full">
                                    <h2>ไฟล์ PDF ที่อัปโหลด:</h2>
                                    <iframe 
                                        src="{{ asset('uploads/pdf/' . $file->name_file) . '#page=' . $textfile->page_number }}" 
                                        width="100%" 
                                        height="600px" 
                                        class="rounded-lg">
                                    </iframe>
                                </div>
                            </div>
                            <div class="col">
                                <textarea id="summernote" name="text"><?php echo nl2br(htmlspecialchars($textfile->text)); ?></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#documentModal">
                            <i class="fa-solid fa-square-plus me-1"></i>
                            บันทึก
                        </button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
            });
    </script>
</body>
@endsection