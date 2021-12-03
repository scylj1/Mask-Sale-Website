function checkForm() {
    var bool = true;
    if (checkpassword() == false) {
        bool = false; 
    }   
    if (checkemail() == false) {
        bool = false; 
    }
    if (checkphone() == false) {
        bool = false;
    }
    return bool; 
}

function checkpassword() {
    var upwd = document.getElementById("upwd");
    var epwd = document.getElementById("password-error");
    if (upwd.value=="") {
        return true;
    }
    else if (upwd.value.length<6 || upwd.value.length>32) {
        epwd.innerHTML="password should be 6-32 chars.";  
        return false;
    } 
    else { 
        epwd.innerHTML="pass";
        return true;
    }
}

function checkemail() {
    var email = document.getElementById("email");
    var eemail = document.getElementById("email-error");
    var reg=/^\w+@\w+(\.[a-zA-Z]{2,3}){1,2}$/;
    if (email.value=="") {  
        return true;
    } 
    else if (reg.test(email.value)==false) {
        eemail.innerHTML="Please enter correct email"; 
        return false; 
    }
    else if(email.value.length>64){
        eemail.innerHTML="email should be no more than 64 chars"; 
        return false;
	}
    else {
        eemail.innerHTML="pass";
        return true;
    } 
}

function checkphone() {
    var phone = document.getElementById("phone");
    var ephone = document.getElementById("phone-error"); 
    var reg=/\d+/;
    if (phone.value=="") {
        return true; 
    }
    else if (reg.test(phone.value)==false) {
        ephone.innerHTML="Please enter correct phone number";
        return false; 
   }
   else if(phone.value.length>16){
        ephone.innerHTML="phone should be no more than 16 chars"; 
        return false;
   }
   else {
        ephone.innerHTML="pass";
        return true;
    }
}

function checkregion() {
    var eregion = document.getElementById("region-error");
    eregion.innerHTML="pass";
    return true;
}
