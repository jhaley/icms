
function validateForm() {
	var msg = '';
	if(!Jha.html.input.validate(Jha.dom.$('titulo').value, 'not empty')){
		msg += 'Debe ingresar el titulo del articulo.\n';
	}
	if (msg != '') {
		alert(msg);
		return false;
	}
	return true;
}
