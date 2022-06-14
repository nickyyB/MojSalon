<?php

/*
* Autor: Petar Jovovic 0352/19
*/

?>

<?= $this->extend('layouts/app_salon') ?>

<?= $this->section('content') ?>
<title>Nova usluga - MojSalon</title>
<section class="contact-us">
  <div class="container">
    <div class="row">
      <div class="col-lg-12" style="padding-bottom: 160pt;">
        <form id="contact" action="<?= site_url("salon/addService") ?>" method="post" style="margin-left:0px;">
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
                <h4>Kreirajte uslugu</h4>
                <p>Popunite neophodna polja i pritisnite na dugme "Dodaj".</p>
              </div>
            </div>
            <div class="col-lg-12">
              <fieldset>
                <input type="name" name="naziv" id="name" placeholder='naziv' autocomplete="on" required>
              </fieldset>
            </div>
            <div class="col-lg-12">
              <fieldset>
                <input type="name" name="cena" id="cena" placeholder='cena' autocomplete="on" required>
              </fieldset>
            </div>


            <div class="col-lg-12">
              <fieldset>
                <input type="name" name="trajanje" id="trajanje" placeholder='trajanje' autocomplete="on" required>
              </fieldset>
            </div>
            <div class="col-lg-12">
              <fieldset>
                <select class="form-select" name='tip' required>
                  <option disabled>Kategorija tretmana</option>

                  <?php foreach ($tipovi as $tip) : ?>
                    <option><?php echo $tip->naziv ?>


                    <?php endforeach; ?>

                </select>
              </fieldset>
            </div>



            <div class="col-lg-12">
              <fieldset>
                <button type="submit" id="form-submit" class="main-gradient-button">Dodaj</button>
              </fieldset>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<?= $this->endSection() ?>