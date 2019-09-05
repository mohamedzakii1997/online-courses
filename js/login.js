var loginspan=document.getElementById('login'),
	signupspan=document.getElementById('signup'),
	loginform=document.getElementById('loginform'),
	signupform=document.getElementById('signupform');
	loginspan.onclick=function (){
		loginform.style.display='block';
		signupspan.classList.add('disableRegister');
		this.classList.remove('disableRegister');
		signupform.style.display='none';
	};
signupspan.onclick=function (){
	loginform.style.display='none';
	signupform.style.display="block";
	loginspan.classList.add('disableRegister');
	this.classList.remove('disableRegister');
};
window.onload = function (){
	if(loginspan.classList.contains('disableRegister')){
		loginform.style.display="none";
		signupform.style.display="block";
	}
	else if (signupspan.classList.contains('disbleRegister')){
		loginform.style.display="block";
		signupform.style.display="none";
	}
};
var signupInputs=document.querySelectorAll('#signupform input'),
	newPassword = document.getElementById('new-password');
	newUsername = document.getElementById('new-username'),
	signupbutton= document.getElementById('signupbutton'),
	invalidFeedback=document.querySelector('.signerror');
for (var i = 0; i <signupInputs.length; i++) {
	signupInputs[i].onblur=function(){
		if(this.value.length==0){
			this.classList.add('is-invalid');
			this.classList.remove('is-valid');
		}else{
		this.classList.add('is-valid');
		this.classList.remove('is-invalid');
		}
	};
}
newUsername.addEventListener('blur',function(){
	if((this.value.length<5) || (this.value.length>30)){
		this.classList.add('is-invalid');
		this.classList.remove('is-valid');
		this.nextElementSibling.style.display='block';
	}else {
		this.classList.add('is-valid');
		this.classList.remove('is-invalid');
		this.nextElementSibling.style.display='none';
	}
});
newPassword.addEventListener('blur',function(){
	if((this.value.length<5) || (this.value.length>30)){
		this.classList.add('is-invalid');
		this.classList.remove('is-valid');
		this.nextElementSibling.style.display='block';
	}else {
		this.classList.add('is-valid');
		this.classList.remove('is-invalid');
		this.nextElementSibling.style.display='none';
	}
});
signupbutton.onclick= function(event){
	for (var i = 0; i <signupInputs.length; i++) {
		if(signupInputs[i].value.length==0||signupInputs[i].classList.contains('is-invalid')){
			event.preventDefault();
			invalidFeedback.style.display='inline';
			break;
		}
}
};

