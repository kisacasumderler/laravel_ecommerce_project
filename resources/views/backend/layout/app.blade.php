<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name') }} Admin Panel</title>
    <!-- plugins:css -->
    <link rel="stylesheet"href="{{ asset('backend') }}/vendors/feather/feather.css">
    <link rel="stylesheet"href="{{ asset('backend') }}/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet"href="{{ asset('backend') }}/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet"href="{{ asset('backend') }}/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet"href="{{ asset('backend') }}/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="text/css"href="{{ asset('backend') }}/js/select.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet"href="{{ asset('backend') }}/css/vertical-layout-light/style.css">
    <link rel="stylesheet"
        href="{{ asset('backend/css/gitcdn.github.io_bootstrap-toggle_2.2.2_css_bootstrap-toggle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend') }}/css/alertify.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- endinject -->
    <link rel="shortcut icon"href="{{ asset('backend') }}/images/favicon.png" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@yield('customcss')

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        @include('backend.inc.header')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel.html -->
            <div class="theme-setting-wrapper">
                <div id="settings-trigger"><i class="ti-settings"></i></div>
                <div id="theme-settings" class="settings-panel">
                    <i class="settings-close ti-close"></i>
                    <p class="settings-heading">SIDEBAR SKINS</p>
                    <div class="sidebar-bg-options selected" id="sidebar-light-theme">
                        <div class="img-ss rounded-circle bg-light border mr-3"></div>Light
                    </div>
                    <div class="sidebar-bg-options" id="sidebar-dark-theme">
                        <div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark
                    </div>
                    <p class="settings-heading mt-2">HEADER SKINS</p>
                    <div class="color-tiles mx-0 px-4">
                        <div class="tiles success"></div>
                        <div class="tiles warning"></div>
                        <div class="tiles danger"></div>
                        <div class="tiles info"></div>
                        <div class="tiles dark"></div>
                        <div class="tiles default"></div>
                    </div>
                </div>
            </div>
            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            @include('backend.inc.sidebar')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                @include('backend.inc.footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->

    <script src="{{ asset('backend/js/code.jquery.com_jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('backend') }}/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('backend') }}/vendors/chart.js/Chart.min.js"></script>
    <script src="{{ asset('backend') }}/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="{{ asset('backend') }}/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="{{ asset('backend') }}/js/dataTables.select.min.js"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('backend') }}/js/off-canvas.js"></script>
    <script src="{{ asset('backend') }}/js/hoverable-collapse.js"></script>
    <script src="{{ asset('backend') }}/js/template.js"></script>
    <script src="{{ asset('backend') }}/js/settings.js"></script>
    <script src="{{ asset('backend') }}/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ asset('backend') }}/js/dashboard.js"></script>
    <script src="{{ asset('backend') }}/js/Chart.roundedBarCharts.js"></script>
    <script src="{{ asset('backend') }}/js/file-upload.js"></script>
    <script src="{{ asset('backend') }}/js/gitcdn.github.io_bootstrap-toggle_2.2.2_js_bootstrap-toggle.min.js"></script>
    <script src="{{ asset('backend/js/alertify.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if (session()->get('success'))
            toastr.success("{{ session()->get('success') }}");
        @endif
        @if (session()->get('error'))
            toastr.error("{{ session()->get('error') }}");
        @endif
        @if (count($errors))
            @foreach ($errors->all() as $error)
                toastr.error("{{$error}}");
            @endforeach
        @endif
    </script>
    @yield('customjs')
    <script>
        alertify.set('notifier','position', 'top-right');
       $(document).on("click",".deleteImage",function(e) {
                  e.preventDefault();
                  $this = $(this);
                  let model = $.trim($(this).closest('.item').attr('data-model'));
                  let image_id = $.trim($(this).closest('.item').attr('data-image_no'));
                  let id = $.trim($(this).closest('.item').attr('data-id'));
                  alertify.confirm('Bu Veri Silinecek', 'Onayladıktan sonra geri alınamaz. Emin misiniz?', function(){

                      $.ajax({
                          type:'DELETE',
                          url: "{{route('panel.image.resimsil')}}",
                          headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                          data: {
                              id:id,
                              image_id:image_id,
                              model:model
                          },
                          headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          },
                          success:function(response) {
                              $this.closest('.item').remove();
                              alertify.success('Başarıyla Silindi');
                          }
                      });

                  }, function(){
                   alertify.error('Silme İşlemi İptal Edildi');
                  }).set('labels', {
                      ok:'Onayla',
                      cancel:'İptal'
                  });
              });

              $(document).on('change', '.vitrinBtn', function(){
                       $('.vitrinBtn').prop('checked',false);
                       $(this).prop('checked',true);
                       let model = $.trim($(this).closest('.item').attr('data-model'));
                       let image_id = $.trim($(this).closest('.item').attr('data-image_no'));
                       let id = $.trim($(this).closest('.item').attr('data-id'));
                       $.ajax({
                           url:  "{{route('panel.vitrin.yap')}}",
                           type: 'POST',
                           headers: {
                               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                           },
                           data:{
                               id:id,
                               model:model,
                               image_id:image_id,
                           },
                           beforeSend: function() {

                           },
                           success: function (response) {
                               alertify.success('Başarıyla Vitrin Güncellendi');
                           },
                           complete: function() {

                           },
                           error: function (data) {

                           }
                       });
               });
       </script>
    <!-- End custom js for this page-->
</body>

</html>
