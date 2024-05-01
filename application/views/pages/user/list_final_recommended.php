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
    table.dataTable.select tbody tr,
    table.dataTable thead th:first-child {
        cursor: pointer;
    </style>
    <div class="row">
        <div class="col-sm-10">
            <div class="form-group">
                <table style="border: 1px solid #000;">
                    <tr>
                        <td style="border: 1px solid #000;"><span><b>&nbsp; IOL</b> : Issue Offer Letter &nbsp;</span></td>
                        <td style="border: 1px solid #000;"><span><b>&nbsp; UOL</b> : Upload Offer Letter &nbsp;</span></td>
                        <td style="border: 1px solid #000;"><span><b>&nbsp; IAL</b> : Issue Appointment Letter &nbsp;</span></td>
                        <td style="border: 1px solid #000;"><span><b>&nbsp; UAL</b> : Upload Appointment Letter &nbsp;</span></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <button type="button" id="iol_btn" title="Issue Offer Letter" onclick="issueOfferLetterModal('<?php echo $id; ?>')" class="btn btn-xs btn-outline-primary" disabled=""> <i class="fa fa-file-text-o"></i> Issue Offer Letter</button>
            </div>
        </div>
    </div>

    <table id="data_details_recc_table" class="table select dataTable table-bordered table-striped nowrap" width="100%">
        <thead>
            <tr>
                <th>Sno</th>
                <th>IOL</th>
                <th>UOL</th>
                <th>IAL</th>
                <th>UAL</th>
                <th>Roll No</th>
                <th>Full Name</th>
                <th>DOB</th>
                <th>Father Name</th>
                <th>Cat. Allot</th>
                <th></th>                                       
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>                                   
        </tfoot>
    </table>


    <div class="row">
        <div class="modal fade" id="modal_iol">
            <div class="modal-dialog">
                <div class="modal-body">
                    <form role="form" autocomplete="off" id="issueOfferLetterForm" name="issueOfferLetterForm" method="post">
                        <div class="modal-content card card-primary card-outline">
                            <div class="card-header">                       
                                <div class="float-left">
                                    Confirmation?
                                </div>
                                <div class="float-right">
                                    <a href="javascript:closeModal('modal_iol')" class="text-danger" title="Close"><i class="fa fa-times-circle"></i></a>
                                </div>                                        
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <p>Do you really wants to issue offer letter..?</p>
                            </div>
                            <!-- /.card-body -->
                            <div class="row card-footer justify-content-end">
                                <div class="card-tools">
                                    <button title="Issue Offer Letter" type="button" onclick="confirmIOL()" class="btn btn-sm btn-outline-primary"><i class="fa fa-check ml-2"></i> Issue Offer Letter</button>
                                    <a href="javascript:closeModal('modal_iol')" title="Close" class="btn btn-sm btn-outline-danger"><i class="fa fa-times"></i> Close</a>
                                </div>                  
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>                
    </div>

    <div class="row">
        <div class="modal fade" id="modal_ial">
            <div class="modal-dialog">
                <div class="modal-body">
                    <form role="form" autocomplete="off" id="issueAppointmentLetterForm" name="issueAppointmentLetterForm" method="post">
                        <input type="hidden" class="form-control form-control-sm" id="inbox_auto_id" name="inbox_auto_id" required="" value="<?php echo $id ?>" >
                        <div class="modal-content card card-primary card-outline">
                            <div class="card-header">                       
                                <div class="float-left">
                                    Confirmation?
                                </div>
                                <div class="float-right">
                                    <a href="javascript:closeModal('modal_ial')" class="text-danger" title="Close"><i class="fa fa-times-circle"></i></a>
                                </div>                                        
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <p>Do you really wants to issue appointment letter..?</p>
                            </div>
                            <!-- /.card-body -->
                            <div class="row card-footer justify-content-end">
                                <div class="card-tools">
                                    <button title="Issue Offer Letter" type="button" onclick="confirmIAL()" class="btn btn-sm btn-outline-primary"><i class="fa fa-check ml-2"></i> Issue Appointment Letter</button>
                                    <a href="javascript:closeModal('modal_ial')" title="Close" class="btn btn-sm btn-outline-danger"><i class="fa fa-times"></i> Close</a>
                                </div>                  
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>                
    </div>

    <div class="row">
        <div class="modal fade" id="modal_upload_ol">
            <div class="modal-dialog">
                <div class="modal-body">
                    <form role="form" autocomplete="off" id="uploadOfferLetterForm" name="uploadOfferLetterForm" method="post">
                        <input type="hidden" class="form-control form-control-sm" id="inbox_auto_id" name="inbox_auto_id" required="" value="<?php echo $id ?>" >
                        <div class="modal-content card card-primary card-outline">
                            <div class="card-header">                       
                                <div class="float-left">
                                    <i class="fa fa-file-pdf-o text-danger"></i> Upload Offer Letter
                                </div>
                                <div class="float-right">
                                    <a href="javascript:closeModal('modal_upload_ol')" class="text-danger" title="Close"><i class="fa fa-times-circle"></i></a>
                                </div>                                        
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="">Upload offer letter (in pdf format) <span class="text-danger">*</span></label>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" onclick="selectFile('fileInput_d_3')"  class="form-control form-control-sm mycustomfile" readonly=""  id="file_copy_fileInput_d_3" name="file_copy_d_3" placeholder="Select File (pdf) only">
                                                            <span class="input-group-append">
                                                                <button type="button" class="btn btn-default" onclick="selectFile('fileInput_d_3')"><i class="fas fa-file text-primary mr-1"></i>Browse</button>
                                                                <button type="button" id="remove_btn_fileInput_d_3" name="remove_btn_fileInput_d_3" onclick="removeFile('fileInput_d_3')" class="removebtn btn btn-default d-none"> <i class="fa fa-trash text-danger mr-1"></i>Remove</button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 d-none">
                                                    <div class="form-group">
                                                        <input type="file"  id="fileInput_d_3" name="file_d_3" required="" onchange="fileValidation('fileInput_d_3')" class="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <!-- Progress bar -->
                                        <div class="hide progress">
                                            <div class="progress-bar"></div>
                                        </div>
                                        <!-- Display upload status -->
                                        <div class="uploadStatus"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="row card-footer justify-content-end">
                                <div class="card-tools">
                                    <button title="Upload File" type="submit" class="btn btn-sm btn-outline-primary"><i class="fa fa-arrow-circle-o-up ml-2"></i> Upload File</button>
                                    <a href="javascript:closeModal('modal_upload_ol')" title="Close" class="btn btn-sm btn-outline-danger"><i class="fa fa-times"></i> Close</a>
                                </div>                  
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>                
    </div>

    <div class="row">
        <div class="modal fade" id="modal_upload_al">
            <div class="modal-dialog">
                <div class="modal-body">
                    <form role="form" autocomplete="off" id="uploadAppointmentLetterForm" name="uploadAppointmentLetterForm" method="post">
                        <input type="hidden" class="form-control form-control-sm" id="inbox_auto_id" name="inbox_auto_id" required="" value="<?php echo $id ?>" >
                        <div class="modal-content card card-primary card-outline">
                            <div class="card-header">                       
                                <div class="float-left">
                                    <i class="fa fa-file-pdf-o text-danger"></i> Upload Appoint Letter
                                </div>
                                <div class="float-right">
                                    <a href="javascript:closeModal('modal_upload_al')" class="text-danger" title="Close"><i class="fa fa-times-circle"></i></a>
                                </div>                                        
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="">Upload appointment letter (in pdf format) <span class="text-danger">*</span></label>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" onclick="selectFile('fileInput_a_3')"  class="form-control form-control-sm mycustomfile" readonly=""  id="file_copy_fileInput_a_3" name="file_copy_a_3" placeholder="Select File (pdf) only">
                                                            <span class="input-group-append">
                                                                <button type="button" class="btn btn-default" onclick="selectFile('fileInput_a_3')"><i class="fas fa-file text-primary mr-1"></i>Browse</button>
                                                                <button type="button" id="remove_btn_fileInput_a_3" name="remove_btn_fileInput_a_3" onclick="removeFile('fileInput_a_3')" class="removebtn btn btn-default d-none"> <i class="fa fa-trash text-danger mr-1"></i>Remove</button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 d-none">
                                                    <div class="form-group">
                                                        <input type="file"  id="fileInput_a_3" name="file_a_3" required="" onchange="fileValidation('fileInput_a_3')" class="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <!-- Progress bar -->
                                        <div class="hide progress">
                                            <div class="progress-bar"></div>
                                        </div>
                                        <!-- Display upload status -->
                                        <div class="uploadStatus"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="row card-footer justify-content-end">
                                <div class="card-tools">
                                    <button title="Upload File" type="submit" class="btn btn-sm btn-outline-primary"><i class="fa fa-arrow-circle-o-up ml-2"></i> Upload File</button>
                                    <a href="javascript:closeModal('modal_upload_al')" title="Close" class="btn btn-sm btn-outline-danger"><i class="fa fa-times"></i> Close</a>
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
                                                            var table = "";
                                                            var autoRefresh = false;
                                                            var rows_selected = [];
                                                            $(document).ready(function () {
                                                                reload_datatables_recc();
                                                                $('form[id="uploadOfferLetterForm"]').validate({
                                                                    rules: {
                                                                        "inbox_auto_id": {
                                                                            required: true,
                                                                            digits: true
                                                                        },
                                                                        "file_copy_d_3": {
                                                                            required: true
                                                                        },
                                                                        "file_d_3": {
                                                                            required: true
                                                                        },
                                                                        roll_no: {
                                                                            required: true,
                                                                            digits: true
                                                                        }
                                                                    },
                                                                    messages: {
                                                                        "file_copy_d_3": {
                                                                            required: "Select pdf file"
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
                                                                        uploadOfferLetter();
                                                                        //$('#loading').show();
                                                                    }
                                                                });


                                                                $('form[id="uploadAppointmentLetterForm"]').validate({
                                                                    rules: {
                                                                        "inbox_auto_id": {
                                                                            required: true,
                                                                            digits: true
                                                                        },
                                                                        "file_copy_a_3": {
                                                                            required: true
                                                                        },
                                                                        "file_a_3": {
                                                                            required: true
                                                                        },
                                                                        roll_no: {
                                                                            required: true,
                                                                            digits: true
                                                                        }
                                                                    },
                                                                    messages: {
                                                                        "file_copy_a_3": {
                                                                            required: "Select pdf file"
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
                                                                        uploadAppointmentLetter();
                                                                        //$('#loading').show();
                                                                    }
                                                                });
                                                            });
                                                            function reload_datatables_recc() {
                                                                table = $('#data_details_recc_table').DataTable({
                                                                    processing: true,
                                                                    serverSide: true,
                                                                    searching: true,
                                                                    "scrollX": true,
                                                                    "lengthMenu": [[5, 10, 20, 30, 40, 50, -1], [5, 10, 20, 30, 40, 50, "All"]],
                                                                    "autoWidth": true,
                                                                    //dom: 'lBfrtip',
                                                                    ajax: {url: "<?php echo site_url('recommendedFinal/ajax_user_list') ?>",
                                                                        type: "POST",
                                                                        data: function (data) {
                                                                            data.inbox_requi_id = '<?php echo $id; ?>'
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
                                                                        {targets: [0, 1, 2, 3, 4, 10], searchable: false, orderable: false},
                                                                        {targets: [0, 1, 2, 3, 4, 5, 7, 9, 10], width: "2px"},
                                                                        {targets: [0, 1, 2, 3, 4, 5, 9, 10], className: "text-center"}
                                                                    ],
                                                                    'rowCallback': function (row, data, dataIndex) {
                                                                        $('#iol_btn').attr('disabled', 'true');
                                                                        // Get row ID
                                                                        var rowId = data[5];
                                                                        // If row ID is in the list of selected row IDs
                                                                        if ($.inArray(rowId, rows_selected) !== -1) {
                                                                            $(row).find('input[type="checkbox"]').prop('checked', true);
                                                                            $(row).addClass('selected');
                                                                            $(row).css('background-color', '#a1aec7');
                                                                        }
                                                                        if (rows_selected.length > 0) {
                                                                            $('#iol_btn').removeAttr('disabled');
                                                                        }
                                                                    }
                                                                });
                                                            }

                                                            // Handle click on checkbox
                                                            $('#data_details_recc_table tbody').on('click', 'input[type="checkbox"]', function (e) {
                                                                $('#iol_btn').attr('disabled', 'true');
                                                                var $row = $(this).closest('tr');
                                                                // Get row data
                                                                var data = table.row($row).data();
                                                                // Get row ID
                                                                var rowId = data[5];
                                                                // Determine whether row ID is in the list of selected row IDs 
                                                                var index = $.inArray(rowId, rows_selected);
                                                                // If checkbox is checked and row ID is not in list of selected row IDs
                                                                if (this.checked && index === -1) {
                                                                    rows_selected.push(rowId);
                                                                    // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
                                                                } else if (!this.checked && index !== -1) {
                                                                    rows_selected.splice(index, 1);
                                                                }

                                                                if (this.checked) {
                                                                    $row.addClass('selected');
                                                                    jQuery(this).parents("tr").css('background-color', '#a1aec7');
                                                                } else {
                                                                    $row.removeClass('selected');
                                                                    jQuery(this).parents("tr").css('background-color', '');
                                                                }
                                                                if (rows_selected.length > 0) {
                                                                    $('#iol_btn').removeAttr('disabled');
                                                                }
                                                                // Update state of "Select all" control
                                                                //updateDataTableSelectAllCtrl(table);
                                                                // Prevent click event from propagating to parent
                                                                e.stopPropagation();
                                                            });

                                                            // Handle click on table cells with checkboxes
                                                            $('#data_details_recc_table').on('click', 'tbody td, thead th:first-child', function (e) {
                                                                $(this).parent().find('input[type="checkbox"]').trigger('click');
                                                            });

                                                            // Handle table draw event
                                                            table.on('draw', function () {
                                                                // Update state of "Select all" control
                                                                // updateDataTableSelectAllCtrl(table);
                                                            });

                                                            function issueOfferLetterModal(auto_id) {
                                                                $("#issueOfferLetterForm #roll_nos").remove();
                                                                $.each(rows_selected, function (index, rowId) {
                                                                    $('#issueOfferLetterForm').append("<input type='hidden' name='roll_nos[]' id='roll_nos' value='" + rowId + "' required=''/>");
                                                                });
                                                                $("#issueOfferLetterForm #auto_id").remove();
                                                                $('#issueOfferLetterForm').append("<input type='hidden' name='auto_id' id='auto_id' value='" + auto_id + "' required=''/>");
                                                                $('#modal_iol').modal('show');
                                                            }

                                                            function confirmIOL() {
                                                                $('#loading').show();
                                                                // Ajax post
                                                                jQuery.ajax({
                                                                    type: "POST",
                                                                    url: "<?php echo base_url('recommendedFinal/issueOfferLetter'); ?>",
                                                                    dataType: 'json',
                                                                    data: $("#issueOfferLetterForm").serialize(),
                                                                    success: function (data) {
                                                                        if (data.status) {
                                                                            Toast.fire({icon: 'success', title: data.msg});
                                                                            $('#modal_iol').modal('hide');
                                                                            rows_selected = [];
                                                                            table.ajax.reload(null, false);
                                                                        } else {
                                                                            toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                                                                        }
                                                                        $('#loading').hide();
                                                                    }
                                                                });
                                                            }

                                                            function showFileUpload(rollno) {
                                                                $('#uploadOfferLetterForm .invalid-feedback').removeClass('invalid-feedback');
                                                                $('#uploadOfferLetterForm .is-invalid').removeClass('is-invalid');
                                                                $('#uploadOfferLetterForm .is-valid').removeClass('is-valid');
                                                                $('#uploadOfferLetterForm .error').remove();
                                                                $('#uploadOfferLetterForm .mycustomfile').val('');
                                                                $('#uploadOfferLetterForm .removebtn').addClass('d-none');
                                                                $("#uploadOfferLetterForm #roll_no").remove();
                                                                $('#uploadOfferLetterForm').append("<div class='form-group'><input type='hidden' required='' class='form-control form-control-sm' name='roll_no' id='roll_no' value='" + rollno + "'/></div>");
                                                                $('#modal_upload_ol').modal({backdrop: 'static', keyboard: false});
                                                            }

                                                            function showFileUploadAL(rollno) {
                                                                $('#uploadAppointmentLetterForm .invalid-feedback').removeClass('invalid-feedback');
                                                                $('#uploadAppointmentLetterForm .is-invalid').removeClass('is-invalid');
                                                                $('#uploadAppointmentLetterForm .is-valid').removeClass('is-valid');
                                                                $('#uploadAppointmentLetterForm .error').remove();
                                                                $('#uploadAppointmentLetterForm .mycustomfile').val('');
                                                                $('#uploadAppointmentLetterForm .removebtn').addClass('d-none');
                                                                $("#uploadAppointmentLetterForm #roll_no").remove();
                                                                $('#uploadAppointmentLetterForm').append("<div class='form-group'><input type='hidden' required='' class='form-control form-control-sm' name='roll_no' id='roll_no' value='" + rollno + "'/></div>");
                                                                $('#modal_upload_al').modal({backdrop: 'static', keyboard: false});
                                                            }

                                                            function selectFile(id) {
                                                                $('#' + id).click();
                                                            }
                                                            function removeFile(id) {
                                                                $('.invalid-feedback').removeClass('invalid-feedback');
                                                                $('.is-invalid').removeClass('is-invalid');
                                                                $('.is-valid').removeClass('is-valid');
                                                                $('.error').remove();
                                                                $('#' + id).val('');
                                                                $('#file_copy_' + id).val('');
                                                                $('#remove_btn_' + id).addClass('d-none');
                                                                $('#view_btn_' + id).addClass('d-none');
                                                            }
                                                            function fileValidation(id) {
                                                                var fileInput = document.getElementById(id);
                                                                var filePath = fileInput.value;
                                                                // Allowing file type
                                                                //var allowedExtensions = /(\.pdf|\.rar)$/i;
                                                                var allowedExtensions = /(\.pdf)$/i;

                                                                if (!allowedExtensions.exec(filePath)) {
                                                                    alert('Invalid file type');
                                                                    fileInput.value = '';
                                                                    $('#file_copy_' + id).val('');
                                                                    $('#remove_btn_' + id).addClass('d-none');
                                                                    $('#view_btn_' + id).addClass('d-none');
                                                                    return false;
                                                                } else {
                                                                    var file = fileInput.files[0];
                                                                    if (fileInput.files && fileInput.files[0]) {
                                                                        $('#remove_btn_' + id).removeClass('d-none');
                                                                        $('#file_copy_' + id).val(file.name);
                                                                    }
                                                                }
                                                            }

                                                            function uploadOfferLetter() {
                                                                $('#loading').show();
                                                                var fi = $("#fileInput_d_3").val();
                                                                if (fi != "") {
                                                                    $('#uploadOfferLetterForm .progress').removeClass('hide');
                                                                } else {
                                                                    $('#uploadOfferLetterForm .progress').addClass('hide');
                                                                }
                                                                $.ajax({
                                                                    xhr: function () {
                                                                        var xhr = new window.XMLHttpRequest();
                                                                        xhr.upload.addEventListener("progress", function (evt) {
                                                                            if (evt.lengthComputable) {
                                                                                var percentComplete = ((evt.loaded / evt.total) * 100);
                                                                                $("#uploadOfferLetterForm .progress-bar").width(percentComplete + '%');
                                                                                $("#uploadOfferLetterForm .progress-bar").html(percentComplete + '%');
                                                                            }
                                                                        }, false);
                                                                        return xhr;
                                                                    },
                                                                    type: 'POST',
                                                                    url: "<?php echo base_url('recommendedFinal/uploadOfferLetter'); ?>",
                                                                    dataType: 'json',
                                                                    data: new FormData($('#uploadOfferLetterForm')[0]),
                                                                    contentType: false,
                                                                    cache: false,
                                                                    processData: false,
                                                                    beforeSend: function () {
                                                                        $("#uploadOfferLetterForm .progress-bar").width('0%');
                                                                    },
                                                                    error: function () {
                                                                        $('#loading').hide();
                                                                        $('#uploadOfferLetterForm .uploadStatus').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');
                                                                    },
                                                                    success: function (data) {
                                                                        if (data.status) {
                                                                            $('#modal_upload_ol').modal('hide');
                                                                            $('#uploadOfferLetterForm .progress').addClass('hide');
                                                                            $('#uploadOfferLetterForm')[0].reset();
                                                                            $('#uploadFilesSubmitBtn').prop("disabled", true);
                                                                            table.ajax.reload(null, false);
                                                                            Toast.fire({icon: 'success', title: data.msg});
                                                                        } else {
                                                                            $('#uploadOfferLetterForm .progress').addClass('hide');
                                                                            toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                                                                            if (data.logout) {
                                                                               window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                                            }
                                                                        }
                                                                        $('#loading').hide();
                                                                    }
                                                                });
                                                            }

                                                            function issueAppointmentLetterModal(roll_no) {
                                                                $("#issueAppointmentLetterForm #roll_no").remove();
                                                                $('#issueAppointmentLetterForm').append("<input type='hidden' name='roll_no' id='roll_no' value='" + roll_no + "' required=''/>");
                                                                $('#modal_ial').modal('show');
                                                            }

                                                            function confirmIAL() {
                                                                $('#loading').show();
                                                                // Ajax post
                                                                jQuery.ajax({
                                                                    type: "POST",
                                                                    url: "<?php echo base_url('recommendedFinal/issueAppointmentLetter'); ?>",
                                                                    dataType: 'json',
                                                                    data: $("#issueAppointmentLetterForm").serialize(),
                                                                    success: function (data) {
                                                                        if (data.status) {
                                                                            Toast.fire({icon: 'success', title: data.msg});
                                                                            $('#modal_ial').modal('hide');
                                                                            table.ajax.reload(null, false);
                                                                        } else {
                                                                            $('#modal_ial').modal('hide');
                                                                            toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                                                                        }
                                                                        $('#loading').hide();
                                                                    }
                                                                });
                                                            }

                                                            function uploadAppointmentLetter() {
                                                                $('#loading').show();
                                                                var fi = $("#fileInput_a_3").val();
                                                                if (fi != "") {
                                                                    $('#uploadAppointmentLetterForm .progress').removeClass('hide');
                                                                } else {
                                                                    $('#uploadAppointmentLetterForm .progress').addClass('hide');
                                                                }
                                                                $.ajax({
                                                                    xhr: function () {
                                                                        var xhr = new window.XMLHttpRequest();
                                                                        xhr.upload.addEventListener("progress", function (evt) {
                                                                            if (evt.lengthComputable) {
                                                                                var percentComplete = ((evt.loaded / evt.total) * 100);
                                                                                $("#uploadAppointmentLetterForm .progress-bar").width(percentComplete + '%');
                                                                                $("#uploadAppointmentLetterForm .progress-bar").html(percentComplete + '%');
                                                                            }
                                                                        }, false);
                                                                        return xhr;
                                                                    },
                                                                    type: 'POST',
                                                                    url: "<?php echo base_url('recommendedFinal/uploadAppointmentLetter'); ?>",
                                                                    dataType: 'json',
                                                                    data: new FormData($('#uploadAppointmentLetterForm')[0]),
                                                                    contentType: false,
                                                                    cache: false,
                                                                    processData: false,
                                                                    beforeSend: function () {
                                                                        $("#uploadAppointmentLetterForm .progress-bar").width('0%');
                                                                    },
                                                                    error: function () {
                                                                        $('#loading').hide();
                                                                        $('#uploadAppointmentLetterForm .uploadStatus').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');
                                                                    },
                                                                    success: function (data) {
                                                                        if (data.status) {
                                                                            $('#modal_upload_al').modal('hide');
                                                                            $('#uploadAppointmentLetterForm .progress').addClass('hide');
                                                                            $('#uploadAppointmentLetterForm')[0].reset();
                                                                            $('#uploadAppointmentLetterForm').prop("disabled", true);
                                                                            table.ajax.reload(null, false);
                                                                            Toast.fire({icon: 'success', title: data.msg});
                                                                        } else {
                                                                            $('#uploadAppointmentLetterForm .progress').addClass('hide');
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
