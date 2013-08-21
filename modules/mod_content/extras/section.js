
function validateForm() {
	var msg = '';
	if(!Jha.html.input.validate(Jha.dom.$('nombre').value, 'not empty')){
		msg += 'Debe ingresar el nombre de la seccion.\n';
	}
	if (msg != '') {
		alert(msg);
		return false;
	}
	return true;
}
