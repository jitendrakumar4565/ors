$(document).ready(function () {
    var baseURL = window.location.pathname;
    $(document).on("click", ".track_by", function () {
        var selectedValue = $("input[name='track_by']:checked").val();
        //alert(selectedValue);
        if (selectedValue === "REF_NO") {
            $("#otp_div").hide();
            $("#refno_div").show();
        } else if (selectedValue === "OTP_VERIFY") {
            $("#refno_div").hide();
            $("#otp_div").show();
        } else {
            $("#refno_div").hide();
            $("#otp_div").hide();
        }//End of if else        
    });

    $(document).on("click", "#submitBtn", function () {
        let track_by = $("input[name='track_by']:checked").val();
        let reference_number = $("#reference_number").val();
        let mobile_number = $("#mobile_number").val();

        if ((track_by !== "REF_NO") && (track_by !== "OTP_VERIFY")) {
            alert("Please select an option to track your application");
        } else if ((track_by === "REF_NO") && (reference_number.length <= 3)) {
            alert("Please enter a valid Reference Number");
        } else if ((track_by === "OTP_VERIFY") && (mobile_number.length !== 10)) {
            alert("Please enter a valid Mobile Number");
        } else {
            //alert(track_by+" => "+reference_number+" & "+mobile_number+baseURL);
            if (track_by === "OTP_VERIFY") {
                sendOtp(mobile_number);
            } else if (track_by === "REF_NO") {
                getDetails(reference_number);
            }
        }//End of if else        
    });//End of onClick #submitBtn

    $(document).on("click", "#verify_otp", function () {
        let mobile_number = $("#mobile_number").val();
        var otp_no = $("#otp_no").val();
        if (otp_no.length !== 6) {
            alert("Please enter a valid otp");
        } else if (mobile_number.length !== 10) {
            alert("Please enter a valid Mobile Number");
        } else {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: baseURL + "/verify_otp",
                data: { "mobile_no": mobile_number, "otp": otp_no },
                beforeSend: function () {
                    $("#otp_no").attr("placeholder", "Verifying OTP...");
                },
                success: function (res) {
                    if (res.status) {
                        $("#otpModal").modal("hide");
                        getRecords("", mobile_number);
                    } else {
                        alert("OTP does not matched!");
                        $("#otp_no").val("");
                        $("#otp_no").attr("placeholder", "Enter your OTP");
                    }//End of if else
                }
            });
        }//End of if else
    });//End of onClick #verify_otp 

    $(document).on("click", "#track_status_btn", function () {
        let reference_number = $("#reference_number").val();
        if (reference_number.length <= 3) {
            alert("Please enter a valid Reference Number");
        } else {
            getDetails(reference_number);
        }//End of if else        
    });//End of onClick #track_status_btn 

    $(document).on("click", "#track_service_btn", function () {
        let reference_number = $("#reference_number").val();
        if (reference_number.length <= 3) {
            alert("Please enter a valid Reference Number");
        } else {
            getDetails(reference_number);
        }//End of if else        
    });//End of onClick #track_service_btn 

    var sendOtp = function (mobileNo) {
        $("#otpModal").modal("show");
        $.ajax({
            type: "POST",
            url: baseURL + "/send_otp",
            data: { "mobile_no": mobileNo },
            beforeSend: function () {
                $("#otp_no").attr("placeholder", "Sending OTP...");
            },
            success: function (res) {
                $("#otp_no").attr("placeholder", "Enter your OTP");
            }
        });
    };//End of sendOtp()

    var getRecords = function (refNo, mobileNo) {
        $.ajax({
            type: "POST",
            url: baseURL + "/get_records",
            data: { "ref_no": refNo, "mobile_no": mobileNo },
            beforeSend: function () {
                $("#details_div").html("Loading...");
            },
            success: function (res) {
                $("#details_div").html(res);
            }
        });
    };//End of getRecords()

    function getDetails(refNo) {
        $.ajax({
            type: "POST",
            url: baseURL + "/get_details",
            data: { "ref_no": refNo },
            beforeSend: function () {
                $("#details_div").html('<div class="loading"></div>');
            },
            success: function (res) {
                if (res === '') {
                    res = '<h2 class="my-4 text-capitalize text-center">' + notFound + '</h2>';
                }

                $("#details_div").html(res);
            }
        });
    }//End of getDetails()
});