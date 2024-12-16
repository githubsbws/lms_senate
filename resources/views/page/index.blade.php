@extends('layout/mainlayout')
@section('content')
<body>

    <div class="index-main">
        <section class="banner-toggle">
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
        </section>

        <section class="body-content">
            <div class="ul">
                <li><a href="">วุฒิสภา ปีที่ ๑ (ปี พ.ศ. ๒๕๖๗)</a></li>
                <li><a href="">วุฒิสภา ปีที่ ๑ (ปี พ.ศ. ๒๕๖๗)</a></li>
                <li><a href="">วุฒิสภา ปีที่ ๑ (ปี พ.ศ. ๒๕๖๗)</a></li>
                <li><a href="">วุฒิสภา ปีที่ ๑ (ปี พ.ศ. ๒๕๖๗)</a></li>
                <li><a href="">วุฒิสภา ปีที่ ๑ (ปี พ.ศ. ๒๕๖๗)</a></li>
            </div>
        </section>
    </div>

</body>
<script>
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
@endsection