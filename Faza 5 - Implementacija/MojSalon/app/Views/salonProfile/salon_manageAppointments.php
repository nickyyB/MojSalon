<?php

/*
* Autor: Petar Jovovic 0352/2019
*
*/
?>


<?= $this->extend('layouts/app_salon') ?>

<?= $this->section('content') ?>

<title>Zahtevi - MojSalon</title>
<section class="our-team" <?php if(count($termini)<3) echo 'style="height: 600pt;"'?>>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php if(count($termini)==0): ?>
                <div style="text-align:center;padding-top:30pt">
                    <h3>Nema zahteva za zakazivanje.</h3>
                </div>
                <?php endif; ?>
                <ul class="nacc">
                    <?php foreach ($termini as $termin) : ?>
                        <li class="active">

                            <div>
                                <form method="POST" action="<?= site_url('Salon/acceptAppointment') ?>">

                                    <div class="left-content">
                                        <h4><?php echo $termin->ime . " " . $termin->prezime ?></h4>
                                        <p name='user' >Korisničko ime: <?php echo $termin->kIme ?><br>
                                        <p name='usluga'>Usluga: <?php echo $termin->naziv ?><br>
                                        <p name='cena'>Cena: <?php echo $termin->cena ?><br>
                                        <p name='datum'>Datum: <?php echo $termin->datum ?><br>
                                        <br>
                                        <input type = hidden name='id' id = 'id'  readonly   style = "border:none;"value = "<?php echo $termin->idTermin ?>" >

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
                                        transition: all .3s;">Prihvati termin
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
                                        transition: all .3s;" formaction="<?= site_url('Salon/denyAppointment') ?>">Odbij termin
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



<section class="main-banner" id="top">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 center" style="z-index: 2">
                <div class="header-text">
                    <div class="form-group">
                        <form method="POST" action="<?= site_url('Salon/confirmation_page_byName') ?>">
                            <div class="input-group" style="padding-bottom:5pt">

                                <input type="text" name="searchUser" id="search" placeholder="Pretraga po korisničkom imenu" class="form-control" />
                                <button style="font-size: 13px;
                                            color: #fff;
                                            background: #850049;
                                            background: linear-gradient(-145deg, #850049 0%, #e30425 100%);
                                            padding: 12px 30px;
                                            display: inline-block;
                                            border-radius: 5px;
                                            font-weight: 500;
                                            text-transform: uppercase;
                                            transition: all .3s;">Pretraži
                                </button>


                            </div>
                        </form>
                    </div>
                </div>
                <div class="filter col-md-12">
                    <div class="row">

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>







<?= $this->endSection() ?>