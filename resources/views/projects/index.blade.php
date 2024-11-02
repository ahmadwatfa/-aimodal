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
                            <h3 class="box-title">قائمة المشاريع </h3>
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
                                            <th>فكرة المشروع</th>
                                            <th>الدولة</th>
                                            <th>تصنيف المشروع</th>
                                            <th>الكلمات المفتاحية</th>
                                            <th>العمليات</th>
                                        </tr>
                                    </thead>
                                    @foreach ($projects as $key => $project)
                                        <tbody>
                                            <th>{{ ++$key }} </th>
                                            <td>{!! \Illuminate\Support\Str::limit($project->idea, 50, '...') !!}</td>
                                            <th>{{ $countries[$project->location] ?? ' ' }} </th>
                                            <th>{{ $project->type }}</th>
                                            <th>
                                                @if (!empty($project->keywords))
                                                @php
                                                        $keywords = json_decode($project->keywords, true);
                                                        $tags = array_column($keywords, 'value');
                                                    @endphp
                                                    {{ implode(', ', $tags) }}
                                                    @else
                                                    لا توجد كلمات مفتاحية
                                                    @endif
                                                </th>
                                                
                                                <th><a href="{{ route('project.show',$project) }}" style="color: blueviolet"><i class="fa fa-eye" aria-hidden="true"></i></a></th>
                                        </tbody>
                                    @endforeach

                                </table>
                            </div><!-- /.table-responsive -->


                        </div><!-- /.box-body -->
                    </div>



                </section><!-- right col -->


            </div><!-- /.row (main row) -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection
