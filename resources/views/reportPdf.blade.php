<!doctype html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
    <link href="assets/css/report.css" type="text/css" rel="stylesheet" media="print" />

    <style>
        body,
        * {
            direction: rtl;
            text-align: right;

        }

        * {
            font-family: 'tajawal' !important;
        }
    </style>

</head>

<body style="font-family: 'tajawal' !important">
    <div class="content-wrapper">
        <div class="container-fluid mt-5">
            <div class="download text-left mt-3">
                <h1 class="text-center">تقرير النتائج</h1>

            </div>
            <div class="container-fluid mt-5">
                <div>
                    <h3>فهرس التقرير</h3>
                    @foreach ($report_sections as $k => $report_section)
                        <ul>
                            @php
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
                            @endphp
                        </ul>
                    @endforeach
                </div>

                @foreach ($report_sections as $k => $report_section)
                    <div class="mt-5">
                        @php
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
                        @endphp
                    </div>
                    <div class="pb-3 {{ $report_section->section_name . '_data' }}"
                        style="margin-bottom: 25px; border-bottom:1px solid;padding-bottom:20px">


                        {!! str_replace(['```html', '```'], '', $report_section->response_openai) !!}

                    </div>
                @endforeach
            </div>
        </div>



    </div>
</body>
