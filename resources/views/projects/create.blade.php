@extends('layout.admin')


@section('main')
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"> اضافة فكرة <small>جديدة</small> </h3>
                        <i class="pull-left header fa fa-th"></i>
                    </div><!-- /.box-header -->

                    <form role="form" id="signupForm1" action="{{ route('project.store') }}" onsubmit="return check()"
                        method="post" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body col-md-12">
                            <div class="col-md-12">
                                <!-- Custom Tabs (Pulled to the right) -->
                                <div class="nav-tabs-custom">

                                    <ul class="nav nav-tabs pull-right">
                                        <li class="active"><a href="#tab_1-1" data-toggle="tab">معلومات الفكرة</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active fade in" id="tab_1-1">
                                            <div class="row">
                                                <div class="col-md-10">

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">موجز الفكرة :</label>

                                                            <input type="text" class="form-control col-sm-9"
                                                                name="idea" value="{{ old('idea') }}"
                                                                placeholder="الفكرة" data-fv-field="">
                                                            @error('idea')
                                                                <p class="text-danger">{{ $message }}</p>
                                                            @enderror

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">تفاصيل الفكرة : </label>
                                                            <textarea class="form-control col-sm-9" style="resize: none;" name="description"  
                                                                id="" cols="30" rows="5" placeholder="تفاصيل الفكرة">{{ old('description') }}</textarea>
                                                            @error('description')
                                                                <p class="text-danger">{{ $message }}</p>
                                                            @enderror

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="type" class="col-sm-3 control-label">نوع
                                                                الفكرة:</label>
                                                            <select class="form-control col-sm-9 select2" name="type"
                                                                id="type" required>
                                                                <option disabled selected value="">اختر النوع</option>
                                                                <option value="service">خدمة</option>
                                                                <option value="project">مشروع</option>
                                                                <option value="product">منتج</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="category" class="col-sm-3 control-label">مجال
                                                                الفكرة:</label>
                                                            <input type="text" class="form-control col-sm-9"
                                                                name="category" value="{{ old('category') }}"
                                                                placeholder="مجال الفكرة" data-fv-field="">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="location"
                                                                class="col-sm-3 control-label">الموقع:</label>
                                                            <select class="form-control col-sm-9 select2" name="location"
                                                                id="location" required>
                                                                <option disabled selected value="">اختر الدولة
                                                                </option>
                                                                @foreach ($countries as $k => $v)
                                                                    <option value="{{ $k }}">{{ $v }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="target_audience"
                                                                class="col-sm-3 control-label">الجمهور المستهدف:</label>
                                                            <select class="form-control col-sm-9" name="target_audience"
                                                                id="target_audience" required>

                                                                <option value="B2B">B2B</option>
                                                                <option value="B2C">B2C</option>
                                                                <option value="other">أخرى</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="revenue_model" class="col-sm-3 control-label">نموذج
                                                                الإيرادات:</label>
                                                            <select class="form-control col-sm-9" name="revenue_model"
                                                                id="revenue_model" required>
                                                                <option value="subscribe">نموذج الاشتراك</option>
                                                                <option value="sale">مبيعات مباشرة</option>
                                                                <option value="free">نموذج مجاني</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="keywords" class="col-sm-3 control-label">الكلمات
                                                                المفتاحية (اختياري):</label>
                                                            <input type="text" style="height: 45px;"
                                                                class="form-control col-sm-9" name="keywords"
                                                                id="keywords">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- /.tab-pane -->

                                    </div><!-- /.tab-content -->
                                </div><!-- nav-tabs-custom -->
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer ">
                            <!-- .box-footer -->
                            <button type="submit" class="btn  btn-purpel pull-left"
                                style="margin-left: 10px;">تخزين</button>
                            <button type="reset" class="btn  btn-default pull-left" style="margin-left: 10px;">تفريغ
                                الحقول</button>
                        </div><!-- /.box-footer -->
                    </form>
                    <!-- form end -->
                </div><!-- /.box -->


            </div> <!-- /.row -->
            </section><!-- /.content -->

        </div> <!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection
@push('my-script')
    <script>
        var input = document.querySelector('input[id=keywords]');
        new Tagify(input, {
            placeholder: 'أدخل الكلمات مفتاحية بحد اقصى عدد 5',
            maxTags: 5,
            placeholder: "مثل: صديق للبيئة، قائم على الذكاء الاصطناعي بحد اقصى عدد 5"

        });
    </script>
@endpush
