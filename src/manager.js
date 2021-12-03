// used for assign reps
function checkform1() {
   var bool = true;
    if (checkuser() == false){
        bool = false;
    }
    if (checkregion() == false) {
        bool = false; 
    }
    if (checknum() == false){
        bool = false;
    }
    return bool;
}

// used for update quota
function checkform2() {
   var bool = true;
    if (checkreps1() == false){
        bool = false;
    }
    if (checknum2() == false){
        bool = false;
    }
    return bool;
}

// used for re-grant quota
function checkform3() {
   var reps2 = document.getElementById("reps2");

    if (reps2.value == "") {
        alert("Reps ID cannot be empty");
        return false;
    }
    else {
        return true;
    }
}

// sub-function 
function checkuser() {
    var uesr = document.getElementById("user");

    if (user.value == "") {
        alert("User ID cannot be empty");
        return false;
    }
    else {
        return true;
    }
}

// sub-function 
function checknum() {
    var num = document.getElementById("quota");
    var reg=/^(0|[1-9][0-9]*)$/;
    if (reg.test(num.value)==false) {
        alert("Please input non-negative integer for quota.");
        return false;
    }
    else if(num.value.length>32){
        alert("Input should be no more than 32 chars");
        return false;
    }
    else {
        return true;
    }
}

// sub-function 
function checkregion() { 
    var region1 = document.getElementById("region1");
    var region2 = document.getElementById("region2");
    var region3 = document.getElementById("region3");
    var region4 = document.getElementById("region4");
    if ((region1.checked || region2.checked || region3.checked || region4.checked) == false) {
        alert("You have to choose one region.");
        return false;
    }
    else {
        return true;
    }
}

// sub-function 
function checkreps1() {
    var reps1 = document.getElementById("reps1");

    if (reps1.value == "") {
        alert("Reps ID cannot be empty");
        return false;
    }
    else {
        return true;
    }
}

// sub-function 
function checknum2() {
    var num2 = document.getElementById("quota2");
    var reg=/^(0|[1-9][0-9]*)$/;
    if (reg.test(num2.value)==false) {
        alert("Please input non-negative integer for quota.");
        return false;
    }    
    else if(num.value.length>32){
        alert("Input should be no more than 32 chars");
        return false;
    }
    else {
        return true;
    }
}

// used for check specific order
function checkorder() {
    var order = document.getElementById("order");

    if (order.value == "") {
        alert("Order ID cannot be empty");
        return false;
    }
    else {
        return true;
    }
}

// used for Check the number of masks sold by a specific representative
function checkreps3() {
    var reps3 = document.getElementById("reps3");

    if (reps3.value == "") {
        alert("Reps ID cannot be empty");
        return false;
    }
    else {
        return true;
    }
}

// used for check week numbers 
function checkweek() {
    var week = document.getElementById("week");
    var reg=/^(0|[1-9][0-9]*)$/;
    if (reg.test(week.value)==false) {
        alert("Please input non-negative integer week numbers.");
        return false;
    }
    else {
        return true;
    }
}

// used for check the masks sold in a region
function checkregion2() { 
    var region1 = document.getElementById("region5");
    var region2 = document.getElementById("region6");
    var region3 = document.getElementById("region7");
    var region4 = document.getElementById("region8");
    if ((region5.checked || region6.checked || region7.checked || region8.checked) == false) {
        alert("You have to choose one region.");
        return false;
    }
    else {
        return true;
    }
}

