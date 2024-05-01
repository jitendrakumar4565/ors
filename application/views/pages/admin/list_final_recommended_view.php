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
<div class="row">
    <div class="col-sm-12">
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
</div>
<table id="data_details_recc_table" class="table dataTable table-bordered table-striped nowrap" width="100%">
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

<script>
    var finalReccTable = "";
    var autoRefresh = false;
    $(document).ready(function () {
        reload_datatables_recc();
    });
    function reload_datatables_recc() {
        finalReccTable = $('#data_details_recc_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            "scrollX": true,
            "lengthMenu": [[5, 10, 20, 30, 40, 50, -1], [5, 10, 20, 30, 40, 50, "All"]],
            "autoWidth": true,
            //dom: 'lBfrtip',
            ajax: {url: "<?php echo site_url('recommendedFinal/ajax_recc_list') ?>",
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
                {targets: [0, 1, 2, 3, 4, 5, 7, 9, 10], className: "text-center"}
            ]
        });
    }
</script>
