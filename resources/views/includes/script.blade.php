<!--   Core JS Files   -->
<script src="{{ asset('/') }}js/core/jquery.3.2.1.min.js"></script>
<script src="{{ asset('/') }}js/core/popper.min.js"></script>
<script src="{{ asset('/') }}js/core/bootstrap.min.js"></script>

<!-- jQuery UI -->
<script src="{{ asset('/') }}js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="{{ asset('/') }}js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

<!-- jQuery Scrollbar -->
<script src="{{ asset('/') }}js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

<!-- Moment JS -->
<script src="{{ asset('/') }}js/plugin/moment/moment.min.js"></script>

<!-- Chart JS -->
<script src="{{ asset('/') }}js/plugin/chart.js/chart.min.js"></script>

<!-- jQuery Sparkline -->
<script src="{{ asset('/') }}js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

<!-- Chart Circle -->
<script src="{{ asset('/') }}js/plugin/chart-circle/circles.min.js"></script>

<!-- Datatables -->
<script src="{{ asset('/') }}js/plugin/datatables/datatables.min.js"></script>

<!-- Bootstrap Notify -->
<script src="{{ asset('/') }}js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

<!-- Bootstrap Toggle -->
<script src="{{ asset('/') }}js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>

<!-- jQuery Vector Maps -->
<script src="{{ asset('/') }}js/plugin/jqvmap/jquery.vmap.min.js"></script>
<script src="{{ asset('/') }}js/plugin/jqvmap/maps/jquery.vmap.world.js"></script>

<!-- Google Maps Plugin -->
<script src="{{ asset('/') }}js/plugin/gmaps/gmaps.js"></script>

<!-- Dropzone -->
<script src="{{ asset('/') }}js/plugin/dropzone/dropzone.min.js"></script>

<!-- Fullcalendar -->
<script src="{{ asset('/') }}js/plugin/fullcalendar/fullcalendar.min.js"></script>

<!-- DateTimePicker -->
<script src="{{ asset('/') }}js/plugin/datepicker/bootstrap-datetimepicker.min.js"></script>

<!-- Bootstrap Tagsinput -->
<script src="{{ asset('/') }}js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>

<!-- Bootstrap Wizard -->
<script src="{{ asset('/') }}js/plugin/bootstrap-wizard/bootstrapwizard.js"></script>

<!-- jQuery Validation -->
<script src="{{ asset('/') }}js/plugin/jquery.validate/jquery.validate.min.js"></script>

<!-- Summernote -->
<script src="{{ asset('/') }}js/plugin/summernote/summernote-bs4.min.js"></script>

<!-- Select2 -->
<script src="{{ asset('/') }}js/plugin/select2/select2.full.min.js"></script>

<!-- Sweet Alert -->
<script src="{{ asset('/') }}js/plugin/sweetalert/sweetalert.min.js"></script>

<!-- Atlantis JS -->
<script src="{{ asset('/') }}js/atlantis2.min.js"></script>

<!-- Atlantis DEMO methods, don't include it in your project! -->
{{-- <script src="{{ asset('/') }}js/demo.js"></script> --}}

<script>
    // {{-- Datatable --}}
    $(document).ready(function() {
        $('#basic-datatables').DataTable({});
    });
    // Select2
    $('#basic').select2({
        theme: "bootstrap"
    });
    // Notif
    @if (Session::has('success'))
        $.notify({
            icon: "fas fa-check-circle ",
            title: "Shayna",
            message: "{{ Session::get('success') }}",
        }, {
            type: "success",
            placement: {
                from: "top",
                align: "right",
            },
            time: 1000,
        });
    @endif
    @if (Session::has('error'))
        $.notify({
            icon: "fas fa-exclamation-triangle",
            title: "Shayna",
            message: "{{ Session::get('error') }}",
        }, {
            type: "danger",
            placement: {
                from: "top",
                align: "right",
            },
            time: 1000,
        });
    @endif

    // Component button table
    function editRow(url) {
        window.location.href = url
    }

    function deleteRow(id, name) {
        swal("Are you sure ?", "You want to delete " + name + " ?", {
            icon: "warning",
            buttons: {
                confirm: {
                    className: 'btn btn-danger',
                    text: "Yes",
                },
                cancel: {
                    visible: true,
                    className: 'btn btn-secondary',
                },
            },
        }).then((response) => {
            if (response == true) {
                $('#deleteAction' + id).submit();
            }
        });
    }
</script>
{{-- Push js custom page --}}
@stack('custom-js')
