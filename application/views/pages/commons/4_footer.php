<style>
    .modal_lock_screen {
        background-color: rgba(255,255,255,0.5);
    }
</style>
<div class="row">
    <div class="modal fade" id="modal_view_file">
        <div class="modal-dialog modal-xl">
            <div class="modal-body">
                <div class="modal-content card card-primary card-outline">
                    <div class="card-header">                       
                        <div class="float-left">
                            File Details
                        </div>
                        <div class="float-right">
                            <a href="javascript:closeModal('modal_view_file')" class="close btn btn-sm" title="Close">
                                <span aria-hidden="true">X Close</span>
                            </a>
                        </div>                                        
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" id="pdfLink">                        
                    </div>
                    <!-- /.card-body -->
                </div>               
            </div>
        </div>
    </div>                
</div>
<div class="row">
    <div class="modal fade modal_lock_screen" id="modal_lock_screen">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-info">
                <div class="modal-body">
                    <!-- User name -->
                    <div class="lockscreen-name" style="text-align: center;font-weight: bold;margin-top: 20px;"><?php echo $this->session->userdata('fullname'); ?></div>
                    <div class="lockscreen-wrapper" style="margin-top:20px">
                        <!-- START LOCK SCREEN ITEM -->
                        <div class="lockscreen-item" style="margin-left: 10px;width: 100%;">
                            <!-- lockscreen image -->
                            <div class="lockscreen-image">
                                <img src="<?php echo base_url('assets/images/no_img.png'); ?>" class="user-image img-circle elevation-2" alt="User">
                            </div>
                            <!-- /.lockscreen-image -->
                            <!-- lockscreen credentials (contains the form) -->
                            <div class="lockscreen-credentials">
                                <div class="input-group">
                                    <input name="user_pwd" value="" id="user_pwd" type="password" class="form-control" placeholder="PASSWORD">
                                    <div class="input-group-append">
                                        <button type="button" onclick="showHidePwd('user_pwd')" class="btn"><i class="fas fas fa-eye user_pwd"></i></button>
                                        <button type="button" onclick="unLockScreen()" class="btn"><i class="fas fa-arrow-right text-muted"></i></button>
                                    </div>                        
                                </div>                    
                            </div>
                            <!-- /.lockscreen credentials -->
                        </div>
                        <div class="help-block text-center">
                            <span id=login_error style="color:red;font-size:13px;font-weight: bold"></span>  
                        </div>
                        <!-- /.lockscreen-item -->
                        <div class="help-block text-center">
                            Enter your password to retrieve your session
                        </div>
                        <div class="text-center">
                            <a style="color:white;font-size:13px;font-weight: bold" href="<?php echo base_url('user/logOut') ?>">Or sign in as a different user</a>
                        </div>
                        <br/>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2022-2023 <a href="javascript:void(0)">APSSB</a>.</strong> All rights reserved.
</footer>
<aside class="control-sidebar control-sidebar-dark ">

</aside>
</div>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/sweetalert2/sweetalert2.all.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/toastr/toastr.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/select2/js/select2.full.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/moment/moment.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/inputmask/jquery.inputmask.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/dist/js/adminlte.min.js') ?>"></script>
<?php
$screenlock = $this->session->userdata('screenlock');
if ($screenlock) {
    echo "<script language=\"javascript\">$('#modal_lock_screen').modal({backdrop: 'static',keyboard: false});</script>";
}
?>
<script>
                                            var currentDatetime = "";
                                            $(document).on('hidden.bs.modal', function (event) {
                                                if ($('.modal:visible').length) {
                                                    $('body').addClass('modal-open');
                                                }

                                            });
                                            $('.select2').select2();
                                            var offline = 2;
                                            var online = 2;
                                            var Toast = Swal.mixin({
                                                toast: true,
                                                position: "top",
                                                showConfirmButton: false,
                                                timer: 5000
                                            });

                                            $(document).ready(function () {
                                                $('#loading').hide();
                                                //$('#modal-lock-screen_back').modal('show');
                                                "<?php $currDT = date('Y-m-d h:i:s'); ?>";
                                                currentDatetime = '<?php echo $currDT; ?>';
                                                "<?php $this->session->set_userdata("oldDateTime", $currDT); ?>";
                                                var field = $('.default-zero');
                                                field.blur(function () {
                                                    if (this.value === "") {
                                                        this.value = '0';
                                                        var idd = this.id;
                                                        $('#' + idd).removeClass('is-invalid');
                                                    }
                                                });

                                                setInterval(function () {
                                                    isOnline()
                                                }, 5000);
                                            });

                                            function isOnline() {
                                                if (navigator.onLine) {
                                                    offline = 1;
                                                    if (online == 1) {
                                                        Toast.fire({icon: 'success', title: ' Back To Online'});
                                                    }
                                                    online = 2;
                                                } else {
                                                    online = 1;
                                                    if (offline == 1) {
                                                        Toast.fire({icon: 'warning', title: ' No Internet Connection'});
                                                    }
                                                    offline = 2;
                                                }
                                                countNos();
                                            }

                                            function viewFile(fileUrl) {
                                                $('#loading').show();
                                                var h = screen.height;
                                                var height = (h - 250);
                                                var pdflink = '<embed src="<?php echo base_url('assets/pdfjs/web/viewer.html?file=') ?>' + fileUrl + '" frameborder="0" width="100%" height="' + height + '"/>';
                                                $('#pdfLink').html(pdflink);
                                                $('#modal_view_file').modal({backdrop: 'static', keyboard: false});
                                                $('#loading').hide();
                                            }

                                            function closeModal(id) {
                                                $('#' + id).modal('hide');
                                            }

                                            function showHidePwd(id) {
                                                var attr = $('#' + id).attr("type");
                                                if (attr == "password") {
                                                    $('#' + id).attr("type", "text");
                                                    $('.' + id).removeClass('fa-eye');
                                                    $('.' + id).addClass('fa-eye-slash');
                                                } else {
                                                    $('#' + id).attr("type", "password");
                                                    $('.' + id).removeClass('fa-eye-slash');
                                                    $('.' + id).addClass('fa-eye');
                                                }
                                            }

                                            function countNos() {
                                                // Ajax post
                                                jQuery.ajax({
                                                    type: "POST",
                                                    url: "<?php echo base_url('requi/countNos'); ?>",
                                                    dataType: 'json',
                                                    data: {
                                                        "currentDatetime": currentDatetime
                                                    },
                                                    success: function (data) {
                                                        $('#timer').html(data.mins);
                                                        if (data.status) {
                                                            $('.topNavAlert').addClass('d-none');
                                                            $('.inboxAlert').addClass('d-none');
                                                            $('.usrAlert').addClass('d-none');
                                                            $('.trashAlert').addClass('d-none');
                                                            $('#inboxAlertValue').html('');
                                                            var nosNotify = parseInt(data.nosDirectReq) + parseInt(data.nosLDCEReq) + parseInt(data.nosUsr);
                                                            if (nosNotify > 0) {
                                                                $('.topNavAlert').removeClass('d-none');
                                                                $('.topNavAlertValue1').html(nosNotify);
                                                                $('.topNavAlertValue2').html(nosNotify + " Notifications");
                                                            }
                                                            if ((parseInt(data.nosDirectReq) + parseInt(data.nosLDCEReq)) > 0) {
                                                                $('.inboxAlert').removeClass('d-none');
                                                                $('.inboxAlertValue').html(parseInt(data.nosDirectReq) + parseInt(data.nosLDCEReq));
                                                                $('.inboxAlertDValue').html(parseInt(data.nosDirectReq));
                                                                $('.inboxAlertLValue').html(parseInt(data.nosLDCEReq));
                                                            }
                                                            if (parseInt(data.nosUsr) > 0) {
                                                                $('.usrAlert').removeClass('d-none');
                                                                $('.usrAlertValue').html(parseInt(data.nosUsr));
                                                            }
                                                            if ((parseInt(data.nosDirectTrash) + parseInt(data.nosLDCETrash)) > 0) {
                                                                $('.trashAlert').removeClass('d-none');
                                                                $('.nosDirectTrash').html(parseInt(data.nosDirectTrash));
                                                                $('.nosLDCETrash').html(parseInt(data.nosLDCETrash));
                                                            }
                                                        }
                                                        if (data.screenlock) {
                                                            $('#modal_lock_screen').modal({backdrop: 'static', keyboard: false});
                                                        }
                                                        if (data.logout) {
                                                            window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                        }
                                                    }
                                                });
                                            }

                                            $(document).on("mousemove keypress", function () {
                                                var today = new Date();
                                                var date = today.getFullYear() + '-' + ("0" + (today.getMonth() + 1)).slice(-2) + '-' + ("0" + today.getDate()).slice(-2);
                                                var time = ("0" + today.getHours()).slice(-2) + ":" + ("0" + today.getMinutes()).slice(-2) + ":" + ("0" + today.getSeconds()).slice(-2);
                                                var dateTime = date + ' ' + time;
                                                currentDatetime = dateTime;
                                            });

                                            function lockScreen() {
                                                // Ajax post
                                                jQuery.ajax({
                                                    type: "POST",
                                                    url: "<?php echo base_url('auth/screenLock'); ?>",
                                                    dataType: 'json',
                                                    data: {},
                                                    success: function (data) {
                                                        if (data.status) {
                                                            $('#modal_lock_screen').modal({backdrop: 'static', keyboard: false});
                                                        } else {
                                                            window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                        }
                                                    }
                                                });
                                            }

                                            function unLockScreen() {
                                                var user_pwd = $("#user_pwd").val();
                                                if (user_pwd !== "") {
                                                    jQuery.ajax({type: "POST",
                                                        url: "<?php echo base_url('auth/unLockScreen'); ?>",
                                                        dataType: 'json',
                                                        data: {user_pwd: user_pwd},
                                                        success: function (data) {
                                                            if (data.status) {
                                                                $('#modal_lock_screen').modal('hide');
                                                            } else {
                                                                Toast.fire({icon: 'warning', title: ' ' + data.msg});
                                                            }
                                                            $('#user_pwd').val('');
                                                            $('#login_error').fadeOut(9000);
                                                        }});
                                                } else {
                                                    Toast.fire({icon: 'warning', title: ' Password is required'});
                                                }
                                            }

                                            $("#user_pwd").on('keypress', function (e) {
                                                if (e.which == 13) {
                                                    unLockScreen();
                                                }
                                            });

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
<script>
    $(function () {
        //Initialize Select2 Elements
        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'})
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {'placeholder': 'mm/dd/yyyy'})
        //Money Euro
        $('[data-mask]').inputmask()

        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'DD/MM/YYYY'
        });
        //Date and time picker
        $('#reservationdatetime').datetimepicker({icons: {time: 'far fa-clock'}});
        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker(
                {
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function (start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
        )

        //Timepicker
        $('#timepicker').datetimepicker({
            format: 'LT'
        })



    })

</script>
</body>
</html>