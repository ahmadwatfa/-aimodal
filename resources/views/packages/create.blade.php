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
                        <h3 class="box-title"> اضافة باقة <small>جديدة</small> </h3>
                        <i class="pull-left header fa fa-th"></i>
                    </div><!-- /.box-header -->

                    <form role="form" id="signupForm1" action="{{ route('package.store') }}" onsubmit="return check()"
                        method="post" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body col-md-12">
                            <div class="col-md-12">
                                <!-- Custom Tabs (Pulled to the right) -->
                                <div class="nav-tabs-custom">

                                    <ul class="nav nav-tabs pull-right">
                                        <li class="active"><a href="#tab_1-1" data-toggle="tab">معلومات الباقة</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active fade in" id="tab_1-1">
                                            <div class="row">
                                                <div class="col-md-10">

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">اسم الباقة :</label>

                                                            <input type="text" class="form-control col-sm-9"
                                                                name="name" value="{{ old('name') }}"
                                                                placeholder="اسم الباقة" data-fv-field="">
                                                            @error('name')
                                                                <p class="text-danger">{{ $message }}</p>
                                                            @enderror

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">وصف الباقة : </label>
                                                            <textarea class="form-control col-sm-9" style="resize: none;" name="description" value="{{ old('description') }}"
                                                                cols="30" rows="5" placeholder="تفاصيل الفكرة"></textarea>
                                                            @error('description')
                                                                <p class="text-danger">{{ $message }}</p>
                                                            @enderror

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">عدد المشاريع :</label>
                                                            <input
                                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                                oninput="validateInput(this)" min="0" type="text"
                                                                placeholder="عدد المشاريع" class="form-control col-sm-9"
                                                                id="count_project" value="{{ old('count_project') }}" required name="count_project">
                                                            @error('count_project')
                                                                <p class="text-danger">{{ $message }}</p>
                                                            @enderror

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">سعر الباقة :</label>

                                                            <input
                                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                                oninput="validateInput(this)" min="0" type="text"
                                                                placeholder="سعر الباقة" class="form-control col-sm-9"
                                                                id="price" value="{{ old('price') }}" required name="price">
                                                            @error('price')
                                                                <p class="text-danger">{{ $message }}</p>
                                                            @enderror

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
