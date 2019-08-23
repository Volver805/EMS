<?php
    include 'connect.php';
    if($_GET['action'] == 'login') {
        $err = "";
        $type = $_POST['type'];
        $id = mysqli_real_escape_string($conn,$_POST['id']);
        $pass = mysqli_real_escape_string($conn,$_POST['pass']);
        if(!$id) {
            $err = "Please Enter an id";
        }
        else if (!$pass) {
            $err = "Please Enter a password";   
        }
        else if (!is_numeric($id)) {
            $err = "ID may only contain numbers";
        }
        else {
        $query = "SELECT * FROM ".$type." WHERE id='".$id."' AND password='".$pass."'"; 
        $row = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($row);
        if(!$row['id']) {
            $err = "Please check your info";
           } 
        else {
            $_SESSION['id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['type'] = $type;
            echo 1;
            exit();
        }
        }
        echo $err;
    }

    if($_GET['action'] == 'logout') {
        session_destroy();
    }
    if($_GET['action'] == 'createCourse') {
        $errors = "";
      
        if(!$_POST['des'] || !$_POST['id'] || !$_POST['name']) {
            $errors="please complete all fields";
        }
        else if(strlen($_POST['id']) > 6) {
            $errors = "course id can't contain more than 6 characters";
        }

        if($errors) {
            echo $errors;
        }
        else {
            $query = "INSERT INTO `courses`(course_id,course_name,course_description,course_teacher) VALUES('".$_POST['id']."','".$_POST['name']."','".$_POST['des']."','".$_SESSION['id']."')";
            mysqli_query($conn,$query);                 
            echo "Course Created!";     
        }
    }  
    if($_GET['action'] == 'CourseDetails') {
        $query = "SELECT * FROM courses WHERE course_id='".$_POST['id']."' ";
        $result = mysqli_query($conn,$query);
        echo mysqli_error($conn);
        $row = mysqli_fetch_assoc($result);
        echo "<h1>".$row['course_name']."</h1><p>Course Code: ".$row['course_id']."</p><div class='assignments'><table><tr><th>Assignment</th><th>Date</th><th>DeadLine</th><th>Answers</th></tr>";
        $query = "SELECT * FROM assignments WHERE course_id='".$_POST['id']."' ";
        $result = mysqli_query($conn,$query);
        while($as = mysqli_fetch_assoc($result) ) {
            echo"<tr><td>".$as['name']."</td><td>".$as['upload_date']."</td><td>".$as['deadline']."</td><td><a class='view-answers' value='".$as['id']."' onclick=\"showAssignmentAnswers('".$as['id']."')\">View Answers</a></td></tr>";
        }
        echo "</table></div><div class='insert-table'><input id='a_name' type='text' placeholder='assignment name'><input id='a_question' type='text' placeholder='question'><input id='a_deadline' type='date'><input id='a_submit' onclick='createAssignment()' data-id='".$_POST['id']."' type='submit'></div>";
    }   

    if($_GET['action'] == 'showAnswer') {
        $a_id = $_POST['id'];
        $query = "SELECT * FROM assignments WHERE id=".$a_id;
        $result = mysqli_query($conn,$query);
        echo mysqli_error($conn);
        $question = mysqli_fetch_assoc($result);
        echo "<div id='question'><h2>Question:-</h2><p>". $question['question']."</p></div><h2>Answers:-</h2>";
        $query = "SELECT * FROM grades WHERE assignment_id=".$a_id;
        $result = mysqli_query($conn,$query);
        while($row = mysqli_fetch_assoc($result)) {
            $query = "SELECT * FROM students WHERE id='".$row['student_id']."'";
            $res = mysqli_query($conn,$query);
            echo mysqli_error($conn);
            $name = mysqli_fetch_assoc($res);
            echo mysqli_error($conn);
            echo"<div class='answer-row' ><div class='slide-answer'><p>".$name['name']."</p><p class='answer-details'><span class='student_grade'>".$row['grade']."</span> / ".$question['max_grade']."</p></div><input type='text' placeholder='set grade' class='grade-input'><input type='submit' class='grade-submit' onclick='setGrade(this)' data-id='".$row['answer_id']."'><div class='student-answer'>".$row['Answer']."</div></div>";
        }

    }
    if($_GET['action'] == 'updateGrade') {
        $query = "UPDATE grades SET grade=".$_POST['val']." WHERE answer_id='".$_POST['id']."'";
        $result = mysqli_query($conn,$query);
        if(!mysqli_error($conn)) {
        echo $_POST['val'];
        }
    }
    if($_GET['action'] == 'createAssignment'){
        $query = "INSERT INTO assignments(`name`,`question`,`deadline`,`course_id`) VALUES('".$_POST['name']."','".$_POST['question']."','".$_POST['deadline']."','".$_POST['course']."')";
        $result = mysqli_query($conn,$query); 
        echo mysqli_error($conn);
    }
    if($_GET['action'] == 'studentViewCourse') {
        $query = "SELECT * FROM courses WHERE course_id='".$_POST['id']."' ";
        $result = mysqli_query($conn,$query);
        echo mysqli_error($conn);
        $row = mysqli_fetch_assoc($result);
        $query = "SELECT name FROM teachers WHERE id=".$row['course_teacher'];
        $result = mysqli_query($conn,$query);
        $name = mysqli_fetch_assoc($result);
        echo "<h4 id='student-course-name'>".$row['course_name']."</h4><p>Professor ".$name['name']."</p>
        <div id='student-course-assignments'><table><tr><th>Assignment</th><th>Deadline</th><th>Question</th><th>Answer</th></tr>";
        $query = "SELECT * FROM assignments WHERE course_id='".$_POST['id']."'";
        $result =  mysqli_query($conn,$query);
        while ($assignment = mysqli_fetch_assoc($result)) {
            echo "<tr>
            <td class='student-assignment-name'>".$assignment['name']."</td>
            <td class='student-assignment-deadline'>".$assignment['deadline']."</td>
            <td class='student-assignment-question'>".$assignment['question']."</td><td class='student-assignment-answer' data-course='".$assignment['id']."'>Submit Answer</td></tr>";
        }
        echo "</table></div>";
    }
    if($_GET['action'] == 'enroll') {
        echo "<div class='enroll-content'>
        <h4 class='enroll-title'>Enroll Courses </h4>";
        $query = "SELECT * FROM courses WHERE course_id NOT IN (SELECT course_id FROM isenrolled WHERE student_id = ".$_SESSION['id'].")";
        $result = mysqli_query($conn,$query);
        while($row = mysqli_fetch_assoc($result)) {
        $c_id = $row['course_id'];
        echo "<div class='enroll-subject'><div class='enroll-subject-button' onclick=\"studentEnroll('$c_id')\" value='".$row['course_id']."'><div class='enroll-animation'>Enroll</div>".$row['course_id']."</div><p>".$row['course_name']."</p><p class='enroll-des'>".$row['course_description']."</p></div>";
        }
        echo "</div>";
    }

    if($_GET['action'] == 'insertAnswer') {
        $answer = mysqli_real_escape_string($conn,$_POST['answer']);
        $query = "INSERT INTO grades(student_id,assignment_id,Answer) VALUES('".$_SESSION['id']."','".$_POST['assignment']."','".$answer."')";
        mysqli_query($conn,$query);
        echo mysqli_error($conn);
    }
    
    if($_GET['action'] == 'enrollStudent') {
        $student = $_SESSION['id'];
        $id = $_POST['course_id'];
        $query = "INSERT INTO isenrolled(`student_id`,`course_id`) VALUES($student,'$id')";
        mysqli_query($conn,$query);
        echo mysqli_error($conn);

    }
?>