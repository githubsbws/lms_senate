@extends('layout/mainlayout')
@section('content')
<style>
    .new-tag {
      color: red;
      font-weight: bold;
      margin-left: 8px;
      animation: blink 0.5s infinite;
    }

    @keyframes blink {
      0% { opacity: 1; }
      50% { opacity: 0; }
      100% { opacity: 1; }
    }
    
    .ul {
            list-style: none;
            padding: 0;
        }

    .ul li {
        margin: 5px 0;
        position: relative;
    }

    .ul a {
        text-decoration: none;
        color: #333;
    }
    .submenu {
        list-style-type: none; /* ลบการแสดง bullet */
        padding: 0;
        margin: 5px 0 5px 20px;
    }
  </style>
<body>

    <div class="index-main">
        <section class="banner-toggle">
            <div class="warp">
                <div class="card">
                    <p>ระบบสืบค้นข้อมูลรายงานการประชุม บันทึกการประชุม </p>
                    <p>และบันทึกการออกเสียงลงคะแนน ของสำนักงานเลขาธิการวุฒิสภา</p>
                    <div class="warp-toggle">
                        <a class="btn btn-light" href="{{route ('frontend.a_search') }}">ค้นหารายงานการประชุม</a>
                        <a class="btn btn-light" href="{{route ('frontend.n_search') }}">ค้นหารายงานการประชุมขั้นสูง</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="body-content">
            <div class="ul">
                <li><i class="bi bi-caret-right-fill"></i><a href="javascript:void(0)" onclick="toggleDropdownIcon(this, '2568')">การประชุมวุฒิสภา ปี พ.ศ. 2568</a><span class="new-tag">New</span></li>
                <li><i class="bi bi-caret-right-fill"></i><a href="javascript:void(0)" onclick="toggleDropdownIcon(this,'2567')">การประชุมวุฒิสภา ปี พ.ศ. 2567</a></li>
                <li><i class="bi bi-caret-right-fill"></i><a href="javascript:void(0)" onclick="toggleDropdownIcon(this,'2566')">การประชุมวุฒิสภา ปี พ.ศ. 2566</a></li>
                <li><i class="bi bi-caret-right-fill"></i><a href="javascript:void(0)" onclick="toggleDropdownIcon(this,'2565')">การประชุมวุฒิสภา ปี พ.ศ. 2565</a></li>
                <li><i class="bi bi-caret-right-fill"></i><a href="javascript:void(0)" onclick="toggleDropdownIcon(this,'2564')">การประชุมวุฒิสภา ปี พ.ศ. 2564</a></li>
                <li><i class="bi bi-caret-right-fill"></i><a href="javascript:void(0)" onclick="toggleDropdownIcon(this,'2563')">การประชุมวุฒิสภา ปี พ.ศ. 2563</a></li>
                <li><i class="bi bi-caret-right-fill"></i><a href="javascript:void(0)" onclick="toggleDropdownIcon(this,'2562')">การประชุมวุฒิสภา ปี พ.ศ. 2562</a></li>
                <li><i class="bi bi-caret-right-fill"></i><a href="javascript:void(0)" onclick="toggleDropdownIcon(this,'2561')">การประชุมวุฒิสภา ปี พ.ศ. 2561</a></li>
                <li><i class="bi bi-caret-right-fill"></i><a href="javascript:void(0)" onclick="toggleDropdownIcon(this,'2560')">การประชุมวุฒิสภา ปี พ.ศ. 2560</a></li>
                <li><i class="bi bi-caret-right-fill"></i><a href="javascript:void(0)" onclick="toggleDropdownIcon(this,'2559')">การประชุมวุฒิสภา ปี พ.ศ. 2559 - 2535</a></li>

            </div>
        </section>
    </div>

</body>
<script>

    function toggleDropdownIcon(anchor, year) {
        const icon = anchor.previousElementSibling;
        if (icon.classList.contains("bi-caret-right-fill")) {
            icon.classList.remove("bi-caret-right-fill");
            icon.classList.add("bi-caret-down-fill");
        } else {
            icon.classList.remove("bi-caret-down-fill");
            icon.classList.add("bi-caret-right-fill");
        }
        showDropdown(anchor, year)
    }
    function showDropdown(linkElement, year) {
        const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
        const userTypeId = {!! json_encode(Auth::check() ? Auth::user()->type_user_id : null) !!};
        event.preventDefault();

        currentYear = year;
        console.log(year);
        const parentLi = linkElement.parentElement;

        // ถ้ามี submenu อยู่แล้ว → toggle
        const existingSubmenu = parentLi.querySelector('.submenu');
        console.log(existingSubmenu);
        if (existingSubmenu) {
            existingSubmenu.remove(); // toggle โดยลบ submenu ออก
            return;
        }

        // ถ้าไม่มี submenu → สร้างใหม่
        const submenu = document.createElement('ul');
        submenu.classList.add('submenu');
        submenu.style.listStyle = 'none'; // ตัด bullet point ออก
        submenu.style.margin = '10px 0 10px 20px'; // ตกแต่งเพิ่มเติมได้

        const items = [
            { id: 1, name: '1.บันทึกการประชุม' },
            { id: 2, name: '2.รายงานการประชุม' },
            { id: 3, name: '3.บันทึกการออกเสียงลงคะแนน' },
        ];

        if (isLoggedIn && userTypeId === 6) {
            items.push({ id: 4, name: '4.ใบประมวลการออกเสียงลงคะแนน' });
            items.push({ id: 5, name: '5.บันทึกเหตุการสำคัญ'});
        }

        items.forEach(item => {
            const li = document.createElement('li');
            const a = document.createElement('a');
            a.href = "#";
            a.innerText = item.name;
            a.addEventListener('click', function (e) {
            e.preventDefault();

            // ลบ submenu เดิมถ้ามี (toggle)
            const existingSub = li.querySelector('.submenu');
            if (existingSub) {
                existingSub.remove();
                return;
            }

            // ดึงข้อมูลจาก API
            fetch(`/api/menu-file/${item.id}/${year}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    const fileList = document.createElement('ul');
                    fileList.classList.add('submenu');
                    fileList.style.marginLeft = '20px';

                    if(!data.files || data.files.length === 0){
                        const fileLi = document.createElement('li');
                        fileLi.innerText = '- ไม่มีข้อมูล -';
                        fileLi.style.color = 'red';
                        fileList.appendChild(fileLi);
                    }
                    data.files.forEach(file => {
                        const fileLi = document.createElement('li');
                        const fileA = document.createElement('a');
                        fileA.href = file.url;
                        fileA.innerText = file.name;
                        fileA.target = "_blank";
                        fileLi.appendChild(fileA);
                        fileList.appendChild(fileLi);
                    });

                    li.appendChild(fileList);
                })
                .catch(error => console.error('API error:', error));
            });
            li.appendChild(a);
            submenu.appendChild(li);
        });

        parentLi.appendChild(submenu);
    }

//////////////////////////////////////////////////////////////////

    var splideindex = new Splide('#splideindex', {
        type: 'loop',
        perPage: 1,
        perMove: 1,
        autoplay: true,
        breakpoints: {
            640: {
                perPage: 1,
            },
        }
    });


    splideindex.mount();
    // splideone.mount();



    const scrollElements = document.querySelectorAll(".js-scroll");

    const elementInView = (el, dividend = 1) => {
        const elementTop = el.getBoundingClientRect().top;

        return (
            elementTop <=
            (window.innerHeight || document.documentElement.clientHeight) / dividend
        );
    };

    const elementOutofView = (el) => {
        const elementTop = el.getBoundingClientRect().top;

        return (
            elementTop > (window.innerHeight || document.documentElement.clientHeight)
        );
    };

    const displayScrollElement = (element) => {
        element.classList.add("scrolled");
    };

    const hideScrollElement = (element) => {
        element.classList.remove("scrolled");
    };

    const handleScrollAnimation = () => {
        scrollElements.forEach((el) => {
            if (elementInView(el, 1.25)) {
                displayScrollElement(el);
            } else if (elementOutofView(el)) {
                hideScrollElement(el)
            }
        })
    }

    window.addEventListener("scroll", () => {
        handleScrollAnimation();
    });
</script>

<script>
    document.getElementById('video').play();
</script>

<script async src="https://www.googletagmanager.com/gtag/js?id=G-85VBDMMB39"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-85VBDMMB39');
</script>

@endsection