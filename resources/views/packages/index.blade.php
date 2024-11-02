@extends('layout.admin')


@section('main')
    <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height: 166px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            {{-- <h1>

                لوحة التحكم
            </h1> --}}

        </section>

        <!-- Main content -->
        <section class="content">
            <style>
                .info-box-text {
                    font-size: 14px;
                    margin-top: 12px;
                    font-weight: bold;
                }

                .info-box-number {
                    font-size: 24px;
                }
            </style>
            <!-- Info Boxes Style 2 -->






            <!-- Main row -->
            <div class="row">
                <!-- Left col -->

                <section class="col-lg-12 connectedSortable ui-sortable">

                    <div class="box box-navy">
                        <div class="box-header with-border ui-sortable-handle" style="cursor: move;">
                            <i class="fa fa-tasks"></i>
                            <h3 class="box-title">قائمة الباقات </h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table text-center no-margin">
                                    <thead>
                                        <tr>
                                            <th>رقم </th>
                                            <th>اسم الباقة</th>
                                            <th>وصف الباقة</th>
                                            <th>عدد المشاريع</th>
                                            <th>السعر</th>
                                            <th>العمليات</th>

                                        </tr>
                                    </thead>
                                    @foreach ($packages as $key => $package)
                                        <tbody>
                                            <th>{{ ++$key }} </th>
                                            <th>{{ $package->name }}</th>
                                            <td>{!! \Illuminate\Support\Str::limit($package->description, 50, '...') !!}</td>
                                            <th>{{ $package->count_project }}</th>
                                            <th>{{ $package->price }}</th>
                                            <td width="20%" align="center">

                                                <a href="{{ route('package.edit', $package->id) }}" title="تعديل"
                                                    type="button" class="btn btn-primary btn-xs">
                                                    <span class=" glyphicon glyphicon-edit" aria-hidden="true">
                                                    </span>
                                                    تعديل
                                                </a>

                                                <button data-effect="effect-scale" data-id="{{ $package->id }}"
                                                    data-toggle="modal" href="#modaldemo9" title="حذف" type="button"
                                                    class="btn btn-danger btn-xs delete">
                                                    <span class=" glyphicon glyphicon-trash" aria-hidden="true">
                                                    </span>
                                                    حذف
                                                </button>



                                            </td>

                                        </tbody>
                                    @endforeach

                                </table>
                            </div><!-- /.table-responsive -->


                        </div><!-- /.box-body -->
                    </div>



                </section><!-- right col -->


            </div><!-- /.row (main row) -->
        </section><!-- /.content -->
        <div class="modal" id="modaldemo9">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">حذف الباقة</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="/package/delete/{id}" method="post">
                        @csrf


                        <div class="modal-body">
                            <p>هل انت متاكد من عملية الحذف ؟</p><br>
                            <input type="hidden" name="id" id="id" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">تاكيد</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.content-wrapper -->
    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);

        })
    </script>
@endsection
