/**
 * Copyright 2011 by Richard Jaldin <ric.jhaley@gmail.com>.
 *  
 * Blocks management functions.
 */

/*
 * Relacionamiento menu-bloque.
 */
function allselections() {
    var e = Jha.dom.$('selections');
        e.disabled = true;
    var i = 0;
    var n = e.options.length;
    for (i = 0; i < n; i++) {
        e.options[i].disabled = true;
        e.options[i].selected = true;
    }
}

function disableselections() {
    var e = Jha.dom.$('selections');
        e.disabled = true;
    var i = 0;
    var n = e.options.length;
    for (i = 0; i < n; i++) {
        e.options[i].disabled = true;
        e.options[i].selected = false;
    }
}

function enableselections() {
    var e = Jha.dom.$('selections');
        e.disabled = false;
    var i = 0;
    var n = e.options.length;
    for (i = 0; i < n; i++) {
        e.options[i].disabled = false;
    }
}

/**
 * Funciones para llamadas dinamicas al server.
 */

function loadParamenters(){
	var objajax = new Jha.ajax();
	objajax.url = "ajax.php";
    objajax.json = false;
    objajax.post = {
		elem : Jha.dom.$('elem').value,
		controller : Jha.dom.$('controller').value,
		blocktype : Jha.dom.$('renderizador').value,
		id : Jha.dom.$('id').value,
		task : 'loadParameters'
	};
	objajax.idUpdate = 'parameters-block';
    objajax.enviarpeticion();
	objajax.action = function (){
		initEditor();
	}
}

function initEditor(){
	if(Jha.dom.$('renderizador').value == 'block_custom'){
		Jha.dom.$('contenidoHTML').style.display = 'block';
	}
	else{
		Jha.dom.$('contenidoHTML').style.display = 'none';
	}
}

function loadOrder(){
    var objajax = new Jha.ajax();
    objajax.url = "ajax.php";
    objajax.json = false;
    objajax.post = {
        elem : Jha.dom.$('elem').value,
        controller : Jha.dom.$('controller').value,
        region : Jha.dom.$('region').value,
        task : 'loadOrder'
    };
    objajax.idUpdate = 'orden';
    objajax.enviarpeticion();
}

function selectFolder(){
	popup = new Jha.popup();
	popup.renderPopup();
	objajax = new Jha.ajax();
	objajax.url = "ajax.php";
    objajax.json = false;
    objajax.post = {
		elem: 'mod_base',
		controller: 'block',
		task: 'selectFolder',
		path: Jha.dom.$('params_directory').value
	};
	objajax.idUpdate = "popup";
	objajax.action = function (){
		var obj = Jha.dom.$('popup_window');
		obj.style.height = obj.offsetHeight + 'px';
		obj.style.marginTop = '-' + parseInt(obj.offsetHeight / 2) + 'px';
	}
    objajax.enviarpeticion();
}

function selectBannerFolder(path){
	Jha.dom.$('params_directory').value = path;
	popup = new Jha.popup();
	popup.hidePopup();
}

function exploreBannerFolder(folderpath) {
	objajax = new Jha.ajax();
	objajax.url = "ajax.php";
    objajax.json = false;
    objajax.post = {
		elem: 'mod_base',
		controller: 'block',
		task: 'selectFolder',
		path: folderpath
	};
	objajax.idUpdate = "popup";
    objajax.enviarpeticion();
}

function validateForm() {
	var msg = '';
	if (!Jha.html.select.validate(Jha.dom.$('renderizador').value, 'x')) {
		msg += 'Debe seleccionar un tipo de Bloque.\n';
	}
	if (!Jha.html.input.validate(Jha.dom.$('titulo').value, 'alphanum')){
		msg += 'Debe ingresar el titulo.\n';
	}
	if (!Jha.html.select.validate(Jha.dom.$('region').value, 'x')) {
		msg += 'Debe seleccionar una region para mostrar el bloque.\n';
	}
	if (msg != '') {
		alert(msg);
		return false;
	}
	return true;
}

