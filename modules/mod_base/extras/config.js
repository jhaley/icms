/**
 * 
 *  Funciones de validacion de la configuracion.
 */

function validateForm() {
	var msg = '';
	if(!Jha.html.input.validate(Jha.dom.$('db_host').value, 'not empty')){
		msg += 'Debe ingresar el servidor de Base de Datos.\n';
	}
	if(!Jha.html.input.validate(Jha.dom.$('db_database').value, 'not empty')){
		msg += 'Debe ingresar el nombre de la Base de Datos.\n';
	}
	if(!Jha.html.input.validate(Jha.dom.$('db_user').value, 'not empty')){
		msg += 'Debe ingresar el usuario de la Base de Datos.\n';
	}
	if(!Jha.html.input.validate(Jha.dom.$('db_preffix').value, 'not empty')){
		msg += 'Debe ingresar el prefijo de las tablas (Por defecto "jha_").\n';
	}
	if(!Jha.html.input.validate(Jha.dom.$('db_preffix').value, 'not empty')){
		msg += 'Debe ingresar el prefijo de las tablas (Por defecto "jha_").\n';
	}
	if (msg != '') {
		alert(msg);
		return false;
	}
	return true;
}

