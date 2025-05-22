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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($request as $req)
                                        <tr>
                                            <td class="text-center">{{ $req->number }}</td>
                                            <td class="text-center">{{ $req->user->firstname }} {{ $req->user->lastname }}</td>
                                            <td class="">{{ $req->type_detail }}</td>
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
</script>
@endsection