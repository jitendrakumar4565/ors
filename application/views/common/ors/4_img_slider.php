<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Automatic Image Slider</title>
        <style>
            .slider {
                position: relative;
                overflow: hidden;
                width: 100%; /* adjust width as needed */
                height: 100%; /* adjust height as needed */
            }

            .slider img {
                width: 100%;
                height: auto;
                display: none;
            }

            .slider img.active {
                display: block;
            }

            .slider-caption {
                position: absolute;
                top: 10px;
                left: 10px;
                z-index: 10;
                background: rgba(0, 0, 0, 0.1);
                color: #fff;
                padding: 5px 10px;
            }
            
            .slider-caption a{
                background: none;
                color: #fff;
                text-decoration: none;
            }

            .slider-caption:nth-child(2) { top: 50px; }
            .slider-caption:nth-child(3) { top: 90px; }
            .slider-caption:nth-child(4) { top: 130px; }
            .slider-caption:nth-child(5) { top: 170px; }
            .slider-caption:nth-child(6) { top: 210px; }
            .slider-caption:nth-child(7) { top: 250px; }
            .slider-caption:nth-child(8) { top: 290px; }
            .slider-caption:nth-child(9) { top: 330px; }
            .slider-caption:nth-child(10) { top: 370px; }

            .slider-caption-bottom {
                position: absolute;
                bottom: 10px;
                right: 10px;
                z-index: 10;
                background: rgba(0, 0, 0, 0.5);
                color: #fff;
                padding: 5px 10px;
            }
        </style>
    </head>
    <body>

        <div class="slider">
            <img class="active" alt="" src="<?php echo base_url('assets/ors/storage/portal/11.png') ?>">
            <img alt="" src="<?php echo base_url('assets/ors/storage/portal/12.png') ?>">
            <!-- Add more images as needed -->

            <div class="slider-caption">Online Requisition System</div>
            <div class="slider-caption">Arunachal Pradesh Staff Selection Board</div>
            <div class="slider-caption">Government of Arunachal Pradesh</div>
            <div class="slider-caption">Help Line No: </div>
            <div class="slider-caption"><a href="">Email : helpdesk-apssb@arn.gov.in</a></div>

            <div class="slider-caption-bottom">Email ID : </div>
        </div>


        <script>
            $(document).ready(function () {
                var currentIndex = 0;
                var images = $('.slider img');
               
                function showImage(index) {
                    images.removeClass('active');
                    images.eq(index).addClass('active');
                }

                function nextImage() {
                    currentIndex = (currentIndex + 1) % images.length;
                    showImage(currentIndex);
                }

                // Initial call
                showImage(currentIndex);

                // Automatic slideshow
                setInterval(nextImage, 3000); // Change 3000 to desired interval in milliseconds
            });
        </script>

    </body>
</html>
