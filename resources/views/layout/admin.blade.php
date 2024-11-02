<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>لوحة التحكم | جدوى كلاود Jadwa Cloud</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="/assets/admin/bootstrap/css/bootstrap.min.css">
    <!-- Bootstrap-rtl 3.3.4 -->
    <link rel="stylesheet" href="/assets/admin/bootstrap/css/bootstrap-rtl.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/admin/dist/css/fontawesome-4.4.0.min.css">
    <!-- Ionicons -->
    <link rel="shortcut icon" href="{{ asset('image/icon.png') }}" type="image/x-icon">

    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="/assets/admin/plugins/select2/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/admin/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/assets/admin/plugins/iCheck/all.css">
    <link rel="stylesheet" href="/assets/admin/dist/css/add-img.css">
    <!-- تحميل CSS و JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.31.3/tagify.min.js"
        integrity="sha512-YrKVSda1sKH9vnfrtO2Dzkv1CHmsnQsPTIBv9IDdu7bqiHAvmTf02zxHv3t+d2hcIWTgJHi+6X6Oy21MVyWNwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.31.3/tagify.css"
        integrity="sha512-fg4mbaXioGkhZsVQlBUD7MmEA5zQY4I3aiawILa2nHXUk0e5gBZjlwGoJCeRIAVHqYOdaddDQA7HUXwqx3vVAA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #tags {
            height: 100%;
        }

        .tagify {
            height: 100% !important;
        }
        
    </style>
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/assets/admin/dist/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery 2.1.4 -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- تأكد من وجود هذا السطر -->

    <script src="/assets/admin/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/assets/admin/dist/js/jquery.validate.js"></script>

</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="admin" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">جدوى</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>جدوى &numsp;</b>Jadwa</span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"></a>


                <div class="navbar-custom-menu">

                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->


                        <li>

                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-power-off"></i>
                            </a>

                            <form id="logout-form" action="" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>


        <!-- Right side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-right image">

                    </div>
                    <div class="pull-left info">
                        <p>{{-- $_SESSION['username'] --}}</p>
                        <a href="#"style="color: #b8c7ce;"> موقع جدوى jadwa </a>
                    </div>
                </div>

                <ul class="sidebar-menu">
                    <li class="header">القائمة الرئيسية</li>
                    <li class="active treeview">
                        <a href="/">
                            <i class="fa fa-home"></i> <span>الرئيسية</span>
                        </a>

                    </li>

                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-file-text-o "></i>
                            <span>مشاريعي</span>
                            <i class="fa fa-angle-left pull-left"></i>
                        </a>

                        <ul class="treeview-menu">
                            <li><a href="{{ route('project.index') }}"><i class="fa fa-circle-o"></i> قائمة المشاريع</a>
                            </li>
                            <li><a href="{{ route('project.create') }}"><i class="fa fa-circle-o"></i> إضافة مشروع
                                    جديد</a></li>
                        </ul>

                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-archive" aria-hidden="true"></i>
                            <span>الباقات</span>
                            <i class="fa fa-angle-left pull-left"></i>
                        </a>

                        <ul class="treeview-menu">
                            <li><a href="{{ route('package.index') }}"><i class="fa fa-circle-o"></i> قائمة الباقات</a>
                            </li>
                            {{-- @if (Auth::user()->type == 'admin') --}}
                                <li><a href="{{ route('package.create') }}"><i class="fa fa-circle-o"></i> إضافة باقة
                                        جديدة</a></li>
                            {{-- @endif --}}
                        </ul>

                    </li>
                    {{-- @if (Auth::user()->type == 'admin') --}}
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-users"></i>
                                <span>المستخدمين</span>
                                <i class="fa fa-angle-left pull-left"></i>
                            </a>

                            <ul class="treeview-menu">
                                <li><a href="{{ route('user.index') }}"><i class="fa fa-circle-o"></i> قائمة
                                        المستخدمين</a>
                                </li>
                            </ul>
                        </li>
                    {{-- @endif --}}

                </ul>
            </section>
        </aside>

        @yield('main')


    </div>

    <footer class="main-footer">
        جميع الحقوق محفوظة ل - جدوى Jadwa <strong dir="ltr"> 2024 &copy; </strong>
    </footer>

    <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- Bootstrap 3.3.5 -->
    <script src="/assets/admin/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/admin/plugins/select2/select2.full.min.js"></script>
    <!-- FastClick -->
    <script src="/assets/admin/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/assets/admin/dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/assets/admin/dist/js/demo.js"></script>
    <!-- DataTables -->
    <script src="/assets/admin/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/assets/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="/assets/admin/dist/js/index.js"></script>

    <script src="/assets/admin/plugins/iCheck/icheck.min.js"></script>
    {{-- @if (!Route::is('project.create') && !Route::is('package.create')) --}}
    {{-- <script src="/assets/admin/plugins/tinymce/tinymce.min.js"></script> --}}
    {{-- @endif --}}

    <style>
        .btn-purpel {
            background-color: #9B5FA3;
            border-color: #9B5FA3;
            color: white
        }

        .btn-purpel:hover {
            background-color: #8d5596;
            border-color: #8d5596;
            color: white
        }
    </style>

    @stack('my-script')
    @yield('my-script')
</body>

</html>
