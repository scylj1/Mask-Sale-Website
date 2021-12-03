function checkform() {
    var bool = true;
    if (checkname() == false){
        bool = false;
    }
    if (checkpassword() == false) {
        bool = false; 
    }
    if (checkrealname() == false) {
        bool = false; 
    }
    if (checkpassport() == false) {
        bool = false; 
    }
    if (checkemail() == false) {
        bool = false; 
    }
    if (checkphone() == false) {
        bool = false; 
    }
    if (checkregion() == false) {
        bool = false; 
    }
    return bool;
}

function checkname() {
    var uname = document.getElementById("uname");
    var ename = document.getElementById("username-error"); 
    if (uname.value=="") {
        ename.innerHTML="username cannot be empty";
        return false;
    }    
    else if(uname.value.length>32){
        ename.innerHTML="username should be no more than 32 chars";
        return false;
    }
    else {
    ename.innerHTML="pass";
        return true;
    }
}

function checkpassword() {  
    var upwd = document.getElementById("upwd");
    var cpwd = document.getElementById("cpwd");
    var epwd = document.getElementById("password-error");

    if (upwd.value != cpwd.value) {
        epwd.innerHTML="passwords are not the same";
    return false; 
    }
    else if (upwd.value=="") {
        epwd.innerHTML="password cannot be empty"; 
        return false;
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

function checkrealname() {
    var rname = document.getElementById("rname");
    var ename = document.getElementById("rname-error");
    if (rname.value=="") {
        ename.innerHTML="real name cannot be empty";
        return false;
    }
    else if(rname.value.length>32){ 
        ename.innerHTML="name should be no more than 32 chars"; 
        return false;
    }
    else {
        ename.innerHTML="pass";
        return true;
    } 
}

function checkpassport() {    
    var passport = document.getElementById("passport");    
    var epassport = document.getElementById("passport-error");   
    if (passport.value=="") {        
        epassport.innerHTML="passport cannot be empty";        
        return false;    
    }    
    else if(passport.value.length>32){ 
        epassport.innerHTML="passport should be no more than 32 chars"; 
        return false;
    }        
    else { 
        epassport.innerHTML="pass";
        return true;
    }      
}

function checkemail() {
    var email = document.getElementById("email");
    var eemail = document.getElementById("email-error");
    var reg=/^\w+@\w+(\.[a-zA-Z]{2,3}){1,2}$/;
    if (email.value=="") {
        eemail.innerHTML="email cannot be empty";  
        return false;
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
        ephone.innerHTML="phone cannot be empty";
        return false; 
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
    var region1 = document.getElementById("region1");
    var region2 = document.getElementById("region2");
    var region3 = document.getElementById("region3");
    var region4 = document.getElementById("region4");
    var eregion = document.getElementById("region-error");
    if ((region1.checked || region2.checked || region3.checked || region4.checked) == false) {
        eregion.innerHTML="You have to choose one region";
        return false;
    }
    else {
        eregion.innerHTML="pass";
        return true;
    }
}
