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

    td.adv-left{
        border-left: 2px solid blue;
    }
    td.adv-right{
        border-right:  2px solid blue;
    }
    td.resi-left{
        border-left: 2px solid red;
    }
    td.resi-right{
        border-right:  2px solid red;
    }
    td.recc-left{
        border-left: 2px solid green;
    }
    td.recc-right{
        border-right:  2px solid green;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Requisitions Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active">Requisitions Report</li>
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
                        <div class="card-header">
                            <div class="card-tools float-left">
                                <a href="javascript:modalFilter()" title="Filter Record" class="btn btn-sm btn-outline-success"><i class="fa fa-filter"></i> Filter</a>
                                <a href="javascript:resetFilter()" title="Reset" class="btn btn-sm btn-outline-danger"><i class="fa fa-refresh"></i> Reset</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="data_details_table" class="table dataTable table-bordered table-striped nowrap" width="100%">
                                <thead>
                                    <tr>
                                        <th colspan="6" style="border-right: 2px solid blue;"></th>
                                        <th colspan="4" class="text-center text-primary" style="border: 2px solid blue;border-left: none;">Vacancy Advertised</th>
                                        <th style="border-right: 2px solid green;"></th>
                                        <th colspan="4" class="text-center text-success" style="border: 2px solid green;border-left: none;">Recommended</th>
                                        <th style="border-right: 2px solid red;"></th>
                                        <th colspan="4" class="text-center text-danger" style="border:  2px solid red;border-left: none;">Residual</th>
                                    </tr>
                                    <tr>
                                        <th>Sno</th>
                                        <th>Organisation</th>
                                        <th>Department</th>
                                        <th>Post</th>
                                        <th>Mode</th>
                                        <th style="border-right: 2px solid blue">Status</th>
                                        <th >UR</th>
                                        <th style="">APST</th>
                                        <th style="">PwD</th>
                                        <th style="border-right:  2px solid blue">Ex-SM</th>
                                        <th style="border-right:  2px solid green;"></th>

                                        <th>UR</th>
                                        <th>APST</th>
                                        <th>PwD</th>
                                        <th style="border-right:  2px solid green">Ex-SM</th>
                                        <th style="border-right:  2px solid red;"></th>

                                        <th>UR</th>
                                        <th>APST</th>
                                        <th>PwD</th>
                                        <th style="border-right:  2px solid red;">Ex-SM</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>

                                <tfoot> 
                                    <tr>
                                        <th colspan="6" style="border-right: 2px solid blue">Total</th>
                                        <th style="border-right:  none">UR</th>
                                        <th>APST</th>
                                        <th>PwD</th>
                                        <th style="border-right:  2px solid blue">Ex-SM</th>
                                        <th style="border-right: 2px solid green;"></th>

                                        <th >UR</th>
                                        <th>APST</th>
                                        <th>PwD</th>
                                        <th style="border-right:  2px solid green">Ex-SM</th>
                                        <th style="border-right: 2px solid red;"></th>

                                        <th>UR</th>
                                        <th>APST</th>
                                        <th>PwD</th>
                                        <th style="border-right:  2px solid red">Ex-SM</th>
                                        <th></th>
                                    </tr>

                                    <tr>
                                        <th colspan="6" style="border-right: 2px solid blue"></th>
                                        <th colspan="4" style="border: 2px solid blue;border-left: none;" class="text-center text-primary">Vacancy Advertised</th>
                                        <th style="border-right:  2px solid green"></th>
                                        <th colspan="4" style="border: 2px solid green;border-left: none;" class="text-center text-success">Recommended</th>
                                        <th style="border-right:  2px solid red"></th>
                                        <th colspan="4" style="border: 2px solid red;border-left: none;" class="text-center text-danger">Residual</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="modal fade" id="modal_filter">
                    <div class="modal-dialog">
                        <div class="modal-body">
                            <div class="modal-content card card-primary card-outline">
                                <div class="card-header">                       
                                    <div class="float-left">
                                        Filter Record
                                    </div>
                                    <div class="float-right">
                                        <a href="javascript:void(0)" data-dismiss="modal" class="close btn btn-sm" title="Close">
                                            <span aria-hidden="true">X Close</span>
                                        </a>
                                    </div>                                        
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Pay Scale <span class="text-danger"> *</span></label>
                                                <select class="form-control form-control-sm"  id="pay_scale" name="pay_scale[]" multiple="" data-placeholder="Select pay scale" style="width: 100%;">
                                                    <option value="1"> Level 1 </option>
                                                    <option value="2"> Level 2 </option>
                                                    <option value="3"> Level 3 </option>
                                                    <option value="4"> Level 4 </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Status <span class="text-danger"> *</span></label>
                                                <select class="form-control form-control-sm"  id="approved_flag" name="approved_flag[]" multiple="" data-placeholder="Select status" style="width: 100%;">
                                                    <option value="PENDING">Pending</option>
                                                    <option value="ACCEPTED">Accepted</option>
                                                    <option value="RETURNED">Returned</option>
                                                    <option value="ADVERTISED">Advertised</option>
                                                    <option value="RECOMMENDED">Recommended</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="">Department <span class="text-danger"> *</span></label>
                                                <select class="form-control" onchange="loadOrgName(this.id)" id="dept_id" name="dept_id" multiple="" data-placeholder="Select department" style="width: 100%;">
                                                    <?php
                                                    if ($deptList != NULL) {
                                                        foreach ($deptList as $dRow) {
                                                            ?>
                                                            <option value="<?php echo $dRow->auto_id; ?>"><?php echo $dRow->dept_name; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Select organisation/office <span class="text-danger">*</span></label>
                                                <select title="Select organisation/office"  class="form-control form-control-sm" id="org_id"  name="org_id[]" multiple="" data-placeholder="Select organisation/office" style="width: 100%;">
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="">Name of post <span class="text-danger"> *</span></label>
                                                <select title="Select post"  class="form-control form-control-sm" id="post_id"  name="post_id[]" multiple="" data-placeholder="Select post" style="width: 100%;">
                                                    <?php
                                                    if ($postList != NULL) {
                                                        foreach ($postList as $pRow) {
                                                            ?>
                                                            <option value="<?php echo $pRow->auto_id; ?>"><?php echo $pRow->post_name; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="">Mode of recruitment <span class="text-danger"> *</span></label>
                                                <select class="form-control form-control-sm"  id="mode_recuit" name="mode_recuit[]" multiple="" data-placeholder="Select mode" style="width: 100%;">
                                                    <option value="D">Direct Recruitment-</option>
                                                    <option value="L">LDCE Recruitment-</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="row card-footer justify-content-end">
                                    <div class="card-tools">
                                        <a href="javascript:filterData()" title="Search Record" class="btn btn-sm btn-outline-success"><i class="fa fa-search ml-2"></i> Search Record</a>
                                        <a href="javascript:void(0)" title="Close" data-dismiss="modal" class="btn btn-sm btn-outline-danger"><i class="fa fa-times"></i> Close</a>
                                    </div>                  
                                </div>
                            </div>
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
                                                        $('#dept_id').multiselect({
                                                            columns: 1,
                                                            placeholder: 'Select Department',
                                                            search: true,
                                                            showCheckbox: true,
                                                            maxHeight: 330,
                                                            minHeight: 330,
                                                            selectAll: true,
                                                            searchOptions: {
                                                                'default': 'Search Department'
                                                                        /* searchText: true, // search within the text               
                                                                         searchValue: false,
                                                                         */
                                                            }
                                                        });
                                                        $('#org_id').multiselect({
                                                            columns: 1,
                                                            placeholder: 'Select Organisation',
                                                            search: true,
                                                            showCheckbox: true,
                                                            maxHeight: 260,
                                                            minHeight: 250,
                                                            searchOptions: {
                                                                'default': 'Search Organisation'
                                                                        /* searchText: true, // search within the text               
                                                                         searchValue: false,
                                                                         */
                                                            },
                                                            selectAll: true
                                                        });
                                                        $('#post_id').multiselect({
                                                            columns: 1,
                                                            placeholder: 'Select Post',
                                                            search: true,
                                                            showCheckbox: true,
                                                            maxHeight: 230,
                                                            minHeight: 220,
                                                            searchOptions: {
                                                                'default': 'Search Post'
                                                                        /* searchText: true, // search within the text               
                                                                         searchValue: false,
                                                                         */
                                                            },
                                                            selectAll: true
                                                        });
                                                        $('#mode_recuit').multiselect({
                                                            columns: 1,
                                                            placeholder: 'Select Mode',
                                                            search: false,
                                                            showCheckbox: true,
                                                            maxHeight: 100,
                                                            minHeight: 90,
                                                            searchOptions: {
                                                                'default': 'Search Mode'
                                                                        /* searchText: true, // search within the text               
                                                                         searchValue: false,
                                                                         */
                                                            },
                                                            selectAll: false
                                                        });
                                                        $('#pay_scale').multiselect({
                                                            columns: 1,
                                                            placeholder: 'Select Pay Scale',
                                                            search: false,
                                                            showCheckbox: true,
                                                            maxHeight: 150,
                                                            minHeight: 150,
                                                            searchOptions: {
                                                                'default': 'Search Pay Scale'
                                                                        /* searchText: true, // search within the text               
                                                                         searchValue: false,
                                                                         */
                                                            },
                                                            selectAll: false
                                                        });
                                                        $('#approved_flag').multiselect({
                                                            columns: 1,
                                                            placeholder: 'Select Status',
                                                            search: false,
                                                            showCheckbox: true,
                                                            maxHeight: 200,
                                                            minHeight: 180,
                                                            searchOptions: {
                                                                'default': 'Search Status'
                                                                        /* searchText: true, // search within the text               
                                                                         searchValue: false,
                                                                         */
                                                            },
                                                            selectAll: false
                                                        });
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
                                                            ajax: {url: "<?php echo site_url('requiReport/ajax_list') ?>",
                                                                type: "POST",
                                                                data: function (data) {
                                                                    data.dept_name = $('#dept_id').val(),
                                                                            data.org_name = $('#org_id').val(),
                                                                            data.post_name = $('#post_id').val(),
                                                                            data.mode_recuit = $('#mode_recuit').val(),
                                                                            data.pay_scale = $('#pay_scale').val(),
                                                                            data.status = $('#approved_flag').val()

                                                                }
                                                            },
                                                            "footerCallback": function (row, data, start, end, display) {
                                                                var api = this.api();
                                                                var logout = api.ajax.json().logout;
                                                                var msg = api.ajax.json().msg;
                                                                var allcat = api.ajax.json().allcat;

                                                                $(api.column(6).footer()).html(allcat['adv_ur']);
                                                                $(api.column(7).footer()).html(allcat['adv_apst']);
                                                                $(api.column(8).footer()).html(allcat['adv_pwd']);
                                                                $(api.column(9).footer()).html(allcat['adv_exsm']);

                                                                $(api.column(11).footer()).html(allcat['rec_ur']);
                                                                $(api.column(12).footer()).html(allcat['rec_apst']);
                                                                $(api.column(13).footer()).html(allcat['rec_pwd']);
                                                                $(api.column(14).footer()).html(allcat['rec_exsm']);

                                                                $(api.column(16).footer()).html(allcat['res_ur']);
                                                                $(api.column(17).footer()).html(allcat['res_apst']);
                                                                $(api.column(18).footer()).html(allcat['res_pwd']);
                                                                $(api.column(19).footer()).html(allcat['res_exsm']);


                                                                if (logout) {
                                                                    toastr.error(msg, "", {closeButton: true, timeOut: 5000});
                                                                    window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                                }
                                                            },
                                                            columnDefs: [
                                                                {targets: [0, 5, 10, 15, 18, 20], searchable: false, orderable: false},
                                                                {targets: [10, 15], width: "1px"},
                                                                {targets: [0, 5, 18], width: "5px"},
                                                                {targets: [0, 4, 6, 7, 8, 11, 12, 13, 16, 17, 18, 20], className: "text-center"},
                                                                {targets: [5], className: "text-center adv-right"},
                                                                {targets: [9], className: "text-center adv-right"},

                                                                {targets: [10], className: "text-center recc-right"},
                                                                {targets: [14], className: "text-center recc-right"},

                                                                {targets: [15], className: "text-center resi-right"},
                                                                {targets: [19], className: "text-center resi-right"}
                                                            ]
                                                        });
                                                    }

                                                    function loadOrgName(deptid) {
                                                        $('#org_id').html('');
                                                        $('#org_id').multiselect('reload');
                                                        var depts = [];
                                                        $.each($("#" + deptid + " option:selected"), function () {
                                                            depts.push($(this).val());
                                                        });
                                                        // Ajax post
                                                        jQuery.ajax({
                                                            type: "POST",
                                                            url: "<?php echo base_url('organisation/loadMultiOrgName'); ?>",
                                                            dataType: 'json',
                                                            data: {
                                                                dept_id: depts
                                                            },
                                                            success: function (data) {
                                                                if (data.status) {
                                                                    // Add options
                                                                    $.each(data.result, function (index, data_dept) {
                                                                        $('#org_id').append('<option value="' + data_dept['auto_id'] + '">' + data_dept['org_name'] + '</option>');
                                                                    });
                                                                    $('#org_id').multiselect('reload');
                                                                } else {
                                                                    toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                                                                    if (data.logout) {
                                                                        window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                                    }
                                                                }
                                                            }
                                                        });
                                                    }

                                                    function previewRecord(id) {
                                                        $('#loading').show();
                                                        jQuery.ajax({
                                                            type: "POST",
                                                            url: "<?php echo base_url('requiReport/viewData'); ?>",
                                                            dataType: 'json',
                                                            data: {
                                                                id: id
                                                            },
                                                            success: function (data) {
                                                                if (data.status) {
                                                                    $('#previewDetailsHTML').html(data.previewDetailsHTML);
                                                                    $('#modal_preview_details').modal({backdrop: 'static', keyboard: false});
                                                                    myTable.draw();
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
                                                                    myTable.draw();
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

                                                    function modalFilter() {
                                                        $('#modal_filter').modal({backdrop: 'static', keyboard: false});
                                                    }

                                                    function filterData() {
                                                        myTable.draw();
                                                        $('#modal_filter').modal('hide');
                                                    }

                                                    function resetFilter() {
                                                        $("select option").prop("selected", false);
                                                        $('#org_id').html('');
                                                        $('select').multiselect('reload');
                                                        myTable.draw();
                                                    }
</script>
