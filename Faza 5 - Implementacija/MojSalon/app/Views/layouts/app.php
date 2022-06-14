<?php
$router = service('router');
/*
* Autor: Nikola Brkovic 0647/2014
* Autor: danabanana
*/

?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="/assets/css/fontawesome.css">
        <link rel="stylesheet" href="/assets/css/templatemo-eduwell-style.css">
        <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="shortcut icon" href="/assets/images/logo_org.jpg" type="image/x-icon">
        
        <script src="/assets/jquery/jquery.min.js"></script>
        <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/assets/js/meni.js"></script>
    </head>
    
    <body>
    
    <header class="header-area header-sticky">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <nav class="main-nav">
                      <!-- ***** Logo Start ***** -->
                      <a href="/" class="logo">
                          <img src="/assets/images/logo.jpg" style="height: 70px; width: 70px;">
                          MojSalon
                      </a>
                      <!-- ***** Logo End ***** -->
                      <!-- ***** Menu Start ***** -->
                      <ul class="nav" id="linkovi">
                          <li class="scroll-to-section"><a href="/" class="
                              <?php $method = $router->methodName(); 
                                    if($method==null or $method=='index') echo "active";?>">Početna</a></li>
                          <li><a href="/Guest/searchSalons" class="
                              <?php $method = $router->methodName(); 
                                    if($method=='searchSalons') echo "active";?>">Saloni</a></li>
                          <li><a href="/Guest/login" class="
                              <?php $method = $router->methodName(); 
                                    if($method=='login') echo "active";?>">Prijava</a></li> 
                          <li class="has-sub">
                            <a onclick="test(this.id);" id="grupa1"  class="
                              <?php $method = $router->methodName(); 
                                    if($method=='regUser' or $method=='regSalon') echo "active";?>">Registracija</a>
                            <ul class="sub-menu" style="padding-left:0px" id="1">
                              <li><a href="/Guest/regUser">Korisnik</a></li>
                              <li><a href="/Guest/regSalon">Salon</a></li>
                            </ul>
                          </li> 
                      </ul>        
                      <a class='menu-trigger' onclick="prikaziMeni();">
                          <span>Menu</span>
                      </a>
                      <!-- ***** Menu End ***** -->
                  </nav>
              </div>
          </div>
      </div>
    </header>


    <?= $this->renderSection('content') ?>

    <section class="contact-us" id="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div id="map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2830.7737632147328!2d20.474245516286228!3d44.80579907909863!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x475a7a9f59af917f%3A0xf9b50e9f0114cb72!2z0JXQu9C10LrRgtGA0L7RgtC10YXQvdC40YfQutC4INGE0LDQutGD0LvRgtC10YIsIDczLCDQkdC10L7Qs9GA0LDQtA!5e0!3m2!1ssr!2srs!4v1648038802715!5m2!1ssr!2srs" width="100%" height="420px" frameborder="0" style="border:0; border-radius: 15px; position: relative; z-index: 2;" allowfullscreen=""></iframe>
                        <div class="row">
                            <div class="col-lg-4 offset-lg-1">
                                <div class="contact-info">
                                    <div class="icon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <h4>Phone</h4>
                                    <span>011-555-333</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="contact-info">
                                    <div class="icon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <h4>Mobile</h4>
                                    <span>066-666-321</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <form id="contact" action="<?= site_url("Guest/send_mail_guest") ?>" method="post">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-heading">
                                    <h6>Imate primedbu ili savet za nas?</h6>
                                    <h4>Kontaktiraj <em>nas</em></h4>

                                </div>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <input type="name" name="name" id="name" placeholder="Ime" autocomplete="on" required>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <input type="text" name="email" id="email" pattern="[^ @]*@[^ @]*" placeholder="Adresa e-pošte" required="">
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <textarea name="message" id="message" placeholder="Vaša poruka" required></textarea>
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
                <div class="col-lg-12">
                    <ul class="social-icons">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fa fa-rss"></i></a></li>
                        <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                </div>
                    </ul>
            </div>
            <div class="col-lg-12">
                <p class="copyright" style="margin-bottom: 0rem">Copyright © 2022 najlePSI tim </p>
            </div>
        </div>
    </section>

    </body>
</html>