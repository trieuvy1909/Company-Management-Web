function thugon_sidebar()
{
    $('#sidebar').toggleClass('active');
}
function validate_reject_task()
{
    let errorField = document.getElementById("errorMessage");
    let task_id = document.getElementById("task_id").value;
    let comment = document.getElementById("comment").value;
    let deadline = document.getElementById("deadline").value;
    let fileField = document.getElementById("file");
    let fileName = fileField.value.split("\\").pop();
    let file_extension = fileName.split('.').pop(); 
    let extensions = new Array("rar","zip","txt","doc","docx","xls","xlsx","jpg","png","mp3","mp4","pdf","png","jpeg");
    file_logic=false;
    for(var i = 0; i < extensions.length; i++)
    {
        if(extensions[i]===file_extension)
        {
            file_logic =true;
        }
    }

    if (task_id === "") {
        errorField.innerHTML = "Vui lòng nhập mã task";
        errorField.style.display = "block";
        return false;
    } else if (isNaN(task_id))
    {
        errorField.innerHTML = "Mã task không hợp lệ";
        errorField.style.display = "block";
        return false;
    }
    else if(deadline ==="")
    {
        errorField.innerHTML = "Vui lòng chọn ngày đến hạn";
        errorField.style.display = "block";
        return false;
    }
    else if (comment === "") {
        errorField.innerHTML = "Vui lòng nhập lời nhắn cho trưởng phòng";
        errorField.style.display = "block";
        return false;
    } 
    else if (
        comment.includes("'") ||
        comment.includes("!") ||
        comment.includes("?") ||
        comment.includes("|") ||
        comment.includes("<") ||
        comment.includes(">")
    ) {
        errorField.innerHTML = "Lời nhắn không được chứa kí tự <,',!,?,|>,";
        errorField.style.display = "block";
        return false;
    }
    else if(fileField.files.item(0)==null)
    {
        errorField.innerHTML = "Vui lòng chọn file để nộp";
        errorField.style.display = "block";
        return false;
    }
    else if(fileField.files.item(0)!==null && !file_logic)
    {
        errorField.innerHTML = "Định dạng file không được hệ thống hỗ trợ";
        errorField.style.display = "block";
        return false;
    }
    else if(fileField.files.item(0)!==null && fileField.files.item(0).size > (8*1024*1024))
    {
        errorField.innerHTML = "File đính kèm lớn hơn 20MB không khả dụng";
        errorField.style.display = "block";
        return false;
    }
    errorField.innerHTML = "";
    return true;
}
function validate_submit_task()
{
    let errorField = document.getElementById("errorMessage");
    let task_id = document.getElementById("task_id").value;
    let comment = document.getElementById("comment").value;
    let fileField = document.getElementById("file");
    let fileName = fileField.value.split("\\").pop();
    let file_extension = fileName.split('.').pop(); 
    let extensions = new Array("rar","zip","txt","doc","docx","xls","xlsx","jpg","png","mp3","mp4","pdf","png","jpeg");
    file_logic=false;
    for(var i = 0; i < extensions.length; i++)
    {
        if(extensions[i]===file_extension)
        {
            file_logic =true;
        }
    }

    if (task_id === "") {
        errorField.innerHTML = "Vui lòng nhập mã task";
        errorField.style.display = "block";
        return false;
    } else if (isNaN(task_id))
    {
        errorField.innerHTML = "Mã task không hợp lệ";
        errorField.style.display = "block";
        return false;
    }
    else if (comment === "") {
        errorField.innerHTML = "Vui lòng nhập lời nhắn cho trưởng phòng";
        errorField.style.display = "block";
        return false;
    } 
    else if (
        comment.includes("'") ||
        comment.includes("!") ||
        comment.includes("?") ||
        comment.includes("|") ||
        comment.includes("<") ||
        comment.includes(">")
    ) {
        errorField.innerHTML = "Lời nhắn không được chứa kí tự <,',!,?,|>,";
        errorField.style.display = "block";
        return false;
    }
    else if(fileField.files.item(0)==null)
    {
        errorField.innerHTML = "Vui lòng chọn file để nộp";
        errorField.style.display = "block";
        return false;
    }
    else if(fileField.files.item(0)!==null && !file_logic)
    {
        errorField.innerHTML = "Định dạng file không được hệ thống hỗ trợ";
        errorField.style.display = "block";
        return false;
    }
    else if(fileField.files.item(0)!==null && fileField.files.item(0).size > (8*1024*1024))
    {
        errorField.innerHTML = "File đính kèm lớn hơn 20MB không khả dụng";
        errorField.style.display = "block";
        return false;
    }
    errorField.innerHTML = "";
    return true;
}
function validate_create_task()
{
    let errorField = document.getElementById("errorMessage");
    let task_id = document.getElementById("task_id").value;
    let deadline = document.getElementById("deadline").value;
    let task_name = document.getElementById("task_name").value;
    let nhanvien_id = document.getElementById("nhanvien_id").value;
    let fileField = document.getElementById("file");
    let fileName = fileField.value.split("\\").pop();
    let file_extension = fileName.split('.').pop(); 
    let extensions = new Array("rar","zip","txt","doc","docx","xls","xlsx","jpg","png","mp3","mp4","pdf","png","jpeg");
    file_logic=false;
    
    for(var i = 0; i < extensions.length; i++)
    {
        if(extensions[i]===file_extension)
        {
            file_logic =true;
        }
    }

    if (task_id === "") {
        errorField.innerHTML = "Vui lòng nhập mã task";
        errorField.style.display = "block";
        return false;
    } else if (
        task_id.includes("'") ||
        task_id.includes("!") ||
        task_id.includes("?") ||
        task_id.includes("|") ||
        task_id.includes("<") ||
        task_id.includes(">")
    ) {
        errorField.innerHTML = "Mã task không được chứa kí tự <,',!,?,|>,";
        errorField.style.display = "block";
        return false;
    }
    else if(deadline ==="")
    {
        errorField.innerHTML = "Vui lòng chọn ngày đến hạn";
        errorField.style.display = "block";
        return false;
    }
    else if(nhanvien_id==="Chọn id nhân viên")
    {
        errorField.innerHTML = "Vui lòng chọn nhân viên phụ trách";
        errorField.style.display = "block";
        return false;
    }
    else if (task_name === "") {
        errorField.innerHTML = "Vui lòng nhập tên task";
        errorField.style.display = "block";
        return false;
    } else if (
        task_name.includes("'") ||
        task_name.includes("!") ||
        task_name.includes("?") ||
        task_name.includes("|") ||
        task_name.includes("<") ||
        task_name.includes(">")
    ) 
    {
        errorField.innerHTML = "Tên task không được chứa kí tự <,',!,?,|>,";
        errorField.style.display = "block";
        return false;
    }
    else if(fileField.files.item(0)!==null && !file_logic)
    {
        errorField.innerHTML = "Định dạng file không được hệ thống hỗ trợ";
        errorField.style.display = "block";
        return false;
    }
    else if(fileField.files.item(0)!==null && fileField.files.item(0).size > (8*1024*1024))
    {
        errorField.innerHTML = "File đính kèm lớn hơn 20MB không khả dụng";
        errorField.style.display = "block";
        return false;
    }
    errorField.innerHTML = "";
    return true;
}
function update_label_of_fileupload()
{
    
    let inputField = document.getElementsByClassName("custom-file-input");
    let fileName = inputField[0].value.split("\\").pop();
    let label = document.getElementsByClassName("custom-file-label");
    label[0].innerHTML = fileName;
}
function validateInput() {
    let usernameField = document.getElementById("username");
    let passwordField = document.getElementById("password");
    let errorField = document.getElementById("errorMessage");
    let username = usernameField.value;
    let password = passwordField.value;
    
    if (username === "") {
        errorField.innerHTML = "Vui lòng nhập tên đăng nhập";
        errorField.style.display = "block";
        usernameField.focus();
        return false;
    } else if (
        password.includes("'") ||
        password.includes("!") ||
        password.includes("?") ||
        password.includes("|") ||
        password.includes("<") ||
        password.includes(">")
    ) {
        errorField.innerHTML = "Mật khẩu không được chứa kí tự <,',!,?,|>,";
        errorField.style.display = "block";
        passwordField.focus();
        return false;
    } else if (password === "") {
        errorField.innerHTML = "Vui lòng nhập mật khẩu";
        errorField.style.display = "block";
        passwordField.focus();
        return false;
    }else if (
        username.includes("'") ||
        username.includes("!") ||
        username.includes("?") ||
        username.includes("|") ||
        username.includes("<") ||
        username.includes(">")
    ) {
        errorField.innerHTML = "Tên đăng nhập không được chứa kí tự <,',!,?,|>,";
        errorField.style.display = "block";
        usernameField.focus();
        return false;
    }
    errorField.innerHTML = "";
    return true;
    }
    function clearErrorMessage() {
        
    let errorField = document.getElementById("errorMessage");
    if(errorField)
    {
        errorField.innerHTML = "";
        errorField.style.display = "none";
    }

    let successField = document.getElementById("successMessage");
    if(successField)
    {
        successField.innerHTML = "";
        successField.style.display = "none";
    }
}
    function validateInput_forResetPassword() {
    let passwordField = document.getElementById("newpassword");
    let errorField = document.getElementById("errorMessage");
    let oldpassword = document.getElementById("oldpassword").value;
    let password = passwordField.value;
    let password_comfirm = document.getElementById("newpassword_comfirm").value;
    if(oldpassword==="")
    {
        errorField.innerHTML = "Vui lòng điền mật khẩu hiện tại";
        errorField.style.display = "block";
        passwordField.focus();
        return false;
    }
    else if(password==="")
    {
        errorField.innerHTML = "Vui lòng điền mật khẩu mới";
        errorField.style.display = "block";
        passwordField.focus();
        return false;
    }
    else if(password_comfirm==="")
    {
        errorField.innerHTML = "Vui lòng xác nhận mật khẩu mới";
        errorField.style.display = "block";
        passwordField.focus();
        return false;
    }
    else if(password!==password_comfirm)
    {
        errorField.innerHTML = "Mật khẩu không khớp";
        errorField.style.display = "block";
        passwordField.focus();
        return false;
    }
    else if (
        password.includes("'") ||
        password.includes("!") ||
        password.includes("?") ||
        password.includes("|") ||
        password.includes("<") ||
        password.includes(">") ||
        password.includes("&") 
    ) {
        errorField.innerHTML = "Mật khẩu không được chứa kí tự <,',!,?,|>,";
        errorField.style.display = "block";
        passwordField.focus();
        return false;
    } 
    else if(password.length <6)
    {
        errorField.innerHTML = "Mật khẩu không được ít hơn 6 chữ số";
        errorField.style.display = "block";
        passwordField.focus();
        return false;
    }
    errorField.innerHTML = "";
    return true;
}
