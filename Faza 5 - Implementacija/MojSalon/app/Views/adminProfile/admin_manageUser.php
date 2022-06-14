<?php

/*
* Autor: Mihajlo Micic 0565/2017
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
                <div class="header-text">
                    <div class="form-group">
                        <form method='GET' action="<?= site_url('Admin/users') ?>">
                            <div class="input-group" style="padding-bottom:5pt">
                                <input type="text" name="search" id="search" placeholder="Pretraga po korisničkom imenu" class="form-control" />
                            </div>
                            <input type="submit">
                        </form>
                    </div>
                </div>
                <div class="filter col-md-12">
                    <div class="row">
                        <?php if(empty($users))
                            echo "Trenutno nema aktivnih korisnika." ?>
                        <ul class="nacc">
                            <?php foreach($users as $user): ?>
                                <li class="active">
                                    <div>
                                        <form method="POST" action="<?= site_url('Admin/remove') ?>">
                                        <div class="left-content">
                                            <h4> <?php echo $user->ime." ".$user->prezime ?></h4>
                                            <p>Korisničko ime: <input readonly name='user'style="border:none"value="<?php echo $user->kIme ?>" ><br>
                                                Ime: <?php echo $user->ime ?><br>
                                                Prezime: <?php echo $user->prezime ?><br>
                                                Opština: <?php echo $user->opstina ?><br>
                                                Datum rođenja: <?php echo $user->datumR ?><br>
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
                                            transition: all .3s;" >Obriši korisnika
                                        </button>
                                        <button type="submit" formaction="<?= site_url('Admin/block') ?>"style="font-size: 13px;
                                            color: #fff;
                                            background: #850049;
                                            background: linear-gradient(-145deg, #850049 0%, #e30425 100%);
                                            padding: 12px 30px;
                                            display: inline-block;
                                            border-radius: 5px;
                                            font-weight: 500;
                                            text-transform: uppercase;
                                            transition: all .3s;">Blokiraj korisnika
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