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
                        <div class="card">
                            <div class="card-body">
                                <table id="docsList" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">เลขที่</th>
                                            <th class="text-center">ชื่อ-นามสกุล</th>
                                            <th class="text-center">รายการคำขอเอกสาร</th>
                                            <th class="text-center">วันที่ร้องขอเอกสาร</th>
                                            <th class="text-center">สถานะ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($approve as $app)
                                        <tr>
                                            <td class="text-center">{{ $app->number}}</td>
                                            <td class="text-center">{{ $app->user->firstname }} {{ $app->user->lastname}}</td>
                                            <td class="">{{ $app->type_detail }}</td>
                                            <td class="text-center">{{ \Carbon\Carbon::parse($app->the_date)->addYear(543)->format('Y-m-d') }}</td>
                                            <td class="text-center">
                                                @if($app->status == 'success')
                                                    <button class="btn btn-success badge" disabled>อนุมัติ</button>
                                                @elseif($app->status == 'deny')
                                                    <!-- ปุ่มสำหรับสถานะ "ไม่อนุมัติ" -->
                                                    <button class="btn btn-danger badge" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#viewDetailModal" 
                                                            data-reason="{{ $app->not_approve_detail }}">
                                                        ไม่อนุมัติ
                                                    </button>
                                                @elseif($app->status == 'waiting')
                                                    <button class="btn btn-warning badge" disabled>รอรายละเอียด</button>
                                                @endif
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
        <!-- Modal -->
        <div class="modal fade" id="viewDetailModal" tabindex="-1" aria-labelledby="viewDetailModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="viewDetailModalLabel">เหตุผลที่ไม่อนุมัติ</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <textarea class="form-control" id="reason" rows="3" disabled></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
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

    document.addEventListener('DOMContentLoaded', () => {
        const viewDetailModal = document.getElementById('viewDetailModal');
        viewDetailModal.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget;
            const reason = button.getAttribute('data-reason');
            viewDetailModal.querySelector('#reason').value = reason || 'ไม่มีเหตุผลที่ระบุไว้';
        });
    });
</script>
@endsection