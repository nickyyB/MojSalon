<?php

/*
* Autor: Petar Jovovic 0352/19
*/

?>

<?= $this->extend('layouts/app_user') ?>

<?= $this->section('content') ?>
<title>Korisnik - izmena profila - MojSalon</title>
<section class="contact-us">
  <div class="container" style="padding-bottom: 150pt">
    <div class="row">
      <div class="col-lg-12">
        <form id="contact" action="<?= site_url("/User/change_data") ?>" method="post" style="margin-left:0px;">
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
              

                <!--<h6>Registrujte se</h6>-->
                <h4>Izmenite profil</h4>
                <p>Popunite zeljena polja za izmenu i pritisnite na dugme "Sacuvaj".</p>
              </div>
            </div>
            <div class="col-lg-12">
              <fieldset>
                <input type="name" name="name" id="name" value="<?php echo $podaci->ime ?>" autocomplete="on"  >
              </fieldset>
            </div>
            <div class="col-lg-12">
              <fieldset>
                <input type="name" name="surname" id="surname" value="<?php echo $podaci->prezime ?>" autocomplete="on"   >
              </fieldset>
            </div>


            <div class="col-lg-12">
            <fieldset>
            <select class="selekcija" name='munc' id="munc">
                              <option value='Voždovac'<?php if(strcmp($podaci->opstina,"Voždovac")==0) {echo 'selected="selected"';}?>>Voždovac</option>
                              <option value='Vračar'<?php if(strcmp($podaci->opstina,"Vračar")==0) {echo 'selected="selected"';}?>>Vračar</option>
                              <option value='Zvezdara'<?php if(strcmp($podaci->opstina,"Zvezdara")==0) echo 'selected="selected"'?>>Zvezdara</option>
                              <option value='Zemun'<?php if(strcmp($podaci->opstina,"Zemun")==0) echo 'selected="selected"'?>>Zemun</option>
                              <option value='Novi Beograd'<?php if(strcmp($podaci->opstina,"Novi Beograd")==0) echo 'selected="selected"'?>>Novi Beograd</option>
                              <option value='Palilula'<?php if(strcmp($podaci->opstina,"Palilula")==0) echo 'selected="selected"'?>>Palilula</option>
                              <option value='Rakovica'<?php if(strcmp($podaci->opstina,"Rakovica")==0) {echo 'selected="selected"';}?>>Rakovica</option>
                              <option value='Savski Venac'<?php if(strcmp($podaci->opstina,"Savski Venac")==0) echo 'selected="selected"'?>>Savski Venac</option>
                              <option value='Stari grad'<?php if(strcmp($podaci->opstina,"Stari grad")==0) echo 'selected="selected"'?>>Stari grad</option>
                              <option value='Čukarica'<?php if(strcmp($podaci->opstina,"Čukarica")==0) {echo 'selected="selected"';}?>>Čukarica</option>
                            </select>
              </fieldset>
            </div>
            
            <div class="col-lg-12">
              <fieldset>
                <input type="name" name="phone" id="phone" value="<?php echo $podaci->telefon ?>" autocomplete="on" >
              </fieldset>
            </div>
            


            <div class="col-lg-12">
              <fieldset>
                <button type="submit" id="form-submit" class="main-gradient-button">Sacuvaj</button>
              </fieldset>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<?= $this->endSection() ?>