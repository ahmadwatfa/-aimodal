<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'tajawal', sans-serif;
        }

        .card {
            background-color: white;
            border-radius: 15px;
            padding: 30px;
        }

        h1,
        h2,
        h3 {
            color: #1E1E1E;
        }

        p,
        li {
            line-height: 1.8;
            color: #4a4a4a;
        }

        .container {
            max-width: 900px;
        }

        .strength {
            background-color: #e0f7fa;
        }

        .weakness {
            background-color: #ffebee;
        }

        .opportunity {
            background-color: #e8f5e9;
        }

        .threat {
            background-color: #fff3e0;
        }

        .shadow-lg,
        .shadow-sm {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body ul {
            margin-top: 15px;
        }

        .card-body img {
            margin: 20px 0;
        }

        .business-model .solution,
        .business-model .problem {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 40px;
        }

        .business-model .problem {
            margin-bottom: 15px;
        }

        @media (max-width:776px) {
            .problem .nishan {
                width: 300px
            }
        }

        .list-unstyled {
            text-align: left
        }

        .arow {
            transform: scaleX(-1);
            width: 24px;
            margin: 0 !important;
        }

        .chart-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
        }

        .chart-container div {
            flex: 1;
            margin: 10px;
        }

        table {
            width: 100%;
        }

        table tbody tr {
            font-weight: bold;
        }

        table td {
            padding: 10px;
        }

        .chart-container canvas {
            max-width: 100%;
            height: auto;
        }

        @media (max-width: 768px) {
            .chart-container {
                flex-direction: column;
                text-align: center;
            }

            table td {
                padding: 5px;
            }
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .purple {
            color: #413783
        }

        .turquoise {
            color: #19A0B3
        }

        .yellow {
            color: #F9AA1C
        }

        .key {
            transform: rotate(45deg);
        }

        .pestel-card {
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 10px;
            transition: 0.3s;
            height: 100%;
        }

        .pestel-card h4 {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: #1E4983;
        }

        .pestel-card p {
            font-size: 1rem;
            color: #4a4a4a;
        }

        .political {
            background-color: #e8f4fa;
        }

        .economic {
            background-color: #f0e5de;
        }

        .social {
            background-color: #e5e8f0;
        }

        .technological {
            background-color: #e0f2f1;
        }

        .environmental {
            background-color: #e6f7eb;
        }

        .legal {
            background-color: #f9ebea;
        }

        .pestel-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .success-indicator {
            display: grid;
            /* استخدام Grid بدلاً من Flex */
            grid-template-columns: 1fr;
            /* عمود واحد */
            align-items: center;
            /* توسيط العناصر عمودياً */
            margin-top: 50px;
        }

        .gauge {
            width: 250px;
            height: 125px;
            overflow: hidden;
            margin: 0 auto;
            /* توسيط العنصر */
        }

        .gauge .arc {
            fill: none;
            stroke-width: 20;
        }

        .gauge .arc-bg {
            stroke: #e0e0e0;
        }

        .gauge .arc-fill {
            stroke: #6a1b9a;
        }

        .gauge .needle {
            stroke: #d32f2f;
            stroke-width: 3;
            fill: none;
        }

        .gauge .center {
            fill: #fff;
            stroke: #000;
            stroke-width: 2;
        }

        .percentage {
            font-size: 24px;
            margin-top: 20px;
            font-weight: bold;
            color: #6a1b9a;
            text-align: center;
            /* توسيط النص */
        }

        .chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }

        #targetAudienceChart {
            width: 300px !important;
            height: 300px !important;
        }
    </style>
</head>

<body>

    <!-- الصفحة الأولى -->
    <div class="container mt-5">
        <div class="card shadow-lg mb-5">
            <div class="card-body">
                <h1 class="text-center mb-4 purple">Executive Summary</h1>
                <p>
                    The project aims to develop a child safety electronic bracelet that connects with a mobile
                    application, providing real-time tracking of children’s location, geofencing capabilities, and
                    emergency alerts through an SOS button. This technology-driven product is targeted at parents who
                    prioritize their children's safety.
                </p>

                <h2 class="mt-4 turquoise">Business Overview</h2>
                <p>
                    Alamal operates with a clear vision to cater to health-conscious individuals and families seeking
                    fresh, organic dining options. Our menu showcases a diverse selection of dishes that not only
                    promote well-being but also enhance the culinary experience through the use of locally sourced
                    ingredients. By engaging with local farmers and suppliers, Alamal ensures the utmost quality in
                    every dish served, enabling patrons to enjoy meals that are both nutritious and delightful.
                </p>

                <h2 class="mt-4 turquoise">Mission</h2>
                <p>
                    At Alamal, our mission is to redefine the dining experience by prioritizing health, sustainability,
                    and exceptional flavors. We aim to inspire our guests to make mindful food choices that contribute
                    to their well-being while experiencing the joys of natural ingredients. Through our commitment to
                    organic farming and responsible sourcing, we seek to create a community of health-conscious
                    individuals who value quality and sustainability.
                </p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card shadow-lg mb-5">
            <h1 class="text-center mb-4 purple">SWOT Analysis</h1>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm text-center strength">
                        <div class="card-body">
                            <h3><svg width="32" height="32" viewBox="0 0 25 23" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_243_19)">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M3.93684 6.66652C3.93684 5.55223 5.04739 4.80835 6.18451 4.80835C7.32166 4.80835 8.43218 5.55224 8.43218 6.66652L8.43218 16.0933C8.43218 17.2076 7.32166 17.9515 6.18451 17.9515C5.0474 17.9515 3.93684 17.2076 3.93684 16.0933L3.93684 6.66652ZM6.18451 6.16799C5.66649 6.16799 5.43529 6.47927 5.43529 6.66652L5.43529 16.0933C5.43529 16.2806 5.66649 16.5919 6.18451 16.5919C6.70255 16.5919 6.93373 16.2806 6.93373 16.0933L6.93373 6.66652C6.93373 6.47927 6.70255 6.16799 6.18451 6.16799Z"
                                            fill="#1E4983" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M16.9234 6.66652C16.9234 5.55224 18.0339 4.80835 19.1711 4.80835C20.3082 4.80835 21.4187 5.55224 21.4187 6.66652V16.0933C21.4187 17.2076 20.3082 17.9515 19.1711 17.9515C18.0339 17.9515 16.9234 17.2076 16.9234 16.0933V6.66652ZM19.1711 6.16799C18.653 6.16799 18.4218 6.47927 18.4218 6.66652V16.0933C18.4218 16.2806 18.653 16.5919 19.1711 16.5919C19.6891 16.5919 19.9203 16.2806 19.9203 16.0933V6.66652C19.9203 6.47927 19.6891 6.16799 19.1711 6.16799Z"
                                            fill="#1E4983" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0.939941 8.96281C0.939941 7.84681 2.03165 7.07441 3.18761 7.07441C4.34357 7.07441 5.43529 7.84681 5.43529 8.96281V13.797C5.43529 14.913 4.34357 15.6854 3.18761 15.6854C2.03165 15.6854 0.939941 14.913 0.939941 13.797L0.939941 8.96281ZM3.18761 8.43405C2.68844 8.43405 2.43839 8.74383 2.43839 8.96281L2.43839 13.797C2.43839 14.016 2.68844 14.3258 3.18761 14.3258C3.68679 14.3258 3.93684 14.016 3.93684 13.797L3.93684 8.96281C3.93684 8.74383 3.68679 8.43405 3.18761 8.43405Z"
                                            fill="#1E4983" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M19.9203 8.96281C19.9203 7.84681 21.012 7.07441 22.168 7.07441C23.324 7.07441 24.4156 7.84681 24.4156 8.96281V13.797C24.4156 14.913 23.324 15.6854 22.168 15.6854C21.012 15.6854 19.9203 14.913 19.9203 13.797V8.96281ZM22.168 8.43405C21.6688 8.43405 21.4187 8.74382 21.4187 8.96281V13.797C21.4187 14.016 21.6688 14.3258 22.168 14.3258C22.6672 14.3258 22.9172 14.016 22.9172 13.797V8.96281C22.9172 8.74382 22.6672 8.43405 22.168 8.43405Z"
                                            fill="#1E4983" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M6.93373 12.7396C6.93373 13.115 7.26917 13.4194 7.68296 13.4194L17.6726 13.4194C18.0864 13.4194 18.4218 13.115 18.4218 12.7396V10.0203C18.4218 9.64484 18.0864 9.34047 17.6726 9.34047L7.68296 9.34047C7.26917 9.34047 6.93373 9.64484 6.93373 10.0203V12.7396ZM8.43218 12.0597V10.7001H16.9234V12.0597L8.43218 12.0597Z"
                                            fill="#1E4983" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_243_19">
                                            <rect width="23.9752" height="21.7542" fill="white"
                                                transform="translate(0.690186 0.502808)" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                Strengths</h3>
                            <ul class="list-unstyled mt-3">
                                <li><img src="images/arow.png" alt="arow" class="arow"> Growing consumer trend
                                    towards health and wellness dining experiences.</li>
                                <li><img src="images/arow.png" alt="arow" class="arow"> Potential partnerships
                                    with local farms and producers for sustainable sourcing.</li>
                                <li><img src="images/arow.png" alt="arow" class="arow"> Expansion of catering
                                    services for health-focused events and gatherings.</li>
                                <li><img src="images/arow.png" alt="arow" class="arow"> Increasing interest in
                                    plant-based and vegetarian menu options.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100 shadow-sm text-center weakness">
                        <div class="card-body">
                            <h3><svg width="32" height="32" viewBox="0 0 25 23" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1.38574 9.11382C1.38574 5.98506 4.18857 3.44867 7.64602 3.44867C9.41665 3.44867 11.0154 4.11433 12.1534 5.1824C13.2914 4.11433 14.8902 3.44867 16.6608 3.44867C20.1183 3.44867 22.9211 5.98506 22.9211 9.11382C22.9211 9.48928 22.5848 9.79364 22.1699 9.79364C21.755 9.79364 21.4186 9.48928 21.4186 9.11382C21.4186 6.73597 19.2885 4.80831 16.6608 4.80831C15.0523 4.80831 13.63 5.53001 12.7676 6.63813C12.6269 6.81895 12.3978 6.92653 12.1534 6.92653C11.909 6.92653 11.6799 6.81895 11.5392 6.63813C10.6769 5.53001 9.25454 4.80831 7.64602 4.80831C5.01836 4.80831 2.88821 6.73597 2.88821 9.11382C2.88821 11.3454 4.3574 13.5614 6.36435 15.3955C8.26866 17.1358 10.5417 18.4252 12.1534 18.965C12.6422 18.8013 13.199 18.5661 13.795 18.2645C14.1572 18.0813 14.6149 18.1984 14.8174 18.5261C15.0198 18.8538 14.8904 19.268 14.5283 19.4513C13.7723 19.8338 13.0434 20.1343 12.3904 20.3307C12.2365 20.3769 12.0703 20.3769 11.9165 20.3307C10.0308 19.7636 7.42888 18.3007 5.29673 16.3522C3.1719 14.4103 1.38574 11.8676 1.38574 9.11382Z"
                                        fill="#CDBC03" />
                                    <path
                                        d="M17.1693 12.2111C17.4918 11.9749 17.9649 12.02 18.2259 12.3119L21.6707 16.1642C21.9317 16.456 21.8818 16.8841 21.5593 17.1203C21.2368 17.3565 20.7638 17.3113 20.5028 17.0195L17.0579 13.1672C16.7969 12.8753 16.8468 12.4472 17.1693 12.2111Z"
                                        fill="#CDBC03" />
                                    <path
                                        d="M21.5593 12.2111C21.8818 12.4472 21.9317 12.8753 21.6707 13.1672L18.2259 17.0195C17.9649 17.3113 17.4918 17.3565 17.1693 17.1203C16.8468 16.8841 16.7969 16.456 17.0579 16.1642L20.5028 12.3119C20.7638 12.02 21.2368 11.9749 21.5593 12.2111Z"
                                        fill="#CDBC03" />
                                </svg>
                                Weaknesses</h3>
                            <ul class="list-unstyled mt-3">
                                <li> <img src="images/arow.png" alt="arow" class="arow"> High costs associated
                                    with organic ingredients.</li>
                                <li> <img src="images/arow.png" alt="arow" class="arow"> Limited availability of
                                    local organic produce.</li>
                                <li> <img src="images/arow.png" alt="arow" class="arow"> Challenges in expanding
                                    beyond niche health-conscious market.</li>
                                <li> <img src="images/arow.png" alt="arow" class="arow"> Need for continuous
                                    supplier relationship management.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100 shadow-sm text-center opportunity">
                        <div class="card-body">
                            <h3><svg width="32" height="32" viewBox="0 0 25 22" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M19.0219 19.0434C16.1478 18.4124 13.8491 18.1408 12.1035 18.2016C10.3701 18.2619 8.49553 18.6745 6.47425 19.4605C6.09306 19.6087 5.65125 19.4493 5.48745 19.1043C5.32364 18.7594 5.49987 18.3596 5.88106 18.2113C8.03403 17.3741 10.0908 16.911 12.0457 16.8429C13.9886 16.7753 16.4396 17.0774 19.3762 17.7221C19.7793 17.8106 20.0269 18.1781 19.9291 18.543C19.8313 18.9079 19.4251 19.1319 19.0219 19.0434Z"
                                        fill="#146B17" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12.883 9.56831C13.2837 9.66567 13.5213 10.0385 13.4137 10.4012C12.744 12.6583 12.5774 15.8906 12.9589 20.1405C12.9925 20.5147 12.6845 20.8427 12.271 20.8731C11.8574 20.9035 11.495 20.6248 11.4614 20.2506C11.0747 15.9437 11.2267 12.5289 11.9626 10.0486C12.0702 9.68598 12.4823 9.47095 12.883 9.56831Z"
                                        fill="#146B17" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M21.9425 6.99295C20.3696 6.24236 18.7696 6.09528 17.1036 6.5314C15.561 6.93518 14.3381 8.14975 13.5614 10.4629C15.6203 11.6156 17.4523 11.6984 19.1607 10.8737C20.1273 10.4071 20.8169 9.82417 21.2678 9.13539C21.6597 8.53699 21.8911 7.82856 21.9425 6.99295ZM16.6861 5.22531C18.9027 4.64506 21.0536 4.91756 23.0897 6.01725C23.3159 6.13944 23.4549 6.35996 23.4559 6.59839C23.461 7.8081 23.1726 8.89353 22.5604 9.82847C21.948 10.7639 21.0376 11.5087 19.8679 12.0733C17.4262 13.252 14.8483 12.9334 12.2615 11.3173C12.0009 11.1545 11.8811 10.8613 11.962 10.5842C12.7899 7.74866 14.3137 5.84626 16.6861 5.22531Z"
                                        fill="#146B17" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M2.60117 1.85085C5.54113 1.06349 8.2051 1.37215 10.5075 2.83839C12.9117 4.36951 13.7645 6.96654 13.3304 10.3549C13.2964 10.6197 13.0945 10.8422 12.814 10.9238C9.54195 11.8756 6.72315 11.5681 4.52326 9.83062C2.32586 8.09508 1.56621 5.56193 2.07087 2.40538C2.11286 2.14271 2.31994 1.92617 2.60117 1.85085ZM3.49605 3.03899C3.17836 5.6602 3.89933 7.53317 5.51122 8.80626C7.11749 10.0749 9.19605 10.4398 11.8871 9.7567C12.1577 6.88347 11.3336 5.02704 9.6428 3.95029C7.8806 2.82807 5.85531 2.50734 3.49605 3.03899Z"
                                        fill="#146B17" />
                                </svg>
                                Opportunities</h3>
                            <ul class="list-unstyled mt-3">
                                <li><img src="images/arow.png" alt="arow" class="arow"> Growing consumer trend
                                    towards health and wellness dining experiences.</li>
                                <li><img src="images/arow.png" alt="arow" class="arow"> Potential partnerships
                                    with local farms and producers for sustainable sourcing.</li>
                                <li><img src="images/arow.png" alt="arow" class="arow"> Expansion of catering
                                    services for health-focused events and gatherings.</li>
                                <li><img src="images/arow.png" alt="arow" class="arow"> Increasing interest in
                                    plant-based and vegetarian menu options.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100 shadow-sm text-center threat">
                        <div class="card-body">
                            <h3><svg width="32" height="32" viewBox="0 0 25 22" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M15.7944 1.81595C16.0837 1.68461 16.4335 1.73577 16.6624 1.94291L22.3286 7.0704C22.5573 7.27736 22.6139 7.59356 22.4692 7.85531C22.3244 8.11707 22.0108 8.2656 21.6907 8.22403L19.7252 7.96883L16.6201 13.0258C16.9933 13.7854 17.2201 14.5378 17.1836 15.2798C17.1405 16.1563 16.7345 16.9397 15.9595 17.6411C15.8186 17.7686 15.6275 17.8402 15.4283 17.8402C15.229 17.8402 15.0379 17.7686 14.897 17.6411L11.4591 14.53L3.82894 19.6347C3.53019 19.8346 3.11485 19.8068 2.85181 19.5693C2.58877 19.3319 2.55703 18.9561 2.77715 18.6853L8.40223 11.7637L4.98165 8.66833C4.68828 8.40285 4.68789 7.97207 4.98126 7.70658C5.75922 7.00255 6.65293 6.62915 7.62917 6.58442C8.45692 6.5465 9.28738 6.74724 10.0978 7.10087L15.6742 4.30384L15.3878 2.52145C15.3412 2.23157 15.505 1.94728 15.7944 1.81595ZM6.63523 8.24189L9.92099 11.2153C10.1834 11.4528 10.2149 11.8282 9.99498 12.0988L6.93179 15.868L11.0862 13.0886C11.3852 12.8885 11.801 12.9166 12.064 13.1546L15.3692 16.1456C15.5748 15.8378 15.6672 15.5326 15.6826 15.2193C15.7083 14.6978 15.5241 14.0765 15.1025 13.2984C14.9943 13.0986 15.001 12.8635 15.1204 12.6689L18.6631 6.89922C18.8144 6.6528 19.1181 6.51645 19.4265 6.55649L19.6709 6.58823L17.2003 4.35251L17.2358 4.57292C17.2807 4.85262 17.1297 5.12832 16.8565 5.26535L10.4751 8.46616C10.2496 8.57927 9.97577 8.57983 9.7497 8.46765C8.97086 8.08114 8.29164 7.91545 7.70514 7.94232C7.3433 7.9589 6.9871 8.04989 6.63523 8.24189Z"
                                        fill="#C44E4E" />
                                </svg>
                                Threats</h3>
                            <ul class="list-unstyled mt-3">
                                <li><img src="images/arow.png" alt="arow" class="arow"> Increasing competition
                                    from other organic restaurants.</li>
                                <li><img src="images/arow.png" alt="arow" class="arow"> Economic fluctuations
                                    affecting customer spending.</li>
                                <li><img src="images/arow.png" alt="arow" class="arow"> Supply chain
                                    disruptions for organic ingredients.</li>
                                <li><img src="images/arow.png" alt="arow" class="arow"> Customer perception
                                    shifts towards lower-cost dining options.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5 business-model">
        <div class="card shadow-lg mb-5">
            <div class="card-body">
                <h2 class="text-center mb-4 purple">Business Model</h2>
                <h4 class="turquoise">1- Problems</h4>
                <div class="problem">
                    <ul class="list-unstyled">
                        <li><img src="images/arow.png" alt="arow" class="arow"> Lack of quality assurance for
                            pre-packaged imported products.</li>
                        <li><img src="images/arow.png" alt="arow" class="arow"> Products come pre-packaged and
                            are of lower quality and difficult to know.</li>
                        <li><img src="images/arow.png" alt="arow" class="arow"> High cost of importing
                            ready-made products.</li>
                        <li><img src="images/arow.png" alt="arow" class="arow"> High prices of products and
                            high costs of shipping and import in general.</li>
                        <li><img src="images/arow.png" alt="arow" class="arow"> Difficulty in customizing
                            packaging, which constitutes an obstacle to marketing and building
                            a
                            brand.</li>
                    </ul>
                    <div class="text-center my-4 key">
                        <img src="images/key.png" alt="Key Icon" width="200">
                    </div>
                </div>
                <h4 class="turquoise">2- Solution</h4>
                <div class="solution">
                    <ul class="list-unstyled">
                        <li><img src="images/arow.png" alt="arow" class="arow"> Lack of quality assurance for
                            pre-packaged imported products.</li>
                        <li><img src="images/arow.png" alt="arow" class="arow"> Products come pre-packaged and
                            are of lower quality and difficult to know.</li>
                        <li><img src="images/arow.png" alt="arow" class="arow"> High cost of importing
                            ready-made products.</li>
                        <li><img src="images/arow.png" alt="arow" class="arow"> Difficulty in customizing
                            packaging, which constitutes an obstacle to marketing and building
                            a
                            brand.</li>
                    </ul>
                    <div class="text-center my-4">
                        <img src="images/lamp.png" alt="Light Bulb Icon" width="200">
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="container mt-5 business-model">
        <div class="card shadow-lg mb-5">
            <div class="card-body">

                <h4 class="turquoise">3- Competitive Advantages</h4>
                <div class="problem">
                    <ul class="list-unstyled">
                        <li><img src="images/true.png" alt="true" width="30px"> Lack of quality assurance for
                            pre-packaged imported products.</li>
                        <li><img src="images/true.png" alt="true" width="30px"> Products come pre-packaged and
                            are of lower quality and difficult to know.</li>
                        <li><img src="images/true.png" alt="true" width="30px"> High cost of importing
                            ready-made products.</li>
                        <li><img src="images/true.png" alt="true" width="30px"> High prices of products and
                            high costs of shipping and import in general.</li>
                        <li><img src="images/true.png" alt="true" width="30px"> Difficulty in customizing
                            packaging, which constitutes an obstacle to marketing and building
                            a
                            brand.</li>
                    </ul>
                    <div class="text-center my-4 arrow">
                        <img src="images/img.png" alt="Nishan" width="400" class="nishan"
                            style="transform: rotate(225deg);">
                    </div>
                </div>
                <h4 class="turquoise">4- Target customers</h4>
                <div class="solution">
                    <ul class="list-unstyled">
                        <li><img src="images/true.png" alt="true" width="30px"> Lack of quality assurance for
                            pre-packaged imported products.</li>
                        <li><img src="images/true.png" alt="true" width="30px"> Products come pre-packaged and
                            are of lower quality and difficult to know.</li>
                        <li><img src="images/true.png" alt="true" width="30px"> High cost of importing
                            ready-made products.</li>
                        <li><img src="images/true.png" alt="true" width="30px"> Difficulty in customizing
                            packaging, which constitutes an obstacle to marketing and building
                            a
                            brand.</li>
                    </ul>
                    <div class="text-center my-4 mt-5">
                        <img src="images/chat.png" alt="Light Bulb Icon" width="250">
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="container mt-5">
        <div class="card shadow-lg mb-5">
            <div class="text-center mb-4">
                <h1 class="purple">Market Size</h1>
                <h2 class="turquoise">Target Market</h2>
            </div>

            <div class="chart-container">
                <div>
                    <canvas id="marketAnalysisChart" width="400" height="200"></canvas>
                </div>
                <div>
                    <table class="fw-bold">

                        <tbody>
                            <tr class="purple">
                                <td>Total Market (TAM)</td>
                                <td>$1,000,000</td>
                                <td>70%</td>
                            </tr>
                            <tr class="yellow">
                                <td>SAM</td>
                                <td>$300,000</td>
                                <td>21%</td>
                            </tr>
                            <tr class="turquoise">
                                <td>SOM</td>
                                <td>$100,000</td>
                                <td>7%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="card shadow-lg mb-5">
            <div class="card-body">
                <h2 class="text-center mb-4">PESTEL Analysis</h2>
                <div class="row text-center">
                    <!-- Political -->
                    <div class="col-md-4 mb-3">
                        <div class="pestel-card political">
                            <h4>Political</h4>
                            <p>Government policies, regulations, and potential political instability that may affect the
                                project.</p>
                        </div>
                    </div>

                    <!-- Economic -->
                    <div class="col-md-4 mb-3">
                        <div class="pestel-card economic">
                            <h4>Economic</h4>
                            <p>Market conditions, economic growth rates, inflation, and other economic factors
                                influencing the project.</p>
                        </div>
                    </div>

                    <!-- Social -->
                    <div class="col-md-4 mb-3">
                        <div class="pestel-card social">
                            <h4>Social</h4>
                            <p>Social trends, demographics, and consumer behavior that impact the project.</p>
                        </div>
                    </div>

                    <!-- Technological -->
                    <div class="col-md-4 mb-3">
                        <div class="pestel-card technological">
                            <h4>Technological</h4>
                            <p>Technological advancements and innovations that might affect the project’s operations and
                                growth.</p>
                        </div>
                    </div>

                    <!-- Environmental -->
                    <div class="col-md-4 mb-3">
                        <div class="pestel-card environmental">
                            <h4>Environmental</h4>
                            <p>Environmental concerns, sustainability issues, and regulations regarding the environment.
                            </p>
                        </div>
                    </div>

                    <!-- Legal -->
                    <div class="col-md-4 mb-3">
                        <div class="pestel-card legal">
                            <h4>Legal</h4>
                            <p>Legal factors including regulations, intellectual property laws, and compliance
                                standards.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container success-indicator mt-5">
        <div class="card shadow-lg mb-5">
            <div class="card-body">
                <h2 class="text-center purple">Project Success Rate</h2>

                <!-- مؤشر النجاح -->
                <div class="gauge">
                    <svg viewBox="0 0 100 50">
                        <!-- الخلفية -->
                        <path class="arc arc-bg" d="M 10,50 A 40,40 0 0,1 90,50" />
                        <!-- القوس الديناميكي الذي يمثل النسبة -->
                        <path class="arc arc-fill" id="arcFill" d="M 10,50 A 40,40 0 0,1 90,50" />
                        <!-- المؤشر أو الإبرة -->
                        <line x1="50" y1="50" x2="50" y2="10" class="needle"
                            id="needle"></line>
                        <!-- مركز المؤشر -->
                        <circle cx="50" cy="50" r="4" class="center"></circle>
                    </svg>
                </div>

                <!-- عرض النسبة -->
                <div class="percentage" id="successPercentage">85%</div>
                <div class="text-left mt-3">
                    <p>The viability analysis for Alamal emphasizes the restaurant’s potential to thrive in Cairo's
                        competitive food landscape by focusing on health-conscious dining and sustainable practices.
                        Given the increasing demand for organic and natural food options, coupled with a growing
                        awareness of health and wellness among consumers, Alamal is well-positioned to attract a diverse
                        clientele. By prioritizing high-quality, organic ingredients and fostering a welcoming
                        atmosphere, Alamal can tap into a lucrative market segment that is often overlooked by
                        traditional dining establishments.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="card shadow-lg mb-5">
            <div class="card-body">
                <h2 class="text-center purple">Target Audience</h2>
                <div class="chart-container">
                    <canvas id="targetAudienceChart" width="250" height="250"></canvas>
                </div>
                <div class="text-center mt-3">
                    <p>Target audience ratings</p>
                </div>
                <p>At Alamal restaurant, we recognize that our diverse clientele comes from various backgrounds and
                    lifestyles. Each target audience brings unique perspectives and needs, which shape the dining
                    experience we offer. By understanding these groups, we can tailor our offerings to ensure
                    satisfaction and foster a loyal patronage.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // بيانات TAM, SAM, SOM
        const data = {
            labels: ['TAM', 'SAM', 'SOM'],
            datasets: [{
                label: 'Market Size',
                data: [1000000, 300000, 100000], // قم بتغيير القيم حسب احتياجاتك
                backgroundColor: [
                    'rgb(67,55,130)',
                    'rgb(249,170,28)',
                    'rgb(61,190,183)'
                ],
                borderColor: [
                    'rgb(67,55,130)',
                    'rgb(249,170,28)',
                    'rgb(61,190,183)'
                ],
                borderWidth: 1
            }]
        };

        const config = {
            type: 'pie',
            data: data,

        };

        const marketAnalysisChart = new Chart(
            document.getElementById('marketAnalysisChart'),
            config
        );
    </script>
    <script>
        // نسبة النجاح من 100
        const successRate = 80; // يمكنك تغيير هذه النسبة ديناميكيًا بناءً على بياناتك

        // حساب زاوية المؤشر بناءً على النسبة
        const angle = (successRate / 100) * 180 - 90; // طرح 90 لتحديد الموضع الصحيح للمؤشر


        // تغيير مسار القوس بناءً على النسبة
        const arcFill = document.getElementById('arcFill');
        const endX = 50 + 40 * Math.cos(Math.PI * (1 - successRate / 100));
        const endY = 50 - 40 * Math.sin(Math.PI * (1 - successRate / 100));
        arcFill.setAttribute('d', `M 10,50 A 40,40 0 0,1 ${endX},${endY}`);

        // تغيير موضع الإبرة بناءً على النسبة
        const needle = document.getElementById('needle');
        needle.setAttribute('transform', `rotate(${angle}, 50, 50)`);

        // عرض نسبة النجاح
        document.getElementById('successPercentage').innerText = `${successRate}%`;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // بيانات الجمهور المستهدف
        const dataAud = {
            labels: ['children', 'parent', 'family'],
            datasets: [{
                label: 'Target audience ratings',
                data: [75, 10, 15], // يمكن تعديل القيم بناءً على البيانات الفعلية
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56'
                ],
                hoverOffset: 4
            }]
        };

        const configAud = {
            type: 'doughnut',
            data: dataAud,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw +
                                    '%';
                            }
                        }
                    }
                }
            },
        };

        const targetAudienceChart = new Chart(
            document.getElementById('targetAudienceChart'),
            configAud
        );
    </script>

</body>

</html>
