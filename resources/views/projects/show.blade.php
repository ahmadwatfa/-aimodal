@extends('layout.admin')

@section('main')
    <style>
        #myBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            left: 30px;
            z-index: 99;
            border: none;
            background-color: #9B5FA3;
            color: white;
            cursor: pointer;
            padding: 15px;
            border-radius: 100px;
            font-size: 18px;
        }

        .market_img {
            display: flex;
            justify-content: left;

        }

        .market_img img {
            width: 500px;
        }

        @media(max-width:667px) {
            .market_img {
                display: flex;
                justify-content: left;
            }

            .market_img img {
                width: 300px;
            }

            .dwn-pdf {
                margin-top: 10px;
            }

        }

        #myBtn:hover {
            background-color: #555;
            /* Add a dark-grey background on hover */
        }
    </style>
    <div class="content-wrapper">
        <div class="container-fluid mt-5">
            <div class="download text-left mt-3">
                <h1 class="text-center">تقرير النتائج</h1>
                <form action="{{ route('pdf_generator') }}">
                    <button class="btn btn-primary dwn-pdf"><i class="fa fa-download" aria-hidden="true"></i>
                        تحميل التقرير ملف pdf </button>
                    <input type="hidden" name="id" value="{{ $report_sections[0]->project_id }}">
                </form>
                <form action="{{ route('word_generator') }}">
                    <button class="btn btn-primary dwn-pdf"><i class="fa fa-download" aria-hidden="true"></i>
                        تحميل التقرير ملف word </button>
                    <input type="hidden" name="id" value="{{ $report_sections[0]->project_id }}">
                </form>
            </div>
            <div class="container-fluid mt-5">
                <div>
                    <h3>فهرس التقرير</h3>
                    @foreach ($report_sections as $k => $report_section)
                        <ul>
                            @php
                                if ($report_section->completed == 1) {
                                    switch ($report_section->section_name) {
                                        case 'overview':
                                            echo ' <li><a href="#overview">المقدمة</a></li>';
                                            break;
                                        case 'executive_summary':
                                            echo ' <li><a href="#executive_summary">الملخص التنفيذي</a></li>';
                                            break;
                                        case 'idea_description':
                                            echo ' <li><a href="#idea_description">وصف المشروع</a></li>';
                                            break;
                                        case 'business_model_1':
                                            echo ' <li><a href="#business_model_1">Business model canvas</a></li>';
                                            break;
                                        case 'swot_analysis':
                                            echo ' <li><a href="#swot_analysis">SWOT Analysis</a></li>';
                                            break;
                                        case 'pestel_analysis':
                                            echo ' <li><a href="#pestel_analysis">PESTEL Analysis</a></li>';
                                            break;
                                        case 'porter_analysis':
                                            echo ' <li><a href="#porter_analysis">Porter\'s Five Forces</a></li>';
                                            break;
                                        case 'competitor_analysis':
                                            echo ' <li><a href="#competitor_analysis">تحليل المنافسين</a></li>';
                                            break;
                                        case 'industry_benchmarks_financial_1':
                                            echo ' <li><a href="#industry_benchmarks_financial">معايير الصناعة المالية </a></li>';
                                            break;
                                        case 'industry_benchmarks_non_financial':
                                            echo ' <li><a href="#industry_benchmarks_non_financial">معايير الصناعة الغير مالية </a></li>';
                                            break;
                                        case 'mvp_suggestion':
                                            echo '<li><a href="#mvp_suggestion">توصيات حول المشروع</a></li>';
                                            break;
                                        case 'success_rate':
                                            echo ' <li><a href="#success_rate">نسبة النجاح المتوقعة</a></li>';
                                            break;
                                        case 'suggestion':
                                            echo ' <li><a href="#success_rate">نصائح حول كيفية التحقق من صحة فكرة المشروع</a></li>';
                                            break;
                                        case 'mvp_development':
                                            echo ' <li><a href="#mvp_development">المراحل الرئيسية لتطوير المشروع</a></li>';
                                            break;
                                        case 'final_recommendation':
                                            echo ' <li><a href="#final_recommendation">الملخص التنفيذي النهائي</a></li>';
                                            break;
                                        default:
                                            echo ' ';
                                            break;
                                    }
                                }
                            @endphp
                        </ul>
                    @endforeach
                </div>

                @foreach ($report_sections as $k => $report_section)
                    <div class="mt-5">
                        @php
                            if ($report_section->completed == 1) {
                                switch ($report_section->section_name) {
                                    case 'overview':
                                        echo "<h1 class='$report_section->section_name' id='$report_section->section_name'>المقدمة</h1>";
                                        break;
                                    case 'executive_summary':
                                        echo "<h1 class='$report_section->section_name' id='$report_section->section_name'>الملخص التنفيذي</h1>";
                                        break;
                                    case 'idea_description':
                                        echo "<h1 class='$report_section->section_name' id='$report_section->section_name'>وصف المشروع</h1>";
                                        break;
                                    case 'business_model_1':
                                        echo "<h1 class='$report_section->section_name' id='$report_section->section_name'>Business model canvas</h1>";
                                        break;
                                    case 'swot_analysis':
                                        echo "<h1 class='$report_section->section_name' id='$report_section->section_name'>SWOT Analysis</h1>";
                                        break;
                                    case 'pestel_analysis':
                                        echo "<h1 class='$report_section->section_name' id='$report_section->section_name'>PESTEL Analysis</h1>";
                                        break;
                                    case 'porter_analysis':
                                        echo "<h1 class='$report_section->section_name' id='$report_section->section_name'>Porter's Five Forces</h1>";
                                        break;
                                    case 'competitor_analysis':
                                        echo "<h1 class='$report_section->section_name' id='$report_section->section_name'>تحليل المنافسين</h1>";
                                        break;
                                    case 'industry_benchmarks_financial_1':
                                        echo "<h1 class='$report_section->section_name' id='$report_section->section_name'>معايير الصناعة المالية </h1>";
                                        break;
                                    case 'industry_benchmarks_non_financial':
                                        echo "<h1 class='$report_section->section_name' id='$report_section->section_name'>معايير الصناعة الغير مالية </h1>";
                                        break;
                                    case 'mvp_suggestion':
                                        echo "<h1 class='$report_section->section_name' id='$report_section->section_name'>توصيات حول المشروع</h1>";
                                        break;
                                    case 'success_rate':
                                        echo "<h1 class='$report_section->section_name' id='$report_section->section_name'>نسبة النجاح المتوقعة</h1>";
                                        break;
                                    case 'suggestion':
                                        echo "<h1 class='$report_section->section_name' id='$report_section->section_name'>نصائح حول كيفية التحقق من صحة فكرة المشروع</h1>";
                                        break;
                                    case 'mvp_development':
                                        echo "<h1 class='$report_section->section_name' id='$report_section->section_name'>المراحل الرئيسية لتطوير المشروع</h1>";
                                        break;
                                    case 'final_recommendation':
                                        echo "<h1 class='$report_section->section_name' id='$report_section->section_name'>الملخص التنفيذي النهائي</h1>";
                                        break;
                                    default:
                                        echo ' ';
                                        break;
                                }
                            }
                        @endphp
                    </div>
                    <div class="pb-3 {{ $report_section->section_name . '_data' }}"
                        @if (
                            $report_section->section_name !== 'business_model_1' &&
                                $report_section->section_name !== 'business_model_2' &&
                                $report_section->section_name !== 'business_model_3' &&
                                $report_section->section_name !== 'business_model_4' &&
                                $report_section->section_name !== 'pestel_analysis' &&
                                $report_section->section_name !== 'pestel_analysis_1' &&
                                $report_section->section_name !== 'porter_analysis' &&
                                $report_section->section_name !== 'industry_benchmarks_non_financial' &&
                                $report_section->section_name !== 'swot_analysis' &&
                                $report_section->section_name !== 'swot_analysis_1' &&
                                $report_section->section_name !== 'industry_benchmarks_financial_1' &&
                                $report_section->completed == 1) style="margin-bottom: 25px; border-bottom:1px solid;padding-bottom:20px" @endif>

                        @if ($report_section->section_name == 'success_rate' && $report_section->completed == 1)
                            <div class="progress-container"
                                style="width: 100%; background-color: #e0e0e0; border-radius: 10px; overflow: hidden; position: relative; height: 30px; margin: 20px 0;">
                                <div class="progress-bar"
                                    style="height: 100%; width: 0; background-color: #4caf50; transition: width 1s;"></div>
                                <div class="percentage"
                                    style="position: absolute; left: 50%; transform: translateX(-50%); font-weight: bold; color: #fff;">
                                    0%</div>
                            </div>
                        @endif
                        {!! str_replace(['```html', '```', '###'], '', $report_section->response_openai) !!}
                        @if ($report_section->section_name == 'overview')
                            <div class="market_img">
                                <img src="../images/15.webp" alt="market_size">
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        @if (isset($labels) && $labels !== '[]')
            <div class="container-fluid mt-5">
                <h2>الاهتمام بمرور الوقت</h2>
                <div class="canvas-container">
                    <canvas id="interestChart"></canvas>
                </div>
            </div>
        @endif
        <div class="container-fluid mt-5">
            {{-- <div class="section">
                @if ($googleResults->isNotEmpty())
                    <h2>نتائج Google Custom Search</h2>
                    <ul class="list-group">
                        @foreach ($googleResults as $result)
                            <li class="list-group-item">
                                <h5>{{ $result->title }}</h5>
                                <p>{{ $result->snippet }}</p>
                                <a href="{{ $result->link }}" target="_blank">زيارة الرابط</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div> --}}
            <button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-arrow-up"
                    aria-hidden="true"></i></button>

        </div>
    </div>

    <script>
        const labels = {!! $labels !!};
        const values = {!! $values !!};

        const ctx = document.getElementById('interestChart').getContext('2d');
        const interestChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'الاهتمام بمرور الوقت',
                    data: values,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        // Get the button:
        let mybutton = document.getElementById("myBtn");

        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var success_rate = document.getElementsByClassName('success_rate_number')[0];
            if (success_rate) {
                const successRateText = success_rate.innerHTML;

                document.getElementsByClassName('success_rate_number')[0].style.display = 'none';
                const previousElement = document.getElementsByClassName('success_rate_number')[0]
                    .previousElementSibling;
                console.log(previousElement);
                if (previousElement == null) {
                    previousElement.style.display = 'none';
                }

                const successRate = parseInt(successRateText.trim(), 10); // تحويل النص إلى عدد صحيح

                const progressBar = document.querySelector('.progress-bar');
                const percentageText = document.querySelector('.percentage');

                if (successRate) {
                    progressBar.style.width = successRate + '%';
                    percentageText.innerText = successRate + '%';
                }
            }


        });
    </script>
@endsection
