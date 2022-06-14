<?php

/*
* Autor: Nikola Brkovic 0647/2014
*
*/
#$router = service('router');

#var_dump(current_url());

#$uri = current_url(true);

#echo $uri->getSegment(2);


#$method = ruter()->methodName();
#echo $method;


#echo site_url("Guest/login");

var_dump($errors2);

    /*if($errors2['mon']=='on'){
        $from = $errors2['monFrom'];
        $to = $errors2['monTo'];
        if($from > $to) echo "PRVI VECI";
        else echo "DRUGI JE VECI";
        echo "/n" . $from . "-" . $to;
    }*/

#var_dump($niz);

#var_dump(json_encode($errors));

#echo "<embed class='card-img-top' src='data:".$errors['ekstenzija'].";base64,".base64_encode($errors['logo'])."' width='180' height='160'/>";

?>

<!--
<!DOCTYPE html>
<html>
    <head>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="proba">
          <input type="text" id="search"/>          
        </div>
        <div id="display">
            
        </div>
        
        <div id="dRow">
            
        </div>
        
        <script>
            $(document).ready(function() {
                //On pressing a key on "Search box" in "search.php" file. This function will be called.
                $("#search").keyup(function() {
                    //Assigning search box value to javascript variable named as "name".
                    var name = $('#search').val();
                    console.log(name);
                    //Validating, if "name" is empty.
                    if (name == "") {
                        //Assigning empty value to "display" div in "search.php" file.
                        $("#display").html("");
                    }
                    else {
                        $.ajax({
                            type: "GET",
                            url: "<?= base_url(); ?>/Guest/search",
                            //Data, that will be sent to "ajax.php".
                            dataType:'json',
                            data: {
                                //search = name 
                                search: name
                            },
                            success: function(data) {
                                //console.log(data);
                                tekst1 = '<img class="card-img-top" src="data:';
                                tekst2=';base64,';
                                tekst3='" width="180" height="160"/>';
                                $('#dRow').html('');
                                $.each(data, function(index, value){
                                    //$("#dRow").append(value.naziv + '<br>');
                                    $("#dRow").append(tekst1 + value.ekstenzija + tekst2 + value.logo + tekst3);
                                });
                            }
                        });
                    }
                });
             });
        </script>
    </body>
</html>