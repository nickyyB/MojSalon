<?php

/*
* Autor: Nikola Brkovic 0647/2014
*
*/
?>


<?= $this->extend('layouts/app_admin') ?>

<?= $this->section('content') ?>

<title>Moj Salon - Admin</title>
<section class="main-banner" id="top" <?php if(count($users)<4) echo 'style="height: 700pt;"'?>>
    <div class="container">
        <div class="row">
            <div class="col-lg-9 center" style="z-index: 2">

                <div class="filter col-md-12">
                    <div class="row">
                        <ul class="nacc">
                            <?php foreach($users as $user): ?>
                                <li class="active">
                                    <div>
                                        <form method="POST" action="<?= site_url('Admin/acceptRequest') ?>">
                                        <div class="left-content">
                                            <h4> <?= $user->naziv ?></h4>
                                            <p>Korisničko ime: <input readonly name='user' style="border:none" value="<?= $user->kIme ?>" ><br>
                                                Naziv: <?= $user->naziv ?><br>
                                                Adresa: <?= $user->adresa ?><br>
                                                Opština: <?= $user->opstina ?><br>
                                                PIB: <?php echo $user->PIB ?><br>
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
                                            transition: all .3s;" >Prihvati
                                        </button>
                                        <button type="submit" formaction="<?= site_url('Admin/rejectRequest') ?>" style="font-size: 13px;
                                            color: #fff;
                                            background: #850049;
                                            background: linear-gradient(-145deg, #850049 0%, #e30425 100%);
                                            padding: 12px 30px;
                                            display: inline-block;
                                            border-radius: 5px;
                                            font-weight: 500;
                                            text-transform: uppercase;
                                            transition: all .3s;">Odbij
                                        </button>
                                        </form>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                            <?php if(empty($users)): ?>
                                <div class="center">
                                    <h1 style="text-align:center">Nema zahteva za registraciju salona</h1>
                                </div>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>