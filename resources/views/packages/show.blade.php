@extends('layout.admin')


@section('main')
    <style>
        .subscription-plans {
            text-align: center;
            padding: 40px 20px;
        }

        .subscription-plans h2 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #333;
        }

        .subscription-plans h3 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #333;
            font-weight: bold
        }

        .subscription-plans p {
            font-size: 1.2em;
            margin-bottom: 30px;
            color: #666;
        }

        .plans-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .plan {
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            width: 320px;
            margin-top: 50px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: right;
            border-top: 6px solid;
        }

        .plan:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .plan.free {
            border-color: #413783;
        }

        .power-user {
            border-color: #413783;
        }

        .plan.power-user {
            border-color: #f7a91b;
        }

        .plan.power-user {
            border-color: #f7a91b;
        }

        .plan h3 {
            margin-top: 0;
            font-size: 1.8em;
            color: #333;
        }

        .plan .price {
            font-size: 2em;
            color: #333;
            margin: 15px 0;
        }

        .plan .price .old-price {
            text-decoration: line-through;
            color: #999;
            margin-right: 10px;
        }

        .plan .tax-included {
            font-size: 1em;
            color: #46c0b8;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .plan ul {
            list-style: none;
            padding: 0;
            text-align: right;
            color: #666;
        }

        .plan ul li {
            margin: 10px 0;
            font-size: 1.1em;
            position: relative;
            padding-right: 20px;
        }

        .plan ul li::before {
            content: "-";
            position: absolute;
            right: 0;
            top: 0;
            color: #007bff;
        }

        .plan ul li.more {
            display: none;
        }

        .plan .see-more {
            color: #007bff;
            cursor: pointer;
            font-size: 1.1em;
            margin-top: 10px;
        }

        .plan .see-more:hover {
            text-decoration: underline;
        }

        .plan .btn {
            display: inline-block;
            padding: 12px 25px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            transition: background 0.3s ease;
        }

        .plan .btn:hover {
            background: #0056b3;
        }

        .plan .btn.get-started {
            background: #413783;
        }

        .plan .btn.get-started-plus {
            background: #f7a91b;
        }

        .plan .btn.get-started:hover {
            background: #f7a91b;
        }

        .plan .btn.get-started-plus:hover {
            background: #413783;
        }

        .bold {
            font-weight: bold;
        }

        .packag-title {
            font-weight: bold;
            background: white !important;
        }

        @media (max-width: 600px) {

            .plan:last-child {
                margin-top: 10px;
                margin-bottom: 30px;
            }
        }

        @media (min-width: 768px) {
            .plan {
                width: 48%;
                margin: 50px 5px
            }
        }

        @media (min-width: 1024px) {
            .plan.free {
                border-color: #413783;
                width: 45%
            }

            .power-user {
                border-color: #413783;
                width: 45%
            }
        }

        .feature-title {
            font-size: 1.2em;
            font-weight: bold;
            margin-top: 20px;
        }

        .feature-price {
            font-size: 1.1em;
            color: #f7a91b;
            margin-top: 5px;
        }

        .small-text {
            font-size: 0.6em;
        }
    </style>
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="plans-container">
                    @if (isset($packages[0]) && !empty($packages[0]))
                        <div class="plan free">
                            <h3 class="packag-title">{{ $packages[0]->name }}</h3>
                            <div>
                                <p class="price"><span class="old-price"></span> <strong>{{ $packages[0]->price }}</strong>
                                    <span class="small-text">ر.س /
                                        سنويا</span>
                                </p>
                                <p class="tax-included">السعر شامل ضريبة القيمة المضافة</p>

                                <p class="price"><strong>{{ $packages[0]->count_project }}</strong>
                                    <span class="small-text">مشروع/مشاريع</span>
                                </p>

                                <p>{{ $packages[0]->description }}</p>
                                <form class="form" action="{{ route('checkout.index') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="package_id" value="{{ $packages[0]->id }}">
                                    <button type="submit" class="btn get-started">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M6.51036 2.0835H13.4903C16.1652 2.0835 18.3337 4.30113 18.3337 7.03662V7.65506L18.3338 7.66884L18.3337 7.68262V12.1002L18.3338 12.114L18.3337 12.1277V12.9637C18.3337 15.6992 16.1652 17.9168 13.4903 17.9168H6.51036C3.83548 17.9168 1.66699 15.6992 1.66699 12.9637V7.03662C1.66699 4.30113 3.83548 2.0835 6.51036 2.0835ZM17.1223 7.03662V7.04946H14.459L14.3064 7.05375C12.8421 7.13553 11.6793 8.37444 11.6793 9.89141C11.6802 11.4611 12.924 12.7324 14.4586 12.7334H17.1223V12.9637C17.1223 15.015 15.4962 16.6781 13.4903 16.6781H6.51036C4.50447 16.6781 2.87831 15.015 2.87831 12.9637V7.03662C2.87831 4.98528 4.50447 3.32226 6.51036 3.32226H13.4903C15.4962 3.32226 17.1223 4.98528 17.1223 7.03662ZM14.4593 8.28822L17.1223 8.28822V11.4946H14.459L14.3364 11.4897C13.5277 11.4253 12.8911 10.7344 12.8906 9.89103C12.8906 9.00635 13.5928 8.28876 14.4593 8.28822ZM15.4345 9.84053C15.4345 9.49845 15.1633 9.22115 14.8288 9.22115H14.5771L14.4949 9.2268C14.1993 9.26781 13.9714 9.52696 13.9714 9.84053C13.9714 10.1826 14.2426 10.4599 14.5771 10.4599H14.8288L14.911 10.4543C15.2066 10.4132 15.4345 10.1541 15.4345 9.84053ZM10.9009 6.45068C10.9009 6.10861 10.6297 5.8313 10.2952 5.8313H5.93535L5.85316 5.83695C5.55754 5.87797 5.32969 6.13711 5.32969 6.45068C5.32969 6.79276 5.60085 7.07006 5.93535 7.07006H10.2952L10.3774 7.06441C10.673 7.02339 10.9009 6.76425 10.9009 6.45068Z"
                                                fill="white" />
                                        </svg>
                                        اشترك الآن
                                    </button>
                                    {{-- <a href="{{ route('checkout.index', $packages[0]->id) }}" class="btn get-started">اشترك
                                        الآن</a> --}}
                                </form>
                            </div>
                        </div>
                    @endif
                    @if (isset($packages[1]) && !empty($packages[1]))
                        <div class="plan power-user">
                            <h3 class="packag-title">{{ $packages[1]->name }}</h3>
                            <p class="price"><span class="old-price"></span> <strong>{{ $packages[1]->price }}</strong>
                                <span class="small-text">ر.س /
                                    سنويا</span>
                            </p>
                            <p class="tax-included">السعر شامل ضريبة القيمة المضافة</p>

                            <p class="price"><strong>{{ $packages[1]->count_project }}</strong>
                                <span class="small-text">مشروع/مشاريع</span>
                            </p>
                            <p>{{ $packages[1]->description }}</p>
                            <form class="form" action="{{ route('checkout.index') }}" method="post">
                                @csrf
                                <input type="hidden" name="package_id" value="{{ $packages[1]->id }}">
                                <button type="submit" class="btn get-started">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M6.51036 2.0835H13.4903C16.1652 2.0835 18.3337 4.30113 18.3337 7.03662V7.65506L18.3338 7.66884L18.3337 7.68262V12.1002L18.3338 12.114L18.3337 12.1277V12.9637C18.3337 15.6992 16.1652 17.9168 13.4903 17.9168H6.51036C3.83548 17.9168 1.66699 15.6992 1.66699 12.9637V7.03662C1.66699 4.30113 3.83548 2.0835 6.51036 2.0835ZM17.1223 7.03662V7.04946H14.459L14.3064 7.05375C12.8421 7.13553 11.6793 8.37444 11.6793 9.89141C11.6802 11.4611 12.924 12.7324 14.4586 12.7334H17.1223V12.9637C17.1223 15.015 15.4962 16.6781 13.4903 16.6781H6.51036C4.50447 16.6781 2.87831 15.015 2.87831 12.9637V7.03662C2.87831 4.98528 4.50447 3.32226 6.51036 3.32226H13.4903C15.4962 3.32226 17.1223 4.98528 17.1223 7.03662ZM14.4593 8.28822L17.1223 8.28822V11.4946H14.459L14.3364 11.4897C13.5277 11.4253 12.8911 10.7344 12.8906 9.89103C12.8906 9.00635 13.5928 8.28876 14.4593 8.28822ZM15.4345 9.84053C15.4345 9.49845 15.1633 9.22115 14.8288 9.22115H14.5771L14.4949 9.2268C14.1993 9.26781 13.9714 9.52696 13.9714 9.84053C13.9714 10.1826 14.2426 10.4599 14.5771 10.4599H14.8288L14.911 10.4543C15.2066 10.4132 15.4345 10.1541 15.4345 9.84053ZM10.9009 6.45068C10.9009 6.10861 10.6297 5.8313 10.2952 5.8313H5.93535L5.85316 5.83695C5.55754 5.87797 5.32969 6.13711 5.32969 6.45068C5.32969 6.79276 5.60085 7.07006 5.93535 7.07006H10.2952L10.3774 7.06441C10.673 7.02339 10.9009 6.76425 10.9009 6.45068Z"
                                            fill="white" />
                                    </svg>
                                    اشترك الآن
                                </button>
                                {{-- <a href="{{ route('checkout.index', $packages[1]->id) }}" class="btn get-started">اشترك
                                    الآن</a> --}}
                            </form>
                        </div>
                    @endif
                </div> <!-- /.row -->
            </div> <!-- /.row -->
        </div><!-- /.content-wrapper -->
    @endsection
