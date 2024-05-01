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

    #approval_heading th {
        padding-top: 5px;
        padding-bottom: 5px;
        text-align: left;
        background-color: green;
        color: white;
    }
    .hide{
        display: none;
    }    
</style>
<div class="box-body" id="">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="adv_date" class="">Advertisement Date (DD/MM/YYYY) <span class="text-danger">*</span></label>
                <div class="input-group" id="reservationdate" data-target-input="nearest">
                    <input type="text" class="form-control form-control-sm" autocomplete="off" id="adv_date" name="adv_date" data-target="#reservationdate"  data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" placeholder="dd/mm/yyyy" data-mask/>
                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
        </div>                                            
<!-- <p id="adv_postname"></p>-->
    </div>
    <?php
    $d_ur = 0;
    $d_apst = 0;
    $d_pwd = 0;
    $d_ex_sm = 0;
    if ($mData != NULL) {
        foreach ($mData as $mRow) {
            $modeRecName = 'DIRECT RECRUITMENT';
            $clsName = 'badge-success';
            $modeRec = $mRow->c_mode_recruitment;
            if ($modeRec == "L") {
                $modeRecName = 'LDCE RECRUITMENT';
                $clsName = 'badge-danger';
            }
            $d_ur = $mRow->d_ur;
            $d_apst = $mRow->d_apst;
            $d_pwd = $mRow->d_pwd;
            $d_ex_sm = $mRow->d_ex_sm;
            ?>
            <fieldset class="scheduler-border">
                <legend class="scheduler-border"><span class="badge <?php echo $clsName; ?>"><?php echo $modeRecName; ?></span></legend>
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
            </fieldset>

            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Vacancy Details</legend>
                <form role="form" autocomplete="off" id="fillPostAdvertised" name="fillPostAdvertised" method="post">
                    <input type="hidden" class="form-control form-control-sm" id="vf_auto_id" name="vf_auto_id" required="" value="<?php echo $id ?>" >
                    <div class="row" style="overflow-x: auto;">

                        <div class="col-sm-12">
                            <div class="form-group">
                                <table id="approval" style="width:100%;" border="0">
                                    <tr>
                                        <th style="width: 50%">Category</th>
                                        <th style="width: 10%;text-align: center">Total Vacancy</th>
                                        <th style="width: 30%;text-align: center">Recommended</th>
                                        <th style="width: 10%;text-align: center">Residual</th>
                                    </tr>
                                    <tr>
                                        <td><b style="">Unreserved  </b></td>
                                        <td style="text-align: center;font-weight: bold"><?php echo $d_ur; ?></td>                                        
                                        <td class="form-group"><input type="text" min="0" max="<?php echo $d_ur; ?>" onkeypress="isNumberU(event)" onkeyup="checkRecValue('res_ur', this.value, '<?php echo $mRow->d_ur; ?>')" onblur="checkRecValue('res_ur', this.value, '<?php echo $mRow->d_ur; ?>')" value="<?php echo $mRow->rec_ur; ?>" class="default-zero form-control form-control-sm" id="rec_ur" name="rec_ur" placeholder="Unreserved"></td>
                                        <td style="text-align: center;font-weight: bold" id="res_ur"><?php echo ($d_ur - $mRow->rec_ur); ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>APST </b></td>
                                        <td style="text-align: center;font-weight: bold"><?php echo $d_apst; ?></td>
                                        <td class="form-group"><input type="text" min="0" max="<?php echo $d_apst; ?>" onkeypress="isNumberU(event)"  onkeyup="checkRecValue('res_apst', this.value, '<?php echo $mRow->d_apst; ?>')" onblur="checkRecValue('res_apst', this.value, '<?php echo $mRow->d_apst; ?>')" value="<?php echo $mRow->rec_apst; ?>" class="default-zero form-control form-control-sm" id="rec_apst" name="rec_apst" placeholder="APST"></td>
                                        <td style="text-align: center;font-weight: bold" id="res_apst"><?php echo ($d_apst - $mRow->rec_apst); ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>PwD </b></td>
                                        <td style="text-align: center;font-weight: bold"><?php echo $d_pwd; ?></td>
                                        <td class="form-group"><input type="text" min="0" max="<?php echo $d_pwd; ?>" onkeypress="isNumberU(event)" onkeyup="checkRecValue('res_pwd', this.value, '<?php echo $mRow->d_pwd; ?>')" onblur="checkRecValue('res_pwd', this.value, '<?php echo $mRow->d_pwd; ?>')" value="<?php echo $mRow->rec_pwd; ?>" class="default-zero form-control form-control-sm" id="rec_pwd" name="rec_pwd" placeholder="PwD"></td>
                                        <td style="text-align: center;font-weight: bold" id="res_pwd"><?php echo ($d_pwd - $mRow->rec_pwd); ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Ex-Serviceman </b></td>
                                        <td style="text-align: center;font-weight: bold"><?php echo $d_ex_sm; ?></td>
                                        <td class="form-group"><input type="text" min="0" max="<?php echo $d_ex_sm; ?>" onkeypress="isNumberU(event)" onkeyup="checkRecValue('res_ex_sm', this.value, '<?php echo $mRow->d_ex_sm; ?>')" onblur="checkRecValue('res_ex_sm', this.value, '<?php echo $mRow->d_ex_sm; ?>')" value="<?php echo $mRow->rec_ex_sm; ?>" class="default-zero form-control form-control-sm" id="rec_ex_sm" name="rec_ex_sm" placeholder="Ex-SM"></td>
                                        <td style="text-align: center;font-weight: bold" id="res_ex_sm"><?php echo ($d_ex_sm - $mRow->rec_ex_sm); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <b> Breakup of vacancy </b>(Horizontal vacancy- The vacancies should be inclusive of total vacancy)
                            </div>
                        </div>
                    </div>
                    <div class="row float-right">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <button type="submit" title="Save Changes" id="saveChangesBtn" name="saveChangesBtn" class="btn btn-sm btn-outline-info"> <i class="fa fa-check"></i> Save Changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </fieldset>

            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Add Recommended Details (<b><?php echo $id ?></b>)</legend>
                <form role="form" id="addDraftRecommendedForm" name="addDraftRecommendedForm" method="post" autocomplete="off">
                    <input type="hidden" class="form-control form-control-sm" id="rec_auto_id" name="rec_auto_id" required="" value="<?php echo $id ?>" >
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="full_name">Candidate Full Name <span class="text-danger"> *</span></label>
                                <input type="text" title="Full Name" class="form-control form-control-sm text-uppercase alphabetsspaceonly" value="" id="full_name" name="full_name"  maxlength="65" minlength="2" placeholder="Full Name">
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="roll_no">Roll No <span class="text-danger"> *</span></label>
                                <input type="text" title="Roll No" onkeypress="isNumberR(event)" class="form-control text-uppercase form-control-sm digitsonly" value="" id="roll_no" name="roll_no"  maxlength="7" minlength="7" placeholder="Roll No">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="dob">DOB(DD/MM/YYYY) <span class="text-danger"> *</span></label>
                                <div class="input-group">
                                    <input type="text" title="DD/MM/YYYY" class="form-control text-uppercase form-control-sm" value="" id="dob" name="dob"  maxlength="10" minlength="10"  placeholder="DD/MM/YYYY">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-calendar"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="father_name">Father Name <span class="text-danger"> *</span></label>
                                <input type="text" title="Father Name" class="form-control form-control-sm text-uppercase alphabetsspaceonly" value="" id="father_name" name="father_name"  maxlength="65" minlength="2"  placeholder="Father Name">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="category_allot">Category Allot <span class="text-danger"> *</span></label>
                                <select class="form-control form-control-sm" name="category_allot" id="category_allot"  style="width: 100%;">
                                    <option value="UR">UR</option>
                                    <option value="APST">APST</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="is_pwd">PwD <span class="text-danger"> *</span></label>
                                <select class="form-control form-control-sm" name="is_pwd" id="is_pwd"  style="width: 100%;">
                                    <option value="N">No</option>
                                    <option value="Y">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="is_ex_sm">Ex-SM <span class="text-danger"> *</span></label>
                                <select class="form-control form-control-sm" name="is_ex_sm" id="is_ex_sm"  style="width: 100%;">
                                    <option value="N">No</option>
                                    <option value="Y">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="file_copy_fileInput_n_3" class="">Upload dossier (in pdf format) <span class="text-danger">*</span></label>
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
                                            <input type="file"  id="fileInput_n_3" name="file_n_3" onchange="return fileValidation('fileInput_n_3')" class="file_input">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <button type="submit" title="Add Details" id="add_details_btn" class="btn btn-sm btn-outline-danger"> <i class="fa fa-plus-circle"></i> Add Details</button>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>                                               
                    </div>
                    <!--
                                        <div class="row float-left">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <button type="submit" title="Add Details" class="btn btn-sm btn-outline-danger"> <i class="fa fa-plus-circle"></i> Add Details</button>
                                                </div>
                                            </div>
                                        </div>
                    -->
                </form>

                <div class="row float-right">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <button type="button" title="Upload Excel File" id="upload_excel_file_btn" onclick="showFileUpload('modal_upload_excel')" class="btn btn-sm btn-outline-primary"> <i class="fa fa-file-excel"></i> Upload Excel File</button>
                            <button type="button" title="Upload Dossiers Files" onclick="showFileUpload('modal_upload_pdf')" class="btn btn-sm btn-outline-danger"> <i class="fa fa-file-pdf-o"></i> Upload Dossiers(PDF Format)</button>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Recommended Details List</legend>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div id="draftRecommendedListHTML"></div>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Dossiers List</legend>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div id="draftDossiersListHTML">

                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <?php
        }
        ?>

        <div class="modal-footer">
            <div class="row">
                <div class="col-sm-12 ml-4">
                    <button type="button" title="Send To Department" id="send_to_dept_btn" name="send_to_dept_btn" onclick="sendToDepartment('<?php echo $mRow->auto_id ?>')" class="btn btn-outline-info"> <i class="fa fa-check"></i> Send To Department</button>
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        <?php }
        ?>
    </div><!-- /.box-body -->
</div>

<div class="row">
    <div class="modal fade" id="modal_upload_excel">
        <div class="modal-dialog">
            <div class="modal-body">
                <form role="form" autocomplete="off" id="importDraftRecommendedDataForm" name="importDraftRecommendedDataForm" method="POST"  enctype="multipart/form-data">
                    <input type="hidden" class="form-control form-control-sm" id="rec_auto_id_excel" name="rec_auto_id_excel" required="" value="<?php echo $id ?>" >
                    <div class="modal-content card card-primary card-outline">
                        <div class="card-header">                       
                            <div class="float-left">
                                <i class="fa fa-file-excel text-success"></i> Upload Excel File
                            </div>
                            <div class="float-right">
                                <a href="javascript:closeModal('modal_upload_excel')" class="text-danger" title="Close"><i class="fa fa-times-circle"></i></a>
                            </div>                                        
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="file_copy_fileInput_o_3" class="">Upload detailed list of eligible candidates (in xls|xlsx format) <span class="text-danger">*</span><a href="<?php echo base_url('assets/ors/storage/performa/sample_recommended_file.xlsx') ?>" target="_self"> Download sample file</a></label>
                                        <div class="row">
                                            <div class="col-md-12">
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
                                                    <input type="file"  id="fileInput_o_3" name="file_o_3" required="" onchange="return fileValidation('fileInput_o_3')" class="file_input">
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
                                <a href="javascript:closeModal('modal_upload_excel')" title="Close" class="btn btn-sm btn-outline-danger"><i class="fa fa-times"></i> Close</a>
                            </div>                  
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>                
</div>

<div class="row">
    <div class="modal fade" id="modal_upload_pdf">
        <div class="modal-dialog modal-lg">
            <div class="modal-body">
                <form role="form" autocomplete="off" id="uploadDossierFilesForm" name="uploadDossierFilesForm" method="POST"  enctype="multipart/form-data">
                    <input type="hidden" class="form-control form-control-sm" id="rec_auto_id_pdf" name="rec_auto_id_pdf" required="" value="<?php echo $id ?>" >
                    <div class="modal-content card card-primary card-outline">
                        <div class="card-header">                       
                            <div class="float-left">
                                <i class="fa fa-file-pdf-o text-danger"></i> Upload Dossiers
                            </div>
                            <div class="float-right">
                                <a href="javascript:closeModal('modal_upload_pdf')" class="text-danger" title="Close"><i class="fa fa-times-circle"></i></a>
                            </div>                                        
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="file_copy_fileInput_d_3" class="">Upload dossiers (in pdf format) <span class="text-danger">*</span></label>
                                        <span>File Name :<b> RollNo.pdf (Eg: 1000001.pdf)</b></span>
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
                                                    <input type="file"  id="fileInput_d_3" name="file_d_3[]" required="" multiple="" onchange="fileDetails('fileInput_d_3')" class="">
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
                            <div class="row" id="fileSelectedRow"></div>

                        </div>
                        <!-- /.card-body -->
                        <div class="row card-footer justify-content-end">
                            <div class="card-tools">
                                <button title="Upload Dossiers" type="submit" id="uploadFilesSubmitBtn" name="uploadFilesSubmitBtn" disabled="" class="btn btn-sm btn-outline-primary"><i class="fa fa-arrow-circle-o-up ml-2"></i> Upload Dossiers</button>
                                <a href="javascript:closeModal('modal_upload_pdf')" title="Close" class="btn btn-sm btn-outline-danger"><i class="fa fa-times"></i> Close</a>
                            </div>                  
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>                
</div>

<div class="row">
    <div class="modal fade" id="modal_send_to_dept">
        <div class="modal-dialog">
            <div class="modal-body">
                <form role="form" autocomplete="off" id="sendReccToDeptForm" name="sendReccToDeptForm" method="post">
                    <div class="modal-content card card-primary card-outline">
                        <div class="card-header">                       
                            <div class="float-left">
                                Confirmation?
                            </div>
                            <div class="float-right">
                                <a href="javascript:closeModal('modal_send_to_dept')" class="text-danger" title="Close"><i class="fa fa-times-circle"></i></a>
                            </div>                                        
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <p>Do you really wants to send recommended to department..?</p>
                        </div>
                        <!-- /.card-body -->
                        <div class="row card-footer justify-content-end">
                            <div class="card-tools">
                                <button title="Confirm Send" type="button" onclick="confirmSendToDept()" class="btn btn-sm btn-outline-primary"><i class="fa fa-check ml-2"></i> Send To Department</button>
                                <a href="javascript:closeModal('modal_send_to_dept')" title="Close" class="btn btn-sm btn-outline-danger"><i class="fa fa-times"></i> Close</a>
                            </div>                  
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>                
</div>
<script>
    $('[data-mask]').inputmask()

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'DD/MM/YYYY'
    });

</script>
<script>
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

        if (id == "fileInput_o_3") {
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

    function isNumberU(evt) {
        evt = (evt) ? evt : window.event;
        let charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
            evt.preventDefault();
        } else {
            return true;
        }
    }

    function checkRecValue(nxt_id, cur_val, tot_val) {
        var curVal = parseInt(cur_val);
        var totVal = parseInt(tot_val);
        if (curVal >= 0) {
            var resVal = (totVal - curVal);
            $('#' + nxt_id).html(resVal);
        } else {
            $('#' + nxt_id).html(totVal);
        }
    }

    function isNumberR(evt) {
        evt = (evt) ? evt : window.event;
        let charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
            evt.preventDefault();
        } else {
            return true;
        }
    }

    $(document).ready(function () {
        draftRecommendedList('<?php echo $id; ?>');
        draftDossiersList('<?php echo $id; ?>');
        var field = $('.default-zero');
        field.blur(function () {
            if (this.value === "") {
                this.value = '0';
                var idd = this.id;
                $('#' + idd).removeClass('is-invalid');
            }
        });
        $('form[id="fillPostAdvertised"]').validate({
            rules: {
                "rec_ur": {
                    required: true,
                    digits: true,
                    min: [0]
                },
                "rec_apst": {
                    required: true,
                    digits: true,
                    min: [0]
                },
                "rec_pwd": {
                    required: true,
                    digits: true,
                    min: [0]
                },
                "rec_ex_sm": {
                    required: true,
                    digits: true,
                    min: [0]
                }
            },
            messages: {
                "rec_ur": {
                    required: "Unserved is required"
                },
                "rec_apst": {
                    required: "APST is required"
                },
                "rec_pwd": {
                    required: "Total is required"
                },
                "rec_ex_sm": {
                    required: "PwD is required"
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
                fillPostAdvertised();
                //$('#loading').show();
            }
        });

        $('form[id="addDraftRecommendedForm"]').validate({
            rules: {
                "full_name": {
                    required: true,
                    alphaspace: true
                },
                "roll_no": {
                    required: true,
                    digits: true
                },
                "dob": {
                    required: true
                },
                "father_name": {
                    required: true,
                    alphaspace: true
                },
                "category_allot": {
                    required: true
                },
                "is_pwd": {
                    required: true
                },
                "is_ex_sm": {
                    required: true
                },
                "file_copy_n_3": {
                    required: false
                }
            },
            messages: {
                "full_name": {
                    required: "Full name is required",
                    alphaspace: "Only alphabet and space allowed"
                },
                "roll_no": {
                    required: "Roll no is required"
                },
                "dob": {
                    required: "DOB is required"
                },
                "father_name": {
                    required: "Father name is required",
                    alphaspace: "Only alphabet and space allowed"
                },
                "category_allot": {
                    required: "Select Cat Allot"
                },
                "is_pwd": {
                    required: "Select PwD"
                },
                "is_ex_sm": {
                    required: "Select Ex-SM"
                },
                "file_copy_n_3": {
                    required: "Select dossier file"
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
                saveDraftRecommendedForm();
                //$('#loading').show();
            }
        });

        $('form[id="importDraftRecommendedDataForm"]').validate({
            rules: {
                "rec_auto_id_excel": {
                    required: true,
                    digits: true
                },
                "file_copy_o_3": {
                    required: true
                },
                "file_o_3": {
                    required: true
                }
            },
            messages: {
                "file_copy_o_3": {
                    required: "Select excel file"
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
                importDraftRecommendedData();
                //$('#loading').show();
            }
        });
        $('form[id="uploadDossierFilesForm"]').validate({
            rules: {
                "rec_auto_id_pdf": {
                    required: true,
                    digits: true
                },
                "file_copy_d_3": {
                    required: true
                },
                "file_d_3": {
                    required: true
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
                uploadDossierFiles();
                //$('#loading').show();
            }
        });
    });

    function importDraftRecommendedData() {
        $('#loading').show();
        var fi = $("#fileInput_o_3").val();
        if (fi != "") {
            $('#importDraftRecommendedDataForm .progress').removeClass('hide');
        } else {
            $('#importDraftRecommendedDataForm .progress').addClass('hide');
        }
        $.ajax({
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        $("#importDraftRecommendedDataForm .progress-bar").width(percentComplete + '%');
                        $("#importDraftRecommendedDataForm .progress-bar").html(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            async: true,
            type: 'POST',
            url: "<?php echo base_url('recommendedDraft/importDraftRecommendedData'); ?>",
            dataType: 'json',
            data: new FormData($('#importDraftRecommendedDataForm')[0]),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $("#importDraftRecommendedDataForm .progress-bar").width('0%');
            },
            error: function () {
                $('#loading').hide();
                $('#importDraftRecommendedDataForm .uploadStatus').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');
            },
            success: function (data) {
                if (data.status) {
                    draftRecommendedList('<?php echo $id; ?>');
                    draftDossiersList('<?php echo $id; ?>');
                    $('#modal_upload_excel').modal('hide');
                    $('#importDraftRecommendedDataForm .progress').addClass('hide');
                    $('#importDraftRecommendedDataForm')[0].reset();
                    Toast.fire({icon: 'success', title: data.msg});
                } else {
                    $('#importDraftRecommendedDataForm .progress').addClass('hide');
                    toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                    if (data.logout) {
                        window.location.href = "<?php echo base_url('page?name=home'); ?>";
                    }
                }
                $('#loading').hide();
            }
        });

    }

    function saveDraftRecommendedForm() {
        $('#loading').show();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('recommendedDraft/saveDraftRecommendedForm'); ?>",
            dataType: 'json',
            data: new FormData($('#addDraftRecommendedForm')[0]),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data.status) {
                    resetForm();
                    draftRecommendedList('<?php echo $id; ?>');
                    draftDossiersList('<?php echo $id; ?>');
                    Toast.fire({icon: 'success', title: data.msg});
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

    function resetForm() {
        $('#addDraftRecommendedForm')[0].reset();
        $('.invalid-feedback').removeClass('invalid-feedback');
        $('.is-invalid').removeClass('is-invalid');
        $('.is-valid').removeClass('is-valid');
        $('.error').remove();
        $('.mycustomfile').val('');
        $('.file_input').val('');
        $('.removebtn').addClass('d-none');
    }

    function fillPostAdvertised() {
        $('#loading').show();
        jQuery.ajax({
            type: "POST",
            url: "<?php echo base_url('requiAdvertised/fillPostAdvertised'); ?>",
            dataType: 'json',
            data: $("#fillPostAdvertised").serialize(),
            success: function (data) {
                if (data.status) {
                    Toast.fire({icon: 'success', title: data.msg});
                    draftReccTable.draw();
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

    function showFileUpload(id) {
        $('#' + id + ' .invalid-feedback').removeClass('invalid-feedback');
        $('#' + id + ' .is-invalid').removeClass('is-invalid');
        $('#' + id + ' .is-valid').removeClass('is-valid');
        $('#' + id + ' .error').remove();
        $('#' + id + ' .mycustomfile').val('');
        $('#' + id + ' .uploadStatus').html('');
        $('#' + id + ' .removebtn').addClass('d-none');
        $('.file_input').val('');
        $('#uploadFilesSubmitBtn').prop("disabled", true);
        $('#fileSelectedRow').html('');
        $('#' + id).modal({backdrop: 'static', keyboard: false});
    }
</script>

<script>

    function bytesToSize(bytes) {
        var sizes = ['bytes', 'KB', 'MB', 'GB', 'TB', 'P'];
        for (var i = 0; i < sizes.length; i++) {
            if (bytes <= 1024) {
                return bytes + ' ' + sizes[i];
            } else {
                bytes = parseFloat(bytes / 1024).toFixed(2);
            }
        }
        return bytes + ' P';
    }

    function fileDetails(id) {
        $('#uploadFilesSubmitBtn').prop("disabled", true);
        var attachments = document.getElementById("fileInput_d_3").files;
        var selFilesHTML = "";
        var fileLength = 0;
        var fileBuffer = new DataTransfer();
        // append the file list to an array iteratively
        for (var i = 0; i < attachments.length; i++) {
            var fname = attachments.item(i).name;
            var value = attachments.item(i).size;
            var size = bytesToSize(value);

            var fext = (fname.substr((fname.lastIndexOf('.') + 1))).toLowerCase();
            if (fext == 'pdf') {
                var chkFlag = dbRollNos.includes(fname); // true 
                fileBuffer.items.add(attachments[i]);
                selFilesHTML += '<div class="col-sm-4">';
                if (chkFlag) {
                    selFilesHTML += '<div class="alert alert-light alert-dismissible">';
                    selFilesHTML += '<button style="color:black" type="button" onClick="remFile(' + i + ')" class="close btn btn-sm" data-dismiss="alert" aria-hidden="true"><i class="fa fa-trash"></i></button>';
                } else {
                    selFilesHTML += '<div class="alert alert-danger alert-dismissible">';
                    selFilesHTML += '<button style="color:white" type="button" onClick="remFile(' + i + ')" class="close btn btn-sm" data-dismiss="alert" aria-hidden="true"><i class="fa fa-trash"></i></button>';
                }
                selFilesHTML += '<i class="fa fa-file-pdf-o"></i> ' + fname + ' ( ' + size + ' )';
                selFilesHTML += '</div>';
                selFilesHTML += '</div>';
                fileLength++;
            }
        }

        document.getElementById("fileInput_d_3").files = fileBuffer.files;
        if (fileLength <= 0) {
            $('#file_copy_' + id).val('Select File (pdf) only');
            $("#fileInput_d_3").val("");
        } else if (fileLength == 1) {
            $('#file_copy_' + id).val('Total Selected Files : ' + fileLength);
            $('#fileSelectedRow').html(selFilesHTML);
            $('#uploadFilesSubmitBtn').removeAttr('disabled');
            /*
             $('#fileSelectedRow').html("");
             $('#uploadFilesSubmitBtn').removeAttr('disabled');
             $('#remove_btn_' + id).removeClass('d-none');
             $('#file_copy_' + id).val(attachments.item(0).name);
             */
        } else if (fileLength > 1) {
            $('#file_copy_' + id).val('Total Selected Files : ' + fileLength);
            $('#fileSelectedRow').html(selFilesHTML);
            $('#uploadFilesSubmitBtn').removeAttr('disabled');
        }
    }

    function remFile(index) {
        var attachments = document.getElementById("fileInput_d_3").files;
        var fileBuffer = new DataTransfer();
        // append the file list to an array iteratively
        for (let i = 0; i < attachments.length; i++) {
            // Exclude file in specified index
            if (index !== i)
                fileBuffer.items.add(attachments[i]);
        }
        // Assign buffer to file input
        document.getElementById("fileInput_d_3").files = fileBuffer.files;
        fileDetails('fileInput_d_3');
    }

    function uploadDossierFiles() {
        $('#loading').show();
        var fi = $("#fileInput_d_3").val();
        if (fi != "") {
            $('#uploadDossierFilesForm .progress').removeClass('hide');
        } else {
            $('#uploadDossierFilesForm .progress').addClass('hide');
        }
        $.ajax({
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        $("#uploadDossierFilesForm .progress-bar").width(percentComplete + '%');
                        $("#uploadDossierFilesForm .progress-bar").html(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            async: true,
            type: 'POST',
            url: "<?php echo base_url('dossierFiles/uploadDossierFiles'); ?>",
            dataType: 'json',
            data: new FormData($('#uploadDossierFilesForm')[0]),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $("#uploadDossierFilesForm .progress-bar").width('0%');
            },
            error: function () {
                $('#loading').hide();
                $('#uploadDossierFilesForm .uploadStatus').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');
            },
            success: function (data) {
                if (data.status) {
                    $('#modal_upload_pdf').modal('hide');
                    $('#uploadDossierFilesForm .progress').addClass('hide');
                    $('#uploadDossierFilesForm')[0].reset();
                    $('#uploadFilesSubmitBtn').prop("disabled", true);
                    $('#fileSelectedRow').html('');
                    Toast.fire({icon: 'success', title: data.msg});
                    draftDossiersList('<?php echo $id; ?>');
                    draftReccTable.draw();
                } else {
                    $('#uploadDossierFilesForm .progress').addClass('hide');
                    toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                    if (data.logout) {
                        window.location.href = "<?php echo base_url('page?name=home'); ?>";
                    }
                }
                $('#loading').hide();
            }
        });
    }

    function draftRecommendedList(id) {
        $('#loading').show();
        jQuery.ajax({
            type: "POST",
            url: "<?php echo base_url('recommendedDraft/draftRecommendedList'); ?>",
            dataType: 'json',
            data: {
                id: id
            },
            success: function (data) {
                if (data.status) {
                    $('#draftRecommendedListHTML').html(data.draftRecommendedListHTML);
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

    function viewFile(fileUrl) {
        var h = screen.height;
        var height = (h - 250);
        var pdflink = '<embed src="<?php echo base_url('assets/pdfjs/web/viewer.html?file=') ?>' + fileUrl + '" frameborder="0" width="100%" height="' + height + '"/>';
        $('#pdfLink').html(pdflink);
        $('#modal_view_file').modal({backdrop: 'static', keyboard: false});
    }

    function draftDossiersList(id) {
        jQuery.ajax({
            type: "POST",
            url: "<?php echo base_url('dossierFiles/draftDossiersList'); ?>",
            dataType: 'json',
            data: {
                id: id
            },
            success: function (data) {
                if (data.status) {
                    $('#draftDossiersListHTML').html(data.draftDossiersListHTML);
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

    function sendToDepartment(auto_id) {
        $("#sendReccToDeptForm #auto_id").remove();
        $('#sendReccToDeptForm').append("<input type='hidden' name='auto_id' id='auto_id' value='" + auto_id + "' required=''/>");
        $('#modal_send_to_dept').modal('show');
    }

    function confirmSendToDept() {
        $('#loading').show();
        // Ajax post
        jQuery.ajax({
            type: "POST",
            url: "<?php echo base_url('recommendedDraft/sendRecommendedToDepartment'); ?>",
            dataType: 'json',
            data: $("#sendReccToDeptForm").serialize(),
            success: function (data) {
                if (data.status) {
                    Toast.fire({icon: 'success', title: data.msg});
                    closeModal('modal_recommended');
                    $('#modal_send_to_dept').modal('hide');
                    myTable.draw();
                } else {
                    toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                }
                $('#loading').hide();
            }
        });
    }
</script>
