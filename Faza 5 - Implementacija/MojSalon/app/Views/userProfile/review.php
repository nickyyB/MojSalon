<?php
/*
* Autor: Danica Jakovljevic 0305/2019
*
*/
?>

<?= $this->extend('layouts/app_user') ?>

<?= $this->section('content') ?>
<title>Ocenite uslugu - MojSalon</title>
<link rel="stylesheet" href="/assets/css/style-danica.css">

<section class="contact-us">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form id="review" action="<?php echo site_url("/User/review/{$appointmentId}") ?>" method="post">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-heading">
                                <?php
                                if ($errorMessage != "") {
                                    echo "<div class=\"alert alert-danger\">";
                                    echo "<p style='font-size:15px; color:red; margin-bottom:0px'>" . $errorMessage . "</p>";
                                    echo "</div>";
                                }
                                ?>
                                <h4>Ocenite uslugu</h4>
                                <p>Molimo popunite polje za ocenu, ostavite komentar ako želite i pritisnite na dugme "Potvrdi".</p>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div>
                                <fieldset>
                                    <label for="rating-1">1</label>
                                    <input class="appointment-review-input" type="radio" name="rating" id="rating-1" value="1">
                                    <label for="rating-2">2</label>
                                    <input class="appointment-review-input" type="radio" name="rating" id="rating-2" value="2">
                                    <label for="rating-3">3</label>
                                    <input class="appointment-review-input" type="radio" name="rating" id="rating-3" value="3">
                                    <label for="rating-4">4</label>
                                    <input class="appointment-review-input" type="radio" name="rating" id="rating-4" value="4">
                                    <label for="rating-5">5</label>
                                    <input class="appointment-review-input" type="radio" name="rating" id="rating-5" value="5">
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <?php
                                if (!empty($errors)) {
                                    echo "<div class=\"alert alert-danger\">";
                                    foreach ($errors as $error) echo "<p style='font-size:15px; color:red; margin-bottom:0px'>" . $error . "</p>";
                                    echo "</div>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <fieldset>
                                <textarea name="comment" id="comment" cols="30" rows="10" maxlength="255" placeholder="Vaš komentar"><?php if ($comment) echo htmlspecialchars($comment) ?></textarea>
                            </fieldset>
                        </div>
                        <div class="col-lg-12">
                            <fieldset>
                                <button type="submit" id="form-submit" class="main-gradient-button">Potvrdi</button>
                            </fieldset>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>