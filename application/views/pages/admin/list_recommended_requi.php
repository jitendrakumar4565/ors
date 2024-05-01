<style>
    .table.dataTable {     
        /*font-size: 1em;*/
    }
    .table.dataTable  {
        /* font-family: Verdana, Geneva, Tahoma, sans-serif;*/
        /* font-size: 1em;*/
    }
    .table th {
        padding: 10px;
    }
    .table td  {
        padding: 0.30rem;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Recommended Lists</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active">Recommended Lists</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12"> 
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <table id="data_details_table" class="table dataTable table-bordered table-striped nowrap" width="100%">
                                <thead>
                                    <tr>
                                        <th>Sno</th>
                                        <th>Organisation</th>
                                        <th>Department</th>
                                        <th>Post</th>
                                        <th>Full Name</th>
                                        <th>Designation</th>
                                        <th>Mode</th>
                                        <th>Status</th>
                                        <th>Adv. Date</th>
                                        <th>Recc. Date</th>
                                        <th>Toal Vacc</th>
                                        <th>Total Recc.</th>
                                        <th></th>                                       
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>                                   
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="modal fade" id="modal_preview_details">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-body">
                            <div class="modal-content card card-primary card-outline">
                                <div class="card-header">                       
                                    <div class="float-left">
                                        Recommended Details
                                    </div>
                                    <div class="float-right">
                                        <a href="javascript:void(0)" data-dismiss="modal" class="close btn btn-sm" title="Close">
                                            <span aria-hidden="true">X Close</span>
                                        </a>
                                    </div>                                        
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body" id="previewDetailsHTML">
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>                
            </div>

            <div class="row">
                <div class="modal fade" id="modal_preview_pdf">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-body">
                            <div class="modal-content card card-primary card-outline">
                                <div class="card-header">                       
                                    <div class="float-left">
                                        File Details
                                    </div>
                                    <div class="float-right">
                                        <a href="javascript:void(0)" data-dismiss="modal" class="close btn btn-sm" title="Close">
                                            <span aria-hidden="true">X Close</span>
                                        </a>
                                    </div>                                        
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body" id="previewPDFDetailsHTML">
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>                
            </div>

            <div class="row">
                <div class="modal fade" id="modal_recommended_list">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-body">
                            <div class="modal-content card card-primary card-outline">
                                <div class="card-header">                       
                                    <div class="float-left">
                                        Recommended Detail List
                                    </div>
                                    <div class="float-right">
                                        <a href="javascript:void(0)" data-dismiss="modal" class="close btn btn-sm" title="Close">
                                            <span aria-hidden="true">X Close</span>
                                        </a>
                                    </div>                                        
                                </div>
                                <!-- /.card-header -->
                                <div class="row" id="recommendedListHTML">

                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </section>
</div>

<script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/additional-methods.min.js"></script>
<script>
    var myTable = "";
    var autoRefresh = true;
    $(document).ready(function () {
        reload_datatables();
    });
    function reload_datatables() {
        myTable = $('#data_details_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            "scrollX": true,
            "lengthMenu": [[10, 20, 30, 40, 50, -1], [10, 20, 30, 40, 50, "All"]],
            "autoWidth": true,
            //dom: 'lBfrtip',
            ajax: {url: "<?php echo site_url('requiRecommended/ajax_list') ?>",
                type: "POST",
                data: function (data) {
                    // data.resolved_status = $('#resolved_status').val()
                }
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();
                var logout = api.ajax.json().logout;
                var msg = api.ajax.json().msg;
                if (logout) {
                    toastr.error(msg, "", {closeButton: true, timeOut: 5000});
                    window.location.href = "<?php echo base_url('page?name=home'); ?>";
                }
            },
            columnDefs: [
                {targets: [0, 6, 7, 12], searchable: false, orderable: false},
                {targets: [0, 5, 6, 7], width: "5px"},
                {targets: [3], width: "25%"},
                {targets: [4], width: "10%"},
                {targets: [8, 11], width: "8%"},
                {targets: [9, 10, 12], width: "10%"},
                {targets: [0, 6, 7, 8, 9, 10, 11, 12], className: "text-center"},
            ]
        });
    }

    function previewRecord(id) {
        $('#loading').show();
        jQuery.ajax({
            type: "POST",
            url: "<?php echo base_url('requiRecommended/viewRecommendedData'); ?>",
            dataType: 'json',
            data: {
                id: id,
                type: 'list'
            },
            success: function (data) {
                if (data.status) {
                    $('#previewDetailsHTML').html(data.previewDetailsHTML);
                    $('#modal_preview_details').modal({backdrop: 'static', keyboard: false});
                } else {
                    toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                    if (data.logout) {
                        window.location.href = "<?php echo base_url('page?name=home'); ?>";
                    }
                }
                $('#loading').hide();
            }
        });
    }

    function previewPdfRecord(id) {
        $('#loading').show();
        jQuery.ajax({
            type: "POST",
            url: "<?php echo base_url('requiInbox/printInbox'); ?>",
            dataType: 'json',
            data: {
                id: id
            },
            success: function (data) {
                if (data.status) {
                    var h = screen.height;
                    var height = (h - 250);
                    var pdflink = '<embed src="<?php echo base_url('assets/pdfjs/web/viewer.html?file=') ?>' + data.fileUrl + '" frameborder="0" width="100%" height="' + height + '"/>';
                    $('#previewPDFDetailsHTML').html(pdflink);
                    $('#modal_preview_pdf').modal({backdrop: 'static', keyboard: false});
                } else {
                    toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                    if (data.logout) {
                        window.location.href = "<?php echo base_url('page?name=home'); ?>";
                    }
                }
                $('#loading').hide();
            }
        });
    }
</script>
