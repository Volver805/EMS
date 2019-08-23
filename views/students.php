<?php
    include 'connect.php';
    $courses = "";
    $query = "SELECT * FROM isenrolled where student_id=".$_SESSION['id'];
    $result = mysqli_query($conn,$query);
    echo mysqli_error($conn);
    while ($row = mysqli_fetch_assoc($result)) {
        $courses .= "<button class='course'>".$row['course_id']."</button>";
    }

?>
<div class='portal' style='background-color:#0061E0'>
<div class='sidebar'>
            <?php
                echo $courses;
            ?>
 <div class='sidebar-bottom'>
                    <button id='enroll-course' onclick='enroll()'>Enroll</button>

                 <button id='logout-button' onclick='logout()'>Logout</button>
            </div>
    </div>
        <div class='student-course-detail'>
            
               
        </div>
</div>
<div class='student-submit-answer'>
    <h1>Answer</h1>
    <textarea id='answer'></textarea>
    <button id='submit-answer' onclick='insertAnswer()'>Submit</button>
    <span id='submit-answer-close' onclick='closeAnswerSubmit()'>X</span>
</div>
<script> 
(function slideIn() {
   $(".portal").animate({
       left:"10%"
   },"slow");
})()
</script>