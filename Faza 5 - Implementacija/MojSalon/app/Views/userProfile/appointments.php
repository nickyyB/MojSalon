<?php
/*
* Autor: Danica Jakovljevic 0305/2019
*
*/
?>

<?= $this->extend('layouts/app_user') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="/assets/css/style-danica.css">
<title>Termini - MojSalon</title>
<section class="our-team" style="padding-bottom:100pt">
    <div class="container">
        <li class="active">
            <div class="row">
                <?php if (count($appointments) != 0) : ?>
                    <div class="col-lg-12">
                        <ul id="dynamic-appointments" class="nacc">

                            <?php foreach ($appointments as $appointment) : ?>
                                <li class="active">
                                    <div>
                                        <div class="left-content">
                                            <h4><?php echo $appointment->nazivSalona ?> | <?php echo $appointment->nazivUsluge ?></h4>
                                            <p>Cena: <?php echo $appointment->cena ?></p>
                                            <p>Datum: <?php echo $appointment->datum ?></p>
                                        </div>
                                        <div class="right-image">
                                            <?php
                                            //Provera da li se prikazuje dugme za ocenjivanje
                                            $currentDate = strtotime(date('Y-m-d H:i:s'));
                                            $appointmentDate = strtotime($appointment->datum);
                                            $days = ($currentDate - $appointmentDate) / 86400;
                                            if ($days > 0 && $days < 7 && $appointment->stanje == 2) : ?>
                                                <a href="<?php echo site_url("/User/review/{$appointment->idTermin}") ?>">
                                                    <button class="appointment-action-button">Oceni</button>
                                                </a>
                                            <?php
                                            //Provera da li se prikazuje dugme za otkazivanje
                                            elseif ($days < -1 && $appointment->stanje == 2) : ?>
                                                <a href="<?php echo site_url("/User/cancel/{$appointment->idTermin}") ?>">
                                                    <button class="appointment-action-button">Otkaži</button>
                                                </a>
                                            <?php
                                            //Prikaz nepotvrdjenog termina
                                            elseif ($days < -1 && ($appointment->stanje == 1)) : ?>
                                                <button class="appointment-action-button-disabled" disabled="disabled">Nije Potvrđen</button>
                                            <?php
                                            //Prikaz otkazanog termina
                                            elseif ($appointment->stanje == 3) : ?>
                                                <button class="appointment-action-button-disabled" disabled="disabled">Otkazan</button>
                                            <?php
                                            //Prikaz termina koji nema akcije(ocenjen/prosao rok za ocenjivanje)
                                            elseif ($days > 0) : ?>
                                                <button class="appointment-action-button-disabled" disabled="disabled">Završen</button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php echo $pager->links() ?>
                    </div>

                <?php
                else : ?>
                    <div class="col-lg-12 no-appointments">
                        <h4>Oh ne! Nemate zakazanih termina.</h4>
                        <div class="main-button-gradient">
                            <a href="<?php echo site_url("/User/searchSalons") ?>">Zakaži termin</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
</section>

<script type="text/javascript">
    // $(document).ready(function() {

    //     function load_data(page) {
    //         $.ajax({
    //             url: "/User/appointments",
    //             method: "POST",
    //             data: {
    //                 page: page
    //             },
    //             success: function(data) {
    //                 $('dynamic-appointments').html(data);
    //             }
    //         })
    //     }

    // });
</script>

<?= $this->endSection() ?>