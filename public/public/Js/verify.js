//verify.js
function freshVerify(url){
	$('#verifyImg').attr('src', url+"?time="+ (new Date()).getTime());
}