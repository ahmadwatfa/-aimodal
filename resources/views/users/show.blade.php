<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقرير النتائج</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.8;
            background-color: #f7f7f7;
        }

        h1,
        h2 {
            font-weight: bold;
            color: #2c3e50;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 30px;
            text-align: center;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #2980b9;
        }

        p {
            font-size: 1.2rem;
            color: #34495e;
        }

        .section {
            background-color: #fff;
            padding: 30px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            font-size: 1.1rem;
            padding: 10px 0;
            color: #7f8c8d;
        }

        .list-group-item {
            background-color: #ecf0f1;
            border: none;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .list-group-item h5 {
            font-size: 1.3rem;
            color: #2c3e50;
        }

        .list-group-item p {
            font-size: 1rem;
            color: #7f8c8d;
        }

        .list-group-item a {
            color: #2980b9;
            text-decoration: underline;
        }

        .canvas-container {
            padding: 20px;
            margin-top: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="container mt-5">
            <h1 class="text-center">تقرير النتائج</h1>
            <div id="json-data"></div>
        </div>
    </div>
    <div class="canvas-container">
        <h2>الاهتمام بمرور الوقت</h2>
        <canvas id="interestChart" width="400" height="200"></canvas>
    </div>

    <div class="section">
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

    <div class="canvas-container">
        <h2>التمثيل البياني للبيانات</h2>
        <canvas id="myChart" width="400" height="200"></canvas>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('interestChart').getContext('2d');
        const interestChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['يناير', 'فبراير', 'مارس', 'أبريل'],
                datasets: [{
                    label: 'الاهتمام بمرور الوقت',
                    data: [10, 50, 30, 90],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false
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
        $(document).ready(function() {
            // البيانات من Laravel بشكل JSON
            var reportSections = @json($report_sections);

            reportSections.forEach(function(section) {
                // تنظيف بيانات response_openai
                var cleanData = section.response_openai
                    .replace(/```json|```/g, '') // إزالة أي نص زائد
                    .replace(/“|”/g, '"') // استبدال الاقتباسات الذكية
                    .trim(); // إزالة الفراغات الزائدة

                try {
                    // تحويل النص إلى JSON
                    var jsonData = JSON.parse(cleanData);

                    // عرض اسم القسم
                    $('#json-data').append('<h2>' + section.section_name + '</h2>');

                    // دالة لعرض محتويات JSON بشكل ديناميكي
                    displayJSONData(jsonData);
                } catch (e) {
                    console.error('Error parsing JSON: ', e);
                    // عرض النص كما هو إذا حدث خطأ في التحليل
                    $('#json-data').append('<p>' + cleanData + '</p>');
                }
            });

            // دالة لعرض محتويات JSON بشكل ديناميكي
            function displayJSONData(jsonData) {
                if (typeof jsonData === 'object') {
                    for (var key in jsonData) {
                        if (jsonData.hasOwnProperty(key)) {
                            $('#json-data').append('<h4>' + key + '</h4>'); // عرض اسم الخاصية
                            if (typeof jsonData[key] === 'object') {
                                // إذا كانت القيمة كائن، استدعاء الدالة للتعامل مع الكائنات
                                displayJSONData(jsonData[key]);
                            } else {
                                // عرض القيم الأخرى
                                $('#json-data').append('<p>' + jsonData[key] + '</p>');
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
