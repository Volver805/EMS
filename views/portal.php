<?php 
   if(isset($_SESSION['name'])) {
    $name = $_SESSION['name'];
   } else {
      session_start();
      $name = $_SESSION['name'];

   }
?>
<!-- Portal -->
<button class="home-button" onclick="returnHome()">Home</button>
<button onmouseover="redBackground(this)" onmouseout="grayBackground(this)"  onclick="logout()"class="logout">logout</button>
<?php
if($_GET['page'] == "create") { ?>
   <div class="create-section">
      <h1> Create Course </h1>
      <div class="create-form">
         <label for="course-name">Course Name</label>
         <input type="text" id="course-name">
         <label for="course-name">Course ID</label>
         <input type="text" id="course-id">
         <label for="course-name">About Course</label>
         <input type="text" id="course-des">
         <input id="create-button" onclick="SubmitCreated()" type="submit" value="create">
   </div>
   <div class="create-errors"><p></p></div>
</div>
<script>
   (function() {
      $('.create-section').fadeIn("slow");
   })()
</script>
 <?php } 
  else if ($_GET['page'] == 'observe') { 
   include '../functions.php';?>
 <div class="cards-div">
 <?php

      ViewMyCourses();
    ?>
  </div>
  <div class="course-details"></div>
   <div id='answers-table'><input type='button' id='close-button' onclick='sam()' value='X'> <div id='answers'></div></div>
   <script>
   (function() {
      $('.course-details').animate({
         height:'82%'
      },"slow")   
   })()
      $('.cards-div').animate({
         top:'40px'
      },"slow");
   </script>
   <?php
}
else { ?> 
 
   <div class="welcome">
      <img src="assets/teachers.png">
      <h1><span class='first-line'>Welcome to your favorite managment portal !</span><br><?php echo $name ?><span id="prof">  Professor</span></p></h1>
   </div>
<div class="options-section">
   <button onclick="viewCourse()"> <img src="assets/glasses.png" class="options-image"> <p>View Courses</p></button>   
   <button onclick="createCourse()" style="padding-left:0px"><img src="assets/book.png" class="options-image"><p>Create Course</p></button>   

</div>
<?php } 
?> 