<?php

/*
* Autor: Nikola Brkovic 0647/2014
*
*/
?>


<?php !isset($user) ? $this->extend('layouts/app') : $this->extend('layouts/app_user'); ?>

<?= $this->section('content') ?>
<title>Pregled salona</title>
<section class="main-banner" id="top">
    <div class="container">
      <div class="row">
        <div class="col-lg-9 center" style="z-index: 2">
          <div class="header-text">
            <h4 align="center">Pronađite odgovarajući <em style="font-style: normal;color: #850049">salon</em> za sve Vaše potrebe!</h4>
            <h2 align="center">Pretraga salona</h2>
            <div class="form-group">
                <div class="input-group" style="padding-bottom:5pt">
                    <input type="text" name="search" id="search" placeholder="Pretraga po nazivu salona" class="form-control" />
                </div>
            </div>
          </div>
            <div class="filter col-md-12">
        <div class="row">
            <?php if(!isset($user)) echo '<div class="col-md-4 mb-4">';  
                  else echo '<div class="col-md-3 mb-4">';
            ?>
                <fieldset style="">
                    <select class="selekcija" name='state' id='state' ">
                        <option value=''>Opština</option>                    
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
            <?php if(!isset($user)) echo '<div class="col-md-4 mb-4">';  
                  else echo '<div class="col-md-3 mb-4">';
            ?>
                <fieldset style="">
                    <select class="selekcija" name='type' id='type' ">
                        <option selected value='0'>Tip usluge</option>                    
                        <?php foreach($services as $service): ?>
                            <option value='<?= $service->idTip; ?>'> <?= $service->naziv ?></option>
                        <?php endforeach; ?>
                    </select>
                </fieldset>
            </div>
            <?php if(isset($user) && isset($opstina->opstina)): ?> 
            <div class="col-md-3 mb-4">
                <fieldset style="">
                    <select class="selekcija" name='statePersonal' id='statePersonal'">
                        <option selected value=''>Lični</option>                    
                        <option value='<?= $opstina->opstina ?>'>Meni najbliži</option>           
                    </select>
                </fieldset>
            </div>
            <?php endif;  ?>
            <?php if(!isset($user)) echo '<div class="col-md-4 mb-4">';  
                  else echo '<div class="col-md-3 mb-4">';
            ?>
                <fieldset style="">
                    <select class="selekcija" name='price' id='price'">
                        <option value='0|0'>Cena</option>                    
                        <option value='0|2000'>0-2000</option>
                        <option value='2000|5000'>2000-5000</option>
                        <option value='5000|10000'>5000-10000</option>
                        <option value='10001|max'>10000+</option>
                    </select>
                </fieldset>
            </div>
         </div>
    </div>
        </div>
      </div>
    </div>
    <script>
        
        $(document).ready(function() {
                function getSalons(name, state='', type=0, price='0|0', page=1){
                            //console.log(price);
                            $.ajax({
                            type: "GET",
                            //search radi za guest korisnika i osnovnog ulogovanog korisnika
                            url: "<?= !isset($controller) ? base_url('/Guest') : base_url($controller) ?>/search",
                            //Sta saljemo
                            dataType:'json',
                            data: {
                                //search = name 
                                search: name,
                                page: page,
                                //filteri
                                state: state,
                                type: type,
                                price: price
                            },
                            success: function(data) {
                                console.log(data);
                                $('#test').html('');
                                $('#stranice').html('');
                                $('#kolicinaSadrzaja').html('');
                                
                                var pageRow = '1';
                                var content = '';
                                if(data.salons.length<5 && data.page>1){
                                    content = data.total_data + ' od ' + data.total_data;
                                }
                                else {
                                    content = (data.salons.length*data.page) + ' od ' + data.total_data;
                                }

                                var count = Math.ceil(data.total_data/5);
                                //console.log(content);
                                if(count > 1 && data.page<count && data.page>1){
                                    pageRow = '<a href="#" value="' + (data.page-1) + '" id="' + (data.page-1) + '">&laquo;</a> '; 
                                    pageRow += '<a href="#" value="' + data.page + '" id="' + data.page + '">'+ data.page + '</a>';
                                    pageRow += ' od ';
                                    pageRow += count;
                                    pageRow += ' <a href="#" value="' + (data.page+1) + '" id="' + (data.page+1) + '">&raquo;</a>';
                                }
                                else if (count > 1 && data.page==1){
                                    pageRow = '<a value="' + (data.page-1) + '" id="' + (data.page-1) + '">&laquo;</a> '; 
                                    pageRow += '<a href="#" value="' + data.page + '" id="' + data.page + '">'+ data.page + '</a>';
                                    pageRow += ' od ';
                                    pageRow += count;
                                    pageRow += ' <a href="#" value="' + (data.page+1) + '" id="' + (data.page+1) + '">&raquo;</a>';
                                }
                                else if(count > 1 && data.page==count){
                                    pageRow = '<a href="#" value="' + (data.page-1) + '" id="' + (data.page-1) + '">&laquo;</a> ';
                                    pageRow += '<a href="#" value="' + data.page + '" id="' + data.page + '">'+ data.page + '</a>';
                                    pageRow += ' od ';
                                    pageRow += count;
                                    pageRow += ' <a value="' + (data.page) + '" id="' + (data.page) + '">&raquo;</a>';
                                }
                                
                                $("#kolicinaSadrzaja").append(content);
                                
                                $.each(data.salons, function(index, value){
                                    var tableRow = '';
                                    a = '<li class="active" style="margin-bottom: 20pt;"><div><div class="left-content"><h4>';
                                    //value.naziv;
                                    //staticki ocena 1, kad se uradi ocenjivanje na osnovu ocene prikazivacemo tacan broj zvezdica
                                    b = '</h4><p style="margin-bottom: 10px">'+value.adresa+'</p><span class="stars">'+value.rejting+'</span><div class="text-button"><a href="<?= !isset($controller) ? base_url('/Guest') : base_url($controller) ?>/salon/';
                                    b1 = '">Rezerviši termin</a></div></div>';
                                    c = '<div class="right-image">';
                                    tekst1 = '<img class="card-img-top" style="width:180px; height:160px" src="data:';
                                    //value.ekstenzija;
                                    tekst2=';base64,';
                                    //value.logo;
                                    kraj= '" /></div></div></li>'; 
                                    tableRow = a + value.naziv + b + value.idSalon + b1 + c + tekst1 + value.ekstenzija + tekst2 + value.logo + kraj;
                                    $("#test").append(tableRow);
                                });
                                
                                $("#stranice").append(pageRow);
                                $('.stars').stars();
                            }
                        })
                }
                
                $("#search").keyup(function() {
                    var name = $('#search').val();
                    var state = $('#state').val(); 
                    var type = $('#type').val();
                    var price = $('#price').val();
                    //console.log(state);
                    //Ako nista nismo ukucali
                    if (name == "") {
                        getSalons('', state, type, price);
                    }
                    else {
                        getSalons(name, state, type, price);
                    }
                });
                
                
                $("#stranice").on('click','a',function(){
                    var name = $('#search').val();
                    var state = $('#state').val();
                    var type = $('#type').val();
                    var price = $('#price').val();
                    var page = this.id;
                    getSalons(name,state,type,price,page);
                });
                
                document.getElementById("type").addEventListener("change", function(){
                    var name = $('#search').val();
                    var state = $('#state').val(); 
                    var type = $('#type').val();
                    var price = $('#price').val();
                    getSalons(name, state, type, price);
                });
                
                document.getElementById("state").addEventListener("change", function(){
                    var name = $('#search').val();
                    var state = $('#state').val(); 
                    var type = $('#type').val();
                    var price = $('#price').val();
                    getSalons(name, state, type, price);
                });
                
                document.getElementById("price").addEventListener("change", function(){
                    var name = $('#search').val();
                    var state = $('#state').val(); 
                    var type = $('#type').val();
                    var price = $('#price').val();
                    getSalons(name, state, type, price);
                });
                
                $.fn.stars = function() {
                    return this.each(function(i,e){$(e).html($('<span/>').width($(e).text()*16));});
                };
                
                <?php if(isset($user) && isset($opstina->opstina)): ?>
                    document.getElementById("statePersonal").addEventListener("change", function(){
                        var name = $('#search').val();
                        var state = $('#statePersonal').val(); 
                        var type = $('#type').val();
                        var price = $('#price').val();
                        getSalons(name, state, type, price);
                    });
                <?php endif; ?>
                
                window.onload = function(){getSalons('');}
        });
    </script>
    
    
</section>
<section class="our-team" style="height:1100pt; margin-top:0pt">
    <div class="container">
        <div class="row">
            <div id="kolicinaSadrzaja" style="text-align: center; z-index:1">
                
            </div>
            <div class="col-lg-12">
                <ul class="nacc" id="test">
                    
                </ul>
            </div>
            <div id="stranice" style="text-align: center; z-index:1">
                    
                
            </div>
        </div>
    </div>
    <style>
                span.stars, span.stars>* {
                    display: inline-block;
                    background: url(http://i.imgur.com/YsyS5y8.png) 0 -16px repeat-x;
                    width: 80px;
                    height: 16px;
                }
                span.stars>*{
                    max-width:80px;
                    background-position: 0 0;
                }
    </style>
</section>


<?= $this->endSection() ?>

