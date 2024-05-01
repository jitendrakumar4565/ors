<style>
    .table td{
        padding: 0.30rem;
    }
    .table th{
        padding: 0.30rem;
    }
</style>

<script type="text/javascript" src="<?php echo base_url('assets/dist/xlsx.full.min.js') ?>"></script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Requisition</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Requisition</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <?php
    $mst_id = $this->session->userdata('MSTID');
    $dnone = "d-none";
    if ($mData != NULL) {
        $dnone = "";
    }
    ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <input type="hidden" id="mst_id" name="mst_id" value="<?php echo $mst_id; ?>" class="form-control" required="" />
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-tools float-right">
                                <form id="freshRequisition" name="freshRequisition" method="post" action="<?php echo base_url('requiDraft/addNew') ?>">
                                    <input type="hidden" name="form_reset" id="form_reset" value="form_reset" class="form-control form-control-sm"/>
                                    <button title="Preview Details and Submit" type="button" id="prevDetailsBtnTop" onclick="previewRecord('<?php echo $mst_id; ?>')" class="prevDetailsBtn btn btn-sm btn-outline-info <?php echo $dnone ?>"> <i class="fa fa-check-circle mr-1"></i>Preview details and submit</button>
                                    <button title="Print Details" type="button" id="prevPdfBtn" onclick="previewPdfRecord('<?php echo $mst_id; ?>')" class="btn btn-sm btn-outline-danger <?php echo $dnone ?>"> <i class="fa fa-file-pdf-o mr-1"></i>Print Details</button>
                                    <a href="javascript:freshRequisition()" title="Fresh Requisition" class="btn btn-sm btn-outline-primary"><i class="fa fa-refresh"></i> Fresh</a>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center" id="tabids">
                                <div class="row col-md-12" id="html">
                                    <?php
                                    if ($mData != null) {
                                        $sno = 1;
                                        foreach ($mData as $mRow) {
                                            ?>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="small-box">
                                                        <div class="inner">
                                                            <p><span class="float-right badge badge-primary"><?php echo $sno; ?></span> <?php echo $mRow->post_name; ?></p>
                                                            <?php
                                                            $modeRec = $mRow->c_mode_recruitment;
                                                            if ($modeRec == 'L') {
                                                                echo '<span class="badge badge-danger">LDCE RECRUITMENT</span>';
                                                            } else {
                                                                echo '<span class="badge badge-success">DIRECT RECRUITMENT</span>';
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="ion ion-bag"></i>
                                                        </div>
                                                        <div class="small-box-footer">
                                                            <button title="Edit Details"  onclick="editMappRecord('<?php echo $mRow->auto_id ?>')" type="button"  class="btn btn-sm btn-outline-info mr-1"> <i class="fa fa-edit"></i></button>
                                                            <button title="Delete Record" onclick="delMappRecord('<?php echo $mRow->auto_id ?>')" type="button" class="btn btn-sm btn-outline-danger"> <i class="fa fa-trash"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $sno++;
                                        }
                                    }
                                    ?> 
                                </div>
                            </div>                            
                            <form role="form" class="form_submit" id="requiFormSubmit" name="requiFormSubmit" method="post" autocomplete="off">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border">Department/Office Details </legend>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="dept_name">Name of Department <span class="text-danger"> *</span></label>
                                                                <select class="form-control form-control-sm" name="dept_name" id="dept_name" style="width: 100%;">
                                                                    <option  value="<?php echo $userData->dept_id; ?>"><?php echo $userData->dept_name; ?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="org_name">Name of the Organization/Office <span class="text-danger"> *</span></label>
                                                                <select class="form-control select2" name="org_name" id="org_name"  style="width: 100%;">
                                                                    <option value="">-Select-</option>
                                                                    <?php
                                                                    if ($orgList != NULL) {
                                                                        foreach ($orgList as $oRow) {
                                                                            ?>
                                                                            <option value="<?php echo $oRow->auto_id; ?>"><?php echo $oRow->org_name; ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="officer_name">Contact details of Department representative(not below the rank of Deputy Secretary) of the identing Office/Department <span class="text-danger"> *</span></label>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="officer_name">Name <span class="text-danger"> *</span></label>
                                                                            <input type="text" class="form-control form-control-sm text-uppercase alphabetsspaceonly" value="<?php echo $userData->full_name; ?>" id="officer_name" name="officer_name"  maxlength="65" minlength="2" placeholder="Name">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="officer_desig">Designation <span class="text-danger"> *</span></label>
                                                                            <select class="form-control select2" name="officer_desig" id="officer_desig"  style="width: 100%;">
                                                                                <option <?php
                                                                                if ($userData->desig == "") {
                                                                                    echo 'selected';
                                                                                }
                                                                                ?> value="">-Select-</option>
                                                                                    <?php
                                                                                    if ($desigList != NULL) {
                                                                                        foreach ($desigList as $dRow) {
                                                                                            ?>
                                                                                        <option <?php
                                                                                        if ($userData->desig == $dRow->auto_id) {
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
                                                                            <label for="contact_no">Contact No <span class="text-danger"> *</span></label>
                                                                            <input type="text" class="form-control form-control-sm digitsonly" value="<?php echo $userData->mobile_no; ?>" id="contact_no" name="contact_no"  maxlength="10" minlength="10"  placeholder="Contact No">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <div class="form-group">
                                                                            <label for="officer_email">Email ID <span class="text-danger"> </span></label>
                                                                            <input type="text" class="form-control form-control-sm" value="<?php echo $userData->email_id; ?>" id="officer_email" name="officer_email" maxlength="120" placeholder="Email-ID">
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
                                                <label for="c_mode_recruitment">Mode of recruitment <span class="text-danger"> *</span></label>
                                                <select class="form-control form-control-sm" name="c_mode_recruitment" id="c_mode_recruitment" onchange="modeOfRec(this.value)"  style="width: 100%;">
                                                    <option value="D">Direct Recruitment-</option>
                                                    <option value="L">LDCE Recruitment-</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="post_name">Name of Post <span class="text-danger"> *</span></label>
                                                <select class="form-control select2 netEmp" name="post_name" id="post_name"  style="width: 100%;">
                                                    <option value="">-Select-</option>
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
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="a_group">Group <span class="text-danger"> *</span></label>
                                                <select class="form-control form-control-sm" name="a_group" id="a_group"  style="width: 100%;">
                                                    <option value="C">-Group C-</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="b_pay_scale">Pay Scale <span class="text-danger"> *</span></label>
                                                <select class="form-control form-control-sm" name="b_pay_scale" id="b_pay_scale"  style="width: 100%;">
                                                    <option value="">-Select-</option>
                                                    <option value="1"> Level 1 </option>
                                                    <option value="2"> Level 2 </option>
                                                    <option value="3"> Level 3 </option>
                                                    <option value="4"> Level 4 </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="directRecuDiv">                                
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="d_ur_2" class="col-sm-12 col-form-label">Breakup of vacancy <span>( Horizontal vacancy- The vacancies should be inclusive of total vacancy) </span></label>
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
                                                                        <input type="text" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm breakUpVaccTotal2 apstUrTot2" id="d_ur_2" name="d_ur_2" value="0" placeholder="Unreserved">
                                                                    </td>
                                                                    <td class="form-group">
                                                                        <input type="text" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm breakUpVaccTotal2 apstUrTot2" id="d_apst_2" name="d_apst_2" value="0" placeholder="APST">
                                                                    </td>
                                                                    <td class="form-group">
                                                                        <input type="text" onkeypress="isNumber(event)" readonly="" value="0" class="form-control form-control-sm" id="d_total_2" name="d_total_2"  placeholder="Total">
                                                                    </td>
                                                                    <td class="form-group">
                                                                        <input type="text" onkeypress="isNumber(event)"  value="0" onblur="pwdCheck2(this.value)" class="default-zero  form-control form-control-sm" id="d_pwd_2" name="d_pwd_2" placeholder="PwD">
                                                                    </td>
                                                                    <td class="form-group">
                                                                        <input type="text" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm" id="d_ex_sm_2" name="d_ex_sm_2" value="0" placeholder="Ex-Serviceman">
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>                                   
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 d-none" id="pwdCategoryDiv2">
                                                <div class="form-group">
                                                    <label for="e_blindness_2" class="col-sm-12 col-form-label">Category of disability, if applicable</label>
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
                                                                        <input type="text" readonly="" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm cat_dis_2" id="e_blindness_2" name="e_blindness_2" placeholder="Total">
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
                                                                        <input type="text" readonly="" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm cat_dis_2" id="e_deaf_2" name="e_deaf_2" placeholder="Total">
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
                                                                        <input type="text" readonly="" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm cat_dis_2" id="e_locomotor_2" name="e_locomotor_2" placeholder="Total">
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
                                                                        <input type="text" readonly="" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm cat_dis_2" id="e_autism_2" name="e_autism_2" placeholder="Total">
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
                                                                        <input type="text" readonly="" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm cat_dis_2" id="e_multiple_2" name="e_multiple_2" placeholder="Total">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th colspan="2" style="text-align: right">Total</th>
                                                                    <td class="form-group">
                                                                        <input type="text" value="0" class="form-control form-control-sm" readonly=""  id="e_total_2" name="e_total_2" placeholder="Total">
                                                                        <span id="e_total_2_error"></span>
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
                                                        <label for="f_vac_worked_out_2Y" class="">Whether the vacancies for the person with disabilities and Ex-Serviceman have been worked out with reference to the instructions contained in the Government of Arunachal Pradesh Orders</label>
                                                        <div class="input-group">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" onclick="fChk('f_vac_worked_out_2Y', 'f_vac_worked_out_2N')" name="f_vac_worked_out_2" id="f_vac_worked_out_2Y" value="Y" checked="true">
                                                                <label for="f_vac_worked_out_2Y">Yes</label>
                                                            </div>
                                                            <div class="form-check ml-4">
                                                                <input type="checkbox" class="form-check-input" onclick="fChk('f_vac_worked_out_2N', 'f_vac_worked_out_2Y')" name="f_vac_worked_out_2" id="f_vac_worked_out_2N" value="N"  >
                                                                <label for="f_vac_worked_out_2Y">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <label for="g_edu_others_2" class="">Education and other qualification laid down in the Recruitment Rules</label>
                                                        <textarea class="form-control" maxlength="225" rows="3" name="g_edu_others_2" id="g_edu_others_2" placeholder="Education and other qualification laid down in the Recruitment Rules"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="h_min_age_2" class="col-sm-12 col-form-label">Age limit as per Recruitment Rules notified in Gazette of Arunachal Pradesh</label>
                                                    <div class="col-sm-12" style="overflow-x: auto">
                                                        <table id="template_table" class="" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        Minimum age (years)
                                                                    </td>
                                                                    <td style="width: 35%" class="form-group">
                                                                        <input type="text" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm" maxlength="2" id="h_min_age_2" name="h_min_age_2" placeholder="MIN AGE">
                                                                    </td>

                                                                    <td class="text-center">
                                                                        Maximum age (years)
                                                                    </td>
                                                                    <td style="width: 35%" class="form-group">
                                                                        <input type="text" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm" maxlength="2" id="h_max_age_2" name="h_max_age_2" placeholder="MAX AGE">
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
                                                    <label for="i_apst_2" class="col-sm-12 col-form-label">Whether relaxation of Upper age available to undermentioned categories, if yes, please mention</label>
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
                                                                        <input type="text" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm" maxlength="2" id="i_apst_2" name="i_apst_2" placeholder="APST">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        PwD (APST)
                                                                    </td>
                                                                    <td class="form-group">
                                                                        <input type="text" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm" maxlength="2" id="i_pwd_apst_2" name="i_pwd_apst_2" placeholder="PwD">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        PwD (UR)
                                                                    </td>
                                                                    <td class="form-group">
                                                                        <input type="text" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm" maxlength="2" id="i_pwd_ur_2" name="i_pwd_ur_2" placeholder="PwD">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        Ex-Servicemen (APST)
                                                                    </td>
                                                                    <td class="form-group">
                                                                        <input type="text" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm" maxlength="2" id="i_ex_sm_apst_2" name="i_ex_sm_apst_2" placeholder="Ex-SM">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        Ex-Servicemen (UR)
                                                                    </td>
                                                                    <td class="form-group">
                                                                        <input type="text" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm" maxlength="2" id="i_ex_sm_ur_2" name="i_ex_sm_ur_2" placeholder="Ex-SM">
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
                                                        <label for="j_ban_restric_2Y" class="">Whether there is any ban or restriction from the Govt. for filling up the post</label>
                                                        <div class="input-group">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" onclick="jChk('j_ban_restric_2Y', 'j_ban_restric_2N')" name="j_ban_restric_2" id="j_ban_restric_2Y" value="Y" checked="true">
                                                                <label for="j_ban_restric_2Y">Yes</label>
                                                            </div>
                                                            <div class="form-check ml-4">
                                                                <input type="checkbox" class="form-check-input" onclick="jChk('j_ban_restric_2N', 'j_ban_restric_2Y')" name="j_ban_restric_2" id="j_ban_restric_2N" value="N"  >
                                                                <label for="j_ban_restric_2N">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <label for="file_copy_fileInput_k_2" class="">Upload latest Recruitment Rules (in pdf format)</label>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="input-group input-group-sm">
                                                                        <input type="text" onclick="selectFile('fileInput_k_2')"  class="form-control form-control-sm mycustomfile" readonly=""  id="file_copy_fileInput_k_2" name="file_copy_k_2" placeholder="Select File (PDF) only">
                                                                        <span class="input-group-append">
                                                                            <button type="button" class="btn btn-default" onclick="selectFile('fileInput_k_2')"><i class="fas fa-file text-primary mr-1"></i>Browse</button>
                                                                            <button type="button" id="remove_btn_fileInput_k_2" name="remove_btn_fileInput_k_2" onclick="removeFile('fileInput_k_2')" class="removebtn btn btn-default d-none"> <i class="fa fa-trash text-danger mr-1"></i>Remove</button>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 d-none">
                                                                <div class="form-group">
                                                                    <input type="file"  id="fileInput_k_2" name="file_k_2" onchange="return fileValidation('fileInput_k_2')" class="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <label for="l_other_requi_cond_2" class="">Any other required or conditions not covered above</label>
                                                        <div class="row col-sm-12">
                                                            <div class="col-sm-12">
                                                                <div class="form-group row">                                                                    
                                                                    <textarea class="form-control" rows="3" maxlength="225" id="l_other_requi_cond_2" name="l_other_requi_cond_2" placeholder="Any other requirement or conditions not covered above"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <label for="file_copy_fileInput_l_2" class="">Upload relevant orders, if any (in pdf format)</label>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="input-group input-group-sm">
                                                                        <input type="text" onclick="selectFile('fileInput_l_2')"  class="form-control form-control-sm mycustomfile" readonly=""  id="file_copy_fileInput_l_2" name="file_copy_l_2" placeholder="Select File (PDF) only">
                                                                        <span class="input-group-append">
                                                                            <button type="button" class="btn btn-default" onclick="selectFile('fileInput_l_2')"><i class="fas fa-file text-primary mr-1"></i>Browse</button>
                                                                            <button type="button" id="remove_btn_fileInput_l_2" name="remove_btn_fileInput_l_2" onclick="removeFile('fileInput_l_2')" class="removebtn btn btn-default d-none"> <i class="fa fa-trash text-danger mr-1"></i>Remove</button>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 d-none">
                                                                <div class="form-group">
                                                                    <input type="file"  id="fileInput_l_2" name="file_l_2" onchange="return fileValidation('fileInput_l_2')" class="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>

                                    <div class="row d-none" id="LDCERecDiv">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="d_ur_3" class="col-sm-12 col-form-label">Breakup of vacancy <span>( Horizontal vacancy- The vacancies should be inclusive of total vacancy) </span></label>
                                                    <div class="col-sm-12" style="overflow-x: auto">
                                                        <table id="template_table" class="mytable table-bordered" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th style="min-width: 120px;">Unreserved</th>
                                                                    <th style="min-width: 120px;">APST</th>
                                                                    <th style="min-width: 120px;">Total</th>
                                                                    <th style="min-width: 120px;">PwD</th>
                                                                    <th style="min-width: 120px;">Ex-Serviceman</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="form-group">                                                                       
                                                                        <input type="text" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm breakUpVaccTotal3 apstUrTot3" id="d_ur_3" name="d_ur_3" placeholder="Unreserved">
                                                                    </td>
                                                                    <td class="form-group">
                                                                        <input type="text"value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm breakUpVaccTotal3 apstUrTot3" id="d_apst_3" name="d_apst_3" placeholder="APST">
                                                                    </td>
                                                                    <td class="form-group">
                                                                        <input type="text"  onkeypress="isNumber(event)" readonly="" value="0" class="form-control form-control-sm" id="d_total_3" name="d_total_3" placeholder="Total">
                                                                    </td>
                                                                    <td class="form-group">
                                                                        <input type="text" onkeypress="isNumber(event)"  value="0" onblur="pwdCheck3(this.value)" class="default-zero form-control form-control-sm" id="d_pwd_3" name="d_pwd_3" placeholder="PwD">
                                                                    </td>
                                                                    <td class="form-group">
                                                                        <input type="text" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm" id="d_ex_sm_3" name="d_ex_sm_3" placeholder="Ex-Serviceman">
                                                                    </td>
                                                                </tr>                                                                
                                                            </tbody>
                                                            <tfoot>                                   
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 d-none" id="pwdCategoryDiv3">
                                                <div class="form-group">
                                                    <label for="e_blindness_3" class="col-sm-12 col-form-label">Category of disability, if applicable</label>
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
                                                                        <input type="text" readonly="" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm cat_dis_3" id="e_blindness_3" name="e_blindness_3" placeholder="Total">
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
                                                                        <input type="text" readonly="" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm cat_dis_3" id="e_deaf_3" name="e_deaf_3" placeholder="Total">
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
                                                                        <input type="text" readonly="" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm cat_dis_3" id="e_locomotor_3" name="e_locomotor_3" placeholder="Total">
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
                                                                        <input type="text" readonly="" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm cat_dis_3" id="e_autism_3" name="e_autism_3" placeholder="Total">
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
                                                                        <input type="text" readonly="" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm cat_dis_3" id="e_multiple_3" name="e_multiple_3" placeholder="Total">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th colspan="2" style="text-align: right">Total</th>
                                                                    <td class="form-group">
                                                                        <input type="text" value="0" class="form-control form-control-sm" readonly=""  id="e_total_3" name="e_total_3" placeholder="Total">
                                                                        <span id="e_total_3_error"></span>
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
                                                        <label for="f_vac_worked_out_3Y" class="">Whether the vacancies for the person with disabilities and Ex-Serviceman have been worked out with reference to the instructions contained in the Government of Arunachal Pradesh Orders</label>
                                                        <div class="input-group">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" onclick="fChk('f_vac_worked_out_3Y', 'f_vac_worked_out_3N')" name="f_vac_worked_out_3" id="f_vac_worked_out_3Y" value="Y" checked="true">
                                                                <label for="f_vac_worked_out_3Y">Yes</label>
                                                            </div>
                                                            <div class="form-check ml-4">
                                                                <input type="checkbox" class="form-check-input" onclick="fChk('f_vac_worked_out_3N', 'f_vac_worked_out_3Y')" name="f_vac_worked_out_3" id="f_vac_worked_out_3N" value="N"  >
                                                                <label for="f_vac_worked_out_3N">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <label for="g_edu_others_3" class="">Education and other qualification laid down in the Recruitment Rules</label>
                                                        <textarea class="form-control" maxlength="225" rows="3" name="g_edu_others_3" id="g_edu_others_3" placeholder="Education and other qualification laid down in the Recruitment Rules"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="h_min_age_3" class="col-sm-12 col-form-label">Age limit as per Recruitment Rules notified in Gazette of Arunachal Pradesh</label>
                                                    <div class="col-sm-12" style="overflow-x: auto">
                                                        <table id="template_table" class="" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        Minimum age (years)
                                                                    </td>
                                                                    <td style="width: 35%" class="form-group">
                                                                        <input type="text" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm" maxlength="2" id="h_min_age_3" name="h_min_age_3" placeholder="MIN AGE">
                                                                    </td>

                                                                    <td class="text-center">
                                                                        Maximum age (years)
                                                                    </td>
                                                                    <td style="width: 35%" class="form-group">
                                                                        <input type="text" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm" maxlength="2" id="h_max_age_3" name="h_max_age_3" placeholder="MAX AGE">
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
                                                    <label for="i_apst_3" class="col-sm-12 col-form-label">Whether relaxation of Upper age available to undermentioned categories, if yes, please mention</label>
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
                                                                        <input type="text" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm" maxlength="2" id="i_apst_3" name="i_apst_3" placeholder="APST">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        PwD (APST)
                                                                    </td>
                                                                    <td class="form-group">
                                                                        <input type="text" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm" maxlength="2" id="i_pwd_apst_3" name="i_pwd_apst_3" placeholder="PwD">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        PwD (UR)
                                                                    </td>
                                                                    <td class="form-group">
                                                                        <input type="text" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm" maxlength="2" id="i_pwd_ur_3" name="i_pwd_ur_3" placeholder="PwD">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        Ex-Servicemen (APST)
                                                                    </td>
                                                                    <td class="form-group">
                                                                        <input type="text" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm" maxlength="2" id="i_ex_sm_apst_3" name="i_ex_sm_apst_3" placeholder="Ex-SM">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        Ex-Servicemen (UR)
                                                                    </td>
                                                                    <td class="form-group">
                                                                        <input type="text" value="0" onkeypress="isNumber(event)" class="default-zero form-control form-control-sm" maxlength="2" id="i_ex_sm_ur_3" name="i_ex_sm_ur_3" placeholder="Ex-SM">
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
                                                        <label for="j_ban_restric_3Y" class="">Whether there is any ban or restriction from the Govt. for filling up the post</label>
                                                        <div class="input-group">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" onclick="jChk('j_ban_restric_3Y', 'j_ban_restric_3N')" name="j_ban_restric_3" id="j_ban_restric_3Y" value="Y" checked="true">
                                                                <label for="j_ban_restric_3Y">Yes</label>
                                                            </div>
                                                            <div class="form-check ml-4">
                                                                <input type="checkbox" class="form-check-input" onclick="jChk('j_ban_restric_3N', 'j_ban_restric_3Y')" name="j_ban_restric_3" id="j_ban_restric_3N" value="N"  >
                                                                <label for="j_ban_restric_3N">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <label for="fileInput_k_3" class="">Upload latest Recruitment Rules (in pdf format)</label>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="input-group input-group-sm">
                                                                        <input type="text" onclick="selectFile('fileInput_k_3')"  class="form-control form-control-sm mycustomfile" readonly=""  id="file_copy_fileInput_k_3" name="file_copy_k_3" placeholder="Select File (PDF) only">
                                                                        <span class="input-group-append">
                                                                            <button type="button" class="btn btn-default" onclick="selectFile('fileInput_k_3')"><i class="fas fa-file text-primary mr-1"></i>Browse</button>
                                                                            <button type="button" id="remove_btn_fileInput_k_3" name="remove_btn_fileInput_k_3" onclick="removeFile('fileInput_k_3')" class="removebtn btn btn-default d-none"> <i class="fa fa-trash text-danger mr-1"></i>Remove</button>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 d-none">
                                                                <div class="form-group">
                                                                    <input type="file"  id="fileInput_k_3" name="file_k_3" onchange="return fileValidation('fileInput_k_3')" class="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <label for="l_other_requi_cond_3" class="">Any other required or conditions not covered above</label>
                                                        <div class="row col-sm-12">
                                                            <div class="col-sm-12">
                                                                <div class="form-group row">                                                                    
                                                                    <textarea class="form-control" rows="3" maxlength="225" id="l_other_requi_cond_3" name="l_other_requi_cond_3" placeholder="Any other requirement or conditions not covered above"></textarea>
                                                                </div>                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <label for="file_copy_fileInput_l_3" class="">Upload relevant orders, if any (in pdf format)</label>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="input-group input-group-sm">
                                                                        <input type="text" onclick="selectFile('fileInput_l_3')"  class="form-control form-control-sm mycustomfile" readonly=""  id="file_copy_fileInput_l_3" name="file_copy_l_3" placeholder="Select File (PDF) only">
                                                                        <span class="input-group-append">
                                                                            <button type="button" class="btn btn-default" onclick="selectFile('fileInput_l_3')"><i class="fas fa-file text-primary mr-1"></i>Browse</button>
                                                                            <button type="button" id="remove_btn_fileInput_l_3" name="remove_btn_fileInput_l_3" onclick="removeFile('fileInput_l_3')" class="removebtn btn btn-default d-none"> <i class="fa fa-trash text-danger mr-1"></i>Remove</button>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 d-none">
                                                                <div class="form-group">
                                                                    <input type="file"  id="fileInput_l_3" name="file_l_3" onchange="return fileValidation('fileInput_l_3')" class="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="m_crit_elig_post_3" class="">Specify the Criteria of Eligibility under which the LDCE post falls, as per Recruitment Rule.</label>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label for="m_crit_elig_post_3">Name of post <span class="text-danger"> *</span></label>
                                                            <select class="form-control form-control-sm" onchange="loadCriteriaEligibility(this.value)" name="m_crit_elig_post_3" id="m_crit_elig_post_3"  style="width: 100%;">
                                                                <option value="">-Select-</option>
                                                                <option selected="" value="LDC">-LDC-</option>
                                                                <option value="DRIVER">-DRIVER-</option>
                                                                <option value="JSA">-JSA-</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <div class="form-group">
                                                            <label for="m_crit_elig_3">Criteria of Eligibility <span class="text-danger"> *</span></label>
                                                            <select class="form-control select2" data-minimum-results-for-search="-1" name="m_crit_elig_3" id="m_crit_elig_3" >
                                                                <option value="">-Select-</option>  
                                                                <?php
                                                                if ($postEligList != NULL) {
                                                                    foreach ($postEligList as $poRow) {
                                                                        ?>
                                                                        <option value="<?php echo $poRow->auto_id ?>"><?php echo $poRow->eligibility; ?></option>
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
                                                <label for="file_copy_fileInput_n_3" class="">Upload detailed list of eligible candidates (as on 1st January of the Year) duly verified by the HoD (in pdf format) <span class="text-danger">*</span><a href="<?php echo base_url('assets/ors/storage/performa/LDCE proforma.docx') ?>" target="_self"> Download sample file</a></label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" onclick="selectFile('fileInput_n_3')"  class="form-control form-control-sm mycustomfile" readonly=""  id="file_copy_fileInput_n_3" name="file_copy_n_3" placeholder="Select File (PDF) only">
                                                                <span class="input-group-append">
                                                                    <button type="button" class="btn btn-default" onclick="selectFile('fileInput_n_3')"><i class="fas fa-file text-primary mr-1"></i>Browse</button>
                                                                    <button type="button" id="remove_btn_fileInput_n_3" name="remove_btn_fileInput_n_3" onclick="removeFile('fileInput_n_3')" class="removebtn btn btn-default d-none"> <i class="fa fa-trash text-danger mr-1"></i>Remove</button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 d-none">
                                                        <div class="form-group">
                                                            <input type="file"  id="fileInput_n_3" name="file_n_3" onchange="return fileValidation('fileInput_n_3')" class="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="file_copy_fileInput_o_3" class="">Upload detailed list of eligible candidates (as on 1st January of the Year) duly verified by the HoD (in xls|xlsx format) <span class="text-danger">*</span><a href="<?php echo base_url('assets/ors/storage/performa/LDCE proforma.xlsx') ?>" target="_self"> Download sample file</a></label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" onclick="selectFile('fileInput_o_3')"  class="form-control form-control-sm mycustomfile" readonly=""  id="file_copy_fileInput_o_3" name="file_copy_o_3" placeholder="Select File (xls|xlss) only">
                                                                <span class="input-group-append">
                                                                    <button type="button" class="btn btn-default" onclick="selectFile('fileInput_o_3')"><i class="fas fa-file text-primary mr-1"></i>Browse</button>
                                                                    <button type="button" id="remove_btn_fileInput_o_3" name="remove_btn_fileInput_o_3" onclick="removeFile('fileInput_o_3')" class="removebtn btn btn-default d-none"> <i class="fa fa-trash text-danger mr-1"></i>Remove</button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 d-none">
                                                        <div class="form-group">
                                                            <input type="file"  id="fileInput_o_3" name="file_o_3" onchange="return fileValidation('fileInput_o_3')" class="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-3" style="max-height: 230px;overflow: auto">
                                            <div class="form-group" id="excel_data" class=""></div>
                                        </div>
                                    </div>


                                    <div class="col-md-12 mr-4 mb-3">
                                        <div class="row justify-content-end">
                                            <div class="">
                                                <button title="Add Details" type="submit" class="btn btn-sm btn-outline-primary"><i class="fa fa-plus-circle"></i> Add Details</button>
                                                <button title="Preview Details and Submit" type="button" id="prevDetailsBtnBottom" onclick="previewRecord('<?php echo $mst_id; ?>')" class="prevDetailsBtn btn btn-sm btn-outline-info <?php echo $dnone ?>"> <i class="fa fa-check-circle mr-1"></i>Preview details and submit</button>
                                                <button title="Clear Form" type="button" onclick="clearForm()" class="btn btn-sm btn-outline-danger"><i class="fa fa-refresh"></i> Clear Form</button>
                                            </div>  
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="modal fade" id="modal_del_mapping">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-body">
                                <form role="form" autocomplete="off" id="deleteTemplateForm" name="deleteTemplateForm" method="post">
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
                                            <p>Do you really want to delete..?</p>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="row card-footer justify-content-end">
                                            <div class="card-tools">
                                                <input type='hidden' name='type' id='type' value='form'/>
                                                <button title="Delete Record" type="submit" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash ml-2"></i> Delete Record</button>
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
                    <div class="modal fade" id="modal_clear_form">
                        <div class="modal-dialog  modal-sm modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <p style="font-size: 14px;font-weight: bold">Are you sure wants to clear this form..?</p>
                                    <div class="modal-footer justify-content-center">
                                        <button title="Cancel" data-dismiss="modal" type="button"  class="btn btn-sm btn-outline-primary"> <i class="fa fa-times-circle mr-1"></i> Cancel</button>
                                        <button title="Clear Form" onclick="resetForm()" type="button"  class="btn btn-sm btn-outline-danger"> <i class="fa fa-refresh mr-1"></i> Clear Form</button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </div>

                <div class="row">
                    <div class="modal fade" id="modal_fresh_requisition">
                        <div class="modal-dialog  modal-sm modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <p style="font-size: 14px;font-weight: bold">Are you sure wants to reset this form..?</p>
                                    <div class="modal-footer justify-content-center">
                                        <button title="Cancel" data-dismiss="modal" type="button"  class="btn btn-sm btn-outline-primary"> <i class="fa fa-times-circle mr-1"></i> Cancel</button>
                                        <button title="Clear Form" onclick="freshForm()" type="button"  class="btn btn-sm btn-outline-danger"> <i class="fa fa-refresh mr-1"></i> Reset Form</button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </div>

                <div class="row">
                    <div class="modal fade" id="modal_msg">
                        <div class="modal-dialog modal-lg modal-sm modal-dialog-centered">
                            <div class="modal-content">
                                <div class="card-header">
                                    <div class="float-right">
                                        <a href="javascript:closeModal('modal_msg')" class="close btn btn-sm" title="Close">
                                            <span aria-hidden="true">X Close</span>
                                        </a>
                                    </div> 
                                </div>
                                <div class="modal-body">
                                    <div id="msg_html"></div>
                                </div>                
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </div>

                <div class="row">
                    <div class="modal fade" id="modal_edit_mapped_details">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-body">
                                <div class="modal-content card card-primary card-outline">
                                    <div class="card-header">                       
                                        <div class="float-left">
                                            Update Details
                                        </div>
                                        <div class="float-right">
                                            <a href="javascript:void(0)" data-dismiss="modal" class="close btn btn-sm" title="Close">
                                                <span aria-hidden="true">X Close</span>
                                            </a>
                                        </div>                                        
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body" id="editMappHTML">
                                    </div>
                                    <!-- /.card-body -->
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
        </div>
    </section>
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url() ?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/additional-methods.min.js"></script>
<script type="text/javascript">
                                            function selectFile(id) {
                                                $('#' + id).click();
                                            }
                                            function removeFile(id) {
                                                if (id == 'fileInput_o_3') {
                                                    $('#excel_data').html('');
                                                }
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
                                                if (id == "fileInput_o_3") {
                                                    $('#excel_data').html('');
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
                                                        $('#file_copy_' + id).val(file.name);
                                                    }
                                                }
                                            }

                                            $(document).ready(function () {
                                                var msg = '<?php echo $this->session->flashdata('message'); ?>';
                                                if (msg != "") {
                                                    Toast.fire({icon: 'success', title: msg});
                                                }
                                                $('form[id="requiFormSubmit"]').validate({
                                                    rules: {
                                                        org_name: {
                                                            required: true
                                                        },
                                                        dept_name: {
                                                            required: true
                                                        },
                                                        officer_name: {
                                                            required: true
                                                        },
                                                        officer_desig: {
                                                            required: true
                                                        },
                                                        contact_no: {
                                                            required: true,
                                                            pattern: /^[6-9]{1}[0-9]{9}$/
                                                        },
                                                        officer_email: {
                                                            required: false
                                                        },
                                                        "c_mode_recruitment": {
                                                            required: true
                                                        },
                                                        "post_name": {
                                                            required: true
                                                        },
                                                        "a_group": {
                                                            required: true
                                                        },
                                                        "b_pay_scale": {
                                                            required: true
                                                        },
                                                        "d_ur_2": {
                                                            required: true
                                                        },
                                                        "d_apst_2": {
                                                            required: true
                                                        },
                                                        "d_total_2": {
                                                            required: true
                                                        },
                                                        "d_pwd_2": {
                                                            required: true
                                                        },
                                                        "d_ex_sm_2": {
                                                            required: true
                                                        },
                                                        "e_blindness_2": {
                                                            required: true
                                                        },
                                                        "e_deaf_2": {
                                                            required: true
                                                        },
                                                        "e_locomotor_2": {
                                                            required: true
                                                        },
                                                        "e_autism_2": {
                                                            required: true
                                                        },
                                                        "e_multiple_2": {
                                                            required: true
                                                        },
                                                        "e_total_2": {
                                                            required: true,
                                                            equalTo: "#d_pwd_2"
                                                        },
                                                        "g_edu_others_2": {
                                                            required: true
                                                        },
                                                        "h_min_age_2": {
                                                            required: true
                                                        },
                                                        "h_max_age_2": {
                                                            required: true
                                                        },
                                                        "i_apst_2": {
                                                            required: true
                                                        },
                                                        "i_pwd_apst_2": {
                                                            required: true
                                                        },
                                                        "i_pwd_ur_2": {
                                                            required: true
                                                        },
                                                        "i_ex_sm_apst_2": {
                                                            required: true
                                                        },
                                                        "i_ex_sm_ur_2": {
                                                            required: true
                                                        },
                                                        "file_copy_k_2": {
                                                            required: true
                                                        },
                                                        "l_other_requi_cond_2": {
                                                            required: true
                                                        },
                                                        "file_copy_l_2": {
                                                            required: true
                                                        },
                                                        "d_ur_3": {
                                                            required: true
                                                        },
                                                        "d_apst_3": {
                                                            required: true
                                                        },
                                                        "d_total_3": {
                                                            required: true
                                                        },
                                                        "d_pwd_3": {
                                                            required: true
                                                        },
                                                        "d_ex_sm_3": {
                                                            required: true
                                                        },
                                                        "e_blindness_3": {
                                                            required: true
                                                        },
                                                        "e_deaf_3": {
                                                            required: true
                                                        },
                                                        "e_locomotor_3": {
                                                            required: true
                                                        },
                                                        "e_autism_3": {
                                                            required: true
                                                        },
                                                        "e_multiple_3": {
                                                            required: true
                                                        },
                                                        "e_total_3": {
                                                            required: true,
                                                            equalTo: "#d_pwd_3"
                                                        },
                                                        "g_edu_others_3": {
                                                            required: true
                                                        },
                                                        "h_min_age_3": {
                                                            required: true
                                                        },
                                                        "h_max_age_3": {
                                                            required: true
                                                        },
                                                        "i_apst_3": {
                                                            required: true
                                                        },
                                                        "i_pwd_apst_3": {
                                                            required: true
                                                        },
                                                        "i_pwd_ur_3": {
                                                            required: true
                                                        },
                                                        "i_ex_sm_apst_3": {
                                                            required: true
                                                        },
                                                        "i_ex_sm_ur_3": {
                                                            required: true
                                                        },
                                                        "file_copy_k_3": {
                                                            required: true
                                                        },
                                                        "l_other_requi_cond_3": {
                                                            required: true
                                                        },
                                                        "file_copy_l_3": {
                                                            required: true
                                                        },
                                                        "m_crit_elig_post_3": {
                                                            required: true
                                                        },
                                                        "m_crit_elig_3": {
                                                            required: true
                                                        },
                                                        "file_copy_n_3": {
                                                            required: true
                                                        },
                                                        "file_copy_o_3": {
                                                            required: true
                                                        }
                                                    },
                                                    messages: {
                                                        org_name: {
                                                            required: "Name of the Organisation/Office is required"
                                                        },
                                                        dept_name: {
                                                            required: "Name of department is required"
                                                        },
                                                        officer_name: {
                                                            required: "Name is required"
                                                        },
                                                        officer_desig: {
                                                            required: "Designation is required"
                                                        },
                                                        contact_no: {
                                                            required: "Contact no is required",
                                                            pattern: "Invalid mobile number"
                                                        },
                                                        "c_mode_recruitment": {
                                                            required: "Mode of recruitment is required"
                                                        },
                                                        'post_name': {
                                                            required: "Name of post is required"
                                                        },
                                                        'a_group': {
                                                            required: "Group is required"
                                                        },
                                                        "b_pay_scale": {
                                                            required: "Pay Scale is required"
                                                        },
                                                        "d_ur_2": {
                                                            required: "Unserved is required"
                                                        },
                                                        "d_apst_2": {
                                                            required: "APST is required"
                                                        },
                                                        "d_total_2": {
                                                            required: "Total is required"
                                                        },
                                                        "d_pwd_2": {
                                                            required: "PwD is required"
                                                        },
                                                        "d_ex_sm_2": {
                                                            required: "Ex-Sm is required"
                                                        },
                                                        "e_blindness_2": {
                                                            required: "This field is required"
                                                        },
                                                        "e_deaf_2": {
                                                            required: "This field is required"
                                                        },
                                                        "e_locomotor_2": {
                                                            required: "This field is required"
                                                        },
                                                        "e_autism_2": {
                                                            required: "This field is required"
                                                        },
                                                        "e_multiple_2": {
                                                            required: "This field is required"
                                                        },
                                                        "e_total_2": {
                                                            required: "This field is required",
                                                            equalTo: "Enter the same value as PwD"
                                                        },
                                                        "g_edu_others_2": {
                                                            required: "This field is required"
                                                        },
                                                        "h_min_age_2": {
                                                            required: "Minimum age is required"
                                                        },
                                                        "h_max_age_2": {
                                                            required: "Maximum age is required"
                                                        },
                                                        "i_apst_2": {
                                                            required: "This field is required"
                                                        },
                                                        "i_pwd_apst_2": {
                                                            required: "This field is required"
                                                        },
                                                        "i_pwd_ur_2": {
                                                            required: "This field is required"
                                                        },
                                                        "i_ex_sm_apst_2": {
                                                            required: "This field is required"
                                                        },
                                                        "i_ex_sm_ur_2": {
                                                            required: "This field is required"
                                                        },
                                                        "file_copy_k_2": {
                                                            required: "Select latest recruitment rules file"
                                                        },
                                                        "l_other_requi_cond_2": {
                                                            required: "Any other requirement or conditions not covered above is required"
                                                        },
                                                        "file_copy_l_2": {
                                                            required: "Select relevant orders file"
                                                        },
                                                        "d_ur_3": {
                                                            required: "Unserved is required"
                                                        },
                                                        "d_apst_3": {
                                                            required: "APST is required"
                                                        },
                                                        "d_total_3": {
                                                            required: "Total is required"
                                                        },
                                                        "d_pwd_3": {
                                                            required: "PwD is required"
                                                        },
                                                        "d_ex_sm_3": {
                                                            required: "Ex-Sm is required"
                                                        },
                                                        "e_blindness_3": {
                                                            required: "This field is required"
                                                        },
                                                        "e_deaf_3": {
                                                            required: "This field is required"
                                                        },
                                                        "e_locomotor_3": {
                                                            required: "This field is required"
                                                        },
                                                        "e_autism_3": {
                                                            required: "This field is required"
                                                        },
                                                        "e_multiple_3": {
                                                            required: "This field is required"
                                                        },
                                                        "e_total_3": {
                                                            required: "This field is required",
                                                            equalTo: "Enter the same value as PwD"
                                                        },
                                                        "g_edu_others_3": {
                                                            required: "This field is required"
                                                        },
                                                        "h_min_age_3": {
                                                            required: "Minimum age is required"
                                                        },
                                                        "h_max_age_3": {
                                                            required: "Maximum age is required"
                                                        },
                                                        "i_apst_3": {
                                                            required: "This field is required"
                                                        },
                                                        "i_pwd_apst_3": {
                                                            required: "This field is required"
                                                        },
                                                        "i_pwd_ur_3": {
                                                            required: "This field is required"
                                                        },
                                                        "i_ex_sm_apst_3": {
                                                            required: "This field is required"
                                                        },
                                                        "i_ex_sm_ur_3": {
                                                            required: "This field is required"
                                                        },
                                                        "file_copy_k_3": {
                                                            required: "Select latest recruitment rules file"
                                                        },
                                                        "l_other_requi_cond_3": {
                                                            required: "Any other requirement or conditions not covered above is required"
                                                        },
                                                        "file_copy_l_3": {
                                                            required: "Select relevant orders file"
                                                        },
                                                        "m_crit_elig_post_3": {
                                                            required: "Select name of post"
                                                        },
                                                        "m_crit_elig_3": {
                                                            required: "Select criteria of eligibility"
                                                        },
                                                        "file_copy_n_3": {
                                                            required: "Select detailed list of eligible candidates"
                                                        },
                                                        "file_copy_o_3": {
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
                                                        var modeRec = $('#c_mode_recruitment').val();
                                                        if (modeRec == 'D') {
                                                            saveTemp2ndForm();
                                                        } else {
                                                            saveTemp3rdForm();
                                                        }
                                                        //$('#loading').show();
                                                    }
                                                });
                                            });

                                            function saveTemp2ndForm() {
                                                $('#loading').show();
                                                $.ajax({
                                                    type: 'POST',
                                                    url: "<?php echo base_url('requiDraft/saveTemp2ndForm'); ?>",
                                                    dataType: 'json',
                                                    data: new FormData($('#requiFormSubmit')[0]),
                                                    contentType: false,
                                                    cache: false,
                                                    processData: false,
                                                    success: function (data) {
                                                        if (data.status) {
                                                            $('#mst_id').val(data.mstid);
                                                            $('#html').html(data.html);
                                                            if (data.mapp_count > 0) {
                                                                $('#custom-tabs-3rd-form-tab').removeClass('disabled');
                                                                $('.prevDetailsBtn').removeClass('d-none');
                                                                $('#prevPdfBtn').removeClass('d-none');
                                                            } else {
                                                                $('#custom-tabs-3rd-form-tab').addClass('disabled');
                                                                $('.prevDetailsBtn').addClass('d-none');
                                                                $('#prevPdfBtn').addClass('d-none');
                                                            }
                                                            resetForm();
                                                            Toast.fire({icon: 'success', title: data.msg});
                                                        } else {
                                                            $('#msg_html').html(data.msg);
                                                            $('#modal_msg').modal('show');
                                                            toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                                                            if (data.logout) {
                                                                window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                            }
                                                        }
                                                        $('#loading').hide();
                                                    }
                                                });
                                            }

                                            function saveTemp3rdForm() {
                                                $('#loading').show();
                                                $.ajax({
                                                    type: 'POST',
                                                    url: "<?php echo base_url('requiDraft/saveTemp3rdForm'); ?>",
                                                    dataType: 'json',
                                                    data: new FormData($('#requiFormSubmit')[0]),
                                                    contentType: false,
                                                    cache: false,
                                                    processData: false,
                                                    success: function (data) {
                                                        if (data.status) {
                                                            $('#mst_id').val(data.mstid);
                                                            $('#html').html(data.html);
                                                            if (data.mapp_count > 0) {
                                                                $('#custom-tabs-3rd-form-tab').removeClass('disabled');
                                                                $('.prevDetailsBtn').removeClass('d-none');
                                                                $('#prevPdfBtn').removeClass('d-none');
                                                            } else {
                                                                $('#custom-tabs-3rd-form-tab').addClass('disabled');
                                                                $('.prevDetailsBtn').addClass('d-none');
                                                                $('#prevPdfBtn').addClass('d-none');
                                                            }
                                                            resetForm();
                                                            Toast.fire({icon: 'success', title: data.msg});
                                                        } else {
                                                            $('#msg_html').html(data.msg);
                                                            $('#modal_msg').modal('show');
                                                            toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                                                            if (data.logout) {
                                                                window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                            }
                                                        }
                                                        $('#loading').hide();
                                                    }
                                                });
                                            }

                                            function delMappRecord(id) {
                                                $("#deleteTemplateForm #auto_id").remove();
                                                $('#deleteTemplateForm').append("<div class='form-group'><input type='hidden' required='' class='form-control form-control-sm' name='auto_id' id='auto_id' value='" + id + "'/></div>");
                                                $('#modal_del_mapping').modal({backdrop: 'static', keyboard: false});
                                            }

                                            $(document).ready(function () {
                                                $('form[id="deleteTemplateForm"]').validate({
                                                    rules: {
                                                        auto_id: {
                                                            required: true,
                                                            digits: true
                                                        }
                                                    },
                                                    messages: {
                                                        auto_id: {
                                                            required: "Auto ID is required"
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
                                                        comfirmDeleteMapping();
                                                        //$('#loading').show();
                                                    }
                                                });
                                            });
                                            function comfirmDeleteMapping() {
                                                $('#loading').show();
                                                jQuery.ajax({
                                                    type: "POST",
                                                    url: "<?php echo base_url('requiDraft/deleteTempMapping'); ?>",
                                                    dataType: 'json',
                                                    data: $("#deleteTemplateForm").serialize(),
                                                    success: function (data) {
                                                        if (data.status) {
                                                            toastr.success(data.msg, "", {closeButton: true, timeOut: 5000});
                                                            $('#html').html(data.html);
                                                            if (data.mapp_count > 0) {
                                                                $('#custom-tabs-3rd-form-tab').removeClass('disabled');
                                                                $('.prevDetailsBtn').removeClass('d-none');
                                                                $('#prevPdfBtn').removeClass('d-none');
                                                            } else {
                                                                $('#custom-tabs-3rd-form-tab').addClass('disabled');
                                                                $('.prevDetailsBtn').addClass('d-none');
                                                                $('#prevPdfBtn').addClass('d-none');
                                                            }
                                                            $('#modal_del_mapping').modal('hide');
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

                                            function editMappRecord(id) {
                                                $('#loading').show();
                                                jQuery.ajax({
                                                    type: "POST",
                                                    url: "<?php echo base_url('requiDraft/editMappRecord'); ?>",
                                                    dataType: 'json',
                                                    data: {
                                                        id: id,
                                                        type: 'form'
                                                    },
                                                    success: function (data) {
                                                        if (data.status) {
                                                            $('#editMappHTML').html(data.editMappHTML);
                                                            $('#modal_edit_mapped_details').modal({backdrop: 'static', keyboard: false});
                                                            $('.select2').select2();
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


                                            function fChk(checked_id, unchecked_id) {
                                                $('#' + checked_id).prop("checked", true);
                                                $('#' + unchecked_id).prop("checked", false);
                                            }

                                            function jChk(checked_id, unchecked_id) {
                                                $('#' + checked_id).prop("checked", true);
                                                $('#' + unchecked_id).prop("checked", false);
                                            }

                                            function clearForm() {
                                                $('#modal_clear_form').modal({backdrop: 'static', keyboard: false});
                                            }
                                            function resetForm() {
                                                $('#requiFormSubmit')[0].reset();
                                                $('.invalid-feedback').removeClass('invalid-feedback');
                                                $('.is-invalid').removeClass('is-invalid');
                                                $('.is-valid').removeClass('is-valid');
                                                $('.error').remove();
                                                $('.mycustomfile').val('');
                                                $('.removebtn').addClass('d-none');
                                                $('#modal_clear_form').modal('hide');
                                                $('.cat_dis_2').attr('readonly', 'true');
                                                $('#e_total_2_error').html("");
                                                $('.cat_dis_2').removeClass('is-valid is-invalid');
                                                $('#e_total_2').removeClass('is-valid is-invalid');
                                                $('#e_total_2_error').removeClass('error is-valid invalid-feedback');
                                                $('#e_total_2').val(0);
                                                $('.cat_dis_2').val(0);
                                                $('.cat_dis_3').attr('readonly', 'true');
                                                $('#e_total_3_error').html("");
                                                $('.cat_dis_3').removeClass('is-valid is-invalid');
                                                $('#e_total_3').removeClass('is-valid is-invalid');
                                                $('#e_total_3_error').removeClass('error is-valid invalid-feedback');
                                                $('#e_total_3').val(0);
                                                $('.cat_dis_3').val(0);
                                                $('.select2').select2();
                                                $('#excel_data').html('');
                                                $("html, body").animate({scrollTop: $("#tabids").offset().top - 130});
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

                                            function previewRecord(id) {
                                                $('#loading').show();
                                                jQuery.ajax({
                                                    type: "POST",
                                                    url: "<?php echo base_url('requiDraft/viewData'); ?>",
                                                    dataType: 'json',
                                                    data: {
                                                        id: id,
                                                        type: 'form'
                                                    },
                                                    success: function (data) {
                                                        if (data.status) {
                                                            $('#previewDetailsHTML').html(data.previewDetailsHTML);
                                                            $('#modal_preview_details').modal({backdrop: 'static', keyboard: false});
                                                            $('.select2').select2();
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
                                                    url: "<?php echo base_url('requiDraft/printDraft'); ?>",
                                                    dataType: 'json',
                                                    data: {
                                                        id: id,
                                                        type: 'form'
                                                    },
                                                    success: function (data) {
                                                        if (data.status) {
                                                            var h = screen.height;
                                                            var height = (h - 200);
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

                                            function isNumber(evt) {
                                                evt = (evt) ? evt : window.event;
                                                let charCode = (evt.which) ? evt.which : evt.keyCode;
                                                if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                                                    evt.preventDefault();
                                                } else {
                                                    return true;
                                                }
                                            }

                                            $('.breakUpVaccTotal2').keyup(function (event) {
                                                var total = 0;
                                                var inputs = $(".apstUrTot2");
                                                for (var i = 0; i < inputs.length; i++) {
                                                    var val = $(inputs[i]).val();
                                                    if (val) {
                                                        val = parseInt(val.replace(/^\$/, ""));
                                                        total += !isNaN(val) ? val : 0;
                                                    }
                                                }
                                                $('#d_total_2').val(total);
                                            });

                                            function pwdCheck2(value) {
                                                var val = parseInt(value);
                                                if (val > 0) {
                                                    $('#pwdCategoryDiv2').removeClass('d-none');
                                                    $('.cat_dis_2').removeAttr('readonly');
                                                    var total = 0;
                                                    var inputs = $(".cat_dis_2");
                                                    for (var i = 0; i < inputs.length; i++) {
                                                        //  alert($(inputs[i]).val());
                                                        var val = $(inputs[i]).val();
                                                        if (val) {
                                                            val = parseInt(val.replace(/^\$/, ""));
                                                            total += !isNaN(val) ? val : 0;
                                                        }
                                                    }
                                                    $('#e_total_2_error').html("");
                                                    $('#e_total_2').removeClass('is-valid is-invalid');
                                                    $('#e_total_2_error').removeClass('error invalid-feedback');
                                                    $('#e_total_2').val(total);
                                                    var pwdTotal = $('#d_pwd_2').val();
                                                    if (parseInt(total) != parseInt(pwdTotal)) {
                                                        $('#e_total_2_error').html("PwD total is invalid");
                                                        $('#e_total_2').addClass('is-invalid');
                                                        $('#e_total_2_error').addClass('error invalid-feedback');
                                                    } else if (parseInt(total) == parseInt(pwdTotal)) {
                                                        $('#e_total_2').addClass('is-valid');
                                                    }
                                                } else {
                                                    $('#pwdCategoryDiv2').addClass('d-none');
                                                    $('.cat_dis_2').attr('readonly', 'true');
                                                    $('#e_total_2_error').html("");
                                                    $('.cat_dis_2').removeClass('is-valid is-invalid');
                                                    $('#e_total_2').removeClass('is-valid is-invalid');
                                                    $('#e_total_2_error').removeClass('error is-valid invalid-feedback');
                                                    $('#e_total_2').val(0);
                                                    $('.cat_dis_2').val(0);
                                                }
                                            }

                                            $('.cat_dis_2').keyup(function (event) {
                                                var total = 0;
                                                var inputs = $(".cat_dis_2");
                                                for (var i = 0; i < inputs.length; i++) {
                                                    //  alert($(inputs[i]).val());
                                                    var val = $(inputs[i]).val();
                                                    if (val) {
                                                        val = parseInt(val.replace(/^\$/, ""));
                                                        total += !isNaN(val) ? val : 0;
                                                    }
                                                }
                                                $('#e_total_2_error').html("");
                                                $('#e_total_2').removeClass('is-valid is-invalid');
                                                $('#e_total_2_error').removeClass('error invalid-feedback');
                                                $('#e_total_2').val(total);
                                                var pwdTotal = $('#d_pwd_2').val();
                                                if (parseInt(total) != parseInt(pwdTotal)) {
                                                    $('#e_total_2_error').html("PwD total is invalid");
                                                    $('#e_total_2').addClass('is-invalid');
                                                    $('#e_total_2_error').addClass('error invalid-feedback');
                                                } else if (parseInt(total) == parseInt(pwdTotal)) {
                                                    $('#e_total_2').addClass('is-valid');
                                                }
                                            });

                                            $('.breakUpVaccTotal3').keyup(function (event) {
                                                var total = 0;
                                                var inputs = $(".apstUrTot3");
                                                for (var i = 0; i < inputs.length; i++) {
                                                    var val = $(inputs[i]).val();
                                                    if (val) {
                                                        val = parseInt(val.replace(/^\$/, ""));
                                                        total += !isNaN(val) ? val : 0;
                                                    }
                                                }
                                                $('#d_total_3').val(total);
                                            });

                                            function pwdCheck3(value) {
                                                var val = parseInt(value);
                                                if (val > 0) {
                                                    $('#pwdCategoryDiv3').removeClass('d-none');
                                                    $('.cat_dis_3').removeAttr('readonly');
                                                    var total = 0;
                                                    var inputs = $(".cat_dis_3");
                                                    for (var i = 0; i < inputs.length; i++) {
                                                        //  alert($(inputs[i]).val());
                                                        var val = $(inputs[i]).val();
                                                        if (val) {
                                                            val = parseInt(val.replace(/^\$/, ""));
                                                            total += !isNaN(val) ? val : 0;
                                                        }
                                                    }
                                                    $('#e_total_3_error').html("");
                                                    $('#e_total_3').removeClass('is-valid is-invalid');
                                                    $('#e_total_3_error').removeClass('error invalid-feedback');
                                                    $('#e_total_3').val(total);
                                                    var pwdTotal = $('#d_pwd_3').val();
                                                    if (parseInt(total) != parseInt(pwdTotal)) {
                                                        $('#e_total_3_error').html("PwD total is invalid");
                                                        $('#e_total_3').addClass('is-invalid');
                                                        $('#e_total_3_error').addClass('error invalid-feedback');
                                                    } else if (parseInt(total) == parseInt(pwdTotal)) {
                                                        $('#e_total_3').addClass('is-valid');
                                                    }
                                                } else {
                                                    $('#pwdCategoryDiv3').addClass('d-none');
                                                    $('.cat_dis_3').attr('readonly', 'true');
                                                    $('#e_total_3_error').html("");
                                                    $('.cat_dis_3').removeClass('is-valid is-invalid');
                                                    $('#e_total_3').removeClass('is-valid is-invalid');
                                                    $('#e_total_3_error').removeClass('error is-valid invalid-feedback');
                                                    $('#e_total_3').val(0);
                                                    $('.cat_dis_3').val(0);
                                                }
                                            }

                                            $('.cat_dis_3').keyup(function (event) {
                                                var total = 0;
                                                var inputs = $(".cat_dis_3");
                                                for (var i = 0; i < inputs.length; i++) {
                                                    //  alert($(inputs[i]).val());
                                                    var val = $(inputs[i]).val();
                                                    if (val) {
                                                        val = parseInt(val.replace(/^\$/, ""));
                                                        total += !isNaN(val) ? val : 0;
                                                    }
                                                }
                                                $('#e_total_3_error').html("");
                                                $('#e_total_3').removeClass('is-valid is-invalid');
                                                $('#e_total_3_error').removeClass('error invalid-feedback');
                                                $('#e_total_3').val(total);
                                                var pwdTotal = $('#d_pwd_3').val();
                                                if (parseInt(total) != parseInt(pwdTotal)) {
                                                    $('#e_total_3_error').html("PwD total is invalid");
                                                    $('#e_total_3').addClass('is-invalid');
                                                    $('#e_total_3_error').addClass('error invalid-feedback');
                                                } else if (parseInt(total) == parseInt(pwdTotal)) {
                                                    $('#e_total_2').addClass('is-valid');
                                                }
                                            });

                                            function modeOfRec(value) {
                                                $('#directRecuDiv').addClass('d-none');
                                                $('#LDCERecDiv').addClass('d-none');
                                                if (value == 'D') {
                                                    $('#directRecuDiv').removeClass('d-none');
                                                } else {
                                                    $('#LDCERecDiv').removeClass('d-none');
                                                }
                                                //LDCERecDiv
                                            }

                                            function freshRequisition() {
                                                $('#modal_fresh_requisition').modal({backdrop: 'static', keyboard: false});
                                            }

                                            function freshForm() {
                                                $('#freshRequisition').submit();
                                            }

                                            function loadCriteriaEligibility(postname) {
                                                $('#loading').show();
                                                $('#m_crit_elig_3').html('Loading..');
                                                $('#m_crit_elig_3').append('<option value=""> -Select- </option>');
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
                                                                    $('#m_crit_elig_3').append('<option value="' + data_dept['auto_id'] + '">' + data_dept['eligibility'] + '</option>');
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
                                                    $('#m_crit_elig_3').addClass('invalid-feedback');
                                                    $('#m_crit_elig_3').addClass('is-invalid');
                                                    $('#m_crit_elig_3').removeClass('is-valid');
                                                    $('#m_crit_elig_3').addClass('error');
                                                }
                                            }
</script>

<script>
    const excel_file = document.getElementById('fileInput_o_3');
    excel_file.addEventListener('change', (event) => {
        var reader = new FileReader();
        reader.readAsArrayBuffer(event.target.files[0]);
        reader.onload = function (event) {
            var data = new Uint8Array(reader.result);
            var work_book = XLSX.read(data, {type: 'array'});
            var sheet_name = work_book.SheetNames;
            var sheet_data = XLSX.utils.sheet_to_json(work_book.Sheets[sheet_name[0]], {header: 1});
            if (sheet_data.length > 0) {
                var table_output = '<table class="table text-sm table-striped table-bordered">';
                for (var row = 0; row < sheet_data.length; row++) {
                    table_output += '<tr>';
                    for (var cell = 0; cell < sheet_data[row].length; cell++) {
                        if (row == 0) {
                            table_output += '<th>' + sheet_data[row][cell] + '</th>';
                        } else {
                            table_output += '<td>' + sheet_data[row][cell] + '</td>';
                        }
                    }
                    table_output += '</tr>';
                }
                table_output += '</table>';
                document.getElementById('excel_data').innerHTML = table_output;
            }

        }
    });
</script>