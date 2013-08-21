/**
 * Copyright 2011 by Richard Jaldin <ric.jhaley@gmail.com>.
 * 
 * Menus management functions.
 */

function showMenuItems(id){
	clear();
	Jha.dom.$('showing').value = id;
	Jha.dom.$('showButton' + id).setAttribute('onclick', 'javascript:hideMenuItems(' + id + ');');
	Jha.dom.$('showButton' + id).innerHTML = 'Ocultar';
	var objajax = new Jha.ajax();
	objajax.url = "ajax.php";
    objajax.json = false;
    objajax.post = {
		elem : Jha.dom.$('elem').value,
		idmenu : id,
		task : 'loadMenuItems'
	};
	objajax.idUpdate = 'menuitems' + id;
    objajax.enviarpeticion();
}

function hideMenuItems(id){
	Jha.dom.$('showing').value = 0;
	Jha.dom.$('showButton' + id).setAttribute('onclick', 'javascript:showMenuItems(' + id + ');');
	Jha.dom.$('showButton' + id).innerHTML = 'Mostrar';
	Jha.dom.$('menuitems' + id).innerHTML = '';
}

function clear(){
	var obj = Jha.dom.$('menuitemslist');
	if(obj != undefined){
		var parentId = obj.parentNode.id + '';
		id = parentId.substr(9);
		hideMenuItems(id);
	}
}

function validateForm() {
	var msg = '';
	if(!Jha.html.input.validate(Jha.dom.$('titulo').value, 'not empty')){
		msg += 'Debe ingresar el nombre del menu.\n';
	}
	if (msg != '') {
		alert(msg);
		return false;
	}
	return true;
}
