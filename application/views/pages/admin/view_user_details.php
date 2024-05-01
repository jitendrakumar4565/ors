<style>
    #approval {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }
    #approval td, #approval th {
        border: 1px solid #ddd;
        padding: 5px;
    }
    #approval tr:nth-child(even){background-color: #f2f2f2;}
    #approval tr:hover {background-color: #ddd;}
    #approval th {
        padding-top: 5px;
        padding-bottom: 5px;
        text-align: left;
        background-color: #4c98af;
        color: white;
    }    
</style>
<div class="box-body" id="">
    <?php
    if ($userDetails != NULL) {
        $emailVerS = "<span class='text-danger'>NO</span>";
        $mobVerS = "<span class='text-danger'>NO</span>";
        $loginAccessS = "<span class='text-danger'>NO</span>";
        $approvedFlagS = "<span class='text-danger'>PENDING</span>";

        $emailVer = $userDetails->is_email_verified;
        if ($emailVer == "Y") {
            $emailVerS = "<span class='text-success'>YES</span>";
        }
        $mobVer = $userDetails->is_mob_verified;
        if ($mobVer == "Y") {
            $mobVerS = "<span class='text-success'>YES</span>";
        }
        $loginAccess = $userDetails->login_access;
        if ($loginAccess == "Y") {
            $loginAccessS = "<span class='text-success'>YES</span>";
        }
        $approvedFlag = $userDetails->approved_flag;
        if ($approvedFlag == "A") {
            $approvedFlagS = "<span class='text-success'>APPROVED</span>";
        }
        ?>
        <div class="row" style="overflow-x: auto;">
            <div class="col-sm-12">
                <div class="form-group">
                    <table id="approval" style="width:100%" border="0">
                        <tr>
                            <td style="width: 25%"><b>Full Name  </b></td>
                            <td style="width: 75%"><?php echo $userDetails->full_name; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 25%"><b>Designation</b></td>
                            <td style="width: 75%"><?php echo $userDetails->desig_name; ?></td>
                        </tr>
                    </table>
                    <table id="approval" style="width:100%" border="0">
                        <tr>
                            <td style="width: 25%;"><b style="">Email </b></td>
                            <td style="width: 75%"><?php echo $userDetails->email_id; ?> </td>
                        </tr>
                        <tr>
                            <td style="width: 25%;"><b style="">Mobile </b></td>
                            <td style="width: 75%"><?php echo $userDetails->mobile_no; ?></td>
                        </tr>
                    </table>
                    <table id="approval" style="width:100%" border="0">
                        <tr>
                            <td style="width: 25%;"><b style="">Email Verified </b></td>
                            <td style="width: 75%"><?php echo $emailVerS; ?> </td>
                        </tr>
                        <tr>
                            <td style="width: 25%;"><b style="">Mobile Verified </b></td>
                            <td style="width: 75%"><?php echo $mobVerS; ?></td>
                        </tr>
                    </table>
                    <table id="approval" style="width:100%" border="0">
                        <tr>
                            <td style="width: 25%;"><b style="">Login Allowed </b></td>
                            <td style="width: 75%"><?php echo $loginAccessS; ?> </td>
                        </tr>
                        <tr>
                            <td style="width: 35%;"><b style="">Approved Status </b></td>
                            <td style="width: 65%"><?php echo $approvedFlagS; ?></td>
                        </tr>
                    </table>
                    <table id="approval" style="width:100%" border="0">
                        <tr>
                            <td style="width: 25%;"><b style="">Department </b></td>
                            <td style="width: 75%"><?php echo $userDetails->dept_name; ?> </td>
                        </tr>
                    </table>
                    <table id="approval" style="width:100%;" border="0">
                        <tr>
                            <td style="width: 100%;text-align: center"><b style="">Organisations List <?php echo ' ( ' . count($orgList) . ' ) '; ?></b></td>
                        </tr>

                        <?php
                        $orgAssigned = "";
                        if ($orgList != NULL) {
                            $sno = 1;
                            foreach ($orgList as $oRow) {
                                $orgAssigned .= '<tr>';
                                $orgAssigned .= '<td>' . $sno . ' . ' . $oRow->org_name . '</td>';
                                $orgAssigned .= '</tr>';
                                $sno++;
                            }
                        }
                        ?> 
                        <tr>
                            <td style="">
                                <?php echo $orgAssigned; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col-sm-12 ml-4">
                    <?php if ($approvedFlag != 'A') { ?>
                        <button type="button" id="finalSubmitBtn" name="finalSubmitBtn" onclick="approveUser()" class="btn btn-outline-info"> <i class="fa fa-check"></i> Approve</button>
                    <?php } ?>
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        <?php }
        ?>
    </div><!-- /.box-body -->
</div>
<?php if ($approvedFlag != 'A') { ?>
    <div class="row">
        <div class="modal fade" id="modal_form_approve">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-body">
                    <div class="modal-content card card-primary card-outline">
                        <div class="card-header">                       
                            <div class="float-left">
                                Confirmation?
                            </div>
                            <div class="float-right">
                                <a href="javascript:closeModal('modal_form_approve')" class="text-danger" title="Close"><i class="fa fa-times-circle"></i></a>
                            </div>                                        
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <p style="font-size: 14px;font-weight: bold">Are you sure wants to approve..?</p>
                        </div>
                        <!-- /.card-body -->
                        <div class="row card-footer justify-content-end">
                            <div class="card-tools">                            
                                <button title="Approve User" type="button" onclick="confirmApprove('<?php echo $autoId ?>')" class="btn btn-sm btn-outline-danger"><i class="fa fa-check-circle ml-2"></i> Approve</button>                             
                                <a href="javascript:closeModal('modal_form_approve')" title="Close" class="btn btn-sm btn-outline-danger"><i class="fa fa-times"></i> Close</a>
                            </div>                  
                        </div>
                    </div>
                </div>
            </div>
        </div>                
    </div>
<?php } ?>
<script>
    function approveUser() {
        $('#modal_form_approve').modal({backdrop: 'static', keyboard: false});
    }
<?php if ($approvedFlag != 'A') { ?>
        function confirmApprove(autoid) {
            if (autoid != "") {
                $('#loading').show();
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo base_url('user/approveUser'); ?>",
                    dataType: 'json',
                    data: {
                        auto_id: autoid
                    },
                    success: function (data) {
                        if (data.status) {
                            $('#modal_form_approve').modal('hide');
                            $('#modal_view_details').modal('hide');
                            Toast.fire({icon: 'success', title: data.msg});
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
            } else {
                toastr.error("Auto ID is required", "", {closeButton: true, timeOut: 5000});
            }
        }
<?php } ?>

</script>
