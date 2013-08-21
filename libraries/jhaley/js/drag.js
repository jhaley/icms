/**
* Do not remove this notice.
*
* Copyright 2011 by Richard Jaldin <ric.jhaley@gmail.com>.
* JSON Object for Drag'n'Drop Utilities.
* 
*/

Jha.drag = function() {
	var drg             = this;
	this.type           = 'element';
	this.currentSource  = null;
	this.targets        = [];
	this.cursorStartX   = 0;
    this.cursorStartY   = 0;
    this.elStartLeft    = 0;
    this.elStartTop     = 0;
    this.zIndex         = 0;
    this.alternate      = null;
    this.target         = -1;
    this.isBeforeTarget = false;
	
    this.setType = function (type){
	    drg.type = type;
	};
	this.addTarget = function (trg){
	    drg.targets[drg.targets.length] = trg;
	};
    this.removeTarget = function (trg){
	    delete drg.targets[Jha.util.inArray(trg, drg.targets)];
	};
	this.removeAllTargets = function(){
	    drg.targets = [];
	};
	this.onDragStart = function(event, newSource){
		drg.currentSource = newSource;
		var x, y;
		if (Jha.nav.isIE) {
			x = window.event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft;
			y = window.event.clientY + document.documentElement.scrollTop + document.body.scrollTop;
		}
		else if (!Jha.nav.isIE) {
			x = event.clientX + window.scrollX;
			y = event.clientY + window.scrollY;
		}
		drg.cursorStartX = x;
		drg.cursorStartY = y;
		drg.elStartLeft = parseInt(drg.currentSource.offsetLeft, 10);
		drg.elStartTop = parseInt(drg.currentSource.offsetTop, 10);
		if (isNaN(drg.elStartLeft)) 
			drg.elStartLeft = 0;
		if (isNaN(drg.elStartTop)) 
			drg.elStartTop = 0;
		drg.currentSource.style.width = drg.currentSource.offsetWidth + 'px';
		drg.currentSource.style.zIndex = ++drg.zIndex;
		drg.currentSource.style.position = 'absolute';
		if (Jha.nav.isIE) {
			document.attachEvent("onmousemove", drg.onDragMove);
			document.attachEvent("onmouseup", drg.onDragEnd);
			window.event.cancelBubble = true;
			window.event.returnValue = false;
		}
		if (!Jha.nav.isIE) {
			document.addEventListener("mousemove", drg.onDragMove, true);
			document.addEventListener("mouseup", drg.onDragEnd, true);
			event.preventDefault();
		}
		drg.target = Jha.util.inArray(drg.currentSource,drg.targets);
		drg.isBeforeTarget = true; 
		drg.onDragTargetHit();
	};
	this.onDragMove = function(event){
        var x, y;
        if (Jha.nav.isIE) {
            x = window.event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft;
            y = window.event.clientY + document.documentElement.scrollTop + document.body.scrollTop;
        }
        if (!Jha.nav.isIE) {
            x = event.clientX + window.scrollX;
            y = event.clientY + window.scrollY;
        }
        var resux = drg.elStartLeft + x - drg.cursorStartX;
        var resuy = drg.elStartTop + y - drg.cursorStartY;
        if (resux >= 0 && resuy >= 0) {
            drg.currentSource.style.left = resux + "px";
            drg.currentSource.style.top = resuy + "px";
            if (Jha.nav.isIE) {
                window.event.cancelBubble = true;
                window.event.returnValue = false;
            }
            if (!Jha.nav.isIE) 
                event.preventDefault();
        }
		// verificar que src != target
		// verificar si las coordenadas del currentSource corresponden a alguno de los targets.
		// de ser asi, establecer el suplente antes del target.
		// sino ver si target lost, sino tar get = src.
		drg.onDragTargetLost();
		drg.target = -1;
		for (var i = 0; i < drg.targets.length; i++) {
	        if(drg.currentSource != drg.targets[i]){
				pos = Jha.dom.position(drg.targets[i]);
				if(drg.mapping(resux, resuy, pos, i))    break;
			}
        }
		if(drg.target == -1){
			style = drg.currentSource.style.cssText;
			drg.currentSource.removeAttribute('style');
			if(Jha.nav.isIE || Jha.nav.isOP)
			    drg.currentSource.style = null;
			pos = Jha.dom.position(drg.currentSource);
			if(!drg.mapping(resux, resuy, pos, Jha.util.inArray(drg.currentSource, drg.targets))){
				drg.onDragTargetLost();
			}
			drg.currentSource.setAttribute('style', style);
		}
		if(drg.target != -1)  drg.onDragTargetHit();
	};
	this.onDragTargetHit = function(){
		drg.onDragTargetLost();
		drg.alternate = drg.createAlternate(drg.currentSource);
		nodes = drg.targets[drg.target].parentNode.childNodes
		if(drg.isBeforeTarget)
		    drg.targets[drg.target].parentNode.insertBefore(drg.alternate, drg.targets[drg.target]);
		else
		    drg.targets[drg.target].parentNode.insertBefore(drg.alternate, nodes[Jha.util.inArray(drg.targets[drg.target], nodes) + 1]);
	};
	this.onDragTargetLost = function() {
		drg.alternate = Jha.dom.$('alternate');
        if(drg.alternate != undefined)
            drg.alternate.parentNode.removeChild(drg.alternate);
	};
	this.onDragEnd = function(){
		if(drg.target != -1 && drg.currentSource != drg.targets[drg.target]) {
			// crear Objeto Ajax, ya sea para module o block
			// pedir un tipo de respuesta JSON con saved: {success->true, fail->false}.
			objajax = new Jha.ajax();
			objajax.url = "ajax.php";
            objajax.json = false;
			objajax.drg = drg;
			idSource = drg.getElementId(drg.currentSource.id);
			idTarget = drg.getElementId(drg.targets[drg.target].id);
            objajax.post = drg.ajaxPost(objajax, idSource, idTarget, drg.isBeforeTarget);
			objajax.action = function (){
				if (objajax.responseJSON && !objajax.responseJSON.saved) {
                    location.href = location.href;
                }
				else{
					drg.reorder(true);
				}
			};
            objajax.enviarpeticion();
        }
        else {
            drg.reorder(false);
        }
        if (Jha.nav.isIE) {
            document.detachEvent("onmousemove", drg.onDragMove);
            document.detachEvent("onmouseup", drg.onDragEnd);
        }
        if (!Jha.nav.isIE) {
            document.removeEventListener("mousemove", drg.onDragMove, true);
            document.removeEventListener("mouseup", drg.onDragEnd, true);
        }
	};
	this.onDragClick = function(source){};
	this.createAlternate = function(obj) {
		var alt = Jha.dom.create('div');
		alt.setAttribute('id', 'alternate');
		alt.setAttribute('class', 'element-hover');
		alt.setAttribute('style', 'height: ' + obj.offsetHeight + 'px');
		return alt;
	};
	this.mapping = function (resux, resuy, pos, index){
		if ((resux >= pos.x && resux <= pos.x + pos.ancho) && (resuy >= pos.y && resuy <= pos.y + (pos.alto / 2))) {
            drg.target = index;
            drg.isBeforeTarget = true;
            return true;
        }
        else if((resux >= pos.x && resux <= pos.x + pos.ancho) && (resuy >= pos.y + (pos.alto / 2) && resuy <= pos.y + pos.alto)){
            drg.target = index;
            drg.isBeforeTarget = false;
            return true;
        }
		return false;
	};
	this.getElementId = function(element) {
		return (element.split(drg.type))[1];
	};
    this.ajaxPost = function (objajax, idSource, idTarget, isBeforeTarget){ };
	this.reorder = function (isSavedSuccessfully){
		alt = Jha.dom.$('alternate');
		if (isSavedSuccessfully) {
			drg.currentSource.parentNode.removeChild(drg.currentSource);
			alt.parentNode.insertBefore(drg.currentSource, alt);
		}
		if(alt != undefined)
			alt.parentNode.removeChild(alt);
        drg.currentSource.removeAttribute('style');
        if (Jha.nav.isOP || Jha.nav.isIE) {
            drg.currentSource.style = null;
        }
		if(drg.type == 'theme'){
			drg.currentSource.setAttribute('style', 'border: 2px dashed #AAAAAA; margin: 5px; padding: 10px;');
		}
        drg.currentSource = null;
        drg.zIndex = 0;
        drg.cursorStartX = 0;
        drg.cursorStartY = 0;
        drg.elStartLeft = 0;
        drg.elStartTop = 0;
        drg.zIndex = 0;
        drg.alternate = null;
        drg.isDragging = false;
        drg.target = -1;
		if (drg.type == 'article') {
			drg.checkListStyle();
		}
	};
	this.checkListStyle = function (){}; 
};