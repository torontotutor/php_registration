<div class = "register">
    <p>Please fill in your details below to register.</p>
    <p class = "mandatory"><strong>*</strong> Mandatory fields</p>

    <form name = "userForm" id = "userForm" method = "POST" action = "register-process.php" enctype = "multipart/form-data">
      <fieldset>
        <div id = "errorDiv">
          <?php 
            if(isset($_SESSION['error']) && isset($_SESSION['formAttempt'])){
              unset($_SESSION['formAttempt']);
              print "Errors encountered<br>\n";
              foreach ($_SESSION['error'] as $error) {
                print $error . "<br>\n";
              }
            }
          ?>
        </div>
        <ul>
               
          <label for = "username" class = "form_label">Username</label>
          <li><input type = "text" name = "username" id = "username"><span class = "required">*</span>
            <span class = "errorFeedback errorSpan" id = "usernameError">Username is required</span>
          </li>

          <label for = "password" class = "form_label">Password</label>
          <li><input type = "password" name = "password" id = "password"><span class = "required">*</span>
            <span class = "errorFeedback errorSpan" id = "passwordError">Password is required</span>
          </li>
                  
          <label for = "c_pass" class = "form_label">Confirm Password</label>
          <li><input type = "password" name = "c_pass" id = "c_pass"><span class = "required">*</span>
            <span class = "errorFeedback errorSpan" id = "c_passError">Passwords don`t match</span>
          </li>
                  
          <label for = "email" class = "form_label">Email Address</label>
          <li><input type = "email" name = "email" id = "email"><span class = "required">*</span>
            <span class = "errorFeedback errorSpan" id = "emailError">Email is required</span>
          </li>   
                
          <label for = "profile_pic" class = "form_label">Profile Picture / Company Logo </label>
          <li><input type = "file" name = "profile_pic" id = "profile_pic"></li>
                  
          <label for = "company" class = "form_label">Company Name</label>
          <li><input type = "text" name = "company" id = "company"></li>

          <label for = "company_bio" class = "form_label">Company BIO</label>
          <li><textarea name = "company_bio" id = "company_bio" cols = 60 rows = 10></textarea></li>

<!-- ADD IN FUNCTION IF PROVINCE IS SELECTED THEN ONLY THOSE CITIES LOAD -->  
          <script language="javascript" src="province.js"></script>
          <label for = "province" class = "form_label">Province</label>
          <li><select id = "province" name = "province" onChange="SelectSubCat();">
              <option value = ""></option>
              </select><span class = "required">  *</span>
              <span class = "errorFeedback errorSpan" id = "provinceError">Province is required</span>
          </li>
                  
          <label for = "region" class = "form_label">Region</label>
          <li><select id = "region" name = "region">
                <option value = ""></option>
              </select><span class = "required">  *</span>
              <span class = "errorFeedback errorSpan" id = "regionError">Region is required</span>
          </li>

          <li class = "user_console_button">
            <input type = "submit" value = "Register" name = "submit_on" id = "submit">
          </li>
               
        </ul>
      </fieldset>
    </form>
