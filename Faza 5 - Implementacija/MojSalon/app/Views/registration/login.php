<?php

/*
* Autor: Nikola Brkovic 0647/2014
*
*/
?>


<?= $this->extend('layouts/app') ?>


<?= $this->section('content') ?>
<title>Prijava - MojSalon</title>
<section class="contact-us" id="contact-section" style="background-image:url(../assets/images/test.jpg);margin-bottom: -110px;">
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-4 center">
                <form id="contact" action="<?= site_url("Guest/login") ?>" method="post" style="margin-left:0px; margin-bottom: 40px">
                    <div class="row">
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
                        <div class="col-lg-12">
                            <div class="section-heading" style="text-align: center">
                                <h4> <em>Prijava</em></h4>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <fieldset>
                                <input type="text" name="username" id="name" placeholder="Korisničko ime ili email" value="<?= set_value('username') ?>">
                            </fieldset>
                        </div>
                        <div class="col-lg-12">
                            <fieldset>
                                <input type="password" name="password" id="password" placeholder="Lozinka">
                            </fieldset>
                        </div>
                        <div class="d-flex justify-content-end pt-3">
                            <button type="submit" id="form-submit" class="main-gradient-button center">Prijavi se</button>
                        </div>

                    </div>
                </form>
            </div>
            <div class="col-lg-12">
                <ul class="social-icons">

            </div>
            </ul>
        </div>
    </div>
</section>

<?= $this->endSection() ?>