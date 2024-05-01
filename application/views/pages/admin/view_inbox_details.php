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
    if ($mData != NULL) {
        foreach ($mData as $mRow) {
            $modeRecName = 'DIRECT RECRUITMENT';
            $clsName = 'badge-success';
            $actionTaken = $mRow->action_taken;
            $modeRec = $mRow->c_mode_recruitment;
            if ($modeRec == "L") {
                $modeRecName = 'LDCE RECRUITMENT';
                $clsName = 'badge-danger';
            }
            $statusSpan = $actionTaken;
            ?>
            <fieldset class="scheduler-border">
                <legend class="scheduler-border"><span class="badge <?php echo $clsName; ?>"><?php echo $modeRecName; ?></span></legend>
                <div class="row" style="overflow-x: auto;">
                    <div class="col-sm-12">
                        <div class="form-group">    
                            <table id="approval" style="width:100%" border="0">
                                <tr>
                                    <td style="width: 15%"><b>Entry DateTime  </b></td>
                                    <td style="width: 15%"><?php echo date("d-m-Y g:i A", strtotime($mRow->entry_datetime)); ?></td>
                                    <td style="width: 13%"><b>Sent DateTime </b> </td>
                                    <td style="width: 17%"><?php echo date("d-m-Y g:i A", strtotime($mRow->sent_datetime)); ?></td>
                                    <td style="width: 15%;text-align: center"><b>Current Status</b> </td>
                                    <td style="width: 25%" colspan="3"><?php echo $statusSpan; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Remarks</b></td>
                                    <td colspan="5"><?php echo $mRow->action_remarks; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row" style="overflow-x: auto;">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <table id="approval" style="width:100%" border="0">
                                <tr>
                                    <td style="width: 25%"><b>Name of the Organization/Office  </b></td>
                                    <td style="width: 75%"><?php echo $mRow->org_name; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 25%"><b>Name of Department</b></td>
                                    <td style="width: 75%"><?php echo $mRow->dept_name; ?></td>
                                </tr>
                            </table>

                            <table id="approval" style="width:100%" border="0">
                                <tr>
                                    <td colspan="2"><b>Contact details of Department representative(not below the rank of Deputy Secretary) of the identing Office/Department</b>  </td>
                                </tr>
                                <tr>
                                    <td style="width: 25%;"><b style="">Name </b></td>
                                    <td style="width: 75%"><?php echo $mRow->officer_name; ?> </td>
                                </tr>
                                <tr>
                                    <td style="width: 25%;"><b style="">Designation </b></td>
                                    <td style="width: 75%"><?php echo $mRow->desig_name; ?></td>
                                </tr>

                                <tr>
                                    <td style="width: 25%;"><b style="">Contact : </b> <?php echo $mRow->contact_no; ?></td>
                                    <td style="width: 75%"><b>Email-Id : </b> <?php echo $mRow->officer_email; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row" style="overflow-x: auto;">
                    <div class="col-sm-12">
                        <div class="form-group">    
                            <table id="approval"  style="width:100%" border="0">
                                <tr>
                                    <td style="width: 25%;"><b style="">Mode of recruitment</b></td>
                                    <td style="width: 75%" colspan="3"><?php echo $modeRecName; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 25%;"><b style="">Name of Post</b></td>
                                    <td style="width: 75%" colspan="3"><?php echo $mRow->post_name; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 25%;"><b style="">Group</b> : <?php echo $mRow->a_group; ?></td>
                                    <td style="width: 75%"><b>Pay Scale </b> : Level - <?php echo $mRow->b_pay_scale; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <table id="approval" style="width:100%" border="0">
                                <tr>
                                    <td colspan="6" style="width: 100%"><b>Breakup of vacancy </b>(Horizontal vacancy- The vacancies should be inclusive of total vacancy)</td>
                                </tr>
                                <tr>
                                    <td style="width: 25%"><b style="">Unreserved : </b><?php echo $mRow->d_ur; ?></td>
                                    <td style="width: 25%"><b>APST : </b><?php echo $mRow->d_apst; ?></td>
                                    <td style="width: 50%"><b>Total : </b><?php echo $mRow->d_total; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 25%"><b style="">PwD : </b><?php echo $mRow->d_pwd; ?></td>
                                    <td style="width: 25%" colspan="2"><b>Ex-Serviceman : </b><?php echo $mRow->d_ex_sm; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <table id="approval" style="width:100%" border="0">
                                <thead>
                                    <tr>
                                        <td colspan="3"><b>Category of disability, if applicable</b></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 5%" class="text-center">Sl no.</th>
                                        <th style="width: 85%">Disability category</th>
                                        <th style="width: 10%;" class="text-center">No. of Vacancy</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center" >
                                            i)
                                        </td>
                                        <td>
                                            Blindness and Low Vision
                                        </td>
                                        <td style="width: 35%" class="text-center">
                                            <?php echo $mRow->e_blindness; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" >
                                            ii)
                                        </td>
                                        <td >
                                            Deaf and Hard of hearing
                                        </td>
                                        <td class="text-center" >
                                            <?php echo $mRow->e_deaf; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" >
                                            iii)
                                        </td>
                                        <td class="">
                                            Locomotor Disability including Cerebral Palsy, Leprosy Cured, Dwarfism, Acid Attack Victims and Muscular Dystrophy
                                        </td>
                                        <td class="text-center" >
                                            <?php echo $mRow->e_locomotor; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" >
                                            iv)
                                        </td>
                                        <td>
                                            Autism, Intellectual Disability, Specific Learning Disability and Mental Illness
                                        </td>
                                        <td class="text-center" >
                                            <?php echo $mRow->e_autism; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" >
                                            v)
                                        </td>
                                        <td>
                                            Multiple Disabilities from among persons under clauses (i) to (iv) including deaf-blindness
                                        </td>
                                        <td class="text-center" >
                                            <?php echo $mRow->e_multiple; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: right"><b>Total</b></td>
                                        <td class="text-center" style="font-weight: bold">
                                            <?php echo $mRow->e_total; ?>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>                                   
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <table id="approval" style="width:100%" border="0">
                                <tr>
                                    <td style="width: 90%"><b>Whether the vacancies for the person with disabilities and Ex-Serviceman have been worked out with reference to the instructions contained in the Government of Arunachal Pradesh Orders </b></td>
                                    <td style="width: 10%" class="text-center"><?php echo $mRow->f_vac_worked_out; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <table id="approval" style="width:100%" border="0">
                                <tr>
                                    <td style="width: 100%"><b>Education and other qualification laid down in the Recruitment Rules</b></td>
                                </tr>
                                <tr>
                                    <td style="width: 100%"><span><?php echo $mRow->g_edu_others; ?></span></td>
                                </tr>                      
                            </table>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <table id="approval" style="width:100%" border="0">
                                <tr>
                                    <td colspan="2" style="width: 100%"><b>Age limit as per Recruitment Rules notified in Gazette of Arunachal Pradesh</b></td>
                                </tr>
                                <tr>
                                    <td style="width: 50%"><b style="">Minimum age (years) : </b> <?php echo $mRow->h_min_age; ?></td>
                                    <td style="width: 50%"><b>Maximum age (years) : </b> <?php echo $mRow->h_max_age; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <table id="approval" style="width:100%" border="0">
                                <thead>
                                    <tr>
                                        <td colspan="3"><b>Whether relaxation of Upper age available to undermentioned categories, if yes, please mention</b></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 70%" class="">Name of Post</th>
                                        <th style="width: 30%" class="text-center">Permissible Upper age relaxation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td  class="">
                                            APST
                                        </td>
                                        <td style="width: 35%" class="text-center">
                                            <?php echo $mRow->i_apst; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td  class="">
                                            PwD (APST)
                                        </td>
                                        <td style="width: 35%" class="text-center">
                                            <?php echo $mRow->i_pwd_apst; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td  class="">
                                            PwD (UR)
                                        </td>
                                        <td style="width: 35%" class="text-center">
                                            <?php echo $mRow->i_pwd_ur; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="">
                                            Ex-Servicemen (APST)
                                        </td>
                                        <td style="width: 35%" class="text-center">
                                            <?php echo $mRow->i_ex_sm_apst; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="">
                                            Ex-Servicemen (UR)
                                        </td>
                                        <td style="width: 35%" class="text-center">
                                            <?php echo $mRow->i_ex_sm_ur; ?>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>                                   
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <table id="approval" style="width:100%" border="0">
                                <tr>
                                    <td style="width: 90%"><b>Whether there is any ban or restriction from the Govt. for filling up the post</b></td>
                                    <td style="width: 10%" class="text-center"><?php echo $mRow->j_ban_restric; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <table id="approval" style="width:100%" border="0">
                                <tr>
                                    <td style="width: 90%"><b>Upload latest Recruitment Rules (in pdf format) </b></td>
                                    <td style="width: 10%" class="text-center"><?php if ($mRow->file_copy_k_rr != "") { ?> <i onclick="viewFile('<?php echo base_url('requisitions_documents/' . $mRow->file_copy_k_rr) ?>')" class="fa fa-file-pdf-o text-danger" style="cursor: pointer"></i><?php } ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <table id="approval" style="width:100%" border="0">
                                <tr>
                                    <td style="width: 90%"><b>Any other requirement or conditions not covered above</b></td>
                                    <td style="width: 10%" class="text-center"><?php if ($mRow->file_copy_l_ro != "") { ?> <i onclick="viewFile('<?php echo base_url('requisitions_documents/' . $mRow->file_copy_l_ro) ?>')" class="fa fa-file-pdf-o text-danger" style="cursor: pointer"></i><?php } ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="width: 100%"><?php echo $mRow->l_other_requi_cond; ?> </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <?php if ($modeRec == "L") { ?>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <table id="approval" style="width:100%" border="0">
                                    <tr>
                                        <td style="width: 100%"><b>Specify the Criteria of Eligibility under which the LDCE post falls, as per Recruitment Rule</b></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100%"><b>Name of post : </b><span><?php echo $mRow->m_criteria_eligibility_post; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100%"><span><?php echo $mRow->eligibility; ?></span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <table id="approval" style="width:100%" border="0">
                                    <tr>
                                        <td style="width: 90%"><b>Upload detailed list of eligible candidates(in pdf format) </b></td>
                                        <td style="width: 10%" class="text-center"><?php if ($mRow->file_copy_n_list_cands != "") { ?> <i onclick="viewFile('<?php echo base_url('requisitions_documents/' . $mRow->file_copy_n_list_cands) ?>')" class="fa fa-file-pdf-o text-danger" style="cursor: pointer"></i><?php } ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <table id="approval" style="width:100%" border="0">
                                    <tr>
                                        <td style="width: 90%"><b>Upload detailed list of eligible candidates(in excel format) </b></td>
                                        <td style="width: 10%" class="text-center"><?php if ($mRow->file_copy_o_list_cands != "") { ?> <a href="<?php echo base_url('requisitions_documents/' . $mRow->file_copy_o_list_cands) ?>" target="_self" class="fa fa-file-excel-o text-success"></a><?php } ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </fieldset>
            <?php
        }
        ?>


        <div class="modal-footer">
            <div class="row">
                <div class="col-sm-12 ml-4">
                    <?php if ($actionTaken == "PENDING") { ?>
                        <button type="button" title="Accept Form" id="finalSubmitBtn" name="finalSubmitBtn" onclick="approveForm('<?php echo $mRow->auto_id ?>')" class="btn btn-outline-info"> <i class="fa fa-check"></i> Accept</button>
                        <button type="button" title="Return Form" id="" name="" onclick="returnForm('<?php echo $mRow->auto_id ?>')" class="btn btn-outline-danger"> <i class="fa fa-arrow-circle-right"></i> Return</button>
                    <?php } ?>
                    <?php if ($mRow->seen_by_dept == 0 && in_array($actionTaken, array('ACCEPTED', 'RETURNED'))) { ?>
                        <button type="button" title="Pull Back" id="" name="" onclick="pullBack('<?php echo $mRow->auto_id ?>')" class="btn btn-outline-danger"> <i class="fa fa-arrow-circle-right"></i> Pull Back</button>
                    <?php } ?>
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        <?php }
        ?>
    </div><!-- /.box-body -->
</div>
<?php if ($actionTaken == "PENDING") { ?>
    <div class="row">
        <div class="modal fade" id="modal_approve_return">
            <div class="modal-dialog">
                <div class="modal-body">
                    <form role="form" autocomplete="off" id="approveReturnForm" name="approveReturnForm" method="post">
                        <div class="modal-content card card-primary card-outline">
                            <div class="card-header">                       
                                <div class="float-left">
                                    Confirmation?
                                </div>
                                <div class="float-right">
                                    <a href="javascript:closeModal('modal_approve_return')" class="text-danger" title="Close"><i class="fa fa-times-circle"></i></a>
                                </div>                                        
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <p id="statusMsg"></p>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="">Any Remarks</label>
                                        <textarea class="form-control" maxlength="225" rows="3" name="remarks" id="remarks" placeholder="Enter remarks"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="row card-footer justify-content-end">
                                <div class="card-tools">
                                    <button title="Approve" id="approveBtn" type="button" onclick="confirmApproveReturn('A')" class="btn btn-sm btn-outline-success d-none"><i class="fa fa-check ml-2"></i> Approve</button>
                                    <button title="Return" id="returnBtn" type="button" onclick="confirmApproveReturn('R')" class="btn btn-sm btn-outline-danger d-none"><i class="fa fa-arrow-circle-o-left ml-2"></i> Return</button>
                                    <a href="javascript:closeModal('modal_approve_return')" title="Close" class="btn btn-sm btn-outline-danger"><i class="fa fa-times"></i> Close</a>
                                </div>                  
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>                
    </div>
<?php } ?>

<script>
    function viewFile(fileUrl) {
        var h = screen.height;
        var height = (h - 250);
        var pdflink = '<embed src="<?php echo base_url('assets/pdfjs/web/viewer.html?file=') ?>' + fileUrl + '" frameborder="0" width="100%" height="' + height + '"/>';
        $('#pdfLink').html(pdflink);
        $('#modal_view_file').modal({backdrop: 'static', keyboard: false});
    }
<?php if ($actionTaken == "PENDING") { ?>
        function approveForm(auto_id) {
            $("#approveReturnForm #auto_id").remove();
            $('#approveReturnForm').append("<input required='' class='form-control' type='hidden' name='auto_id' id='auto_id' value='" + auto_id + "'/>");
            $('#statusMsg').html('Do you really wants to approve..?');
            $('#returnBtn').addClass('d-none');
            $('#approveBtn').removeClass('d-none');
            $('#modal_approve_return').modal('show');
        }

        function returnForm(auto_id) {
            $("#approveReturnForm #auto_id").remove();
            $('#approveReturnForm').append("<input required='' class='form-control' type='hidden' name='auto_id' id='auto_id' value='" + auto_id + "'/>");
            $('#statusMsg').html('Do you really wants to rerurn..?');
            $('#approveBtn').addClass('d-none');
            $('#returnBtn').removeClass('d-none');
            $('#modal_approve_return').modal('show');
        }

        function confirmApproveReturn(status) {
            $("#approveReturnForm #status").remove();
            $('#approveReturnForm').append("<input required='' class='form-control' type='text' name='status' id='status' value='" + status + "'/>");
            // Ajax post
            jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url('requiInbox/approveRequi'); ?>",
                dataType: 'json',
                data: $("#approveReturnForm").serialize(),
                success: function (data) {
                    if (data.status) {
                        Toast.fire({icon: 'success', title: data.msg});
                        myTable.draw();
                        $('#modal_approve_return').modal('hide');
                        $('#modal_preview_details').modal('hide');
                    } else {
                        toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                        if (data.logout) {
                            window.location.href = "<?php echo base_url('page?name=home'); ?>";
                        }
                    }
                }
            });
        }
<?php } ?>
</script>
