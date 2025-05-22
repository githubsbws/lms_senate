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
                                    <form id="survey-form" method="POST" action="/admin/save-survey">
                                        @csrf
                                    
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">ชื่อหัวข้อแบบสำรวจ</label>
                                            <input type="text" class="form-control" name="survey_title" required>
                                        </div>
                                    
                                        <button class="btn btn-success mb-3" type="button" id="add-heading-btn">
                                            <i class="fa-solid fa-plus me-1"></i> เพิ่มหัวข้อคำถาม
                                        </button>
                                    
                                        <div id="headings-container"></div>
                                    
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
    <script>
        let headingCount = 0;
        
        document.getElementById("add-heading-btn").addEventListener("click", function () {
            headingCount++;
            const headingId = Date.now();
            const headingsContainer = document.getElementById("headings-container");
        
            const headingSection = document.createElement("div");
            headingSection.classList.add("heading-section", "mb-4", "p-3", "border", "rounded");
            headingSection.dataset.id = headingId;
        
            headingSection.innerHTML = `
                <div class="mb-2">
                    <label class="form-label fw-semibold">หัวข้อคำถาม</label>
                    <input type="text" name="headings[${headingId}][heading_text]" class="form-control" required>
                </div>
                <div class="questions-container"></div>
                <button type="button" class="btn btn-secondary btn-sm mt-2 add-question-btn">
                    <i class="fa fa-plus"></i> เพิ่มคำถาม
                </button>
            `;
        
            headingsContainer.appendChild(headingSection);
        
            attachQuestionHandler(headingSection);
        });
        
        function attachQuestionHandler(headingSection) {
            const questionsContainer = headingSection.querySelector(".questions-container");
            const addQuestionBtn = headingSection.querySelector(".add-question-btn");
            const headingId = headingSection.dataset.id;
        
            addQuestionBtn.addEventListener("click", function () {
                const questionId = Date.now();
        
                const questionDiv = document.createElement("div");
                questionDiv.classList.add("mb-3", "border", "p-2", "rounded");
        
                questionDiv.innerHTML = `
                    <label class="form-label">คำถาม</label>
                    <input type="text" name="headings[${headingId}][questions][${questionId}][text]" class="form-control mb-2" required>
        
                    <label class="form-label">ประเภทคำถาม</label>
                    <select class="form-select" name="headings[${headingId}][questions][${questionId}][type]">
                        <option value="single">คำตอบเดียว (1-5)</option>
                        <option value="multiple">หลายคำตอบ (1-5)</option>
                        <option value="textarea">ข้อความยาว</option>
                    </select>
                `;
        
                questionsContainer.appendChild(questionDiv);
            });
        }
        </script>
</body>
@endsection