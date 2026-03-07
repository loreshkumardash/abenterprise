function chkdata(obj,type)
{
	var checkstr
	//var fieldname
	checkstr=obj.value
	
	if (type =='alphabet')		
		var checkOK = " ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	else if (type=='email')												
		var checkOK = " 0123456789.@_-ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	else if (type =='number' )									
		var checkOK = "0123456789";
	else if (type =='decimal' )									
		var checkOK = "0123456789.";
	else if (type =='date' )									
		var checkOK = "0123456789/-";
	else if (type =='phone' )									
		var checkOK = " 0123456789-+)(";
	else if (type=='address')																		 
		var checkOK = "0123456789- ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz@\/,.+";
	else if (type=='alphanumeric')															
		var checkOK = " 0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	else if (type=='caps')															
		var checkOK = " 0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	else if (type=='words')															
		var checkOK = " 0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz.,-_/\\";
	else if (type=='website')															
		var checkOK = " 0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz:%.,-_/\\";
	else if(type == 'alphanum')
		var checkOK = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	var allValid = true;
	var decPoints = 0;
	var allNum = "";
	for (i = 0;  i < checkstr.length;  i++)
	{
		ch = checkstr.charAt(i);
		for (j = 0;  j < checkOK.length;  j++)
		if (ch == checkOK.charAt(j))
		{ break;}
		
		if (j == checkOK.length)
		{
			allValid = false;
			break;
		}
		if (ch != ",")
			allNum += ch;
	}
	if (!allValid)
	{
		obj.value=allNum
		obj.focus();
	}
}


function notEmpty(elem, helperMsg){
	if(elem.value.length == 0){
		alert(helperMsg);
		elem.focus(); // set the focus to this input
		return false;
	}
	return true;
}

function isNumeric(elem, helperMsg){
	var numericExpression = /^[0-9]+$/;
	if(elem.value.match(numericExpression)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}

function isAlphabet(elem, helperMsg){
	var alphaExp = /^[a-zA-Z]+$/;
	if(elem.value.match(alphaExp)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}

function isAlphanumeric(elem, helperMsg){
	var alphaExp = /^[0-9a-zA-Z]+$/;
	if(elem.value.match(alphaExp)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}

function lengthRestriction(elem, min, max){
	var uInput = elem.value;
	if(uInput.length >= min && uInput.length <= max){
		return true;
	}else{
		alert("Please enter between " +min+ " and " +max+ " characters");
		elem.focus();
		return false;
	}
}

function passwordchar(elem, min){
	var uInput = elem.value;
	if(uInput.length >= min){
		return true;
	}else{
		alert("Password atleast " +min+ " characters long");
		elem.focus();
		return false;
	}
}

function madeSelection(elem, helperMsg){
	if(elem.value == ""){
		alert(helperMsg);
		elem.focus();
		return false;
	}else{
		return true;
	}
}

function emailValidator(elem, helperMsg){
	var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	if(elem.value.match(emailExp)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}