/*
* Do not remove this notice.
*
* Copyright 2011 by Richard Jaldin <ric.jhaley@gmail.com>.
* JSON Object for Popup Windows.
* 
*/

Jha.popup = function() {
	
    this.renderPopup = function (){
	    this.createOverlay();
		this.createPopup();
	};
	this.createOverlay = function (){
		var div = Jha.dom.$('popup_overlay');
		if (!div) {
			div = Jha.dom.create('div');
			Jha.dom.$$$('body', 0).appendChild(div);
		}
		div.setAttribute('class', 'popup-overlay');
		div.setAttribute('style', 'z-index: 1000; background-color: #000000; opacity: 0.5; position: fixed; width: 100%; height: 100%; top:0; left:0;');
		div.setAttribute('id', 'popup_overlay');
		div.setAttribute('onclick', 'obj = new Jha.popup(); obj.hidePopup();');
	};
	this.createPopup = function (){
		var capa = Jha.dom.$('popup_window');
		if (!capa) {
			capa = Jha.dom.create('div');
			Jha.dom.$$$('body', 0).appendChild(capa);
		}
		capa.setAttribute('class', 'art-Block');
		capa.setAttribute('id', 'popup_window');
		capa.setAttribute('style', 'left: 50%; margin-left: -300px; opacity: 0.9; position: fixed; top: 50%; width: 600px; z-index: 1001;');
		capa.innerHTML = '<div class="art-Block-tl"></div><div class="art-Block-tr"></div><div class="art-Block-bl"></div><div class="art-Block-br"></div><div class="art-Block-tc"></div><div class="art-Block-bc"></div><div class="art-Block-cl"></div><div class="art-Block-cr"></div><div class="art-Block-cc"></div><div class="art-Block-body"><div class="art-BlockContent"><div style="height: 20px; position: absolute; right: 0; top: 0; width: 20px; z-index: 1500;"><a href="javascript:;" onclick="javascript:obj = new Jha.popup(); obj.hidePopup();"><img src="images/close.png" title="Cerrar" /></a></div><div class="art-BlockContent-tl"></div><div class="art-BlockContent-tr"></div><div class="art-BlockContent-bl"></div><div class="art-BlockContent-br"></div><div class="art-BlockContent-tc"></div><div class="art-BlockContent-bc"></div><div class="art-BlockContent-cl"></div><div class="art-BlockContent-cr"></div><div class="art-BlockContent-cc"></div><div class="art-BlockContent-body" id="popup"></div></div><div class="cleared"></div></div>';
		
	};
	this.hidePopup = function (){
		var div = Jha.dom.$('popup_overlay');
		div.parentNode.removeChild(div);
		div = Jha.dom.$('popup_window');
		div.parentNode.removeChild(div);
	};
};