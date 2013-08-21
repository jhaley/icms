/*
* Do not remove this notice.
*
* Copyright 2011 by Richard Jaldin <ric.jhaley@gmail.com>.
* JSON Object for Administrator Menu.
*/

Jha.menu = function(el) {
	var elements = Jha.dom.$$$('li', -1, el);
	var nested = null
	for (var i=0; i<elements.length; i++) {
		var element = elements[i];
		if (Jha.nav.isIE) {
			element.attachEvent('onmouseover', function(){ this.className = this.className + ' hover'; });
            element.attachEvent('onmouseout', function(){ parts = (this.className).split('hover'); this.className = parts.join(' '); });
		}
		else {
			element.addEventListener('mouseover', function(){ this.className = this.className + ' hover'; }, true);
			element.addEventListener('mouseout', function(){ parts = (this.className).split('hover'); this.className = parts.join(' '); }, true);
		}
		nested = Jha.dom.$$$('ul', 0, element);
		if(!nested) {
			continue;
		}
		var offsetWidth  = 0;
		for (k=0; k < nested.childNodes.length; k++) {
			var node  = nested.childNodes[k]
			if (node.nodeName == "LI") {
				offsetWidth = (offsetWidth >= node.offsetWidth) ? offsetWidth : node.offsetWidth;
			}
		}
		for (l=0; l < nested.childNodes.length; l++) {
			var node = nested.childNodes[l]
			if (node.nodeName == "LI") {
				node.style.width = offsetWidth+'px';
			}
		}
		nested.style.width = offsetWidth+'px';
	}
};