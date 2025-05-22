@extends('admin/layouts/main')
@section('content')
<div class="container">
    <h2>แก้ไขไฟล์ Synonym</h2>

     @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
        @php
            session()->forget('success'); // ล้างเองหลังแสดง
        @endphp
    @endif

    <form method="POST" action="{{ route('admin.synonym.update') }}">
        @csrf
        <div class="form-group">
            <label for="synonym">เนื้อหาในไฟล์ synonym.txt</label>
            <textarea name="synonym" id="synonym" rows="15" class="form-control">{{ old('synonym', $content) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3">บันทึก</button>
    </form>
</div>
@endsection