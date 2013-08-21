/**
 * Copyright 2011 by Richard Jaldin <ric.jhaley@gmail.com>.
 * 
 * Menus management functions.
 */

function showPopupMenu(event){
	var content = [
		{
			nombre: 'Art&iacute;culos',
			atributos: [
				['href', 'javascript:;'],
				['onclick', 'javascript:listForSelect(true);']
			]
		}, {
			nombre: 'Secciones',
			atributos: [
				['href', 'javascript:;'],
				['onclick', 'javascript:listForSelect(false);']
			]
		}, {
			nombre: 'Enlace Externo',
			atributos: [
				['href', 'javascript:;'],
				['onclick', 'javascript:externalLink();']
			]
		}
	];
	var popupmenu = new Jha.pmenu();
	var pmHTML = popupmenu.createPMenu(event, content);
	Jha.dom.$$$('body', 0).appendChild(pmHTML);
	document.onclick = popupmenu.hidePMenu;
}

function listForSelect(isArticle){
	popup = new Jha.popup();
	popup.renderPopup();
	objajax = new Jha.ajax();
	objajax.url = "ajax.php";
    objajax.json = false;
    objajax.post = {
		elem: 'mod_menu',
		task: isArticle ? 'listArticles' : 'listSections'
	};
	objajax.idUpdate = "popup";
	objajax.action = function (){
		var obj = Jha.dom.$('popup_window');
		obj.style.height = obj.offsetHeight + 'px';
		obj.style.marginTop = '-' + parseInt(obj.offsetHeight / 2) + 'px';
	}
    objajax.enviarpeticion();
}

function externalLink(){
	popup = new Jha.popup();
	popup.renderPopup();
	var div = Jha.dom.$('popup');
	//creando tabla contenedora.
	var table = Jha.dom.create('table');
	var tr = Jha.dom.create('tr');
	var td = Jha.dom.create('td');
	var input = Jha.dom.create('input');
	input.setAttribute('type', 'text');
	input.setAttribute('name', 'extlink');
	input.setAttribute('id', 'extlink');
	input.setAttribute('value', 'http://');
	td.appendChild(input);
	tr.appendChild(td);
	td = new Jha.dom.create('td');
	var a = Jha.dom.create('a');
	a.innerHTML = 'Validar Enlace';
	a.setAttribute('href', 'javascript:;');
	a.setAttribute('onclick', 'javascript:selectExternalLink(Jha.dom.$(\'extlink\').value);');
	td.appendChild(a);
	tr.appendChild(td);
	table.appendChild(tr);
	div.appendChild(table);
}

function selectExternalLink(link){
	popup = new Jha.popup();
	popup.hidePopup();
	Jha.dom.$('enlace').value = link;
	Jha.dom.$('enlace_view').value = 'Enlace Externo';
}

function selectLink(link, id, nombre){
	popup = new Jha.popup();
	popup.hidePopup();
	Jha.dom.$('enlace').value = link;
	Jha.dom.$('enlace_view').value = id + ' : ' + nombre;
}

function validateForm() {
	var msg = '';
	if(!Jha.html.input.validate(Jha.dom.$('nombre').value, 'not empty')){
		msg += 'Debe ingresar el nombre para el menu.\n';
	}
	if (msg != '') {
		alert(msg);
		return false;
	}
	return true;
}
