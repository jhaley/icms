/**
 * Copyright 2011 by Richard Jaldin <ric.jhaley@gmail.com>.
 *  
 * Themes management functions.
 */

/**
 * Funciones para llamadas dinamicas al server.
 */

function changeDefault(id){
	if(!Jha.dom.$('rb'+id).checked) Jha.dom.$('rb'+id).checked = true;
	Jha.dom.$('task').value = 'changeDefault';
	document.forms.adminForm.submit();
}

function changeName(obj){
	if(!Jha.dom.$('nombre'))	return false;
	else if(Jha.dom.$('nombre').value != '')	return false;
	var nom = obj.value + '';
	var parts = nom.split('.');
	if(nom.search(' ') != -1)	alert('El nombre de la plantilla no debe contener espacios.')
	Jha.dom.$('nombre').value = parts[0];
}

function validateForm() {
	var msg = '';
	if(!Jha.html.input.validate(Jha.dom.$('nombre').value, 'not empty')){
		msg += 'Debe ingresar el nombre de la plantilla.\n';
	}
	if(!Jha.html.input.validate(Jha.dom.$('theme').value, 'not empty')){
		msg += 'Debe seleccionar el archivo de la plantilla.\n';
	}
	if (msg != '') {
		alert(msg);
		return false;
	}
	return true;
}