<?php

/*
* Autor: Petar Jovovic 0352/19
*/

?>

<?= $this->extend('layouts/app_user') ?>

<?= $this->section('content') ?>
<title>Podrška - MojSalon</title>
<section class="contact-us">
  <div class="container" style="padding-bottom:270pt">
    <div class="row">
      <div class="col-lg-12">
        <form id="contact" action="<?= site_url('User/send_mail_user') ?>" method="post" style="margin-left:0px;">
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
                <h4>Kontaktirajte nas</h4>

              </div>
            </div>
            <div class="col-lg-12">
            
              
            </div>
            <div class="col-lg-12">
              <fieldset>
                <textarea name="message" id="message" placeholder="Vaša poruka" required ></textarea>
              </fieldset>
            </div>





            <div class="col-lg-12">
              <fieldset>
                <button type="submit" id="form-submit" class="main-gradient-button">Pošalji</button>
              </fieldset>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<?= $this->endSection() ?>