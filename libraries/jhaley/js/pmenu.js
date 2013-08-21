/*
* Do not remove this notice.
*
* Copyright 2011 by Richard Jaldin <ric.jhaley@gmail.com>.
* JSON Object for Popup Menu.
* 
*/

Jha.pmenu = function() {
	
    this.createPMenu = function (event, contenido){
	    var items = this.createLinks(contenido);
		return this.createPopupMenu(event, items);
	};
	this.renderPMenu = function (event, contenido){
		var obj = this.createPMenu(event, contenido);
		Jha.dom.$$$('body', 0).appendChild(obj);
	};
	this.createLinks = function (contenido){
		var res = [];
		for (var i = 0; i < contenido.length; i++) {
			var item = contenido[i];
			var aux = Jha.dom.create('a');
			aux.innerHTML = item.nombre;
			for (var j = 0; j < item.atributos.length; j++) {
				if (item.atributos[j][0] == 'onclick') {
					item.atributos[j][1] += ' pm = new Jha.pmenu(); pm.hidePMenu();';
				}
				aux.setAttribute(item.atributos[j][0], item.atributos[j][1]);
			}
			res[res.length] = aux;
		}
		return res;
	};
	this.createPopupMenu = function (event, items){
		this.hidePMenu();
		div = Jha.dom.create('div');
		Jha.dom.$$$('body', 0).appendChild(div);
		div.setAttribute('class', 'popup-menu');
		posxy = Jha.dom.posFromEvent(event);
		div.setAttribute('style', 'top:' + posxy.y + 'px; left:' + posxy.x + 'px;');
		div.setAttribute('id', 'popup_menu');
		//creando tabla contenedora.
		var table = Jha.dom.create('table');
		for (var i = 0; i < items.length; i++) {
			var tr = Jha.dom.create('tr');
			var td = Jha.dom.create('td');
			td.appendChild(items[i]);
			tr.appendChild(td);
			table.appendChild(tr);
		}
		div.appendChild(table);
		return div;
	};
	this.hidePMenu = function (){
		var div = Jha.dom.$('popup_menu');
		if(div)
			div.parentNode.removeChild(div);
	};
};