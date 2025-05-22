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
                                    <form id="survey-form" method="POST" action="{{ route('admin.survey_edit', ['id' => $survey->id]) }}">
                                        @csrf
                                    
                                        <div class="mb-3">
                                            <label for="name" class="form-label fw-semibold">ชื่อหัวข้อแบบสำรวจ</label>
                                            <input type="text" class="form-control" name="survey_title" id="name" value="{{ $survey->survey_title }}">
                                        </div>
                                    
                                        <div id="headings-container">
                                            @foreach ($survey->headings as $hIndex => $heading)
                                            <div class="heading-section mb-4" data-heading-id="{{ $heading->id }}">
                                                <div class="mb-2">
                                                    <label class="form-label fw-bold">หัวข้อคำถาม</label>
                                                    <input type="hidden" name="headings[{{ $hIndex }}][id]" value="{{ $heading->id }}">
                                                    <input type="text" class="form-control" name="headings[{{ $hIndex }}][heading_text]" value="{{ $heading->heading_text }}">
                                                </div>
                                    
                                                @foreach ($heading->questions as $qIndex => $question)
                                                    @if($question->active == 'y' && $question->status == 'y')  {{-- เช็คว่า active และ status ของคำถามเป็น 'y' หรือไม่ --}}
                                                        <div class="question-section mb-3" data-question-id="{{ $question->id }}">
                                                            <label class="form-label fw-semibold">คำถาม</label>
                                                            <input type="hidden" name="headings[{{ $hIndex }}][questions][{{ $qIndex }}][id]" value="{{ $question->id }}">
                                                            <input type="text" name="headings[{{ $hIndex }}][questions][{{ $qIndex }}][text]" class="form-control mb-2" value="{{ $question->question_text }}">

                                                            <label class="form-label fw-semibold">ประเภทคำตอบ</label>
                                                            <select class="form-select mb-2" name="headings[{{ $hIndex }}][questions][{{ $qIndex }}][type]">
                                                                <option value="single" {{ $question->question_type == 'single' ? 'selected' : '' }}>คำตอบเดียว</option>
                                                                <option value="multiple" {{ $question->question_type == 'multiple' ? 'selected' : '' }}>หลายคำตอบ</option>
                                                                <option value="textarea" {{ $question->question_type == 'textarea' ? 'selected' : '' }}>ข้อความยาว</option>
                                                            </select>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            @endforeach
                                        </div>
                                    
                                        <button class="btn btn-primary mt-3" type="submit">บันทึกแบบสำรวจ</button>
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