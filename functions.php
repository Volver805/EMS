<?php 
    include 'connect.php';
    function test() {
        echo "working";
    }
    function ViewMyCourses() {
               global $conn;
                  $query = "SELECT * FROM courses WHERE course_teacher=".$_SESSION['id'];  
                $result = mysqli_query($conn,$query);
                $i = 3;
                while($row = mysqli_fetch_assoc($result)) {
            
                    if($i == 3) {
                        echo "<div class='card card-active' style='z-index:".$i."' onclick=\"showDetails('".$row['course_id']."')\" ><p>".$row['course_name']."</p></div>";  
                    }
                    else {
                    echo "<div class='card' style='z-index:".$i."' onclick=\"showDetails('".$row['course_id']."')\" ><p>".$row['course_name']."</p></div>";  
                    }
                    $i--;
                }
            }
?>