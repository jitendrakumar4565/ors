<?php

$cpayscalename = "";
if (isset($_POST['b_pay_scale'])) {
    $payscaleName = $_POST['b_pay_scale'];
    if (count($payscaleName) > 1) {
        foreach ($payscaleName as $pname) {
            if (trim($pname) != '') {
                $cpayscalename .= "'" . trim($pname) . "',";
            }
        }
        $cpayscalename = rtrim($cpayscalename, ",");
        if ($cpayscalename != "") {
            array_push($condArr, 'req.b_pay_scale IN ( ' . $cpayscalename . ' )');
        }
    } else if (count($payscaleName) == 1) {
        foreach ($payscaleName as $pname) {
            if (trim($pname) != '') {
                $cpayscalename .= $pname;
            }
        }
        if ($cpayscalename != "") {
            array_push($condArr, "req.b_pay_scale = '" . $cpayscalename . "'");
        } else {
            $cpayscalename = "";
        }
    }
} else {
    $cpayscalename = "";
}

