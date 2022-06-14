<?php

/*
* Autor: Mihajlo Micic 0565/2017
*
*/
?>


<?= $this->extend('layouts/app_salon') ?>

<?= $this->section('content') ?>

<title>Moj Salon - <?php echo $salon->naziv ?></title>
<section class="our-team" <?php if(count($slike)<4) echo 'style="height: 620pt;"'?>>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <?php if(empty($slike)): ?>
                        <h3 style="padding-top:20pt;">Galerija je trenutno prazna.</h3>
                    <?php endif; ?>
                    
                    <?php 
                        if(!empty($errors)){
                            echo "<div class='alert alert-danger'>";
                            foreach($errors as $error) echo "<p style='font-size:15px; color:red; margin-bottom:0px'>".$error."</p>"; 
                            echo "</div>";
                        }
                    ?>
                    <ul class="nacc" style="overflow:auto;">
                        <?php foreach($slike as $slika): ?>
                            <li class="active">
                                <div class="col-lg-12" style="overflow:hidden">
                                    <form method="POST" action="<?= site_url("salon/deleteImage/$slika->idSlika") ?>">
                                        <div class="col-lg-6" style="float:left">
                                            <img src="/<?= $slika->putanja?>" style="height:100px; width:100px;">                 
                                        </div>
                                        <div class="col-lg-6" style="text-align:center; overflow:hidden">
                                            <button style="font-size: 13px;
                                                color: #fff;
                                                background: #850049;
                                                background: linear-gradient(-145deg, #850049 0%, #e30425 100%);
                                                padding: 12px 30px;
                                                display: inline-block;
                                                border-radius: 5px;
                                                font-weight: 500;
                                                text-transform: uppercase;
                                                transition: all .3s;" >Ukloni sliku
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <br>
            <br>
            
            <div class="row" style="overflow:auto;<?php if(count($slike)>=5) echo "visibility:hidden"?>">
                <div class="col-lg-12" style="padding-top:50pt">
                    <form method="POST" action="<?= site_url("salon/addImage")?>" enctype="multipart/form-data">
                        <label> Nova slika:</label>
                        <input type="file" name= "image" accept="image/*" required> 
                        <button type="submit" style="font-size: 13px;
                                                color: #fff;
                                                background: #850049;
                                                background: linear-gradient(-145deg, #850049 0%, #e30425 100%);
                                                padding: 12px 30px;
                                                display: inline-block;
                                                border-radius: 5px;
                                                font-weight: 500;
                                                text-transform: uppercase;
                                                transition: all .3s;"> 
                                                Dodaj sliku </button>
                    </form>
                </div>
            </div>
        </div>
</section>


<?= $this->endSection() ?>