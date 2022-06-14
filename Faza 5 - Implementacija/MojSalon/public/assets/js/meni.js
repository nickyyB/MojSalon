	function prikaziMeni() {
          var x = document.getElementById("linkovi");
          if (x.style.display === "block") {
            x.style.display = "none";
            //$('.sub-menu').css('display', 'none')
          } else {
            x.style.display = "block";
            //$('.sub-menu').css('display', 'block')
          }
        }
        
        function test(id) {
          console.log(id);
          var x='';
          if(id=='grupa1'){
               x = document.getElementById('1');
          }
          else if(id=='grupa2'){
              x = document.getElementById('2');
          }
          else x = document.getElementById('3');
          
          if (x.style.display === "block") {
            x.style.display = "none";
          } else {
            x.style.display = "block";
          }
        }