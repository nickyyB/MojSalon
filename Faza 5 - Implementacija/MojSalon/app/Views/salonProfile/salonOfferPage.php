<?php

/*
* Autor: Petar Jovovic 0352/2019
*
*/
?>


<?= $this->extend('layouts/app_salon') ?>

<?= $this->section('content') ?>

<title>Ponuda - MojSalon</title>
<section class="our-team" <?php if(count($usluge)<3) echo 'style="height: 700pt;"'?>>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- prikaz uspesne izmene podataka, micke -->
                        <?php
                            if (!empty($success)) {
                              echo "<br><div class='alert alert-success'>";
                              foreach ($success as $alert) echo "<p style='font-size:15px; color:green; margin-bottom:0px'>" . $alert . "</p>";
                              echo "</div>";
                            }
                          ?>

                <div>
                    <form method="POST" action="<?= site_url("salon/addServicePage") ?>" style="margin-left:200pt">
                        <button id='14' style="font-size: 13px;
                        color: #fff;
                        background: #850049;
                        margin:top;
                        margin-top: 40px;
                        background: linear-gradient(-145deg, #850049 0%, #e30425 100%);
                        padding: 12px 30px;
                        display: inline-block;
                        border-radius: 5px;
                        font-weight: 500;
                        text-transform: uppercase;
                        transition: all .3s;">Dodaj Uslugu
                        </button>
                    </form>
                </div>


                <ul class="nacc">
                    <?php foreach ($usluge as $usluga) : ?>
                        <li class="active">
                            <div>
                                <form method="POST" action="<?= site_url("Salon/serviceChangePage/$usluga->idUsluga") ?>">
                                    <div class="left-content">
                                        <h4><?php echo $usluga->naziv ?></h4>


                                        <p name='cena'>Cena: <?php echo $usluga->cena ?><br>
                                        <p name='trajanje'>Trajanje: <?php echo $usluga->trajanje ?><br>


                                    </div>
                                    <button style="font-size: 13px;
                                        color: #fff;
                                        background: #850049;
                                        background: linear-gradient(-145deg, #850049 0%, #e30425 100%);
                                        padding: 12px 30px;
                                        display: inline-block;
                                        border-radius: 5px;
                                        font-weight: 500;
                                        text-transform: uppercase;
                                        transition: all .3s;">Izmeni Uslugu
                                    </button>
                                    <button type="submit" style="font-size: 13px;
                                        color: #fff;
                                        background: #850049;
                                        background: linear-gradient(-145deg, #850049 0%, #e30425 100%);
                                        padding: 12px 30px;
                                        display: inline-block;
                                        border-radius: 5px;
                                        font-weight: 500;
                                        text-transform: uppercase;
                                        transition: all .3s;" formaction="<?= site_url("Salon/deleteService/$usluga->idUsluga") ?>">Obriši Uslugu
                                    </button>
                                </form>

                                <div class="right-image">
                                    <!--<? php // echo "<embed class='card-img-top' src='data:".$salon->ekstenzija.";base64,".base64_encode($salon->logo)."' width='200' height='180'/>";
                                        ?> -->
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>


<?= $this->endSection() ?>