<?php

/*
* Autor: Mihajlo Micic 0565/2017
*
*/
?>


<?= $this->extend('layouts/app_user') ?>

<?= $this->section('content') ?>

<title>Moj Salon - <?php echo $salon->naziv ?></title>
<section class="our-team">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-4" style="margin:auto">
                    <?php echo "<embed class='card-img-top' src='data:" . $salon->ekstenzija . ";base64," . base64_encode($salon->logo) . "' width='200' height='180'/>"; ?>
                </div>
                <div style="overflow:hidden">
                    <div class="col-lg-6" style="float:left">
                        <div class="row">
                            <h5>Radno vreme:</h5>
                        </div>
                        <div class="row">
                            <h7>Ponedeljak: <?php if (is_null($workingHrs->pon)) echo "Neradan dan";
                                            echo $workingHrs->pon ?></h7>
                        </div>


                        <div class="row">
                            <h7>Utorak: <?php if (is_null($workingHrs->uto)) echo "Neradan dan";
                                        echo $workingHrs->uto ?> </h7>
                        </div>
                        <div class="row">
                            <h7>Sreda: <?php if (is_null($workingHrs->sre)) echo "Neradan dan";
                                        echo $workingHrs->sre ?> </h7>
                        </div>
                        <div class="row">
                            <h7>Četvrtak: <?php if (is_null($workingHrs->cet)) echo "Neradan dan";
                                            echo $workingHrs->cet ?> </h7>
                        </div>
                        <div class="row">
                            <h7>Petak: <?php if (is_null($workingHrs->pet)) echo "Neradan dan";
                                        echo $workingHrs->pet ?> </h7>
                        </div>
                        <div class="row">
                            <h7>Subota: <?php if (is_null($workingHrs->sub)) echo "Neradan dan";
                                        echo $workingHrs->sub ?> </h7>
                        </div>
                        <div class="row">
                            <h7>Nedelja: <?php if (is_null($workingHrs->ned)) echo "Neradan dan";
                                            echo $workingHrs->ned ?> </h7>
                        </div>
                    </div>

                    <div class="col-lg-6" style="overflow: hidden; text-align:right">
                        <h5>Adresa: <?php echo $salon->adresa ?> </h5>
                        <br>
                        <br>
                        <br>
                        <br>
                        <h5> Ocena: <?php echo round($rating,2) ?> /5
                    </div>
                </div>
                <!--          /////////////////////////////////////////////////                                                  -->
                <div class="row" <?php if(empty($images)) echo "hidden"?>>
                    <div class="container">

                        <!-- Full-width images with number text -->
                        <?php foreach($images as $image):?>
                            <div class="mySlides" style="text-align:center">
                                <img src="/<?= $image->putanja?>" style="width:600px; height:300px;" >
                            </div>
                        <?php endforeach;?>
                            <!-- Next and previous buttons -->
                            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                            <a class="next" onclick="plusSlides(1)">&#10095;</a>
                    </div>
                </div>
                <!--          /////////////////////////////////////////////////      -->
                <div class="section-heading">
                    <h4> Usluge dostupne u <em><?php echo $salon->naziv ?></em> </h4>
                </div>
                <?php if (empty($usluge))
                    echo "Salon u pripremi." ?>
                <ul class="nacc">
                    <?php foreach ($usluge as $usluga) : ?>
                        <li class="active">
                            <div>
                                <div class="left-content">
                                    <h4><?php echo $usluga->naziv ?></h4>
                                    <p>Trajanje tretmana: <?php echo $usluga->trajanje ?>min</p>
                                    <p>Cena: <?php echo $usluga->cena ?></p>
                                </div>
                                <div class="right-image">
                                    <a href="<?php echo site_url("/User/makeAppointment/{$usluga->idUsluga}") ?>">
                                        <button style="font-size: 13px;
                                            color: #fff;
                                            background: #850049;
                                            background: linear-gradient(-145deg, #850049 0%, #e30425 100%);
                                            padding: 12px 30px;
                                            display: inline-block;
                                            border-radius: 5px;
                                            font-weight: 500;
                                            text-transform: uppercase;
                                            transition: all .3s;">ZAKAŽI
                                        </button>
                                    </a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <hr>
                <div class="row">
                    <h4>Komentari korisnika:</h4>
                    <?php if(empty($comments))
                            echo "Nema komentara za ovaj salon." ?>
                    <ul class="nacc">
                        <?php foreach($comments as $comment): ?>
                            <li class="active">
                                <div>
                                    <div class="left-content">
                                        <h4><?php echo $comment->ime ?></h4>
                                        <p><?php echo $comment->tekst ?></p>
                                    </div>
                                    <div class="right-image">
                                        Ocena: <?php echo $comment->ocena ?>/5
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ////////////////////////////////////////////////////////////////////////////////////// -->

<script>
        let slideIndex = 1;
        showSlides(slideIndex);

        // Next/previous controls
        function plusSlides(n) {
        showSlides(slideIndex += n);
        }

        // Thumbnail image controls
        function currentSlide(n) {
        showSlides(slideIndex = n);
        }

        function showSlides(n) {
        let i;
        let slides = document.getElementsByClassName("mySlides");
        let dots = document.getElementsByClassName("demo");
        let captionText = document.getElementById("caption");
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block";
        dots[slideIndex-1].className += " active";
        captionText.innerHTML = dots[slideIndex-1].alt;
        }
    </script>



    <style>
        * {
        box-sizing: border-box;
        }

        /* Position the image container (needed to position the left and right arrows) */
        .container {
        position: relative;
        }

        /* Hide the images by default */
        .mySlides {
        display: none;
        }

        /* Add a pointer when hovering over the thumbnail images */
        .cursor {
        cursor: pointer;
        }

        /* Next & previous buttons */
        .prev,
        .next {
        cursor: pointer;
        position: absolute;
        top: 40%;
        width: auto;
        padding: 16px;
        margin-top: -50px;
        color: black;
        font-weight: bold;
        font-size: 20px;
        border-radius: 0 3px 3px 0;
        user-select: none;
        -webkit-user-select: none;
        }

        /* Position the "next button" to the right */
        .next {
        right: 0;
        border-radius: 3px 0 0 3px;
        }

        /* On hover, add a black background color with a little bit see-through */
        .prev:hover,
        .next:hover {
        background-color: rgba(0, 0, 0, 0.8);
        }

        /* Number text (1/3 etc) */
        .numbertext {
        color: #f2f2f2;
        font-size: 12px;
        padding: 8px 12px;
        position: absolute;
        top: 0;
        }

        /* Container for image text */
        .caption-container {
        text-align: center;
        background-color: #222;
        padding: 2px 16px;
        color: white;
        }

        .row:after {
        content: "";
        display: table;
        clear: both;
        }

        /* Six columns side by side */
        .column {
        float: left;
        width: 16.66%;
        }

        /* Add a transparency effect for thumnbail images */
        .demo {
        opacity: 0.6;
        }

        .active,
        .demo:hover {
        opacity: 1;
        }
    </style>

    
<?= $this->endSection() ?>