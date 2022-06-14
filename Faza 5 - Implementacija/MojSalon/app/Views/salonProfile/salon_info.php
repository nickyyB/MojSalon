<?php

/*
* Autor: Mihajlo Micic 0565/2017
*/

?>

<?= $this->extend('layouts/app_salon') ?>

<?= $this->section('content') ?>
<title>Salon - <?php echo $salon->naziv ?></title>
<section class="contact-us">
    <div class="container" style="padding-bottom: 50pt">
        <div class="row">
            <div class="col-lg-12">
                <form id="contact" action="/salon/change_data" method="post" style="margin-left:0px;">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="section-heading">
                          <?php
                            if (!empty($errors)) {
                              echo "<div class='alert alert-danger'>";
                              foreach ($errors as $error) echo "<p style='font-size:15px; color:red; margin-bottom:0px'>" . $error . "</p>";
                              echo "</div>";
                            }
                          ?>

                          <h4>Izmenite profil</h4>
                          <p>Popunite željena polja za izmenu i pritisnite na dugme "Sačuvaj".</p>
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <fieldset>
                          Naziv:
                          <input type="name" name="name" id="name" value = "<?php echo $salon->naziv ?>" autocomplete="on" > 
                        </fieldset>
                      </div>
                      <div class="col-lg-12">
                        <fieldset>
                          Adresa:
                          <input type="address" name="address" id="address" value = "<?php echo $salon->adresa ?>" autocomplete="on" > 
                        </fieldset>
                      </div>
                      <div class="col-lg-12">
                        <fieldset>
                            Opština:
                            <select class="selekcija" name='munc' id="munc">
                              <option value='Voždovac'<?php if(strcmp($salon->opstina,"Voždovac")==0) {echo 'selected="selected"';}?>>Voždovac</option>
                              <option value='Vračar'<?php if(strcmp($salon->opstina,"Vračar")==0) {echo 'selected="selected"';}?>>Vračar</option>
                              <option value='Zvezdara'<?php if(strcmp($salon->opstina,"Zvezdara")==0) echo 'selected="selected"'?>>Zvezdara</option>
                              <option value='Zemun'<?php if(strcmp($salon->opstina,"Zemun")==0) echo 'selected="selected"'?>>Zemun</option>
                              <option value='Novi Beograd'<?php if(strcmp($salon->opstina,"Novi Beograd")==0) echo 'selected="selected"'?>>Novi Beograd</option>
                              <option value='Palilula'<?php if(strcmp($salon->opstina,"Palilula")==0) echo 'selected="selected"'?>>Palilula</option>
                              <option value='Rakovica'<?php if(strcmp($salon->opstina,"Rakovica")==0) {echo 'selected="selected"';}?>>Rakovica</option>
                              <option value='Savski Venac'<?php if(strcmp($salon->opstina,"Savski Venac")==0) echo 'selected="selected"'?>>Savski Venac</option>
                              <option value='Stari grad'<?php if(strcmp($salon->opstina,"Stari grad")==0) echo 'selected="selected"'?>>Stari grad</option>
                              <option value='Čukarica'<?php if(strcmp($salon->opstina,"Čukarica")==0) {echo 'selected="selected"';}?>>Čukarica</option>
                            </select>
                        </fieldset>
                      </div>
                      <div class="col-lg-12">
                        <fieldset>
                          Telefon:
                          <input type="name" name="phone" id="phone" value = "<?php echo $salon->telefon ?>" autocomplete="on" required> 
                        </fieldset>
                      </div>
                      
                      <div class="col-lg-12">
                        <fieldset>
                          <button type="submit" id="form-submit" class="main-gradient-button">
                            Sačuvaj</button>
                        </fieldset>
                      </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>