@extends('layout.admin')


@section('main')
    <style>
        .div-pay {
            padding: 25px;
            margin-bottom: 25px !important;
            border-radius: 8px;
        }

        .row {
            margin-top: 50px !important;
        }
    </style>
    <div class="content-wrapper">
        <div class="container mt-5">
            <div class="row justify-content-center mt-4">
                <!-- طريقة الدفع -->
                <div class="col-md-4">
                    <h4 class="mb-3">طرق الدفع</h4>
                    <div class="list-group">
                        <button id="creditCardButton" class="list-group-item list-group-item-action active">
                            بطاقة ائتمان
                            <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png" width="40"
                                alt="Mastercard">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" width="40"
                                alt="Visa">

                        </button>
                        <button id="bankTransferButton" class="list-group-item list-group-item-action">
                            تحويل حساب بنكي
                        </button>
                    </div>
                </div>
                <div class="col-md-7 list-group-item list-group-item-action div-pay text-center" id="creditCard">
                    <h4 class="mb-3">طرق الدفع</h4>
                    <div class="list-group">
                        <form id="urway" class="form" style="display: flex;flex-direction: column; height: 100%"
                            action="" method="post">
                            @csrf
                            {{-- <input type="hidden" name="sum" value="{{ $sum }}"> --}}
                            @if (isset($package_id))
                                <input type="hidden" name="package_id" value="{{ $package_id }}">
                            @endif
                            @if (isset($project_id))
                                <input type="hidden" name="project_id" value="{{ $project_id }}">
                            @endif
                           
                            {{-- <input type="hidden" name="order_id" value="{{ $order_id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}"> --}}



                            <div class="text-start">
                                <p class="fw-bold" style="font-size: 15px">
                                    أنت الآن تدفع عبر بوابة دفع إلكترونية
                                </p>
                            </div>

                            <div class="d-flex justify-content-end mt-auto">
                                <button class="btn btn-primary">
                                    تأكيد الدفع
                                    <i class="fa fa-credit-card" aria-hidden="true"></i>
                                </button>
                            </div>

                        </form>
                    </div>

                </div>
                <div class="col-md-7 list-group-item list-group-item-action div-pay" id="bankTransfer">
                    <h4 class="mb-3">طرق الدفع</h4>
                    <div class="list-group ">
                        <form class="form" id="pay_transfer" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            {{-- <input type="hidden" name="order_id" value="{{ $order_id }}"> --}}
                            @if (isset($package_id))
                                <input type="hidden" name="package_id" value="{{ $package_id }}">
                            @endif
                            @if (isset($coupon_id))
                                <input type="hidden" name="coupon_id" value="{{ $coupon_id }}">
                            @endif
                            @if (isset($project_id))
                                <input type="hidden" name="project_id" value="{{ $project_id }}">
                            @endif
                            @if (isset($consultation_id))
                                <input type="hidden" name="consultation_id" value="{{ $consultation_id }}">
                            @endif
                            @if (isset($discound_id))
                                <input type="hidden" name="discound_id" value="{{ $discound_id }}">
                            @endif
                            <div class="row ">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3 ">
                                        <label for="user_name">الاسم</label>
                                        <input type="text" id="user_name" name="user_name" placeholder="الاسم"
                                            class="form-control" />
                                        <span class="text-danger error-text user_name_error"></span>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="bank_name">اسم البنك</label>
                                        <input type="text" id="bank_name" name="bank_name" placeholder="اسم البنك"
                                            class="form-control" />
                                        <span class="text-danger error-text bank_name_error"></span>

                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="amount">المبلغ</label>

                                        {{-- <input type="hidden" name="amount" id="amount"
                                            value="{{ $sum }}"> --}}
                                        <input type="text" id="amountInput" value=""
                                            class="form-control disabled" disabled placeholder="المبلغ">

                                        <span class="text-danger error-text amount_error"></span>

                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="date">التاريخ</label>
                                        <input type="text" id="date" name="date" placeholder="التاريخ"
                                            class="form-control" onkeypress="event.preventDefault(); return false;" />
                                        <span class="text-danger error-text date_error"></span>

                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="account_number">رقم الحساب</label>
                                        <input type="text"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            id="account_number" name="account_number" placeholder="رقم الحساب"
                                            class="form-control" />
                                        <span class="text-danger error-text account_number_error"></span>

                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="iban">رقم الأيبان (IBAN)</label>
                                        <input type="text" id="iban" name="iban"
                                            placeholder="رقم الأيبان (IBAN)" class="form-control" />
                                        <span class="text-danger error-text iban_error"></span>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="file-upload">

                                    <div class="image-upload-wrap">
                                        <input class="file-upload-input" name="image_transfer" type='file'
                                            onchange="readURL(this);" accept="image/*" />
                                        <div class="drag-text">
                                            <h3>
                                                <svg width="21" height="22" viewBox="0 0 21 22" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M0.523438 12.169C0.523438 9.78976 2.39737 7.84785 4.74968 7.73882L4.95844 7.734H5.89144C6.30565 7.734 6.64144 8.06978 6.64144 8.484C6.64144 8.86369 6.35928 9.17749 5.99321 9.22715L5.89144 9.234H4.95844C3.39554 9.234 2.1177 10.456 2.02842 11.9966L2.02344 12.169L2.02344 17.044C2.02344 18.6061 3.24557 19.8837 4.78601 19.973L4.95844 19.978H16.0884C17.6512 19.978 18.9292 18.7561 19.0185 17.2163L19.0234 17.044V12.159C19.0234 10.6016 17.8058 9.32796 16.2712 9.23896L16.0994 9.234H15.1564C14.7422 9.234 14.4064 8.89821 14.4064 8.484C14.4064 8.1043 14.6886 7.79051 15.0547 7.74084L15.1564 7.734H16.0994C18.4707 7.734 20.4065 9.6008 20.5183 11.9446L20.5234 12.159V17.044C20.5234 19.4224 18.6493 21.3642 16.2972 21.4732L16.0884 21.478H4.95844C2.57938 21.478 0.6373 19.6042 0.528266 17.2527L0.523438 17.044L0.523438 12.169ZM9.98164 1.17179C10.1182 1.02925 10.3104 0.940496 10.5233 0.940496C10.7384 0.940496 10.9324 1.03104 11.0691 1.17609L13.9707 4.08956C14.2629 4.38305 14.262 4.85792 13.9685 5.15022C13.7017 5.41593 13.285 5.43929 12.9918 5.22083L12.9078 5.14804L11.2733 3.50797L11.2733 13.7315C11.2733 14.1457 10.9376 14.4815 10.5233 14.4815C10.1436 14.4815 9.82985 14.1993 9.78018 13.8333L9.77334 13.7315L9.77334 3.50629L8.13975 5.14795C7.87407 5.4148 7.45746 5.43994 7.16337 5.22274L7.07909 5.15031C6.81223 4.88463 6.7871 4.46802 7.0043 4.17393L7.07673 4.08965L9.98164 1.17179Z"
                                                        fill="#3CC0B9" />
                                                </svg>
                                                <bR>
                                                تحميل صورة الإيداع
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="file-upload-content">
                                        <img class="file-upload-image" name="logo" id="logok" src=""
                                            alt="your image" />

                                        <div class="image-title-wrap">
                                            <button type="button" onclick="removeUpload()" class="remove-image">حذف
                                                <span class="image-title">الصورة </span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=" text-danger mt-3">
                                <p class="mb-0"
                                    style="color: #E71414; text-align: justify; font-size: 13px; font-style: normal; font-weight: 500; line-height: 20px;">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M2 12C2 6.47779 6.47779 2 12 2C17.5229 2 22 6.47745 22 12C22 17.5225 17.5229 22 12 22C6.47779 22 2 17.5222 2 12ZM20.5 12C20.5 7.30586 16.6944 3.5 12 3.5C7.30621 3.5 3.5 7.30621 3.5 12C3.5 16.6938 7.30621 20.5 12 20.5C16.6944 20.5 20.5 16.6941 20.5 12ZM11.9951 7.4541C12.3748 7.4541 12.6886 7.73625 12.7383 8.10233L12.7451 8.2041V12.6231C12.7451 13.0373 12.4093 13.3731 11.9951 13.3731C11.6154 13.3731 11.3016 13.0909 11.2519 12.7249L11.2451 12.6231V8.2041C11.2451 7.78989 11.5809 7.4541 11.9951 7.4541ZM12.7551 15.7959C12.7551 15.3817 12.4193 15.0459 12.0051 15.0459L11.8933 15.0527C11.5273 15.1024 11.2451 15.4162 11.2451 15.7959C11.2451 16.2101 11.5809 16.5459 11.9951 16.5459L12.1069 16.5391C12.4729 16.4894 12.7551 16.1756 12.7551 15.7959Z"
                                            fill="#E00404" />
                                    </svg>
                                    تستغرق عملية التحويل يومين عمل ، يرجى الانتظار حتى يتم التأكد من عملية الدفع وتفعيل
                                    الباقة
                                </p>
                            </div>

                            <div class="text-left">
                                <button class="btn btn-primary">
                                    تأكيد الدفع
                                    <i class="fa fa-credit-card" aria-hidden="true"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>


            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#creditCard').removeClass('hidden');
            $('#bankTransfer').addClass('hidden');
            // إظهار قسم البطاقة عند الضغط على زر البطاقة
            $('#creditCardButton').click(function() {
                $('#creditCardSection').addClass('active');
                $('#bankTransferSection').removeClass('active');
                $(this).addClass('active');
                $('#bankTransferButton').removeClass('active');
                $('#creditCard').removeClass('hidden');
                $('#bankTransfer').addClass('hidden');
            });

            // إظهار قسم التحويل البنكي عند الضغط على زر التحويل
            $('#bankTransferButton').click(function() {
                $('#bankTransferSection').addClass('active');
                $('#creditCardSection').removeClass('active');
                $(this).addClass('active');
                $('#creditCardButton').removeClass('active');
                $('#creditCard').addClass('hidden');
                $('#bankTransfer').removeClass('hidden');
            });
        });
    </script>
@endsection
