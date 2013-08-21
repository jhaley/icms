
function validateForm() {
	var msg = '';
	if(!Jha.html.input.validate(Jha.dom.$('contenido').value, 'not empty')){
		msg += 'Debe ingresar el contenido de la noticia.\n';
	}
	if (msg != '') {
		alert(msg);
		return false;
	}
	return true;
}
