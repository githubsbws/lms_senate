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
                                <div class="container mt-4">
                                    <form id="survey-form" method="POST" action="{{ route('admin.permission_update', ['id' => $user->id]) }}">
                                        @csrf
                                    
                                        <div class="mb-3">
                                            <label for="name" class="form-label fw-semibold">ชื่อผู้ใช้งาน</label>
                                            <input type="text" class="form-control" name="survey_title" id="name" value="{{ $user->username }}" disabled>
                                        </div>
                                        
                                        <div id="headings-container">
                                            <div class="heading-section mb-4">
                                                 <div class="mb-2"> 
                                                    <label for="typeuser" class="form-label fw-semibold">กำหนดสิทธิ์ผู้ใช้งาน</label>
                                                    <select name="typeuser" class="form-control">
                                                        <option value="" {{ old('typeuser', $user->type_user_id ?? null) === null ? 'selected' : '' }}>
                                                            -- กรุณาเลือกสิทธิ์ผู้ใช้งาน --
                                                        </option>
                                                        @foreach ($type as $ty)
                                                            <option value="{{ $ty->id }}" {{ old('typeuser', $user->type_user_id ?? null) == $ty->id ? 'selected' : '' }}>
                                                                {{ $ty->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary mt-3" type="submit">บันทึก</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        
    </div>
    
</body>
@endsection