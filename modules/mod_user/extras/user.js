/**
 * Copyright 2011 by Richard Jaldin <ric.jhaley@gmail.com>.
 * 
 * User management functions.
 */

function validateForm() {
	var msg = '';
	if(!Jha.html.input.validate(Jha.dom.$('nombre').value, 'not empty')){
		msg += 'Debe ingresar el nombre real.\n';
	}
	if(!Jha.html.input.validate(Jha.dom.$('usuario').value, 'username')){
		msg += 'Debe ingresar un nombre de usuario con un minimo de 6 caracteres (numeros, letras, _ y .).\n';
	}
	if(Jha.dom.$('user_msg').innerHTML != '') {
		msg += 'El nombre de usuario es invalido.\n';
	}
	if(!validatePassword(Jha.dom.$('contrasenia').value, Jha.dom.$('rcontrasenia').value)){
		msg += 'Debe ingresar un nombre de usuario con un minimo de 6 caracteres.\n';
	}
	if (msg != '') {
		alert(msg);
		return false;
	}
	return true;
}

function validatePassword(passwd, rpasswd) {
	if(passwd == rpasswd)
		return true;
	return false;
}

function isUniqueName(name) {
	var objajax = new Jha.ajax();
	objajax.url = "ajax.php";
    objajax.json = false;
    objajax.post = {
		elem : Jha.dom.$('elem').value,
		nombre : name,
		task : 'isUniqueName'
	};
	objajax.idUpdate = 'user_msg';
    objajax.enviarpeticion();
	objajax.action = function () {
		if (objajax.responseText.indexOf('Nombre de usuario ingresado ya existe, ingrese otro.') != -1) {
			return false;
		}
		else {
			return true;
		}
	}
}
