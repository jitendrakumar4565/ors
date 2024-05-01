<style>
    .table.dataTable {     
        /*font-size: 1em;*/
    }
    .table.dataTable  {
        /* font-family: Verdana, Geneva, Tahoma, sans-serif;*/
        /* font-size: 1em;*/
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
                    <h1>Accepted List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active">Accepted List</li>
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
                                        <th>Sent Datetime</th>
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
                                        Preview Details
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
                <div class="modal fade" id="modal_pull_back">
                    <div class="modal-dialog">
                        <div class="modal-body">
                            <form role="form" autocomplete="off" id="pullBackForm" name="pullBackForm" method="post">
                                <div class="modal-content card card-primary card-outline">
                                    <div class="card-header">                       
                                        <div class="float-left">
                                            Confirmation?
                                        </div>
                                        <div class="float-right">
                                            <a href="javascript:void(0)" data-dismiss="modal" class="text-danger" title="Close"><i class="fa fa-times-circle"></i></a>
                                        </div>                                        
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <p>Do you really wants to pull back..?</p>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="row card-footer justify-content-end">
                                        <div class="card-tools">
                                            <button title="Pull Back" type="button" onclick="confirmPullBack()" class="btn btn-sm btn-outline-danger"><i class="fa fa-arrow-circle-o-left ml-2"></i> Pull Back</button>
                                            <a href="javascript:void(0)" title="Close" data-dismiss="modal" class="btn btn-sm btn-outline-danger"><i class="fa fa-times"></i> Close</a>
                                        </div>                  
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="row">
                <div class="modal fade" id="modal_advertised">
                    <div class="modal-dialog">
                        <div class="modal-body">
                            <form role="form" autocomplete="off" id="advertisedForm" name="advertisedForm" method="post">
                                <div class="modal-content card card-primary card-outline">
                                    <div class="card-header">                       
                                        <div class="float-left">
                                            Advertised
                                        </div>
                                        <div class="float-right">
                                            <a href="javascript:void(0)" data-dismiss="modal" class="text-danger" title="Close"><i class="fa fa-times-circle"></i></a>
                                        </div>                                        
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="adv_date" class="">Advertisement Date (DD/MM/YYYY) <span class="text-danger">*</span></label>
                                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                        <input type="text" class="form-control form-control-sm" autocomplete="off" id="adv_date" name="adv_date" data-target="#reservationdate"  data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" placeholder="dd/mm/yyyy" data-mask/>
                                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                            
<!-- <p id="adv_postname"></p>-->
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="row card-footer justify-content-end">
                                        <div class="card-tools">
                                            <button title="Advertised" type="submit" class="btn btn-sm btn-outline-primary"><i class="fa fa-newspaper-o ml-2"></i> Advertised</button>
                                            <a href="javascript:void(0)" title="Close" data-dismiss="modal" class="btn btn-sm btn-outline-danger"><i class="fa fa-times"></i> Close</a>
                                        </div>                  
                                    </div>
                                </div>
                            </form>
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
                                                var autoRefresh = false;
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
                                                        ajax: {url: "<?php echo site_url('requiAccepted/ajax_list') ?>",
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
                                                            {targets: [0, 6, 7, 8, 9], searchable: false, orderable: false},
                                                            {targets: [0, 5, 6, 7], width: "5px"},
                                                            {targets: [3], width: "25%"},
                                                            {targets: [4], width: "10%"},
                                                            {targets: [8], width: "8%"},
                                                            {targets: [0, 6, 7, 8, 9], className: "text-center"},
                                                        ]
                                                    });
                                                }

                                                function previewRecord(id) {
                                                    $('#loading').show();
                                                    jQuery.ajax({
                                                        type: "POST",
                                                        url: "<?php echo base_url('requiInbox/viewData'); ?>",
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

                                                function pullBack(auto_id) {
                                                    $("#pullBackForm #auto_id").remove();
                                                    $('#pullBackForm').append("<input type='hidden' name='auto_id' id='auto_id' value='" + auto_id + "'/>");
                                                    $('#modal_pull_back').modal('show');
                                                }

                                                function confirmPullBack() {
                                                    $('#loading').show();
                                                    // Ajax post
                                                    jQuery.ajax({
                                                        type: "POST",
                                                        url: "<?php echo base_url('requiInbox/pullBackSentForm'); ?>",
                                                        dataType: 'json',
                                                        data: $("#pullBackForm").serialize(),
                                                        success: function (data) {
                                                            if (data.status) {
                                                                Toast.fire({icon: 'success', title: data.msg});
                                                                myTable.draw();
                                                                $('#modal_pull_back').modal('hide');
                                                                $('#modal_preview_details').modal('hide');
                                                            } else {
                                                                toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                                                                $('#modal_pull_back').modal('hide');
                                                            }
                                                            $('#loading').hide();
                                                        }
                                                    });
                                                }

                                                function advertisedPost(auto_id) {
                                                    $("#advertisedForm #auto_id").remove();
                                                    $('#advertisedForm').append("<input type='hidden' name='auto_id' id='auto_id' value='" + auto_id + "'/>");
                                                    $('#modal_advertised').modal('show');
                                                    //var postname = $('#' + auto_id).val();
                                                    //$('#adv_postname').html(postname);
                                                }


                                                $(document).ready(function () {
                                                    $('form[id="advertisedForm"]').validate({
                                                        rules: {
                                                            adv_date: {
                                                                required: true
                                                            }
                                                        },
                                                        messages: {
                                                            adv_date: {
                                                                required: "Advertisement date is required",
                                                            }
                                                        },
                                                        errorElement: 'span',
                                                        errorPlacement: function (error, element) {
                                                            error.addClass('invalid-feedback');
                                                            element.closest('.form-group').append(error);
                                                        },
                                                        highlight: function (element, errorClass, validClass) {
                                                            $(element).addClass('is-invalid');
                                                        },
                                                        unhighlight: function (element, errorClass, validClass) {
                                                            $(element).removeClass('is-invalid');
                                                            $(element).addClass('is-valid');
                                                        },
                                                        submitHandler: function (form) {
                                                            postAdvertised();
                                                            //$('#loading').show();
                                                        }
                                                    });
                                                });

                                                function postAdvertised() {
                                                    $('#loading').show();
                                                    jQuery.ajax({
                                                        type: "POST",
                                                        url: "<?php echo base_url('requiInbox/postAdvertised'); ?>",
                                                        dataType: 'json',
                                                        data: $("#advertisedForm").serialize(),
                                                        success: function (data) {
                                                            if (data.status) {
                                                                Toast.fire({icon: 'success', title: data.msg});
                                                                myTable.draw();
                                                                $('#modal_advertised').modal('hide');
                                                            } else if (!(data.status)) {
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
