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


<table id="data_details_recc_table" class="table dataTable table-bordered table-striped nowrap" width="100%">
    <thead>
        <tr>
            <th>Sno</th>
            <th>Roll No</th>
            <th>Full Name</th>
            <th>DOB</th>
            <th>Father Name</th>
            <th>Cat. Allot</th>
            <th>PwD</th>
            <th>Ex-SM</th>
            <th></th>                                       
        </tr>
    </thead>
    <tbody>
    </tbody>
    <tfoot>                                   
    </tfoot>
</table>

<div class="row">
    <div class="modal fade" id="modal_delete_recc_row">
        <div class="modal-dialog">
            <div class="modal-body">
                <form role="form" autocomplete="off" id="dataDeleteForm" name="dataDeleteForm" method="post">
                    <div class="modal-content card card-primary card-outline">
                        <div class="card-header">                       
                            <div class="float-left">
                                Confirmation?
                            </div>
                            <div class="float-right">
                                <a href="javascript:closeModal('modal_delete_recc_row')" class="text-danger" title="Close"><i class="fa fa-times-circle"></i></a>
                            </div>                                        
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <p>Do you really want to delete..?</p>
                        </div>
                        <!-- /.card-body -->
                        <div class="row card-footer justify-content-end">
                            <div class="card-tools">
                                <button title="Delete Record" type="button" onclick="confirmDeleteData()" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash ml-2"></i> Delete Record</button>
                                <a href="javascript:closeModal('modal_delete_recc_row')" title="Close" class="btn btn-sm btn-outline-danger"><i class="fa fa-times"></i> Close</a>
                            </div>                  
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>                
</div>

<script src="<?php echo base_url() ?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/additional-methods.min.js"></script>
<script>
                                    var dbRollNos = "";
                                    var draftReccTable = "";
                                    var autoRefresh = false;
                                    $(document).ready(function () {
                                        //  var a = ['1.pdf', '2', '3'];
                                        //var a = a.includes('1.pdf1'); // true 
                                        //var b = a.includes(1); // false
                                        //alert(a);

                                        reload_datatables_recc();
                                    });
                                    function reload_datatables_recc() {
                                        draftReccTable = $('#data_details_recc_table').DataTable({
                                            processing: true,
                                            serverSide: true,
                                            searching: true,
                                            "scrollX": true,
                                            "lengthMenu": [[5, 10, 20, 30, 40, 50, -1], [5, 10, 20, 30, 40, 50, "All"]],
                                            "autoWidth": true,
                                            //dom: 'lBfrtip',
                                            ajax: {url: "<?php echo site_url('recommendedDraft/ajax_list') ?>",
                                                type: "POST",
                                                data: function (data) {
                                                    data.inbox_requi_id = '<?php echo $id; ?>'
                                                }
                                            },
                                            "footerCallback": function (row, data, start, end, display) {
                                                var api = this.api();
                                                var logout = api.ajax.json().logout;
                                                var msg = api.ajax.json().msg;
                                                var nosDraftRecord = api.ajax.json().nosDraftRecord;
                                                var totalRecc = api.ajax.json().totalRecc;
                                                var validDossiers = api.ajax.json().validDossiers;
                                                dbRollNos = api.ajax.json().dbRollNos;
                                                //var a = dbRollNos.includes('1000002.pdf'); // true 
                                                //alert('Total Rec : ' + totalRecc + " nos rec : " + nosDraftRecord + " Valid Dossiers : " + validDossiers);
                                                if (parseInt(nosDraftRecord) >= totalRecc) {
                                                    $('#add_details_btn').attr('disabled', 'true');
                                                    // $('#upload_excel_file_btn').attr('disabled', 'true');
                                                } else {
                                                    $('#add_details_btn').removeAttr('disabled');
                                                    // $('#upload_excel_file_btn').removeAttr('disabled');
                                                }
                                                if ((parseInt(totalRecc) == parseInt(nosDraftRecord)) && (parseInt(totalRecc) == parseInt(validDossiers))) {
                                                    $('#send_to_dept_btn').removeAttr('disabled');
                                                } else {
                                                    $('#send_to_dept_btn').attr('disabled', 'true');
                                                }
                                                if (logout) {
                                                    toastr.error(msg, "", {closeButton: true, timeOut: 5000});
                                                    window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                }
                                            },
                                            columnDefs: [
                                                {targets: [0, 8], searchable: false, orderable: false},
                                                {targets: [0, 1, 3, 5, 6, 7, 8], width: "5px"},
                                                {targets: [0, 1, 3, 5, 6, 7, 8], className: "text-center"}
                                            ]
                                        });
                                    }

                                    function deleteDetail(auto_id) {
                                        $("#dataDeleteForm #auto_id").remove();
                                        $('#dataDeleteForm').append("<input type='hidden' name='auto_id' id='auto_id' value='" + auto_id + "' required=''/>");
                                        $('#modal_delete_recc_row').modal('show');
                                    }

                                    function confirmDeleteData() {
                                        $('#loading').show();
                                        // Ajax post
                                        jQuery.ajax({
                                            type: "POST",
                                            url: "<?php echo base_url('recommendedDraft/deleteData'); ?>",
                                            dataType: 'json',
                                            data: $("#dataDeleteForm").serialize(),
                                            success: function (data) {
                                                if (data.status) {
                                                    Toast.fire({icon: 'success', title: data.msg});
                                                    $('#modal_delete_recc_row').modal('hide');
                                                    draftReccTable.draw();
                                                    draftDossiersList('<?php echo $id; ?>');
                                                } else {
                                                    toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                                                }
                                                $('#loading').hide();
                                            }
                                        });
                                    }
</script>
