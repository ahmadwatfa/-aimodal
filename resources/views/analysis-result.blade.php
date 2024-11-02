<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقرير النتائج</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">تقرير النتائج</h1>

        <div class="section mt-4">
            <h2>نتائج OpenAI</h2>
            @foreach ($report_sections as $report_section)
                <pre>
@if ($report_section->section_name == 'overview')
{{ $report_section->response_openai }}
@endif
            </pre>
                <pre>
                @if ($report_section->section_name == 'executive_summary')
{{ $report_section->response_openai }}
@endif
            </pre>
                <pre>
                @if ($report_section->section_name == 'idea_description')
{{ $report_section->response_openai }}
@endif
            </pre>
                <pre>
                @if ($report_section->section_name == 'business_model')
{{ $report_section->response_openai }}
@endif
            </pre>
                <pre>
                @if ($report_section->section_name == 'swot_analysis')
{{ $report_section->response_openai }}
@endif
            </pre>
                <pre>
                @if ($report_section->section_name == 'pestel_analysis')
{{ $report_section->response_openai }}
@endif
            </pre>
                <pre>
                @if ($report_section->section_name == 'porter_analysis')
{{ $report_section->response_openai }}
@endif
            </pre>
                <pre>
                @if ($report_section->section_name == 'competitor_analysis')
{{ $report_section->response_openai }}
@endif
            </pre>
                <pre>
                @if ($report_section->section_name == 'industry_benchmarks')
{{ $report_section->response_openai }}
@endif
            </pre>
                <pre>
                @if ($report_section->section_name == 'success_rate')
{{ $report_section->response_openai }}
@endif
            </pre>
                <pre>
                @if ($report_section->section_name == 'mvp_development')
{{ $report_section->response_openai }}
@endif
</pre>
            @endforeach
        </div>

        <div class="container mt-5">
            <h1 class="text-center">الاهتمام بمرور الوقت</h1>

            <div class="section mt-4">
                <canvas id="interestChart" width="400" height="200"></canvas>
            </div>
        </div>

        <div class="section mt-4">
            <h2>نتائج Google Custom Search</h2>
            @if (isset($googleResults['items']) && is_array($googleResults['items']))
                <ul class="list-group">
                    @foreach ($googleResults['items'] as $result)
                        <li class="list-group-item">
                            <h5>{{ $result['title'] }}</h5>
                            <p>{{ $result['snippet'] }}</p>
                            <a href="{{ $result['link'] }}" target="_blank">زيارة الرابط</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>لا توجد نتائج متاحة من Google.</p>
            @endif
        </div>

        <div class="section mt-4">
            <h2>التمثيل البياني للبيانات</h2>
            <canvas id="myChart" width="400" height="200"></canvas>
        </div>
    </div>

    <script>
        const labels = {!! $labels !!}; // تمرير البيانات من PHP إلى JavaScript
        const values = {!! $values !!};

        const ctx = document.getElementById('interestChart').getContext('2d');
        const interestChart = new Chart(ctx, {
            type: 'line', // نوع المخطط
            data: {
                labels: labels,
                datasets: [{
                    label: 'الاهتمام بمرور الوقت',
                    data: values,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false,
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
