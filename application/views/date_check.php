
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AdminLTE 3 | Advanced form elements</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

        <link rel="stylesheet" href="<?php echo base_url('assets/') ?>plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="<?php echo base_url('assets/') ?>plugins/daterangepicker/daterangepicker.css">
        <link rel="stylesheet" href="<?php echo base_url('assets/') ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">


        <link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist/css/adminlte.min.css?v=3.2.0">
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">


            <div class="content-wrapper">

                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Advanced Form</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Advanced Form</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="content">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title">Input masks</h3>
                                    </div>
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label>Date masks:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                            </div>

                                        </div>


                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask>
                                            </div>

                                        </div>


                                        <div class="form-group">
                                            <label>US phone mask:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                </div>
                                                <input type="text" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                                            </div>

                                        </div>


                                        <div class="form-group">
                                            <label>Intl US phone mask:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                </div>
                                                <input type="text" class="form-control" data-inputmask="'mask': ['999-999-9999 [x99999]', '+099 99 99 9999[9]-9999']" data-mask>
                                            </div>

                                        </div>


                                        <div class="form-group">
                                            <label>IP mask:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                                                </div>
                                                <input type="text" class="form-control" data-inputmask="'alias': 'ip'" data-mask>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Color & Time Picker</h3>
                                    </div>
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label>Color picker:</label>
                                            <input type="text" class="form-control my-colorpicker1">
                                        </div>


                                        <div class="form-group">
                                            <label>Color picker with addon:</label>
                                            <div class="input-group my-colorpicker2">
                                                <input type="text" class="form-control">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="bootstrap-timepicker">
                                            <div class="form-group">
                                                <label>Time picker:</label>
                                                <div class="input-group date" id="timepicker" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#timepicker" />
                                                    <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Date picker</h3>
                                    </div>
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label>Date:</label>
                                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" />
                                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Date and time:</label>
                                            <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime" />
                                                <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label>Date range:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control float-right" id="reservation">
                                            </div>

                                        </div>


                                        <div class="form-group">
                                            <label>Date and time range:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                </div>
                                                <input type="text" class="form-control float-right" id="reservationtime">
                                            </div>

                                        </div>


                                        <div class="form-group">
                                            <label>Date range button:</label>
                                            <div class="input-group">
                                                <button type="button" class="btn btn-default float-right" id="daterange-btn">
                                                    <i class="far fa-calendar-alt"></i> Date range picker
                                                    <i class="fas fa-caret-down"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        Visit <a href="https://getdatepicker.com/5-4/">tempusdominus </a> for more examples and information about
                                        the plugin.
                                    </div>

                                </div>


                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">iCheck Bootstrap - Checkbox &amp; Radio Inputs</h3>
                                    </div>
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-sm-6">

                                                <div class="form-group clearfix">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="checkboxPrimary1" checked>
                                                        <label for="checkboxPrimary1">
                                                        </label>
                                                    </div>
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="checkboxPrimary2">
                                                        <label for="checkboxPrimary2">
                                                        </label>
                                                    </div>
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" id="checkboxPrimary3" disabled>
                                                        <label for="checkboxPrimary3">
                                                            Primary checkbox
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">

                                                <div class="form-group clearfix">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="radio" id="radioPrimary1" name="r1" checked>
                                                        <label for="radioPrimary1">
                                                        </label>
                                                    </div>
                                                    <div class="icheck-primary d-inline">
                                                        <input type="radio" id="radioPrimary2" name="r1">
                                                        <label for="radioPrimary2">
                                                        </label>
                                                    </div>
                                                    <div class="icheck-primary d-inline">
                                                        <input type="radio" id="radioPrimary3" name="r1" disabled>
                                                        <label for="radioPrimary3">
                                                            Primary radio
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">

                                                <div class="form-group clearfix">
                                                    <div class="icheck-danger d-inline">
                                                        <input type="checkbox" checked id="checkboxDanger1">
                                                        <label for="checkboxDanger1">
                                                        </label>
                                                    </div>
                                                    <div class="icheck-danger d-inline">
                                                        <input type="checkbox" id="checkboxDanger2">
                                                        <label for="checkboxDanger2">
                                                        </label>
                                                    </div>
                                                    <div class="icheck-danger d-inline">
                                                        <input type="checkbox" disabled id="checkboxDanger3">
                                                        <label for="checkboxDanger3">
                                                            Danger checkbox
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">

                                                <div class="form-group clearfix">
                                                    <div class="icheck-danger d-inline">
                                                        <input type="radio" name="r2" checked id="radioDanger1">
                                                        <label for="radioDanger1">
                                                        </label>
                                                    </div>
                                                    <div class="icheck-danger d-inline">
                                                        <input type="radio" name="r2" id="radioDanger2">
                                                        <label for="radioDanger2">
                                                        </label>
                                                    </div>
                                                    <div class="icheck-danger d-inline">
                                                        <input type="radio" name="r2" disabled id="radioDanger3">
                                                        <label for="radioDanger3">
                                                            Danger radio
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">

                                                <div class="form-group clearfix">
                                                    <div class="icheck-success d-inline">
                                                        <input type="checkbox" checked id="checkboxSuccess1">
                                                        <label for="checkboxSuccess1">
                                                        </label>
                                                    </div>
                                                    <div class="icheck-success d-inline">
                                                        <input type="checkbox" id="checkboxSuccess2">
                                                        <label for="checkboxSuccess2">
                                                        </label>
                                                    </div>
                                                    <div class="icheck-success d-inline">
                                                        <input type="checkbox" disabled id="checkboxSuccess3">
                                                        <label for="checkboxSuccess3">
                                                            Success checkbox
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">

                                                <div class="form-group clearfix">
                                                    <div class="icheck-success d-inline">
                                                        <input type="radio" name="r3" checked id="radioSuccess1">
                                                        <label for="radioSuccess1">
                                                        </label>
                                                    </div>
                                                    <div class="icheck-success d-inline">
                                                        <input type="radio" name="r3" id="radioSuccess2">
                                                        <label for="radioSuccess2">
                                                        </label>
                                                    </div>
                                                    <div class="icheck-success d-inline">
                                                        <input type="radio" name="r3" disabled id="radioSuccess3">
                                                        <label for="radioSuccess3">
                                                            Success radio
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        Many more skins available. <a href="https://bantikyan.github.io/icheck-bootstrap/">Documentation</a>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>

                </section>

            </div>

            <footer class="main-footer">
                <div class="float-right d-none d-sm-block">
                    <b>Version</b> 3.2.0
                </div>
                <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
            </footer>

            <aside class="control-sidebar control-sidebar-dark">

            </aside>

        </div>


        <script src="<?php echo base_url('assets/') ?>plugins/jquery/jquery.min.js"></script>    
        <script src="<?php echo base_url('assets/') ?>plugins/moment/moment.min.js"></script>
        <script src="<?php echo base_url('assets/') ?>plugins/inputmask/jquery.inputmask.min.js"></script>
        <script src="<?php echo base_url('assets/') ?>plugins/daterangepicker/daterangepicker.js"></script>
        <script src="<?php echo base_url('assets/') ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
        <script src="<?php echo base_url('assets/') ?>dist/js/adminlte.min.js?v=3.2.0"></script>


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
                    format: 'L'
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
