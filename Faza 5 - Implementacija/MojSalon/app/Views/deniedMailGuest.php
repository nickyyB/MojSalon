<?php

/*
* Autor: Petar Jovovic 0352/19
*/

?>

<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<title>Mejl poslat - MojSalon</title>
<section class="contact-us">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">

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
              

            </div>
          </div>
          <div class="col-lg-12">


          </div>






          <div class="col-lg-12">

            

          </div>

        </div>

      </div>
    </div>
  </div>
</section>
<?= $this->endSection() ?>