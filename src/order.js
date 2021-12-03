function checkform() {
    var num1 = document.getElementById("num1");
    var num2 = document.getElementById("num2");
    var num3 = document.getElementById("num3");
    var num4 = document.getElementById("reps");
    var reg=/^(0|[1-9][0-9]*)$/;
    if ((reg.test(num1.value)==false) || (reg.test(num2.value)==false) || (reg.test(num3.value)==false) || (reg.test(num4.value)==false)){
        alert("Please input non-negative integer for numbers and ID.");
        return false;
    }
    else{
        return true;
    }
}

function checknum5() {
    var num = document.getElementById("order");
    var reg=/^(0|[1-9][0-9]*)$/;
    if (reg.test(num.value)==false) {
        alert("Please input non-negative integer for ID.");
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

