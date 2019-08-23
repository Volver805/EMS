<?php
echo '<div class="portal">';
include 'views/portal.php';

echo '<script> (function slideIn() {
   $(".portal").animate({
       left:"10%"
   },"slow");
})()
</script></div>';
?>