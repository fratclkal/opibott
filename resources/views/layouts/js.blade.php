<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

<!-- Jquery js-->
<script src="/assets/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap js-->
<script src="/assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Ionicons js-->
<script src="/assets/plugins/ionicons/ionicons.js"></script>

<!-- Moment js -->
<script src="/assets/plugins/moment/moment.js"></script>

<!-- P-scroll js -->
<script src="/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/assets/plugins/perfect-scrollbar/p-scroll.js"></script>

<!-- Rating js-->
<script src="/assets/plugins/rating/jquery.rating-stars.js"></script>
<script src="/assets/plugins/rating/jquery.barrating.js"></script>

<!-- Sticky js -->
<script src="/assets/js/sticky.js"></script>

<!-- Sidebar js -->
<script id="sidemenu" src="/assets/plugins/side-menu/sidemenu.js"></script>

<!-- Right-sidebar js -->
<script src="/assets/plugins/sidebar/sidebar.js"></script>
<script src="/assets/plugins/sidebar/sidebar-custom.js"></script>

<!-- eva-icons js -->
<script src="/assets/plugins/eva-icons/eva-icons.min.js"></script>


<!-- Moment js -->
<script src="/assets/plugins/raphael/raphael.min.js"></script>

<!--Internal  Chart.bundle js -->
<script src="/assets/plugins/chart.js/Chart.bundle.min.js"></script>

<!--Internal Sparkline js -->
<script src="/assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

<!--Internal Apexchart js-->
<script src="/assets/js/apexcharts.js"></script>

<!--Internal  Perfect-scrollbar js -->
<script src="/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/assets/plugins/perfect-scrollbar/p-scroll.js"></script>

<!-- Internal Map -->
<script src="/assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="/assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>

<!--Internal  index js -->
<script src="/assets/js/index.js"></script>


<!-- custom js -->
<script src="/assets/js/custom.js"></script>

<!-- Switcher js -->
<script src="/assets/switcher/js/switcher.js"></script>
<script src="assets/plugins/sweet-alert/sweetalert.min.js"></script>
<script src="assets/plugins/sweet-alert/jquery.sweet-alert.js"></script>

<!-- Sweet-alert js  -->
<script src="assets/plugins/sweet-alert/sweetalert.min.js"></script>
<script src="assets/js/sweet-alert.js"></script>

<!-- Internal Data tables -->
<script src="/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatable/datatables.min.js"></script>
<script src="/assets/plugins/datatable/js/dataTables.bootstrap5.js"></script>
<script src="/assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
<script src="/assets/plugins/datatable/js/buttons.bootstrap5.min.js"></script>
<script src="/assets/plugins/datatable/js/jszip.min.js"></script>
<script src="/assets/plugins/datatable/js/buttons.html5.min.js"></script>
<script src="/assets/plugins/datatable/js/buttons.print.min.js"></script>
<script src="/assets/plugins/datatable/js/buttons.colVis.min.js"></script>
<script src="/assets/plugins/datatable/pdfmake/pdfmake.min.js"></script>
<script src="/assets/plugins/datatable/pdfmake/vfs_fonts.js"></script>

<script src="assets/plugins/treeview/treeview.js"></script>

<!--Internal  Datatable js -->
<script src="assets/js/table-data.js"></script>
        

<script type="text/javascript">
    let error = `{{ Session::get('error') }}`;
    if(error){
        swal('', error, 'warning');
    }

    let success = `{{ Session::get('success') }}`;
    if(success){
        swal('', success, 'success');
    }

</script>
@yield('js')
