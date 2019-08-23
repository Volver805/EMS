
<!-- Form -->
 <div id="login-view">
     <div class="header">
            <h1>Sign In</h1>
            <p>Use your unique ID and password to login</p>
    </div>
    <p id="errors"></p>
    <div class="login-form">
        <div class="login-form-input">
            <input type="hidden" id="login-form-type" value="teachers">
            <input type="text"  id="login-form-id" placeholder="Teacher ID" style="border-right:1px solid #e4e4e4">
            <input type="password"  id="login-form-password" placeholder="Password">
        </div>
        <button id='login-form-button' onclick="login()">
            login as teacher
        </button>
    </div>
    <p style="color:white;text-align:center;font-weight:1000;font-size:130%">Or</p>
    
    <div id="switch-buttons">
        <button id="teacher-student" onclick="changeToStudent()">login as a student</button>
        <button id="student-teacher" onclick="changeToTeacher()">login as a Teacher</button>
    </div>
</div>