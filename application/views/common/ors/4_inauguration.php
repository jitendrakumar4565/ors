<script src="<?php echo base_url('assets/ors/curtain/jquery.easing.1.3.js') ?>" type="text/javascript"></script> 
<script type="text/javascript">
    $(document).ready(function () {
        $curtainopen = false;
        $(".rope").click(function () {
            $(this).blur();
            if ($curtainopen == false) {
                $(this).stop().animate({top: '0px'}, {queue: false, duration: 350, easing: 'easeOutBounce'});
                $(".leftcurtain").stop().animate({width: '10%'}, 5000);
                $(".rightcurtain").stop().animate({width: '10%'}, 5000);
                $curtainopen = true;
                startConfetti();
                setTimeout(stopConfetti, 8000)
            } else {
                $(this).stop().animate({top: '-30px'}, {queue: false, duration: 350, easing: 'easeOutBounce'});
                $(".leftcurtain").stop().animate({width: '50%'}, 5000);
                $(".rightcurtain").stop().animate({width: '51%'}, 5000);
                $curtainopen = false;
                stopConfetti();
            }
            return false;
        });

    });
</script>
<style type="text/css">
    .rnOuter {        
        overflow: hidden;
        position: relative;
        height: 76vh;
    }
    .leftcurtain{
        width: 50%;
        height: 99%;
        left: 0px;
        position: absolute;
        z-index: 3;
    }
    .rightcurtain{
        width: 51%;
        height: 99%;
        right: 0px;
        position: absolute;
        z-index: 4;
    }
    .rightcurtain img, .leftcurtain img{
        width: 100%;
        height: 100%;
    }
    .logo{
        margin: 0px auto;
        margin-top: 0px;
    }
    .rope{
        position: absolute;
        top: -30px;
        left: 90%;
        z-index: 5;
    }
    .board{
        width: 100%;
        height: 100%; 
        top: 0;
        position: absolute;
        z-index: 2;
        background-color: #000000;
        color: #D3AB66;
        overflow: hidden;
        right: 0;
        left: 0;
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-style:double none double none;
        border-width: 6px;
    }

    .stone{
        /* background: #000000 url('<?php echo base_url("assets/ors/curtain/images/b2.png") ?>') no-repeat;
         height: 100%;
        */
    }

    .footer_img{
        position: absolute;
        background: #4f3722 url('<?php echo base_url("assets/ors/curtain/images/darkcurtain_footer.jpg") ?>') repeat-x;
        height: 5%;
        width: 100%;
        bottom: 0px;
    }

    .swing {
        animation: swing ease-in-out 1s infinite alternate;
        transform-origin: center -20px;
        float:left;
    }

    .swing:after{
        content: '';
        position: absolute;  
        top: -10px; left: 50%;
        z-index: 0;
        border-bottom: none;
        border-right: none;
        transform: rotate(45deg);
    }
    /* nail */
    .swing:before{
        content: '';
        position: absolute;
        top: -14px;left: 54%;
        z-index: 5;
    }

    @keyframes swing {
        0% { transform: rotate(3deg); }
        100% { transform: rotate(-3deg); }
    }

    .gradient-border {
        background: #1D1F20;
        /*background:#000000;*/
        border-style:double double double double;
        border-width: 11px;
        border-radius: 0px;

    } 
</style>
<!--  Image slider -->
<div id="row">
    <div class="col-md-12 rnOuter" style="">
        <div class="leftcurtain"><img src="<?php echo base_url('assets/ors/curtain/images/frontcurtain.jpg') ?>"/></div>
        <div class="rightcurtain"><img src="<?php echo base_url('assets/ors/curtain/images/frontcurtain.jpg') ?>"/></div>
        <a class="rope swing" href="#">
            <img src="<?php echo base_url('assets/ors/curtain/images/rope.png') ?>"/>
        </a>        
        <div class="board">
            <div class="row justify-content-center">
                <div class="gradient-border col-md-6 stone mt-4">
                    <div class="col-md-12 mt-3 text-center"><img src="<?php echo base_url('assets/ors/curtain/images/emblem_gold.png') ?>" style="width: 40px;height: 60px;"/></div>
                    <div class="col-md-12 mt-2">
                        <h4 class="text-center">Arunachal Pradesh Staff Selection Board</h4>
                    </div>

                    <div class="col-md-12" style="margin-top: 20px;">
                        <h6 class="text-center">Inauguration of </h6>
                    </div>
                    <div class="col-md-12">
                        <h4 class="text-center">Online Requisition System </h4>
                    </div>
                    <div class="col-md-12" style="margin-top: 20px;">
                        <h6 class="text-center">By </h6>
                    </div>
                    <div class="col-md-12">
                        <h4 class="text-center">Sh. Name of the Guest </h4>
                    </div>
                    <div class="col-md-12">
                        <h6 class="text-center">Designation </h6>
                    </div>
                    <div class="col-md-12">
                        <h6 class="text-center">Arunachal Pradesh </h6>
                    </div>
                    <div class="col-md-12" style="margin-top: 25px;">
                        <h4 class="text-center">On 25 <sup>th</sup> May 2020 </h4>
                    </div>
                    <div class="row justify-content-center mb-3" style="margin-top: 30px;">
                        <div class="col-md-10 form-inline">
                            <div class="col-md-6">
                                <h5 class="text-center">Name one </h5>
                                <h5 class="text-center">Chairperson, APSSB </h5>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-center">Name Two </h5>
                                <h5 class="text-center">Secretary, APSSB </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer_img">
            </div>
        </div> 
    </div>
</div>
