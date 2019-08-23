function changeToStudent() {
    $('.student-bg-image').fadeIn(1000);
    $('#teacher-student').fadeOut(500);
    $('#student-teacher').delay(500).fadeIn(1000);
    $('.teacher-bg-image').fadeOut(800);
    $('#login-form-type').val('students');
    $('#login-form-id').attr('placeholder','Student ID');
    $('#login-form-button').html('login as student');
}
function changeToTeacher() {
    $('.teacher-bg-image').fadeIn(1000);
    $('#student-teacher').fadeOut(500);
    $('#teacher-student').delay(500).fadeIn(1000);
    $('.student-bg-image').fadeOut(800);
    $('#login-form-type').val('teachers');
    $('#login-form-id').attr('placeholder','Teacher ID');
    $('#login-form-button').html('login as student');


}
function login() {
    $.ajax({
        type:'POST',
        url:'actions.php?action=login',
        data: "type="+$('#login-form-type').val()+"&id="+$("#login-form-id").val()+"&pass="+$("#login-form-password").val(),
        success: function(result){
            if (result == '1') {
                slideLeft('#login-view');
                setTimeout(window.location.reload.bind(window.location),500);
            }
            else {
            $('#errors').html(result);        
            }
        }
    })
}
function slideLeft(div) {
    $(div).animate({
        left:'-100%'
    },"slow"); 
};
function redBackground(button) {
    $(button).animate({
        backgroundColor:'#d7423c',
        color:"white"
    },"fast")
}; 
function grayBackground(button) {
    $(button).animate({
                backgroundColor:'#F5F5F5',
                color:'#d7423c'
            },'fast')
}

function logout() {
    slideLeft('.portal');
    var ajaxCall = $.ajax({
        type:'POST',
        url:'actions.php?action=logout',
        success: function() {
            location.reload();
        }
    });
    setTimeout(ajaxCall,500);
}
function createCourse() {
    function callAjax() { $.ajax({
        type:'POST',
        url:'views/portal.php?page=create',
        success: function(result) {
            $('.portal').html(result);
        }
    });
    }
    $('.options-section').animate({
        height:"0%"
    },"slow");
    $('.welcome').fadeOut("slow");
    
    setTimeout(callAjax,500);

}
function SubmitCreated(){
    $.ajax({
        type:'POST',
        url:"actions.php?action=createCourse",
        data:'name='+$('#course-name').val()+"&id="+$("#course-id").val()+"&des="+$("#course-des").val(),
        success:function(result){
            $('.create-errors').html(result);
            if (result == "Course Created!") {
                $('.create-errors').css('color','green');
            }
            $('#course-name').val("");
            $('#course-id').val("");
            $('#course-des').val("");
        }
    })
}
function viewCourse() {
    function callAjax() { $.ajax({
        type:'POST',
        url:'views/portal.php?page=observe',
        success: function(result) {
            $('.portal').html(result);
        }
    })
}   
        $('.options-section').animate({
            height:"0%"
        },"slow");
        $('.welcome').fadeOut("slow");

        setTimeout(callAjax,500);


}
var SelectCourse = function() {
    console.log('working');
    $(this).removeClass('card');
    $(this).addClass("active-card");   
}
function showDetails(course) {
    $.ajax({
        type:'POST',
        url:'actions.php?action=CourseDetails',
        data:'id='+course,
        success: function(result) {
            $('.course-details').html(result);
        }
    })
}
function sam() {
    $('#answers-table').animate({
        left:'100%'
    },"slow");
}
function showAssignmentAnswers(assignment) {
    $.ajax({
        type:'POST',
        url:'actions.php?action=showAnswer',
        data:'id='+assignment,
        success: function(result) {
            $('#answers').html(result);
        }
    });
    $('#answers-table').animate({
        left:'15%'
    },"slow");
}


$('.portal').on("click",".slide-answer",function() {
    let parent = $(this).parent();
    if($('.student-answer',parent).css('height') == '0px') {
    $('.student-answer',parent).animate({
        height:'40px'
    },100);     
    }
    else {
        $('.student-answer',parent).animate({
            height:'0px'
        },100);         }
})
$('.portal').on("click",".card",function() {
    $('.card').css('z-index','2');
    $('.card-active').css('z-index','3')
    $('.card').removeClass('card-active'); 
    $(this).css('z-index','4');
    $(this).addClass('card-active');
})
function setGrade(grade) {
    $.ajax({
        method:'POST',
        url:'actions.php?action=updateGrade',
        data:'id='+$(grade).attr('data-id')+'&val='+$(grade).siblings('.grade-input').val(),
        success: function(result) {
            $(grade).siblings('.slide-answer').children('.answer-details').children('.student_grade').text(result);
        }
    })
}
function returnHome(){
    $.ajax({
        method:'POST',
        url:'views/portal.php?page=home',
        success: function(result) {
            $('.portal').html(result);
        }
    })
}
$('.portal').on("mouseenter",".home-button",function(){
    $(this).animate({
        backgroundColor:'#4caf50',
        color:'white'  
    },'fast')
})

$('.portal').on("mouseleave",".home-button",function(){
    $(this).animate({
        backgroundColor:'transparent',
        color:'#4caf50'  
    },'fast')
})
function createAssignment(){
    $.ajax({
        method:'POST',
        url:'actions.php?action=createAssignment',
        data:'name='+$('#a_name').val()+'&question='+$('#a_question').val()+'&deadline='+$('#a_deadline').val()+"&course="+$('#a_submit').attr('data-id'),
        success: function(result){
            alert(result)
        }
    })
}
$('.portal').on("click",".course",function(){
    $.ajax({
        method:'POST',
        url:'actions.php?action=studentViewCourse',
        data:'id='+$(this).html(),
        success: function(result) {
            $('.student-course-detail').html(result);
        }
    })
})
$('.portal').on("click",".student-assignment-answer",function(){
    $('.student-submit-answer').animate({
        left:'40%'
    },'slow');
    $('#submit-answer').val($(this).attr('data-course'));
})
$('.portal').on("click","#submit-answer",function(){
})
function insertAnswer() {
    
    $.ajax({
        method:'POST',
        url:'actions.php?action=insertAnswer',
        data:'answer='+$('#answer').val()+'&assignment='+$('#submit-answer').val(),
        success :function(result) {
            $('.student-submit-answer').animate({
                left:'-50%'
            },'slow')
        }
    })
 
}

function enroll() {
    $.ajax({
        method:'POST',
        url:'actions.php?action=enroll',
        success:function(result){
            $('.student-course-detail').html(result);
        }
    })
}

function studentEnroll(id) {
    $.ajax({
        method:'POST',
        url:'actions.php?action=enrollStudent',
        data:'course_id='+id,
        success:function(result) {
            alert(result);
        }
    })
}
function closeAnswerSubmit() {
    $('.student-submit-answer').animate({
        left:'-50%'
    },'slow')
}