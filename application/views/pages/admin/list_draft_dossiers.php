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
    .bold{
        font-weight: bold;
    }
</style>

<table id="dossiers_list_table" class="table table-bordered table-striped nowrap">
    <thead>
        <tr>
            <th>Sno</th>
            <th>Name</th>
            <th>Date Modified</th>
            <th>Size</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $dbRollNos = array();
        foreach ($rollNosDraft as $rRow) {
            $dbRollNos[] = $rRow->roll_no . '.pdf';
        }
        $sl = 1;
        if ($files != NULL) {
            foreach ($files as $file) {
                $size = " bytes";
                $value = filesize($targetDir . $file);
                //convert Bytes Logic
                if ($value < 1024) {
                    $size = $value . " bytes";
                }
                //convert Kilobytes Logic
                else if ($value < 1024000) {
                    $size = round(($value / 1024), 1) . " KB";
                }
                //convert Megabytes Logic
                else {
                    $size = round(($value / 1024000), 1) . " MB";
                }
                //echo $file . ' : ' . date("d-m-Y H:i", filemtime($targetDir . $file)) . ' : ' . $size . '<br/>';
                $fname = $file;
                $cls = '';
                if (!(in_array($fname, $dbRollNos))) {
                    $cls = 'text-danger bold';
                }
                $datemod = date("d-m-Y H:i", filemtime($targetDir . $file));
                $fsize = $size;
                ?>  
                <tr class="<?php echo $cls; ?>">
                    <td><?php echo $sl; ?></td>
                    <td><?php echo $fname; ?></td>
                    <td><?php echo $datemod; ?></td>
                    <td><?php echo $fsize; ?></td>
                    <td>
                        <a title="Download" class="btn btn-outline-info btn-sm" href="<?php echo base_url('dossierFiles/downloadDossier?fname=' . $fname . '&id=' . $id); ?>"><i class="fas fa-download"></i>  </a>&nbsp;
                        <a title="View" class="btn btn-outline-danger btn-sm" href="javascript:void(0)" onclick="viewFile('<?php echo base_url($targetDir . $file); ?>')"><i class="fa fa-file-pdf-o"></i> View Dossier</a>&nbsp;
                        <a title="Delete" class="btn btn-outline-danger btn-sm" href="javascript:void(0)" onclick="deleteFile('<?php echo $fname; ?>', '<?php echo $id; ?>')"><i class="fa fa-trash"></i>  </a>&nbsp;
                    </td>
                </tr>
                <?php
                $sl++;
            }
        }
        ?>
    </tbody>
    <tfoot>

    </tfoot>
</table>
<div class="row">
    <div class="modal fade" id="modal_delete">
        <div class="modal-dialog">
            <div class="modal-body">
                <form role="form" autocomplete="off" id="dataDeleteFileForm" name="dataDeleteFileForm" method="post">
                    <div class="modal-content card card-primary card-outline">
                        <div class="card-header">                       
                            <div class="float-left">
                                Confirmation?
                            </div>
                            <div class="float-right">
                                <a href="javascript:closeModal('modal_delete')" class="text-danger" title="Close"><i class="fa fa-times-circle"></i></a>
                            </div>                                        
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <p>Do you really want to delete..?</p>
                        </div>
                        <!-- /.card-body -->
                        <div class="row card-footer justify-content-end">
                            <div class="card-tools">
                                <button title="Delete File" type="button" onclick="confirmDeleteFile()" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash ml-2"></i> Delete File</button>
                                <a href="javascript:closeModal('modal_delete')" title="Close" class="btn btn-sm btn-outline-danger"><i class="fa fa-times"></i> Close</a>
                            </div>                  
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>                
</div>
<script>
    var dossierTable = $("#dossiers_list_table").DataTable({
        "responsive": true,
        "autoWidth": false,
        "lengthMenu": [[5, 10, 20, 30, 40, 50, -1], [5, 10, 20, 30, 40, 50, "All"]],
        columnDefs: [
            {targets: [0, 4], searchable: false, orderable: false},
            {targets: [0, 2, 3, 4], width: "5px"},
            {targets: [0, 3, 4], className: "text-center"}
        ]
    });
    function deleteFile(filename, id) {
        $("#dataDeleteFileForm #auto_id").remove();
        $('#dataDeleteFileForm').append("<input type='hidden' name='fname' id='fname' value='" + filename + "' required=''/>");
        $('#dataDeleteFileForm').append("<input type='hidden' name='id' id='id' value='" + id + "' required=''/>");
        $('#modal_delete').modal('show');
    }

    function confirmDeleteFile() {
        $('#loading').show();
        // Ajax post
        jQuery.ajax({
            type: "POST",
            url: "<?php echo base_url('dossierFiles/deleteDraftDossier'); ?>",
            dataType: 'json',
            data: $("#dataDeleteFileForm").serialize(),
            success: function (data) {
                if (data.status) {
                    Toast.fire({icon: 'success', title: data.msg});
                    $('#modal_delete').modal('hide');
                    draftDossiersList('<?php echo $id; ?>');
                    draftReccTable.draw();
                } else {
                    toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                }
                $('#loading').hide();
            }
        });
    }
</script>