<?php

/*
* Autor: Nikola Brkovic 0647/2014
*
*/

?>

<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<title>Registracija - MojSalon</title>
<section class="contact-us" style='margin-bottom: -110px;'>
  <div class="container">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
        <form id="contact" action="<?= site_url("Guest/regUser") ?>" method="post" style="margin-left:0px; margin-bottom: 40px">
          <div class="row g-0">
            <div class="col-xl-6">
              <div class="card-body p-md-5 text-black">
                <?php
                if (!empty($errors)) {
                  echo "<div class='alert alert-danger'>";
                  foreach ($errors as $error) echo "<p style='font-size:15px; color:red; margin-bottom:0px'>" . $error . "</p>";
                  echo "</div>";
                }
                if (!empty($message)) {
                  echo "<div class='alert alert-success'><p style='font-size:13px; color:green; margin-bottom:0px'>" . $message . "</p></div>";
                }
                ?>
                <div class="section-heading">
                  <h6>Registrujte se</h6>
                  <h4>Postanite deo <em>MojSalon</em> porodice!</h4>
                  <p>Polja označena zvezdicom su obavezna. Nakon popunjavanja pritisnite na dugme "Registracija".</p>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-4">
                    <input type="text" name="email" placeholder="Adresa e-pošte*" value="<?= set_value('email') ?>">
                  </div>
                  <div class="col-md-6 mb-4">
                    <input type="name" name="username" placeholder="Korisničko ime*" value="<?= set_value('username') ?>">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-4">
                    <input type="password" name="password" placeholder="Lozinka*">
                  </div>
                  <div class="col-md-6 mb-4">
                    <input type="password" name="password2" placeholder="Potvrda lozinke*">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-4">
                    <input type="name" name="name" placeholder="Ime" value="<?= set_value('name') ?>">
                  </div>
                  <div class="col-md-6 mb-4">
                    <input type="name" name="surname" placeholder="Prezime" value="<?= set_value('surname') ?>">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-4">
                    <input type="name" name="phone" placeholder="Broj telefona" value="<?= set_value('phone') ?>">
                  </div>
                  <div class="col-md-6 mb-4">
                    <fieldset>
                      <select class="selekcija" name='gender'>
                        <option disabled selected value='0'>Odaberite pol</option>
                        <option value='M'>Muški</option>
                        <option value='Z'>Ženski</option>
                      </select>
                    </fieldset>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-4">
                    <p style="text-align:center; font-size:14px; margin-bottom:0rem;margin-top: -18pt">Datum rođenja:</p>
                    <fieldset>
                      <input type="date" name="bday" class="center" id="name">
                    </fieldset>
                  </div>
                  <div class="col-md-6 mb-4">
                    <fieldset>
                      <select class="selekcija" name='state'>
                        <option disabled selected value='0'>Odaberite opštinu</option>
                        <option value='Voždovac'>Voždovac</option>
                        <option value='Vračar'>Vračar</option>
                        <option value='Zvezdara'>Zvezdara</option>
                        <option value='Zemun'>Zemun</option>
                        <option value='Novi Beograd'>Novi Beograd</option>
                        <option value='Palilula'>Palilula</option>
                        <option value='Rakovica'>Rakovica</option>
                        <option value='Savski Venac'>Savski Venac</option>
                        <option value='Stari grad'>Stari grad</option>
                        <option value='Čukarica'>Čukarica</option>
                      </select>
                    </fieldset>
                  </div>
                </div>

                <div class="d-flex justify-content-end pt-3">
                  <button type="submit" id="form-submit" class="main-gradient-button center">Registracija</button>
                </div>

              </div>
            </div>
            <div class="col-xl-6 d-none d-xl-block">
              <img src="/assets/images/test1.jpg" alt="Sample photo" class="img-fluid" style="border-top-left-radius: .25rem; border-bottom-left-radius: .25rem; padding-top: 100px;width:95%" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<?= $this->endSection() ?>