<?php
/*
* Autor: Nikola Brkovic 0647/2014
*
*/
?>
<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<title>Početna - MojSalon</title>
<section class="main-banner" id="top">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 align-self-center">
        <div class="header-text">
        <?php
                if (!empty($errors)) {
                  echo "<div class='alert alert-danger'>";
                  foreach ($errors as $error) echo "<p style='font-size:15px; color:red; margin-bottom:0px'>" . $error . "</p>";
                  echo "</div>";
                }
                
        ?>
          <h6>Postanite deo mojSalon porodice!</h6>
          <h2>Pronađite odgovarajući <em>salon</em> za sve Vaše potrebe!</h2>
          <div class="main-button-gradient">
            <a href="/Guest/regUser">Registrujte se!</a>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="right-image">
          <img src="/assets/images/logo.jpg" alt="">
        </div>
      </div>
    </div>
  </div>
</section>

<section class="services" id="services">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="section-heading">
          <h4>Preporučeni <em>saloni</em></h4>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="row">
          <?php foreach ($niz as $salon) : ?>
            <div class="card col-lg-3 col-md-6 col-sm-12">
              <a href="/Guest/salon/<?php echo $salon->idSalon ?>">
                <div class="card-body">
                  <div class="card-img-top">
                    <?php echo "<embed class='card-img-top' src='data:" . $salon->ekstenzija . ";base64," . base64_encode($salon->logo) . "' width='180' height='160'/>"; ?>
                  </div>
                  <h4 class="card-title" style="text-align:center"><?php echo $salon->naziv; ?></h4>
                  <p class="card-text" style="text-align:center;bottom: 0;left: 26%;position: absolute"><em>POGLEDAJ PONUDU</em></p>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="simple-cta">
  <div class="container">
    <div class="row">
      <div class="col-lg-5 offset-lg-1">
        <div class="left-image">
          <img src="/assets/images/haird.png" alt="">
        </div>
      </div>
      <div class="col-lg-5 align-self-center">
        <h6>Želite da se Vaš salon nađe u našoj ponudi?</h6>
        <h4>Registrujte Vaš salon za samo 5 minuta!</h4>
        <br>
        <div class="white-button">
          <a href="/Guest/regSalon">Registruj salon!</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>