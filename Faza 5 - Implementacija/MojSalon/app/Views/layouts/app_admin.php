<?php
/*
* Autor: Nikola Brkovic 0647/2014
*
*/

?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="/assets/css/fontawesome.css">
        <link rel="stylesheet" href="/assets/css/templatemo-eduwell-style.css">
        <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">  
        <script src="/assets/jquery/jquery.min.js"></script>
        <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/assets/js/meni.js"></script>
    </head>
    
    <body>
    
    <header class="header-area header-sticky" >
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <nav class="main-nav" >
                      <!-- ***** Logo Start ***** -->
                      <a href="/" class="logo">
                          <img src="/assets/images/logo.jpg" style="height: 70px; width: 70px;">
                          MojSalon
                      </a>
                      <!-- ***** Logo End ***** -->
                      <!-- ***** Menu Start ***** -->
                      <ul class="nav" id="linkovi">
                        <li class="has-sub">
                            <a onclick="test(this.id);" id="grupa1" style="text-transform:none;" class="
                              <?php 
                              if($method==null or $method=='index' or $method=='users' or $method=='blockedUsers' or $method=='searchBlockedUsers') echo "active";?>">Korisnici</a>
                            <ul class="sub-menu" style="padding-left:0px" id="1">
                              <li><a href="<?= site_url() ?>">Aktivni</a></li> 
                              <li><a href="/<?= $controller ?>/blockedUsers">Blokirani</a></li> 
                            </ul>
                        </li> 
                        <li class="has-sub">
                            <a onclick="test(this.id);" id="grupa2" style="text-transform:none;" class="
                              <?php if($method=='activesalons' or $method=='blockedsalons' or $method=='salons' or $method=='regRequest') echo "active";?>">Saloni</a>
                            <ul class="sub-menu" style="padding-left:0px" id="2">
                              <li><a href="/<?= $controller ?>/activesalons">Aktivni</a></li> 
                              <li><a href="/<?= $controller ?>/blockedsalons">Blokirani</a></li> 
                              <li><a href="/<?= $controller ?>/regRequest">Zahtevi</a></li>
                            </ul>
                        </li>
                          <li class="has-sub">
                            <a onclick="test(this.id);" id="grupa3" id="link" style="text-transform:none;">Dobro došao <?= $user->kIme ?></a>
                            <ul class="sub-menu" style="padding-left:0px" id="3">
                              <li><a href="/<?= $controller ?>/logout">Izloguj se</a></li> 
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

    <?= view('layouts/smallFooter'); ?>
    <script></script>

</body>

</html>