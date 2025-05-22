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
                                            <th class="">ชื่อเอกสาร</th>
                                            <th class="">ประเภทเอกสาร</th>
                                            <th class="">เปิดปิดการแสดงผล</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($doc as $do)
                                        <tr>
                                            <td class="">{{ $do->name_type_doc }}</td>
                                            <td class="">
                                                <input 
                                                    type="checkbox" 
                                                    {{ $do->status == 'y' ? 'checked' : '' }} 
                                                    data-toggle="toggle" 
                                                    data-onlabel="{{ $do->status == 'y' ? 'แสดง' : 'ไม่แสดง' }}" 
                                                    data-offlabel="ไม่แสดง" 
                                                    data-offstyle="danger"
                                                />
                                                <button class="btn btn-warning">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                                <button class="btn btn-danger" onclick="">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
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
    <script>
    $(document).ready(function() {
        $('#docsList').DataTable({
            scrollX: true,
            language: {
                url: '/includes/languageDataTable.json',
            }
        });
    });
    </script>
</body>
@endsection