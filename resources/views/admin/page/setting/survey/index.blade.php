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
                        <div class="section mb-3">
                            <a href="{{route('admin.survey_create')}}" type="button" class="btn btn-primary ms-auto">
                                <i class="fa-solid fa-square-plus me-1"></i>
                                เพิ่มเอกสาร
                            </a>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <table id="docsList" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="w-75">ชื่อแบบสำรวจ</th>
                                            <th class="">จัดการข้อมูล</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($survey as $sur)
                                        <tr>  
                                            <td>{{ $sur->survey_title }}</td>
                                            <td>
                                                <a href="{{ route('admin.survey_edit', $sur->id) }}" class="btn btn-warning">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>

                                                <a href="{{ route('admin.survey_del', $sur->id) }}" class="btn btn-danger">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                                
                                                <input type="checkbox" data-toggle="toggle" data-onlabel="" data-offlabel="" data-offstyle="success"
                                                        onchange="updateStatus({{ $sur->id }}, this.checked)" 
                                                        {{ $sur->sur_status == 'y' ? 'checked' : '' }} />
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

    </div>
</body>
<script>
    $(document).ready(function() {
        $('#docsList').DataTable({
            scrollX: true,
            language: {
                url: '/includes/languageDataTable.json',
            }
        });
    });

    function updateStatus(surveyId, status) {
        console.log("Survey ID:", surveyId);
        console.log("Status:", status ? 'y' : 'n');
        const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
        if (!csrfTokenElement) {
            console.error('CSRF token not found.');
            return;
        }
        const csrfToken = csrfTokenElement.getAttribute('content');

        fetch('/admin/survey_status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                survey_id: surveyId,
                status: status ? 'y' : 'n'
            })
        })
        .then(response => {
            if (!response.ok) {
                console.error('Error response:', response.statusText);
                alert('ไม่สามารถอัพเดตสถานะได้');
                return response.json();  // เพิ่มการแสดงข้อความ error
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                console.log('Status updated:', data);
                alert('สถานะอัพเดตเรียบร้อย');
            } else {
                console.error('Error updating status:', data.message);
                alert(data.message || 'เกิดข้อผิดพลาดในการอัพเดตสถานะ');
            }
        })
        .catch(error => {
            console.error('Error updating status', error);
            alert('เกิดข้อผิดพลาดในการอัพเดตสถานะ');
        });
    }

</script>
@endsection