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
    <link rel="shortcut icon" href="/assets/images/logo_org.jpg" type="image/x-icon">
    <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
                            <li class="scroll-to-section"><a href="<?= site_url() ?>" class="
                                <?php if ($method == null or $method == 'index') echo "active"; ?>">Početna</a></li>

                            <li><a href="/User/searchSalons" class="
                                <?php if ($method == 'searchSalons') echo "active"; ?>">Saloni</a></li>
                            <li><a href="/User/support_page" class="
                                <?php if ($method == 'support_page') echo "active"; ?>">Support</a></li>

                            <li class="has-sub">
                                <a onclick="test(this.id);" id="grupa1" class="
                                  <?php $methods = ['appointments', 'status', 'changeProfile'];
                                    if (in_array($method, $methods)) echo "active"; ?>" style="text-transform: none;">Dobro došao <?= $user->kIme ?>
                                </a>
                                <ul class="sub-menu" id="1" style="padding-left:0px">
                                    <li><a href="/<?= $controller ?>/appointments">Moji termini</a></li>
                                    <li><a href="/<?= $controller ?>/status">Status</a></li>
                                    <li><a href="/<?= $controller ?>/changeProfile">Izmeni profil</a></li>
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


</body>

</html>