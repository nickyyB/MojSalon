<?php
/*
* Autor: Nikola Brkovic 0647/2014
*
*/
?>

<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<title>Registracija - MojSalon</title>
<section class="contact-us" style="margin-bottom: -110px;">
  <div class="container">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
        <form id="contact" action='<?php site_url('Guest/regSalon') ?>' method="post" enctype="multipart/form-data" style="margin-left:0px; margin-bottom: 40px">
          <div class="row g-0">
            <div class="col-xl-6">
              <div class="card-body p-md-5 text-black">
                <?php
                if (!empty($errors)) {
                  echo "<div class='alert alert-danger'>";
                  foreach ($errors as $error) echo "<p style='font-size:15px; color:red; margin-bottom:0px'>" . $error . "</p>";
                  echo "</div>";
                }
                ?>
                <div class="section-heading">
                  <h6>Registrujte se</h6>
                  <h4>Postanite deo <em>MojSalon</em> porodice!</h4>
                  <p>Polja označena zvezdicom su obavezna. Nakon popunjavanja pritisnite na dugme "Registracija".</p>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-4">
                    <input type="name" name="name" placeholder="Naziv salona*" value="<?= set_value('name') ?>">
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
                    <input type="name" name="adress" placeholder="Adresa*" value="<?= set_value('adress') ?>">
                  </div>
                  <div class="col-md-6 mb-4">
                    <fieldset>
                      <select class="selekcija" name='state' id="state">
                        <option disabled selected>Odaberite opštinu*</option>
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

                <div class="row">
                  <div class="col-md-6 mb-4">
                    <input type="name" name="pib" placeholder="PIB*" value="<?= set_value('pib') ?>">
                  </div>
                  <div class="col-md-6 mb-4">
                    <input type="text" name="email" placeholder="Adresa e-pošte*" value="<?= set_value('email') ?>">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <input type="name" name="phone" placeholder="Broj telefona*" value="<?= set_value('phone') ?>">
                  </div>
                  <div class="col-md-6" style="text-align: center">
                    <fieldset>
                      <label for="file" class="center" style="position: absolute; margin-top:-20px">Logo vaše firme(do 64KB)*</label>
                      <input type="file" name="logo" class='center' style="padding-top:8px" />
                      <!--accept="image/png, image/jpeg" -->
                    </fieldset>
                  </div>
                </div>
                <!-- RADNO VREME -->
                <div class="row">
                  <div class="col-md-12">
                    <h6 style="text-align: center;padding-bottom: 15pt">Radno vreme</h6>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <label for="scales" style="vertical-align:text-top;width:50pt;">Ponedeljak</label> <input type="checkbox" id="scales" name="mon" <?php if (isset($_POST['mon'])) echo 'checked'; ?> style="width:25%;height:25%;margin-top:10px">
                  </div>
                  <div class="col-md-3" style="text-align: center">
                    <fieldset>
                      <label for="file" class="center" style="position: absolute; margin-top:-20px">Od:</label>
                      <input type="time" id="appt" name="MondayFrom" value="<?= set_value('MondayFrom') ?>">
                    </fieldset>
                  </div>
                  <div class="col-md-3" style="text-align: center">
                    <fieldset>
                      <label for="file" class="center" style="position: absolute; margin-top:-20px">Do:</label>
                      <input type="time" id="appt" name="MondayTo" value="<?= set_value('MondayTo') ?>">
                    </fieldset>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <label for="scales" style="vertical-align:text-top;width:50pt;">Utorak</label> <input type="checkbox" id="scales" name="tue" <?php if (isset($_POST['tue'])) echo 'checked'; ?> style="width:25%;height:25%;margin-top:10px">
                  </div>
                  <div class="col-md-3" style="text-align: center">
                    <fieldset>
                      <label for="file" class="center" style="position: absolute; margin-top:-20px">Od:</label>
                      <input type="time" id="appt" name="TuesdayFrom" value="<?= set_value('TuesdayFrom') ?>">
                    </fieldset>
                  </div>
                  <div class="col-md-3" style="text-align: center">
                    <fieldset>
                      <label for="file" class="center" style="position: absolute; margin-top:-20px">Do:</label>
                      <input type="time" id="appt" name="TuesdayTo" value="<?= set_value('TuesdayTo') ?>">
                    </fieldset>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <label for="scales" style="vertical-align:text-top;width:50pt;">Sreda</label> <input type="checkbox" id="scales" name="wed" <?php if (isset($_POST['wed'])) echo 'checked'; ?> style="width:25%;height:25%;margin-top:10px">
                  </div>
                  <div class="col-md-3" style="text-align: center">
                    <fieldset>
                      <label for="file" class="center" style="position: absolute; margin-top:-20px">Od:</label>
                      <input type="time" id="appt" name="WednesdayFrom" value="<?= set_value('WednesdayFrom') ?>">
                    </fieldset>
                  </div>
                  <div class="col-md-3" style="text-align: center">
                    <fieldset>
                      <label for="file" class="center" style="position: absolute; margin-top:-20px">Do:</label>
                      <input type="time" id="appt" name="WednesdayTo" value="<?= set_value('WednesdayTo') ?>">
                    </fieldset>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <label for="scales" style="vertical-align:text-top;width:50pt;">Četvrtak</label> <input type="checkbox" id="scales" name="thu" <?php if (isset($_POST['thu'])) echo 'checked'; ?> style="width:25%;height:25%;margin-top:10px">
                  </div>
                  <div class="col-md-3" style="text-align: center">
                    <fieldset>
                      <label for="file" class="center" style="position: absolute; margin-top:-20px">Od:</label>
                      <input type="time" id="appt" name="ThursdayFrom" value="<?= set_value('ThursdayFrom') ?>">
                    </fieldset>
                  </div>
                  <div class="col-md-3" style="text-align: center">
                    <fieldset>
                      <label for="file" class="center" style="position: absolute; margin-top:-20px">Do:</label>
                      <input type="time" id="appt" name="ThursdayTo" value="<?= set_value('ThursdayTo') ?>">
                    </fieldset>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <label for="scales" style="vertical-align:text-top;width:50pt;">Petak</label> <input type="checkbox" id="scales" name="fri" <?php if (isset($_POST['fri'])) echo 'checked'; ?> style="width:25%;height:25%;margin-top:10px">
                  </div>
                  <div class="col-md-3" style="text-align: center">
                    <fieldset>
                      <label for="file" class="center" style="position: absolute; margin-top:-20px">Od:</label>
                      <input type="time" id="appt" name="FridayFrom" value="<?= set_value('FridayFrom') ?>">
                    </fieldset>
                  </div>
                  <div class="col-md-3" style="text-align: center">
                    <fieldset>
                      <label for="file" class="center" style="position: absolute; margin-top:-20px">Do:</label>
                      <input type="time" id="appt" name="FridayTo" value="<?= set_value('FridayTo') ?>">
                    </fieldset>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <label for="scales" style="vertical-align:text-top;width:50pt;">Subota</label> <input type="checkbox" id="scales" name="sat" <?php if (isset($_POST['sat'])) echo 'checked'; ?> style="width:25%;height:25%;margin-top:10px">
                  </div>
                  <div class="col-md-3" style="text-align: center">
                    <fieldset>
                      <label for="file" class="center" style="position: absolute; margin-top:-20px">Od:</label>
                      <input type="time" id="appt" name="SaturdayFrom" value="<?= set_value('SaturdayFrom') ?>">
                    </fieldset>
                  </div>
                  <div class="col-md-3" style="text-align: center">
                    <fieldset>
                      <label for="file" class="center" style="position: absolute; margin-top:-20px">Do:</label>
                      <input type="time" id="appt" name="SaturdayTo" value="<?= set_value('SaturdayTo') ?>">
                    </fieldset>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 mb-4">
                    <label for="scales" style="vertical-align:text-top;width:50pt;">Nedelja</label> <input type="checkbox" id="scales" name="sun" <?php if (isset($_POST['sun'])) echo 'checked'; ?> style="width:25%;height:25%;margin-top:10px">
                  </div>
                  <div class="col-md-3 mb-4" style="text-align: center">
                    <fieldset>
                      <label for="file" class="center" style="position: absolute; margin-top:-20px">Od:</label>
                      <input type="time" id="appt" name="SundayFrom" value="<?= set_value('SundayFrom') ?>">
                    </fieldset>
                  </div>
                  <div class="col-md-3 mb-4" style="text-align: center">
                    <fieldset>
                      <label for="file" class="center" style="position: absolute; margin-top:-20px">Do:</label>
                      <input type="time" id="appt" name="SundayTo" value="<?= set_value('SundayTo') ?>">
                    </fieldset>
                  </div>
                </div>

                <div class="d-flex justify-content-end pt-3">
                  <button type="submit" id="form-submit" class="main-gradient-button center">Registracija</button>
                </div>

              </div>
            </div>
            <div class="col-xl-6 d-none d-xl-block">
              <img src="/assets/images/slika.jpg" alt="Sample photo" class="img-fluid" style="border-top-left-radius: .25rem; border-bottom-left-radius: .25rem;height:90%;padding-top:150pt;width:95%" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php
  ##TESTA FAZA NISU OBRADJENI IZUZECI OVO JE SAMO PROBA!!!
  if (array_key_exists('potvrdi', $_POST)) {
    $naziv = $_POST['naziv'];
    $adresa = $_POST['adresa'];
    $pib = $_POST['pib'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];
    $kIme = $_POST['kIme'];
    $lozinka = $_POST['lozinka'];
    $opstina = $_POST['opstina'];
    $logo = file_get_contents($_FILES['logo']['tmp_name']);

    /* INICIJALNO SAMO PROBA NA TEST BAZU BEZ KORISCENJA DATABASE CODEIGNITER OPCIJE*/
    $db = new PDO("mysql:host=localhost;dbname=mojsalon2;charset=utf8", "root", "");

    $query = $db->prepare("INSERT INTO korisnik(email, kime, lozinka, telefon) values(?,?,?,?)");
    $query->bindParam(1, $email);
    $query->bindParam(2, $kIme);
    $query->bindParam(3, $lozinka);
    $query->bindParam(4, $telefon);
    $query->execute();

    $query = $db->prepare("SELECT * FROM korisnik WHERE email=:email");
    $query->execute(['email' => $email]);
    $res = $query->fetch();

    $id = $res['idKorisnik'];
    #var_dump($id);

    $query = $db->prepare("INSERT INTO salon(idsalon, naziv, adresa, opstina, pib, logo, ekstenzija) values(?,?,?,?,?,?,?)");
    $query->bindParam(1, $id);
    $query->bindParam(2, $naziv);
    $query->bindParam(3, $adresa);
    $query->bindParam(4, $opstina);
    $query->bindParam(5, $pib);
    $query->bindParam(6, $logo);
    $query->bindParam(7, $_FILES['logo']['type']);
    #var_dump($query);
    $query->execute();
  }
  ?>
  <script type="text/javascript">
    <?php if (isset($_POST['state'])) : ?>
      document.getElementById('state').value = "<?= $_POST['state']; ?>";
    <?php endif; ?>
  </script>
</section>

<?= $this->endSection() ?>