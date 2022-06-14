<?php
/*
* Autor: Dancica Jakovljevic 0305/2019
*
*/
?>
<?= $this->extend('layouts/app_user') ?>
<?= $this->section('content') ?>

<title>Zakazivanje - MojSalon</title>
<link rel="stylesheet" href="/assets/css/style-danica.css">

<section class="our-team" style="height:620pt">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 make-appointment">
                <div class="calendar">
                    <div class="date-picker">
                        <div class="week-picker">
                            <div class="month-year">
                                <h6></h6>
                            </div>
                            <div>
                                <button class="button-left fa fa-angle-left fa-2x"></button>
                                <button class="button-right fa fa-angle-right fa-2x"></button>
                            </div>
                        </div>
                        <hr>
                        <div class="day-picker">
                            <div>P</div>
                            <div>U</div>
                            <div>S</div>
                            <div>Č</div>
                            <div>P</div>
                            <div>S</div>
                            <div>N</div>
                            <div id="day-1" class="day-numbers"></div>
                            <div id="day-2" class="day-numbers"></div>
                            <div id="day-3" class="day-numbers"></div>
                            <div id="day-4" class="day-numbers"></div>
                            <div id="day-5" class="day-numbers"></div>
                            <div id="day-6" class="day-numbers"></div>
                            <div id="day-7" class="day-numbers"></div>
                        </div>
                    </div>
                    <hr>
                    <div class="time-picker">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 make-appointment">
                <div class="appointment-details">
                    <h6>Usluga: </h6>
                    <h6><?php echo $service->naziv ?></h6>
                    <br>
                    <h6>Salon: </h6>
                    <h6><?php echo $salon->naziv ?></h6>
                    <br>
                    <hr>
                    <h6>Datum i vreme:</h6>
                    <h6 id="selected-date-time"></h6>
                    <hr>
                    <h6>Cena: </h6>
                    <h6 class="<?php if ($discount != null) echo "discount" ?>"><?php echo $service->cena ?></h6>
                    <h6 id="discounted-price"><?php if ($discount != null) echo number_format($service->cena * (1 - ($discount / 100)), 2, '.', '') ?></h6>

                    <button class="confirm-button disabled">Zakaži</button>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="/assets/js/script-danica.js"></script>
<?= $this->endSection() ?>