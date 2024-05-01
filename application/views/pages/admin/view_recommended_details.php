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
                </div>

                <div class="row" style="overflow-x: auto;">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <table id="approval" style="width:100%;" border="0">
                                <tr>
                                    <th style="width: 70%">Category</th>
                                    <th style="width: 10%;text-align: center">Total Vacancy</th>
                                    <th style="width: 10%;text-align: center">Recommended</th>
                                    <th style="width: 10%;text-align: center">Residual</th>
                                </tr>
                                <tr>
                                    <td><b style="">Unreserved  </b></td>
                                    <td style="text-align: center;font-weight: bold"><?php echo $mRow->d_ur; ?></td>                                        
                                    <td style="text-align: center;font-weight: bold"><?php echo $mRow->rec_ur; ?></td>
                                    <td style="text-align: center;font-weight: bold"><?php echo ($mRow->d_ur - $mRow->rec_ur); ?></td>
                                </tr>
                                <tr>
                                    <td><b>APST </b></td>
                                    <td style="text-align: center;font-weight: bold"><?php echo $mRow->d_apst; ?></td>
                                    <td style="text-align: center;font-weight: bold"><?php echo $mRow->rec_apst; ?></td>
                                    <td style="text-align: center;font-weight: bold"><?php echo ($mRow->d_apst - $mRow->rec_apst); ?></td>
                                </tr>
                                <tr>
                                    <td><b>PwD </b></td>
                                    <td style="text-align: center;font-weight: bold"><?php echo $mRow->d_pwd; ?></td>
                                    <td style="text-align: center;font-weight: bold"><?php echo $mRow->rec_pwd; ?></td>
                                    <td style="text-align: center;font-weight: bold"><?php echo ($mRow->d_pwd - $mRow->rec_pwd); ?></td>
                                </tr>
                                <tr>
                                    <td><b>Ex-Serviceman </b></td>
                                    <td style="text-align: center;font-weight: bold"><?php echo $mRow->d_ex_sm; ?></td>
                                    <td style="text-align: center;font-weight: bold"><?php echo $mRow->rec_ex_sm; ?></td>
                                    <td style="text-align: center;font-weight: bold"><?php echo ($mRow->d_ex_sm - $mRow->rec_ex_sm); ?></td>
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
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Final Recommended List</legend>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div id="finalRecommendedListHTML"></div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <?php
        }
        ?>
    <?php }
    ?>
</div>

<script>
    $(document).ready(function () {
        finalRecommendedList('<?php echo $id; ?>');
    });
    function viewFile(fileUrl) {
        var h = screen.height;
        var height = (h - 250);
        var pdflink = '<embed src="<?php echo base_url('assets/pdfjs/web/viewer.html?file=') ?>' + fileUrl + '" frameborder="0" width="100%" height="' + height + '"/>';
        $('#pdfLink').html(pdflink);
        $('#modal_view_file').modal({backdrop: 'static', keyboard: false});
    }
    function finalRecommendedList(id) {
        $('#loading').show();
        jQuery.ajax({
            type: "POST",
            url: "<?php echo base_url('recommendedFinal/finalRecommendedListView'); ?>",
            dataType: 'json',
            data: {
                id: id
            },
            success: function (data) {
                if (data.status) {
                    $('#finalRecommendedListHTML').html(data.finalRecommendedListHTML);
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
