<?php
/*
* Autor: Danica Jakovljevic 0305/2019
*
*/
?>

<?= $this->extend('layouts/app_user') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="/assets/css/style-danica.css">

<title>Status - MojSalon</title>
<section class="simple-cta" style="height: 720pt;">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 offset-lg-1">
                <div class="gauge gauge--liveupdate" id="gauge">
                    <div class="gauge__container">
                        <div class="gauge__marker"></div>
                        <div class="gauge__background"></div>
                        <div class="gauge__center"></div>
                        <div class="gauge__data"></div>
                        <div class="gauge__needle"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 align-self-center">
                <?php if ($status) : ?>
                    <h4>Trenutno imate status <em><?php echo $status ?></em> člana.</h4>
                <?php else : ?>
                    <h4>Trenutno nemate poseban status.</h4>
                <?php endif; ?>
                <h6><?php if ($status) : ?>Cena svakog termina biće umanjena za <?php echo $discount ?>%.
                <?php else : ?>
                    <h6>Plaćate punu cenu usluga.
                    <?php endif;
                    if ($next_status) : ?>
                        Ostvarite još <?php echo $next_count - $count;
                                        if (($next_count - $count) % 10 == 1 && ($next_count - $count) % 100 != 11) echo ' termin';
                                        else echo ' termina' ?>
                        da biste postali <em><?php echo $next_status ?></em> član.</h6>
                <?php else : ?>
                </h6>
            <?php endif; ?>
            <br>
            <div class="white-button">
                <a href="/User/searchsalons">Zakaži termin</a>
            </div>
            </div>
        </div>
    </div>
</section>
<script src="/assets/js/material-gauge.js"></script>
<script>
    var gauge = new Gauge(document.getElementById("gauge"));

    gauge.value(<?php echo $count ?> / <?php echo $next_count ?>);
</script>

<?= $this->endSection() ?>