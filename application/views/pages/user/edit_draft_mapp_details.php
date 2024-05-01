<?php
$modRec = $mData->c_mode_recruitment;
$direct = 'd-none';
$ldce = 'd-none';
$subPwd = 'readonly=""';
$pwdDiv = 'd-none';
$org_name = $mData->org_name;
$officer_desig = $mData->officer_desig;
$post_name = $mData->post_name;
$pwd = $mData->d_pwd;
if ($modRec == 'D') {
    $direct = "";
}
if ($modRec == 'L') {
    $ldce = "";
}

if ($pwd > 0) {
    $pwdDiv = "";
    $subPwd = "";
}
?>
<div class="row">
    <div class="col-12 col-sm-12">
        <form role="form" class="form_submit" id="requiFormSubmitUpdate" name="requiFormSubmitUpdate" method="post" autocomplete="off">
            <input type="hidden" id="auto_id" name="auto_id" required="" class="form-control form-control-sm" value="<?php echo $id; ?>" />
            <input type="hidden" id="mst_id" name="mst_id" required="" class="form-control form-control-sm" value="<?php echo $mData->mst_id; ?>" />
            <input type="hidden" id="type" name="type" required=""  class="form-control form-control-sm" value="<?php echo $type; ?>" />
            <div class="row">
                <div class="col-sm-12">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Department/Office Details </legend>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Name of Department <span class="text-danger"> *</span></label>
                                            <select class="form-control form-control-sm" name="dept_name1" id="dept_name1" style="width: 100%;">
                                                <?php
                                                if ($deptList != NULL) {
                                                    ?>
                                                    <option value="<?php echo $deptList->auto_id; ?>"><?php echo $deptList->dept_name; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Name of the Organization/Office <span class="text-danger"> *</span></label>
                                            <select class="form-control select2"  name="org_name1" id="org_name1"  style="width: 100%;">
                                                <option <?php
                                                if ($org_name == "") {
                                                    echo 'selected';
                                                }
                                                ?> value="">-Select-</option>
                                                    <?php
                                                    if ($orgList != NULL) {
                                                        foreach ($orgList as $oRow) {
                                                            ?>
                                                        <option <?php
                                                        if ($org_name == $oRow->auto_id) {
                                                            echo 'selected';
                                                        }
                                                        ?> value="<?php echo $oRow->auto_id; ?>"><?php echo $oRow->org_name; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Contact details of Department representative(not below the rank of Deputy Secretary) of the identing Office/Department <span class="text-danger"> *</span></label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Name <span class="text-danger"> *</span></label>
                                                        <input type="text" class="form-control form-control-sm text-uppercase alphabetsspaceonly" value="<?php echo $mData->officer_name; ?>" id="officer_name1" name="officer_name1"  maxlength="65" minlength="2" placeholder="Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Designation <span class="text-danger"> *</span></label>
                                                        <select class="form-control select2" name="officer_desig1" id="officer_desig1"  style="width: 100%;">
                                                            <option <?php
                                                            if ($officer_desig == "") {
                                                                echo 'selected';
                                                            }
                                                            ?> value="">-Select-</option>
                                                                <?php
                                                                if ($desigList != NULL) {
                                                                    foreach ($desigList as $dRow) {
                                                                        ?>
                                                                    <option <?php
                                                                    if ($officer_desig == $dRow->auto_id) {
                                                                        echo 'selected';
                                                                    }
                                                                    ?> value="<?php echo $dRow->auto_id; ?>"><?php echo $dRow->desig_name; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>                                                      
                                                        </select>
                                                    </div>
                                                </div> 
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Contact No <span class="text-danger"> *</span></label>
                                                        <input type="text" class="form-control form-control-sm digitsonly" value="<?php echo $mData->contact_no; ?>" id="contact_no1" name="contact_no1"  maxlength="10" minlength="10"  placeholder="Contact No">
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="">Email ID <span class="text-danger"> </span></label>
                                                        <input type="text" class="form-control form-control-sm" value="<?php echo $mData->officer_email; ?>" id="officer_email1" name="officer_email1" maxlength="120" placeholder="Email-ID">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                            
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Vacancy </legend>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Mode of recruitment <span class="text-danger"> *</span></label>
                            <select class="form-control form-control-sm" name="c_mode_recruitment1" id="c_mode_recruitment1" onchange="modeOfRecU(this.value)"  style="width: 100%;">
                                <option value="D" <?php
                                if ($modRec == "D") {
                                    echo "selected";
                                }
                                ?>>-Direct Recruitment-</option>
                                <option value="L" <?php
                                if ($modRec == "L") {
                                    echo "selected";
                                }
                                ?>>-LDCE Recruitment-</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Name of Post <span class="text-danger"> *</span></label>
                            <select class="form-control select2 netEmp" name="post_name1" id="post_name1"  style="width: 100%;">
                                <option <?php
                                if ($post_name == "") {
                                    echo 'selected';
                                }
                                ?> value="">-Select-</option>
                                    <?php
                                    if ($postList != NULL) {
                                        foreach ($postList as $pRow) {
                                            ?>
                                        <option <?php
                                        if ($post_name == $pRow->auto_id) {
                                            echo 'selected';
                                        }
                                        ?> value="<?php echo $pRow->auto_id; ?>"><?php echo $pRow->post_name; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Group <span class="text-danger"> *</span></label>
                            <select class="form-control form-control-sm" name="a_group1" id="a_group1"  style="width: 100%;">
                                <option value="C" <?php
                                if ($mData->a_group == "C") {
                                    echo "selected";
                                }
                                ?>>-Group C-</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Pay Scale <span class="text-danger"> *</span></label>
                            <select class="form-control form-control-sm" name="b_pay_scale1" id="b_pay_scale1"  style="width: 100%;">
                                <option value="" <?php
                                if ($mData->b_pay_scale == "") {
                                    echo "selected";
                                }
                                ?>>-Select-</option>
                                <option value="1" <?php
                                if ($mData->b_pay_scale == "1") {
                                    echo "selected";
                                }
                                ?>>-Level 1-</option>
                                <option value="2" <?php
                                if ($mData->b_pay_scale == "2") {
                                    echo "selected";
                                }
                                ?>>-Level 2-</option>
                                <option value="3" <?php
                                if ($mData->b_pay_scale == "3") {
                                    echo "selected";
                                }
                                ?>>-Level 3-</option>
                                <option value="4" <?php
                                if ($mData->b_pay_scale == "4") {
                                    echo "selected";
                                }
                                ?>>-Level 4-</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row <?php echo $direct; ?>" id="directRecuDivU">                                
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-12 col-form-label">Breakup of vacancy  </label>
                                <div class="col-sm-12" style="overflow-x: auto">
                                    <table id="template_table" class="mytable table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="min-width: 120px;">Unreserved</th>
                                                <th style="min-width: 120px;">APST</th>
                                                <th style="min-width: 120px;">Total</th>
                                                <th style="min-width: 120px;">PwD <span class="text-danger"> *</span></th>
                                                <th style="min-width: 120px;">Ex-Serviceman <span class="text-danger"> *</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="form-group">                                                                       
                                                    <input type="text" onkeypress="isNumberU(event)" value="<?php echo $mData->d_ur; ?>" class="default-zero form-control form-control-sm breakUpVaccTotal4 apstUrTot4" id="d_ur_4" name="d_ur_4" placeholder="Unreserved">
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" onkeypress="isNumberU(event)" value="<?php echo $mData->d_apst; ?>" class="default-zero form-control form-control-sm breakUpVaccTotal4 apstUrTot4" id="d_apst_4" name="d_apst_4" placeholder="APST">
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" onkeypress="isNumberU(event)" value="<?php echo $mData->d_total; ?>" readonly="" value="0" class="form-control form-control-sm" id="d_total_4" name="d_total_4" placeholder="Total">
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" onkeypress="isNumberU(event)" value="<?php echo $mData->d_pwd; ?>" onblur="pwdCheck4(this.value)" class="default-zero form-control form-control-sm" id="d_pwd_4" name="d_pwd_4" placeholder="PwD">
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" onkeypress="isNumberU(event)" value="<?php echo $mData->d_ex_sm; ?>" class="default-zero form-control form-control-sm" id="d_ex_sm_4" name="d_ex_sm_4" placeholder="Ex-Serviceman">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">* Horizontal vacancy- The vacancies should be inclusive of total vacancy</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>                                   
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 <?php echo $pwdDiv; ?>" id="pwdCategoryDiv4">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-12 col-form-label">Category of disability, if applicable</label>
                                <div class="col-sm-12" style="overflow-x: auto">
                                    <table id="template_table" class="mytable table-bordered table-striped" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%" class="text-center">Sl no.</th>
                                                <th style="width: 65%">Disability category</th>
                                                <th style="width: 45%">No. of Vacancy</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">
                                                    i)
                                                </td>
                                                <td >
                                                    Blindness and Low Vision
                                                </td>
                                                <td style="width: 35%" class="form-group">
                                                    <input type="text" <?php echo $subPwd; ?> value="<?php echo $mData->e_blindness; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm cat_dis_4" id="e_blindness_4" name="e_blindness_4" placeholder="Total">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  class="text-center">
                                                    ii)
                                                </td>
                                                <td >
                                                    Deaf and Hard of hearing
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" <?php echo $subPwd; ?> value="<?php echo $mData->e_deaf; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm cat_dis_4" id="e_deaf_4" name="e_deaf_4" placeholder="Total">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    iii)
                                                </td>
                                                <td>
                                                    Locomotor Disability including Cerebral Palsy, Leprosy Cured, Dwarfism, Acid Attack Victims and Muscular Dystrophy
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" <?php echo $subPwd; ?> value="<?php echo $mData->e_locomotor; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm cat_dis_4" id="e_locomotor_4" name="e_locomotor_4" placeholder="Total">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    iv)
                                                </td>
                                                <td>
                                                    Autism, Intellectual Disability, Specific Learning Disability and Mental Illness
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" <?php echo $subPwd; ?> value="<?php echo $mData->e_autism; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm cat_dis_4" id="e_autism_4" name="e_autism_4" placeholder="Total">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    v)
                                                </td>
                                                <td>
                                                    Multiple Disabilities from among persons under clauses (i) to (iv) including deaf-blindness
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" <?php echo $subPwd; ?> value="<?php echo $mData->e_multiple; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm cat_dis_4" id="e_multiple_4" name="e_multiple_4" placeholder="Total">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th colspan="2" style="text-align: right">Total</th>
                                                <td class="form-group">
                                                    <input type="text" value="<?php echo $mData->e_total; ?>" class="form-control form-control-sm" readonly=""  id="e_total_4" name="e_total_4" placeholder="Total">
                                                    <span id="e_total_4_error"></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>                                   
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="inputEmail3" class="">Whether the vacancies for the person with disabilities and Ex-Serviceman have been worked out with reference to the instructions contained in the Government of Arunachal Pradesh Orders</label>
                                    <div class="input-group">
                                        <div class="form-check">
                                            <input type="checkbox" <?php
                                            if ($mData->f_vac_worked_out == "Y") {
                                                echo 'checked="true"';
                                            }
                                            ?> class="form-check-input"  onclick="fChk4('f_vac_worked_out_4Y', 'f_vac_worked_out_4N')" name="f_vac_worked_out_4" id="f_vac_worked_out_4Y" value="Y">
                                            <label for="radio1">Yes</label>
                                        </div>
                                        <div class="form-check ml-4">
                                            <input type="checkbox" <?php
                                            if ($mData->f_vac_worked_out == "N") {
                                                echo 'checked="true"';
                                            }
                                            ?> class="form-check-input" onclick="fChk4('f_vac_worked_out_4N', 'f_vac_worked_out_4Y')" name="f_vac_worked_out_4" id="f_vac_worked_out_4N" value="N"  >
                                            <label for="radio1">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="inputEmail3" class="">Education and other qualification laid down in the Recruitment Rules</label>
                                    <textarea class="form-control" maxlength="225" rows="3" name="g_edu_others_4" id="g_edu_others_4" placeholder="Education and other qualification laid down in the Recruitment Rules"><?php echo $mData->g_edu_others; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-12 col-form-label">Age limit as per Recruitment Rules notified in Gazette of Arunachal Pradesh</label>
                                <div class="col-sm-12" style="overflow-x: auto">
                                    <table id="template_table" class="" width="100%">
                                        <tbody>
                                            <tr>
                                                <td class="text-center">
                                                    Minimum age (years)
                                                </td>
                                                <td style="width: 35%" class="form-group">
                                                    <input type="text" value="<?php echo $mData->h_min_age; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm" maxlength="2" id="h_min_age_4" name="h_min_age_4" placeholder="MIN AGE">
                                                </td>

                                                <td class="text-center">
                                                    Maximum age (years)
                                                </td>
                                                <td style="width: 35%" class="form-group">
                                                    <input type="text" value="<?php echo $mData->h_max_age; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm" maxlength="2" id="h_max_age_4" name="h_max_age_4" placeholder="MAX AGE">
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>                                   
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-12 col-form-label">Whether relaxation of Upper age available to undermentioned categories, if yes, please mention</label>
                                <div class="col-sm-12" style="overflow-x: auto">
                                    <table id="template_table" class="mytable table-bordered table-striped" border="1" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">Name of Post</th>
                                                <th style="">Permissible Upper age relaxation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>                                                                   
                                                <td class="text-center">
                                                    APST
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" value="<?php echo $mData->i_apst; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm" maxlength="2" id="i_apst_4" name="i_apst_4" placeholder="APST">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    PwD (APST)
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" value="<?php echo $mData->i_pwd_apst; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm" maxlength="2" id="i_pwd_apst_4" name="i_pwd_apst_4" placeholder="PwD">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    PwD (UR)
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" value="<?php echo $mData->i_pwd_ur; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm" maxlength="2" id="i_pwd_ur_4" name="i_pwd_ur_4" placeholder="PwD">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    Ex-Servicemen (APST)
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" value="<?php echo $mData->i_ex_sm_apst; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm" maxlength="2" id="i_ex_sm_apst_4" name="i_ex_sm_apst_4" placeholder="Ex-SM">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    Ex-Servicemen (UR)
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" value="<?php echo $mData->i_ex_sm_ur; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm" maxlength="2" id="i_ex_sm_ur_4" name="i_ex_sm_ur_4" placeholder="Ex-SM">
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>                                   
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="inputEmail3" class="">Whether there is any ban or restriction from the Govt. for filling up the post</label>
                                    <div class="input-group">
                                        <div class="form-check">
                                            <input type="checkbox" <?php
                                            if ($mData->j_ban_restric == "Y") {
                                                echo 'checked="true"';
                                            }
                                            ?> class="form-check-input" onclick="jChk5('j_ban_restric_4Y', 'j_ban_restric_4N')" name="j_ban_restric_4" id="j_ban_restric_4Y" value="Y">
                                            <label for="radio1">Yes</label>
                                        </div>
                                        <div class="form-check ml-4">
                                            <input type="checkbox" <?php
                                            if ($mData->j_ban_restric == "N") {
                                                echo 'checked="true"';
                                            }
                                            ?> class="form-check-input" onclick="jChk5('j_ban_restric_4N', 'j_ban_restric_4Y')" name="j_ban_restric_4" id="j_ban_restric_4N" value="N"  >
                                            <label for="radio1">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="inputEmail3" class="">Upload latest Recruitment Rules (in pdf format)</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="input-group input-group-sm">
                                                    <input type="text" onclick="selectFileU('fileInput_k_4')"  class="form-control form-control-sm mycustomfile" readonly="" id="file_copy_fileInput_k_4" name="file_copy_k_4" value="<?php echo $mData->file_copy_k_rr; ?>" placeholder="Select File (PDF) only">
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-default" onclick="selectFileU('fileInput_k_4')"><i class="fas fa-file text-primary mr-1"></i>Browse</button>
                                                        <button type="button" id="remove_btn_fileInput_k_4" name="remove_btn_fileInput_k_4" onclick="removeFileU('fileInput_k_4')"  class="removebtn btn btn-default <?php
                                                        if ($mData->file_copy_k_rr == "") {
                                                            echo 'd-none';
                                                        }
                                                        ?>"> <i class="fa fa-trash text-danger mr-1"></i>Remove</button>
                                                        <button type="button" id="view_btn_fileInput_k_4" name="view_btn_fileInput_k_4" onclick="viewFile('<?php echo base_url('requisitions_documents/' . $mData->file_copy_k_rr) ?>')" class="removebtn btn btn-default <?php
                                                        if ($mData->file_copy_k_rr == "") {
                                                            echo 'd-none';
                                                        }
                                                        ?>"> <i class="fa fa-file-pdf-o text-danger mr-1"></i>View</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 d-none">
                                            <div class="form-group">
                                                <input type="file"  id="fileInput_k_4" name="file_k_4" onchange="return fileValidationU('fileInput_k_4')">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="inputEmail3" class="">Any other required or conditions not covered above</label>
                                    <div class="row col-sm-12">
                                        <div class="col-sm-12">
                                            <div class="form-group row">                                                                    
                                                <textarea class="form-control" rows="3" maxlength="225" id="l_other_requi_cond_4" name="l_other_requi_cond_4" placeholder="Any other requirement or conditions not covered above"><?php echo $mData->l_other_requi_cond; ?></textarea>
                                            </div>
                                            <div class="form-group row ml-4">
                                                <label for="inputEmail3" class="col-sm-4 col-form-label">Upload relevant orders, if any (in pdf format)</label>
                                                <div class="col-sm-7">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <div class="input-group input-group-sm">
                                                                    <input type="text" onclick="selectFileU('fileInput_l_4')"  class="form-control form-control-sm mycustomfile" readonly=""  id="file_copy_fileInput_l_4" name="file_copy_l_4" value="<?php echo $mData->file_copy_l_ro; ?>" placeholder="Select File (PDF) only">
                                                                    <span class="input-group-append">
                                                                        <button type="button" class="btn btn-default" onclick="selectFileU('fileInput_l_4')"><i class="fas fa-file text-primary mr-1"></i>Browse</button>
                                                                        <button type="button" id="remove_btn_fileInput_l_4" name="remove_btn_fileInput_l_4" onclick="removeFileU('fileInput_l_4')" class="removebtn btn btn-default <?php
                                                                        if ($mData->file_copy_l_ro == "") {
                                                                            echo 'd-none';
                                                                        }
                                                                        ?>"> <i class="fa fa-trash text-danger mr-1"></i>Remove</button>
                                                                        <button type="button" id="view_btn_fileInput_l_4" name="view_btn_fileInput_l_4" onclick="viewFile('<?php echo base_url('requisitions_documents/' . $mData->file_copy_l_ro) ?>')" class="removebtn btn btn-default <?php
                                                                        if ($mData->file_copy_l_ro == "") {
                                                                            echo 'd-none';
                                                                        }
                                                                        ?>"> <i class="fa fa-file-pdf-o text-danger mr-1"></i>View</button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 d-none">
                                                            <div class="form-group">
                                                                <input type="file" id="fileInput_l_4" name="file_l_4" onchange="return fileValidationU('fileInput_l_4')" class="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row <?php echo $ldce; ?>" id="LDCERecDivU">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-12 col-form-label">Breakup of vacancy  </label>
                                <div class="col-sm-12" style="overflow-x: auto">
                                    <table id="template_table" class="mytable table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="min-width: 120px;">Unreserved</th>
                                                <th style="min-width: 120px;">APST</th>
                                                <th style="min-width: 120px;">Total</th>
                                                <th style="min-width: 120px;">PwD <span class="text-danger"> *</span></th>
                                                <th style="min-width: 120px;">Ex-Serviceman <span class="text-danger"> *</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="form-group">                                                                       
                                                    <input type="text" onkeypress="isNumberU(event)" value="<?php echo $mData->d_ur; ?>" class="default-zero form-control form-control-sm breakUpVaccTotal5 apstUrTot5" id="d_ur_5" name="d_ur_5" placeholder="Unreserved">
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" onkeypress="isNumberU(event)" value="<?php echo $mData->d_apst; ?>" class="default-zero form-control form-control-sm breakUpVaccTotal5 apstUrTot5" id="d_apst_5" name="d_apst_5" placeholder="APST">
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" onkeypress="isNumberU(event)" value="<?php echo $mData->d_total; ?>" readonly="" class="form-control form-control-sm" id="d_total_5" name="d_total_5" placeholder="Total">
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" onkeypress="isNumberU(event)"  value="<?php echo $mData->d_pwd; ?>" onblur="pwdCheck5(this.value)" class="default-zero form-control form-control-sm" id="d_pwd_5" name="d_pwd_5" placeholder="PwD">
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" onkeypress="isNumberU(event)" value="<?php echo $mData->d_ex_sm; ?>" class="default-zero form-control form-control-sm" id="d_ex_sm_5" name="d_ex_sm_5" placeholder="Ex-Serviceman">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">* Horizontal vacancy- The vacancies should be inclusive of total vacancy</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>                                   
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 <?php echo $pwdDiv; ?>" id="pwdCategoryDiv5">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-12 col-form-label">Category of disability, if applicable</label>
                                <div class="col-sm-12" style="overflow-x: auto">
                                    <table id="template_table" class="mytable table-bordered table-striped" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%" class="text-center">Sl no.</th>
                                                <th style="width: 65%">Disability category</th>
                                                <th style="width: 45%">No. of Vacancy</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">
                                                    i)
                                                </td>
                                                <td >
                                                    Blindness and Low Vision
                                                </td>
                                                <td style="width: 35%" class="form-group">
                                                    <input type="text" <?php echo $subPwd; ?> value="<?php echo $mData->e_blindness; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm cat_dis_5" id="e_blindness_5" name="e_blindness_5" placeholder="Total">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  class="text-center">
                                                    ii)
                                                </td>
                                                <td >
                                                    Deaf and Hard of hearing
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" <?php echo $subPwd; ?> value="<?php echo $mData->e_deaf; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm cat_dis_5" id="e_deaf_5" name="e_deaf_5" placeholder="Total">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    iii)
                                                </td>
                                                <td>
                                                    Locomotor Disability including Cerebral Palsy, Leprosy Cured, Dwarfism, Acid Attack Victims and Muscular Dystrophy
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" <?php echo $subPwd; ?> value="<?php echo $mData->e_locomotor; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm cat_dis_5" id="e_locomotor_5" name="e_locomotor_5" placeholder="Total">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    iv)
                                                </td>
                                                <td>
                                                    Autism, Intellectual Disability, Specific Learning Disability and Mental Illness
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" <?php echo $subPwd; ?> value="<?php echo $mData->e_autism; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm cat_dis_5" id="e_autism_5" name="e_autism_5" placeholder="Total">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    v)
                                                </td>
                                                <td>
                                                    Multiple Disabilities from among persons under clauses (i) to (iv) including deaf-blindness
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" <?php echo $subPwd; ?> value="<?php echo $mData->e_multiple; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm cat_dis_5" id="e_multiple_5" name="e_multiple_5" placeholder="Total">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th colspan="2" style="text-align: right">Total</th>
                                                <td class="form-group">
                                                    <input type="text" value="<?php echo $mData->e_total; ?>" class="form-control form-control-sm" readonly=""  id="e_total_5" name="e_total_5" placeholder="Total">
                                                    <span id="e_total_5_error"></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>                                   
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="inputEmail3" class="">Whether the vacancies for the person with disabilities and Ex-Serviceman have been worked out with reference to the instructions contained in the Government of Arunachal Pradesh Orders</label>
                                    <div class="input-group">
                                        <div class="form-check">
                                            <input type="checkbox" <?php
                                            if ($mData->f_vac_worked_out == "Y") {
                                                echo 'checked="true"';
                                            }
                                            ?> class="form-check-input" onclick="fChk5('f_vac_worked_out_5Y', 'f_vac_worked_out_5N')" name="f_vac_worked_out_5" id="f_vac_worked_out_5Y" value="Y" checked="true">
                                            <label for="radio1">Yes</label>
                                        </div>
                                        <div class="form-check ml-4">
                                            <input type="checkbox" <?php
                                            if ($mData->f_vac_worked_out == "N") {
                                                echo 'checked="true"';
                                            }
                                            ?> class="form-check-input" onclick="fChk5('f_vac_worked_out_5N', 'f_vac_worked_out_5Y')" name="f_vac_worked_out_5" id="f_vac_worked_out_5N" value="N"  >
                                            <label for="radio1">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="inputEmail3" class="">Education and other qualification laid down in the Recruitment Rules</label>
                                    <textarea class="form-control" maxlength="225" rows="3" name="g_edu_others_5" id="g_edu_others_5" placeholder="Education and other qualification laid down in the Recruitment Rules"><?php echo $mData->g_edu_others; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-12 col-form-label">Age limit as per Recruitment Rules notified in Gazette of Arunachal Pradesh</label>
                                <div class="col-sm-12" style="overflow-x: auto">
                                    <table id="template_table" class="" width="100%">
                                        <tbody>
                                            <tr>
                                                <td class="text-center">
                                                    Minimum age (years)
                                                </td>
                                                <td style="width: 35%" class="form-group">
                                                    <input type="text" value="<?php echo $mData->h_min_age; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm" maxlength="2" id="h_min_age_5" name="h_min_age_5" placeholder="MIN AGE">
                                                </td>

                                                <td class="text-center">
                                                    Maximum age (years)
                                                </td>
                                                <td style="width: 35%" class="form-group">
                                                    <input type="text" value="<?php echo $mData->h_max_age; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm" maxlength="2" id="h_max_age_5" name="h_max_age_5" placeholder="MAX AGE">
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>                                   
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-12 col-form-label">Whether relaxation of Upper age available to undermentioned categories, if yes, please mention</label>
                                <div class="col-sm-12" style="overflow-x: auto">
                                    <table id="template_table" class="mytable table-bordered table-striped" border="1" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">Name of Post</th>
                                                <th style="">Permissible Upper age relaxation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>                                                                   
                                                <td class="text-center">
                                                    APST
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" value="<?php echo $mData->i_apst; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm" maxlength="2" id="i_apst_5" name="i_apst_5" placeholder="APST">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    PwD (APST)
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" value="<?php echo $mData->i_pwd_apst; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm" maxlength="2" id="i_pwd_apst_5" name="i_pwd_apst_5" placeholder="PwD">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    PwD (UR)
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" value="<?php echo $mData->i_pwd_ur; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm" maxlength="2" id="i_pwd_ur_5" name="i_pwd_ur_5" placeholder="PwD">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    Ex-Servicemen (APST)
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" value="<?php echo $mData->i_ex_sm_apst; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm" maxlength="2" id="i_ex_sm_apst_5" name="i_ex_sm_apst_5" placeholder="Ex-SM">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    Ex-Servicemen (UR)
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" value="<?php echo $mData->i_ex_sm_ur; ?>" onkeypress="isNumberU(event)" class="default-zero form-control form-control-sm" maxlength="2" id="i_ex_sm_ur_5" name="i_ex_sm_ur_5" placeholder="Ex-SM">
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>                                   
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="inputEmail3" class="">Whether there is any ban or restriction from the Govt. for filling up the post</label>
                                    <div class="input-group">
                                        <div class="form-check">
                                            <input type="checkbox" <?php
                                            if ($mData->j_ban_restric == "Y") {
                                                echo 'checked="true"';
                                            }
                                            ?> class="form-check-input" onclick="jChk5('j_ban_restric_5Y', 'j_ban_restric_5N')" name="j_ban_restric_5" id="j_ban_restric_5Y" value="Y" checked="true">
                                            <label for="radio1">Yes</label>
                                        </div>
                                        <div class="form-check ml-4">
                                            <input type="checkbox"  <?php
                                            if ($mData->j_ban_restric == "N") {
                                                echo 'checked="true"';
                                            }
                                            ?> class="form-check-input" onclick="jChk5('j_ban_restric_5N', 'j_ban_restric_5Y')" name="j_ban_restric_5" id="j_ban_restric_5N" value="N"  >
                                            <label for="radio1">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="inputEmail3" class="">Upload latest Recruitment Rules (in pdf format)</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="input-group input-group-sm">
                                                    <input type="text" onclick="selectFileU('fileInput_k_5')"  class="form-control form-control-sm mycustomfile" readonly=""  id="file_copy_fileInput_k_5" name="file_copy_k_5" value="<?php echo $mData->file_copy_k_rr; ?>" placeholder="Select File (PDF) only">
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-default" onclick="selectFileU('fileInput_k_5')"><i class="fas fa-file text-primary mr-1"></i>Browse</button>
                                                        <button type="button" id="remove_btn_fileInput_k_5" name="remove_btn_fileInput_k_5" onclick="removeFileU('fileInput_k_5')"  class="removebtn btn btn-default <?php
                                                        if ($mData->file_copy_k_rr == "") {
                                                            echo 'd-none';
                                                        }
                                                        ?>"> <i class="fa fa-trash text-danger mr-1"></i>Remove</button>
                                                        <button type="button" id="view_btn_fileInput_k_5" name="view_btn_fileInput_k_5" onclick="viewFile('<?php echo base_url('requisitions_documents/' . $mData->file_copy_k_rr) ?>')" class="removebtn btn btn-default <?php
                                                        if ($mData->file_copy_k_rr == "") {
                                                            echo 'd-none';
                                                        }
                                                        ?>"> <i class="fa fa-file-pdf-o text-danger mr-1"></i>View</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 d-none">
                                            <div class="form-group">
                                                <input type="file"  id="fileInput_k_5" name="file_k_5" onchange="return fileValidationU('fileInput_k_5')" class="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>           


                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="inputEmail3" class="">Any other required or conditions not covered above</label>
                                    <div class="row col-sm-12">
                                        <div class="col-sm-12">
                                            <div class="form-group row">                                                                    
                                                <textarea class="form-control" rows="3" maxlength="225" id="l_other_requi_cond_5" name="l_other_requi_cond_5" placeholder="Any other requirement or conditions not covered above"><?php echo $mData->l_other_requi_cond; ?></textarea>
                                            </div>
                                            <div class="form-group row ml-4">
                                                <label for="inputEmail3" class="col-sm-4 col-form-label">Upload relevant orders, if any (in pdf format)</label>
                                                <div class="col-sm-7">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <div class="input-group input-group-sm">
                                                                    <input type="text" onclick="selectFileU('fileInput_l_5')"  class="form-control form-control-sm mycustomfile" readonly=""  id="file_copy_fileInput_l_5" name="file_copy_l_5" value="<?php echo $mData->file_copy_l_ro; ?>" placeholder="Select File (PDF) only">
                                                                    <span class="input-group-append">
                                                                        <button type="button" class="btn btn-default" onclick="selectFileU('fileInput_l_5')"><i class="fas fa-file text-primary mr-1"></i>Browse</button>
                                                                        <button type="button" id="remove_btn_fileInput_l_5" name="remove_btn_fileInput_l_5" onclick="removeFileU('fileInput_l_5')" class="removebtn btn btn-default <?php
                                                                        if ($mData->file_copy_l_ro == "") {
                                                                            echo 'd-none';
                                                                        }
                                                                        ?>"> <i class="fa fa-trash text-danger mr-1"></i>Remove</button>
                                                                        <button type="button" id="view_btn_fileInput_l_5" name="view_btn_fileInput_l_5" onclick="viewFile('<?php echo base_url('requisitions_documents/' . $mData->file_copy_l_ro) ?>')" class="removebtn btn btn-default <?php
                                                                        if ($mData->file_copy_l_ro == "") {
                                                                            echo 'd-none';
                                                                        }
                                                                        ?>"> <i class="fa fa-file-pdf-o text-danger mr-1"></i>View</button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 d-none">
                                                            <div class="form-group">
                                                                <input type="file" id="fileInput_l_5" name="file_l_5" onchange="return fileValidationU('fileInput_l_5')" class="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputEmail3" class="">Specify the Criteria of Eligibility under which the LDCE post falls, as per Recruitment Rule.</label>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">Name of post <span class="text-danger"> *</span></label>
                                        <select class="form-control form-control-sm" onchange="loadCriteriaEligibility1(this.value)" name="m_crit_elig_post_5" id="m_crit_elig_post_5"  style="width: 100%;">
                                            <option <?php
                                            if ($mData->m_criteria_eligibility_post == "") {
                                                echo 'selected';
                                            }
                                            ?> value="">-Select-</option>
                                            <option <?php
                                            if ($mData->m_criteria_eligibility_post == "LDC") {
                                                echo 'selected';
                                            }
                                            ?> value="LDC">-LDC-</option>
                                            <option <?php
                                            if ($mData->m_criteria_eligibility_post == "DRIVER") {
                                                echo 'selected';
                                            }
                                            ?> value="DRIVER">-DRIVER-</option>
                                            <option <?php
                                            if ($mData->m_criteria_eligibility_post == "JSA") {
                                                echo 'selected';
                                            }
                                            ?> value="JSA">-JSA-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <label for="">Criteria of Eligibility <span class="text-danger"> *</span></label>
                                        <select class="form-control select2" data-minimum-results-for-search="-1" name="m_crit_elig_5" id="m_crit_elig_5" >
                                            <option <?php
                                            if ($mData->m_criteria_eligibility == "") {
                                                echo 'selected';
                                            }
                                            ?> value="">-Select-</option>  
                                                <?php
                                                if ($postEligList != NULL) {
                                                    foreach ($postEligList as $poRow) {
                                                        ?>
                                                    <option <?php
                                                    if ($mData->m_criteria_eligibility == $poRow->auto_id) {
                                                        echo 'selected';
                                                    }
                                                    ?> value="<?php echo $poRow->auto_id; ?>"><?php echo $poRow->eligibility; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputEmail3" class="">Upload detailed list of eligible candidates (as on 1st January of the Year) duly verified by the HoD (in pdf format) <span class="text-danger">*</span><a href="<?php echo base_url('assets/ors/storage/performa/LDCE proforma.docx') ?>" target="_self"> Download sample file</a></label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group input-group-sm">
                                            <input type="text" onclick="selectFileU('fileInput_n_5')"  class="form-control form-control-sm mycustomfile" readonly=""  id="file_copy_fileInput_n_5" name="file_copy_n_5" value="<?php echo $mData->file_copy_n_list_cands; ?>" placeholder="Select File (PDF) only">
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-default" onclick="selectFileU('fileInput_n_5')"><i class="fas fa-file text-primary mr-1"></i>Browse</button>
                                                <button type="button" id="remove_btn_fileInput_n_5" name="remove_btn_fileInput_n_5" onclick="removeFileU('fileInput_n_5')" class="removebtn btn btn-default <?php
                                                if ($mData->file_copy_n_list_cands == "") {
                                                    echo 'd-none';
                                                }
                                                ?>"> <i class="fa fa-trash text-danger mr-1"></i>Remove</button>
                                                <button type="button" id="view_btn_fileInput_n_5" name="view_btn_fileInput_n_5" onclick="viewFile('<?php echo base_url('requisitions_documents/' . $mData->file_copy_n_list_cands) ?>')" class="removebtn btn btn-default <?php
                                                if ($mData->file_copy_n_list_cands == "") {
                                                    echo 'd-none';
                                                }
                                                ?>"> <i class="fa fa-file-pdf-o text-danger mr-1"></i>View</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 d-none">
                                    <div class="form-group">
                                        <input type="file"  id="fileInput_n_5" name="file_n_5" onchange="return fileValidationU('fileInput_n_5')" class="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputEmail3" class="">Upload detailed list of eligible candidates (as on 1st January of the Year) duly verified by the HoD (in xls|xlsx format) <span class="text-danger">*</span><a href="<?php echo base_url('assets/ors/storage/performa/LDCE proforma.xlsx') ?>" target="_self"> Download sample file</a></label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group input-group-sm">
                                            <input type="text" onclick="selectFileU('fileInput_o_5')"  class="form-control form-control-sm mycustomfile" readonly=""  id="file_copy_fileInput_o_5" name="file_copy_o_5" value="<?php echo $mData->file_copy_o_list_cands; ?>" placeholder="Select File (XLS'XLSX) only">
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-default" onclick="selectFileU('fileInput_o_5')"><i class="fas fa-file text-primary mr-1"></i>Browse</button>
                                                <button type="button" id="remove_btn_fileInput_o_5" name="remove_btn_fileInput_o_5" onclick="removeFileU('fileInput_o_5')" class="removebtn btn btn-default <?php
                                                if ($mData->file_copy_o_list_cands == "") {
                                                    echo 'd-none';
                                                }
                                                ?>"> <i class="fa fa-trash text-danger mr-1"></i>Remove</button>
                                                <a type="_blank" href="<?php echo base_url('requisitions_documents/' . $mData->file_copy_o_list_cands) ?>"  id="view_btn_fileInput_o_5" name="view_btn_fileInput_o_5" class="removebtn btn btn-default <?php
                                                if ($mData->file_copy_o_list_cands == "") {
                                                    echo 'd-none';
                                                }
                                                ?>"> <i class="fa fa-file-excel-o text-success mr-1"></i>Download</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 d-none">
                                    <div class="form-group">
                                        <input type="file"  id="fileInput_o_5" name="file_o_5" onchange="return fileValidationU('fileInput_o_5')" class="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mr-4 mb-3">
                    <div class="row justify-content-end">
                        <div class="">
                            <button title="Update Details" type="submit" class="btn btn-sm btn-outline-primary"><i class="fa fa-save"></i> Update Details</button>
                            <button title="Close Form" type="button" onclick="closeModal('modal_edit_mapped_details')" class="btn btn-sm btn-outline-danger"><i class="fa fa-times-circle"></i> Close</button>
                        </div>  
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<div class="row">
    <div class="modal fade" id="modal_msgU">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card-header">
                    <div class="float-right">
                        <a href="javascript:closeModal('modal_msgU')" class="close btn btn-sm" title="Close">
                            <span aria-hidden="true">X Close</span>
                        </a>
                    </div> 
                </div>
                <div class="modal-body">
                    <div id="msg_htmlU"></div>
                </div>                
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<script type="text/javascript">
    function selectFileU(id) {
        $('#' + id).click();
    }
    function removeFileU(id) {
        $('.invalid-feedback').removeClass('invalid-feedback');
        $('.is-invalid').removeClass('is-invalid');
        $('.is-valid').removeClass('is-valid');
        $('.error').remove();
        $('#' + id).val('');
        $('#file_copy_' + id).val('');
        $('#remove_btn_' + id).addClass('d-none');
        $('#view_btn_' + id).addClass('d-none');
    }
    function fileValidationU(id) {
        var fileInput = document.getElementById(id);
        var filePath = fileInput.value;
        // Allowing file type
        //var allowedExtensions = /(\.pdf|\.rar)$/i;
        var allowedExtensions = /(\.pdf)$/i;
        if (id == "fileInput_o_5") {
            allowedExtensions = /(\.xls|\.xlsx)$/i;
        }
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
                $('#view_btn_' + id).addClass('d-none');
                $('#file_copy_' + id).val(file.name);
            }
        }
    }

    $(document).ready(function () {
        var field = $('.default-zero');
        field.blur(function () {
            if (this.value === "") {
                this.value = '0';
                var idd = this.id;
                $('#' + idd).removeClass('is-invalid');
            }
        });
        $('form[id="requiFormSubmitUpdate"]').validate({
            rules: {
                org_name1: {
                    required: true
                },
                dept_name1: {
                    required: true
                },
                officer_name1: {
                    required: true
                },
                officer_desig1: {
                    required: true
                },
                contact_no1: {
                    required: true,
                    pattern: /^[6-9]{1}[0-9]{9}$/
                },
                officer_email1: {
                    required: true
                },
                "c_mode_recruitment1": {
                    required: true
                },
                "post_name1": {
                    required: true
                },
                "a_group1": {
                    required: true
                },
                "b_pay_scale1": {
                    required: true
                },
                "d_ur_4": {
                    required: true
                },
                "d_apst_4": {
                    required: true
                },
                "d_total_4": {
                    required: true
                },
                "d_pwd_4": {
                    required: true
                },
                "d_ex_sm_4": {
                    required: true
                },
                "e_blindness_4": {
                    required: true
                },
                "e_deaf_4": {
                    required: true
                },
                "e_locomotor_4": {
                    required: true
                },
                "e_autism_4": {
                    required: true
                },
                "e_multiple_4": {
                    required: true
                },
                "e_total_4": {
                    required: true
                },
                "g_edu_others_4": {
                    required: true
                },
                "h_min_age_4": {
                    required: true
                },
                "h_max_age_4": {
                    required: true
                },
                "i_apst_4": {
                    required: true
                },
                "i_pwd_apst_4": {
                    required: true
                },
                "i_pwd_ur_4": {
                    required: true
                },
                "i_ex_sm_apst_4": {
                    required: true
                },
                "i_ex_sm_ur_4": {
                    required: true
                },
                "file_copy_k_4": {
                    required: true
                },
                "l_other_requi_cond_4": {
                    required: true
                },
                "file_copy_l_4": {
                    required: true
                },
                "d_ur_5": {
                    required: true
                },
                "d_apst_5": {
                    required: true
                },
                "d_total_5": {
                    required: true
                },
                "d_pwd_5": {
                    required: true
                },
                "d_ex_sm_5": {
                    required: true
                },
                "e_blindness_5": {
                    required: true
                },
                "e_deaf_5": {
                    required: true
                },
                "e_locomotor_5": {
                    required: true
                },
                "e_autism_5": {
                    required: true
                },
                "e_multiple_5": {
                    required: true
                },
                "e_total_5": {
                    required: true
                },
                "g_edu_others_5": {
                    required: true
                },
                "h_min_age_5": {
                    required: true
                },
                "h_max_age_5": {
                    required: true
                },
                "i_apst_5": {
                    required: true
                },
                "i_pwd_apst_5": {
                    required: true
                },
                "i_pwd_ur_5": {
                    required: true
                },
                "i_ex_sm_apst_5": {
                    required: true
                },
                "i_ex_sm_ur_5": {
                    required: true
                },
                "file_copy_k_5": {
                    required: true
                },
                "l_other_requi_cond_5": {
                    required: true
                },
                "file_copy_l_5": {
                    required: true
                },
                "m_crit_elig_post_5": {
                    required: true
                },
                "m_crit_elig_5": {
                    required: true
                },
                "file_copy_n_5": {
                    required: true
                },
                "file_copy_o_5": {
                    required: true
                }
            },
            messages: {
                org_name1: {
                    required: "Name of the Organisation/Office is required"
                },
                dept_name1: {
                    required: "Name of Department is required"
                },
                officer_name1: {
                    required: "Name is required"
                },
                officer_desig1: {
                    required: "Designation is required"
                },
                contact_no1: {
                    required: "Contact no is required",
                    pattern: "Invalid mobile number"
                },
                "c_mode_recruitment1": {
                    required: "Mode of recruitment is required"
                },
                'post_name1': {
                    required: "Name of post is required"
                },
                'a_group1': {
                    required: "Group is required"
                },
                "b_pay_scale1": {
                    required: "Pay Scale is required"
                },
                "d_ur_4": {
                    required: "Unserved is required"
                },
                "d_apst_4": {
                    required: "APST is required"
                },
                "d_total_4": {
                    required: "Total is required"
                },
                "d_pwd_4": {
                    required: "PwD is required"
                },
                "d_ex_sm_4": {
                    required: "Ex-Sm is required"
                },
                "e_blindness_4": {
                    required: "This field is required"
                },
                "e_deaf_4": {
                    required: "This field is required"
                },
                "e_locomotor_4": {
                    required: "This field is required"
                },
                "e_autism_4": {
                    required: "This field is required"
                },
                "e_multiple_4": {
                    required: "This field is required"
                },
                "e_total_4": {
                    required: "This field is required"
                },
                "g_edu_others_4": {
                    required: "This field is required"
                },
                "h_min_age_4": {
                    required: "Minimum age is required"
                },
                "h_max_age_4": {
                    required: "Maximum age is required"
                },
                "i_apst_4": {
                    required: "This field is required"
                },
                "i_pwd_apst_4": {
                    required: "This field is required"
                },
                "i_pwd_ur_4": {
                    required: "This field is required"
                },
                "i_ex_sm_apst_4": {
                    required: "This field is required"
                },
                "i_ex_sm_ur_4": {
                    required: "This field is required"
                },
                "file_copy_k_4": {
                    required: "Select Latest Recruitment Rules file"
                },
                "l_other_requi_cond_4": {
                    required: "Any other requirement or conditions not covered above is required"
                },
                "file_copy_l_4": {
                    required: "Select Relevant orders file"
                },
                "d_ur_5": {
                    required: "Unserved is required"
                },
                "d_apst_5": {
                    required: "APST is required"
                },
                "d_total_5": {
                    required: "Total is required"
                },
                "d_pwd_5": {
                    required: "PwD is required"
                },
                "d_ex_sm_5": {
                    required: "Ex-Sm is required"
                },
                "e_blindness_5": {
                    required: "This field is required"
                },
                "e_deaf_5": {
                    required: "This field is required"
                },
                "e_locomotor_5": {
                    required: "This field is required"
                },
                "e_autism_5": {
                    required: "This field is required"
                },
                "e_multiple_5": {
                    required: "This field is required"
                },
                "e_total_5": {
                    required: "This field is required"
                },
                "g_edu_others_5": {
                    required: "This field is required"
                },
                "h_min_age_5": {
                    required: "Minimum age is required"
                },
                "h_max_age_5": {
                    required: "Maximum age is required"
                },
                "i_apst_5": {
                    required: "This field is required"
                },
                "i_pwd_5": {
                    required: "This field is required"
                },
                "i_ex_sm_5": {
                    required: "This field is required"
                },
                "file_copy_k_5": {
                    required: "Select Latest Recruitment Rules file"
                },
                "l_other_requi_cond_5": {
                    required: "Any other requirement or conditions not covered above is required"
                },
                "file_copy_l_5": {
                    required: "Select Relevant orders file"
                },
                "m_crit_elig_post_5": {
                    required: "Select name of post"
                },
                "m_crit_elig_5": {
                    required: "Select criteria of eligibility"
                },
                "file_copy_n_5": {
                    required: "Select detailed list of eligible candidates"
                },
                "file_copy_o_5": {
                    required: "Select detailed list of eligible candidates"
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
                var modeRec = $('#c_mode_recruitment1').val();
                if (modeRec == 'D') {
                    updateTemp2ndForm();
                } else {
                    updateTemp3rdForm();
                }
                //$('#loading').show();
            }
        });
    });

    function updateTemp2ndForm() {
        $('#loading').show();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('requiDraft/updateTemp2ndForm'); ?>",
            dataType: 'json',
            data: new FormData($('#requiFormSubmitUpdate')[0]),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data.status) {
                    $('#modal_edit_mapped_details').modal('hide');
                    Toast.fire({icon: 'success', title: data.msg});
                    if (data.type == 'list') {
                        myTable.draw();
                    } else {
                        $('#html').html(data.html);
                    }
                } else {
                    $('#msg_htmlU').html(data.msg);
                    $('#modal_msgU').modal('show');
                    if (data.logout) {
                       window.location.href = "<?php echo base_url('page?name=home'); ?>";
                    }
                }
                $('#loading').hide();
            }
        });
    }

    function updateTemp3rdForm() {
        $('#loading').show();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('requiDraft/updateTemp3rdForm'); ?>",
            dataType: 'json',
            data: new FormData($('#requiFormSubmitUpdate')[0]),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data.status) {
                    $('#modal_edit_mapped_details').modal('hide');
                    Toast.fire({icon: 'success', title: data.msg});
                    if (data.type == 'list') {
                        myTable.draw();
                    } else {
                        $('#html').html(data.html);
                    }
                } else {
                    $('#msg_htmlU').html(data.msg);
                    $('#modal_msgU').modal('show');
                    if (data.logout) {
                       window.location.href = "<?php echo base_url('page?name=home'); ?>";
                    }
                }
                $('#loading').hide();
            }
        });
    }

    function fChk4(checked_id, unchecked_id) {
        $('#' + checked_id).prop("checked", true);
        $('#' + unchecked_id).prop("checked", false);
    }
    function fChk5(checked_id, unchecked_id) {
        $('#' + checked_id).prop("checked", true);
        $('#' + unchecked_id).prop("checked", false);
    }

    function jChk5(checked_id, unchecked_id) {
        $('#' + checked_id).prop("checked", true);
        $('#' + unchecked_id).prop("checked", false);
    }


    $('.select2').on('change', function () {
        var id = this.id;
        var val = this.value;
        if (val != "") {
            $('#' + id).removeClass('invalid-feedback');
            $('#' + id).removeClass('is-invalid');
            $('#' + id).addClass('is-valid');
            $('#' + id).removeClass('error');
        } else {
            $('#' + id).addClass('invalid-feedback');
            $('#' + id).addClass('is-invalid');
            $('#' + id).removeClass('is-valid');
            $('#' + id).addClass('error');
        }
    });

    function isNumberU(evt) {
        evt = (evt) ? evt : window.event;
        let charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
            evt.preventDefault();
        } else {
            return true;
        }
    }

    $('.breakUpVaccTotal4').keyup(function (event) {
        var total = 0;
        var inputs = $(".apstUrTot4");
        for (var i = 0; i < inputs.length; i++) {
            var val = $(inputs[i]).val();
            if (val) {
                val = parseInt(val.replace(/^\$/, ""));
                total += !isNaN(val) ? val : 0;
            }
        }
        $('#d_total_4').val(total);
    });

    function pwdCheck4(value) {
        var val = parseInt(value);
        if (val > 0) {
            $('#pwdCategoryDiv4').removeClass('d-none');
            $('.cat_dis_4').removeAttr('readonly');
            var total = 0;
            var inputs = $(".cat_dis_4");
            for (var i = 0; i < inputs.length; i++) {
                //  alert($(inputs[i]).val());
                var val = $(inputs[i]).val();
                if (val) {
                    val = parseInt(val.replace(/^\$/, ""));
                    total += !isNaN(val) ? val : 0;
                }
            }
            $('#e_total_4_error').html("");
            $('#e_total_4').removeClass('is-valid is-invalid');
            $('#e_total_4_error').removeClass('error invalid-feedback');
            $('#e_total_4').val(total);
            var pwdTotal = $('#d_pwd_4').val();
            if (parseInt(total) != parseInt(pwdTotal)) {
                $('#e_total_4_error').html("PwD total is invalid");
                $('#e_total_4').addClass('is-invalid');
                $('#e_total_4_error').addClass('error invalid-feedback');
            } else if (parseInt(total) == parseInt(pwdTotal)) {
                $('#e_total_4').addClass('is-valid');
            }
        } else {
            $('#pwdCategoryDiv4').addClass('d-none');
            $('.cat_dis_4').attr('readonly', 'true');
            $('#e_total_4_error').html("");
            $('.cat_dis_4').removeClass('is-valid is-invalid');
            $('#e_total_4').removeClass('is-valid is-invalid');
            $('#e_total_4_error').removeClass('error is-valid invalid-feedback');
            $('#e_total_4').val(0);
            $('.cat_dis_4').val(0);
        }
    }

    $('.cat_dis_4').keyup(function (event) {
        var total = 0;
        var inputs = $(".cat_dis_4");
        for (var i = 0; i < inputs.length; i++) {
            //  alert($(inputs[i]).val());
            var val = $(inputs[i]).val();
            if (val) {
                val = parseInt(val.replace(/^\$/, ""));
                total += !isNaN(val) ? val : 0;
            }
        }
        $('#e_total_4_error').html("");
        $('#e_total_4').removeClass('is-valid is-invalid');
        $('#e_total_4_error').removeClass('error invalid-feedback');
        $('#e_total_4').val(total);
        var pwdTotal = $('#d_pwd_4').val();
        if (parseInt(total) != parseInt(pwdTotal)) {
            $('#e_total_4_error').html("PwD total is invalid");
            $('#e_total_4').addClass('is-invalid');
            $('#e_total_4_error').addClass('error invalid-feedback');
        } else if (parseInt(total) == parseInt(pwdTotal)) {
            $('#e_total_4').addClass('is-valid');
        }
    });

    $('.breakUpVaccTotal5').keyup(function (event) {
        var total = 0;
        var inputs = $(".apstUrTot5");
        for (var i = 0; i < inputs.length; i++) {
            var val = $(inputs[i]).val();
            if (val) {
                val = parseInt(val.replace(/^\$/, ""));
                total += !isNaN(val) ? val : 0;
            }
        }
        $('#d_total_5').val(total);
    });

    function pwdCheck5(value) {
        var val = parseInt(value);
        if (val > 0) {
            $('#pwdCategoryDiv5').removeClass('d-none');
            $('.cat_dis_5').removeAttr('readonly');
            var total = 0;
            var inputs = $(".cat_dis_5");
            for (var i = 0; i < inputs.length; i++) {
                //  alert($(inputs[i]).val());
                var val = $(inputs[i]).val();
                if (val) {
                    val = parseInt(val.replace(/^\$/, ""));
                    total += !isNaN(val) ? val : 0;
                }
            }
            $('#e_total_5_error').html("");
            $('#e_total_5').removeClass('is-valid is-invalid');
            $('#e_total_5_error').removeClass('error invalid-feedback');
            $('#e_total_5').val(total);
            var pwdTotal = $('#d_pwd_5').val();
            if (parseInt(total) != parseInt(pwdTotal)) {
                $('#e_total_5_error').html("PwD total is invalid");
                $('#e_total_5').addClass('is-invalid');
                $('#e_total_5_error').addClass('error invalid-feedback');
            } else if (parseInt(total) == parseInt(pwdTotal)) {
                $('#e_total_5').addClass('is-valid');
            }
        } else {
            $('#pwdCategoryDiv5').addClass('d-none');
            $('.cat_dis_5').attr('readonly', 'true');
            $('#e_total_5_error').html("");
            $('.cat_dis_5').removeClass('is-valid is-invalid');
            $('#e_total_5').removeClass('is-valid is-invalid');
            $('#e_total_5_error').removeClass('error is-valid invalid-feedback');
            $('#e_total_5').val(0);
            $('.cat_dis_5').val(0);
        }
    }

    $('.cat_dis_5').keyup(function (event) {
        var total = 0;
        var inputs = $(".cat_dis_5");
        for (var i = 0; i < inputs.length; i++) {
            //  alert($(inputs[i]).val());
            var val = $(inputs[i]).val();
            if (val) {
                val = parseInt(val.replace(/^\$/, ""));
                total += !isNaN(val) ? val : 0;
            }
        }
        $('#e_total_5_error').html("");
        $('#e_total_5').removeClass('is-valid is-invalid');
        $('#e_total_5_error').removeClass('error invalid-feedback');
        $('#e_total_5').val(total);
        var pwdTotal = $('#d_pwd_5').val();
        if (parseInt(total) != parseInt(pwdTotal)) {
            $('#e_total_5_error').html("PwD total is invalid");
            $('#e_total_5').addClass('is-invalid');
            $('#e_total_5_error').addClass('error invalid-feedback');
        } else if (parseInt(total) == parseInt(pwdTotal)) {
            $('#e_total_5').addClass('is-valid');
        }
    });

    function modeOfRecU(value) {
        $('#directRecuDivU').addClass('d-none');
        $('#LDCERecDivU').addClass('d-none');
        if (value == 'D') {
            $('#directRecuDivU').removeClass('d-none');
        } else {
            $('#LDCERecDivU').removeClass('d-none');
        }
        //LDCERecDivU
    }

    function loadCriteriaEligibility1(postname) {
        $('#loading').show();
        $('#m_crit_elig_5').html('Loading..');
        $('#m_crit_elig_5').append('<option value=""> -Select- </option>');
        if (postname != "") {
            // Ajax post
            jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url('requiDraft/loadCriteriaEligibility'); ?>",
                dataType: 'json',
                data: {
                    post_name: postname
                },
                success: function (data) {
                    if (data.status) {
                        // Add options
                        $.each(data.result, function (index, data_dept) {
                            $('#m_crit_elig_5').append('<option value="' + data_dept['auto_id'] + '">' + data_dept['eligibility'] + '</option>');
                        });
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
            $('#loading').hide();
            $('#m_crit_elig_5').addClass('invalid-feedback');
            $('#m_crit_elig_5').addClass('is-invalid');
            $('#m_crit_elig_5').removeClass('is-valid');
            $('#m_crit_elig_5').addClass('error');
        }
    }

    $('.alphabetsonly').keypress(function (e) {
        var regex = new RegExp(/^[a-zA-Z]+$/);
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        } else {
            e.preventDefault();
            return false;
        }
    });

    $('.alphabetsspaceonly').keypress(function (e) {
        var id = e.target.id;
        var value = $('#' + id).val();
        var newVal = value.replace(/  +/g, ' ');
        var regex = new RegExp(/^([a-zA-Z ]+\s?)*$/);
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            $('#' + id).val(newVal);
            return true;
        } else {
            e.preventDefault();
            return false;
        }
    });

    $('.digitsonly').keypress(function (e) {
        var regex = new RegExp(/^[0-9]+$/);
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        } else {
            e.preventDefault();
            return false;
        }
    });

</script>
