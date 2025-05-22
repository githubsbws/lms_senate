@extends('layout/mainlayout')
@section('content')
<body>
    <div class="status-main">
        {{-- <section class="banner-toggle">
            <div class="warp">
                <div class="card">
                    <p>ระบบสืบค้นข้อมูลรายงานการประชุม บันทึกการประชุม </p>
                    <p>และบันทึกการออกเสียงลงคะแนน ของสำนักงานเลขาธิการวุฒิสภา</p>
                    <div class="warp-toggle">
                        <a class="btn btn-light" href="{{route ('frontend.n_search') }}">ค้นหารายงานการประชุม</a>
                        <a class="btn btn-light" href="{{route ('frontend.a_search') }}">ค้นหารายงานการประชุมขั้นสูง</a>
                    </div>
                </div>
            </div>
        </section> --}}

        <section class="body-content mt-5">
            <div class="container">
                <div class="card">
                    <label for="form-control">
                        <h3>{{ $survey->survey_title }}</h3>
                    </label>
                    @php
                        $scaleLabels = [
                            5 => 'มากที่สุด',
                            4 => 'มาก',
                            3 => 'ปานกลาง',
                            2 => 'น้อย',
                            1 => 'น้อยที่สุด'
                        ];
                    @endphp
                    <form action="{{ route('survey.submit', $survey->id) }}" method="POST">
                        @csrf
                    
                        @foreach($survey->headings as $heading)
                            <div class="mb-4">
                                <table class="table table-bordered w-100">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%"><h5>{{ $heading->heading_text }}</h5></th>
                                            @if(!$heading->questions->contains('question_type', 'textarea'))
                                                @foreach($scaleLabels as $label)
                                                    <th class="text-center">{{ $label }}</th>
                                                @endforeach
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($heading->questions->sortBy('id') as $question)
                                            @if($question->question_type === 'textarea')
                                                <tr>
                                                    <td colspan="6">
                                                        <h5>{{ $question->question_text }}</h5>
                                                        <textarea name="answer[{{ $question->id }}]" rows="4" class="form-control mt-2"></textarea>
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td>{{ $question->question_text }}</td>
                                                    @foreach($scaleLabels as $value => $label)
                                                        <td class="text-center">
                                                            @if($question->question_type === 'single')
                                                                <input type="radio" name="answer[{{ $question->id }}]" value="{{ $value }}">
                                                            @elseif($question->question_type === 'multiple')
                                                                <input type="checkbox" name="answer[{{ $question->id }}][]" value="{{ $value }}">
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    
                        <div class="card-footer mt-3">
                            <button class="btn btn-primary" type="submit">บันทึกแบบสำรวจ</button>
                        </div>
                    </form>
                </div>                
            </div>
        </section>
    </div>
</body>
@endsection