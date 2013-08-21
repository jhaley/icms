/**
 * Copyright 2011 by Richard Jaldin <ric.jhaley@gmail.com>.
 *  
 * Personalize themes management functions.
 */

function popupThemeMenu(event, isModule, region){
	//Jha.dom.scan(event);
	var content = null;
	if(!isModule){
		content = [
			{
				nombre: 'Dividir en filas',
				atributos: [
					['href', 'javascript:;'],
					['onclick', 'javascript:divideIn(true, \'' + region + '\');']
				]
			}, {
				nombre: 'Dividir en columnas',
				atributos: [
					['href', 'javascript:;'],
					['onclick', 'javascript:divideIn(false, \'' + region + '\');']
				]
			}, {
				nombre: 'Eliminar region',
				atributos: [
					['href', 'javascript:;'],
					['onclick', 'javascript:deleteRegion(\'' + region + '\');']
				]
			}, {
				nombre: 'Establecer como contenido principal',
				atributos: [
					['href', 'javascript:;'],
					['onclick', 'javascript:stablishMainContent(\'' + region + '\');']
				]
			}, {
				nombre: 'Cambiar el nombre de region',
				atributos: [
					['href', 'javascript:;'],
					['onclick', 'javascript:changeRegionName(\'' + region + '\');']
				]
			}/*, {
				nombre: 'Agregar atributos (class, style, etc.)',
				atributos: [
					['href', 'javascript:;'],
					['onclick', 'javascript:addAttributes(\'' + region + '\');']
				]
			}*/
		];
	}
	else {
		content = [
			{
				nombre: 'Dividir en filas',
				atributos: [
					['href', 'javascript:;'],
					['onclick', 'javascript:divideIn(true, \'' + region + '\');']
				]
			}, {
				nombre: 'Dividir en columnas',
				atributos: [
					['href', 'javascript:;'],
					['onclick', 'javascript:divideIn(false, \'' + region + '\');']
				]
			}/*, {
				nombre: 'Agregar atributos (class, style, etc.)',
				atributos: [
					['href', 'javascript:;'],
					['onclick', 'javascript:addAttributes(\'' + region + '\');']
				]
			}*/
		];
	}
	var popupmenu = new Jha.pmenu();
	var pmHTML = popupmenu.createPMenu(event, content);
	Jha.dom.$$$('body', 0).appendChild(pmHTML);
	document.onclick = popupmenu.hidePMenu;
}

function reorganizeXML(elem){
	regblock = /<div([^>]+)><span([^>]+)>(Region:\s)([^<]+)(<\/span><\/div>)/g;
	regmodule = /<div([^>]+)><span([^>]+)>(Contenido Principal)(<\/span><\/div>)/g;
	html = elem.innerHTML + '';
	blocksReplaced = html.replace(regblock, "<jhadoc type=\"block\" region=\"$4\"></jhadoc>");
	moduleReplaced = blocksReplaced.replace(regmodule, "<jhadoc type=\"module\"></jhadoc>");
	xmlFinal = moduleReplaced.replace(/div/g, 'elem');
	return xmlFinal;
}

function divide(isRow, reg, numCols){
	objajax = new Jha.ajax();
	objajax.url = "ajax.php";
    objajax.json = false;
    objajax.post = {
		elem: 'mod_base',
		controller: 'theme',
		task: 'divideIn',
		dividemethod: isRow ? 'rows' : 'cols',
		region: reg,
		cols: numCols
	};
	objajax.action = function () {
		location.href = location.href;
	}
    objajax.enviarpeticion();
}

function divideIn(isRow, reg){
	if (isRow) {
		divide(isRow, reg, 0);
	}
	else {
		popup = new Jha.popup();
		popup.renderPopup();
		var div = Jha.dom.$('popup');
		//creando tabla contenedora.
		var table = Jha.dom.create('table');
		var tr = Jha.dom.create('tr');
		var td = Jha.dom.create('td');
		var label = Jha.dom.create('label');
		label.innerHTML = 'Nº de columnas: ';
		td.appendChild(label);
		tr.appendChild(td);
		td = Jha.dom.create('td');
		var input = Jha.dom.create('select');
		input.setAttribute('name', 'ncols');
		input.setAttribute('id', 'ncols');
		for (var i = 2; i <= 5; i++) {
			var opt = Jha.dom.create('option');
			opt.setAttribute('value', i);
			opt.innerHTML = i;
			input.appendChild(opt);
		}
		td.appendChild(input);
		tr.appendChild(td);
		td = new Jha.dom.create('td');
		var a = Jha.dom.create('a');
		a.innerHTML = 'Dividir';
		a.setAttribute('href', 'javascript:;');
		a.setAttribute('onclick', 'javascript:divide(' + isRow + ', \'' + reg + '\', Jha.dom.$(\'ncols\').value);');
		td.appendChild(a);
		tr.appendChild(td);
		table.appendChild(tr);
		div.appendChild(table);
	}
}

function deleteRegion(reg){
	objajax = new Jha.ajax();
	objajax.url = "ajax.php";
    objajax.json = false;
    objajax.post = {
		elem: 'mod_base',
		controller: 'theme',
		task: 'deleteRegion',
		region: reg
	};
	objajax.action = function () {
		location.href = location.href;
	}
    objajax.enviarpeticion();
}

function changeRegionName(region){
	popup = new Jha.popup();
	popup.renderPopup();
	var div = Jha.dom.$('popup');
	//creando tabla contenedora.
	var table = Jha.dom.create('table');
	var tr = Jha.dom.create('tr');
	var td = Jha.dom.create('td');
	var input = Jha.dom.create('input');
	input.setAttribute('type', 'text');
	input.setAttribute('name', 'newregion');
	input.setAttribute('id', 'newregion');
	input.setAttribute('value', '');
	td.appendChild(input);
	tr.appendChild(td);
	td = new Jha.dom.create('td');
	var a = Jha.dom.create('a');
	a.innerHTML = 'Validar nombre';
	a.setAttribute('href', 'javascript:;');
	a.setAttribute('onclick', 'javascript:validateRegionName(Jha.dom.$(\'newregion\').value, \'' + region + '\');');
	td.appendChild(a);
	tr.appendChild(td);
	table.appendChild(tr);
	div.appendChild(table);
}

function stablishMainContent(reg){
	objajax = new Jha.ajax();
	objajax.url = "ajax.php";
    objajax.json = false;
    objajax.post = {
		elem: 'mod_base',
		controller: 'theme',
		task: 'changeMainContent',
		region: reg
	};
	objajax.action = function () {
		location.href = location.href;
	}
    objajax.enviarpeticion();
}

function addAttributes(region){
	popup = new Jha.popup();
	popup.renderPopup();
	var div = Jha.dom.$('popup');
	//creando tabla contenedora.
	var table = Jha.dom.create('table');
	var tr = Jha.dom.create('tr');
	var td = Jha.dom.create('td');
	var label = Jha.dom.create('label');
	label.setAttribute('for', 'attr');
	label.innerHTML = 'Atributo: ';
	var input = Jha.dom.create('input');
	input.setAttribute('type', 'text');
	input.setAttribute('name', 'attr');
	input.setAttribute('id', 'attr');
	input.setAttribute('value', '');
	td.appendChild(label);
	td.appendChild(input);
	tr.appendChild(td);
	
	td = Jha.dom.create('td');
	label = Jha.dom.create('label');
	label.setAttribute('for', 'valor');
	label.innerHTML = 'Valor: ';
	var input = Jha.dom.create('input');
	input.setAttribute('type', 'text');
	input.setAttribute('name', 'valor');
	input.setAttribute('id', 'valor');
	input.setAttribute('value', '');
	td.appendChild(label);
	td.appendChild(input);
	tr.appendChild(td);
	td = new Jha.dom.create('td');
	var a = Jha.dom.create('a');
	a.innerHTML = 'Validar atributo';
	a.setAttribute('href', 'javascript:;');
	a.setAttribute('onclick', 'javascript:validateAttribute(Jha.dom.$(\'attr\').value, Jha.dom.$(\'valor\').value, \'' + region + '\');');
	td.appendChild(a);
	tr.appendChild(td);
	table.appendChild(tr);
	div.appendChild(table);
}

function validateRegionName(newreg, oldreg){
	if(newreg == undefined || newreg == '')	return false;
	objajax = new Jha.ajax();
	objajax.url = "ajax.php";
    objajax.json = false;
    objajax.post = {
		elem: 'mod_base',
		controller: 'theme',
		task: 'changeRegionName',
		oldregion: oldreg,
		newregion: newreg
	};
	objajax.action = function () {
		location.href = location.href;
	}
    objajax.enviarpeticion();
}

function validateAttribute(attr, val, reg){
	if(attr == undefined || attr == '')	return false;
	objajax = new Jha.ajax();
	objajax.url = "ajax.php";
    objajax.json = false;
    objajax.post = {
		elem: 'mod_base',
		controller: 'theme',
		task: 'setThemeAttribute',
		region: reg,
		attribute: attr,
		value: val
	};
	objajax.action = function () {
		location.href = location.href;
	}
    objajax.enviarpeticion();
}
