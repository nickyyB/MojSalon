<?php

/*
* Autor: Mihajlo Micic 0565/2017
*
*/
?>


<?= $this->extend('layouts/app_admin') ?>

<?= $this->section('content') ?>

<title>Moj Salon - Admin</title>


<section class="main-banner" id="top" <?php if(count($salons)<4) echo 'style="height: 700pt;"'?>>
    <div class="container">
        <div class="row">
            <div class="col-lg-9 center" style="z-index: 2">
                <div class="header-text">
                    <div class="form-group">
                        <form method='GET' action="<?= site_url('Admin/blockedsalons') ?>">
                            <div class="input-group" style="padding-bottom:5pt">
                                <input type="text" name="search" id="search" placeholder="Pretraga po nazivu" class="form-control" />
                            </div>
                            <input type="submit">
                        </form>
                    </div>
                </div>
                <div class="filter col-md-12">
                    <div class="row">
                        <ul class="nacc">
                            <?php if(empty($salons))
                                echo "Trenutno nema blokiranih salona." ?>
                            <?php foreach($salons as $salon): ?>
                                <li class="active">
                                    <div>
                                        <form method="POST" action="<?= site_url('Admin/removeBlockedsalon') ?>">
                                        <div class="left-content">
                                            <h4> <?php echo $salon->naziv ?></h4>
                                            <p>Naziv: <input readonly name='user'style="border:none"value="<?php echo $salon->naziv ?>" ><br>
                                                Adresa: <?php echo $salon->adresa?><br>
                                                Opstina: <?php echo $salon->opstina?><br>
                                                <input hidden value="<?php echo $salon->idSalon?>" name="id">
                                            </p>
                                        </div>
                                        <button type="submit" style="font-size: 13px;
                                            color: #fff;
                                            background: #850049;
                                            background: linear-gradient(-145deg, #850049 0%, #e30425 100%);
                                            padding: 12px 30px;
                                            display: inline-block;
                                            border-radius: 5px;
                                            font-weight: 500;
                                            text-transform: uppercase;
                                            transition: all .3s;" >Obriši salon
                                        </button>
                                        <button type="submit" formaction="<?= site_url('Admin/unblocksalon') ?>"style="font-size: 13px;
                                            color: #fff;
                                            background: #850049;
                                            background: linear-gradient(-145deg, #850049 0%, #e30425 100%);
                                            padding: 12px 30px;
                                            display: inline-block;
                                            border-radius: 5px;
                                            font-weight: 500;
                                            text-transform: uppercase;
                                            transition: all .3s;">Odblokiraj salon
                                        </button>
                                        </form>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>







<?= $this->endSection() ?>