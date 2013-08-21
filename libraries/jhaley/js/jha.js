/*
* Do not remove this notice.
*
* Copyright 2011 by Richard Jaldin <ric.jhaley@gmail.com>.
* JSON Object for utilities.
* 
* Based in Goaamb Framework 2009 <goaamb@gmail.com>
*/

var Jha = {
	nav : {
		isIE : false,
		isNS : false,
		isOP : false,
		isSA : false,
		isCH : false,
		version : null,
		init : function() {
			ua = navigator.userAgent;
			s = "MSIE";
			if ((i = ua.indexOf(s)) >= 0) {
				this.isIE = true;
				this.version = parseFloat(ua.substr(i + s.length));
			} else {
				s = "Netscape6/";
				if ((i = ua.indexOf(s)) >= 0) {
					this.isNS = true;
					this.version = parseFloat(ua.substr(i + s.length));
				} else {
					s = "Netscape/8";
					if ((i = ua.indexOf(s)) >= 0) {
						this.isNS = true;
						this.version = 8;
					} else {
						s = "Firefox";
						if ((i = ua.indexOf(s)) >= 0) {
							this.isNS = true;
							this.version = parseFloat(ua.substr(i + s.length));
						} else {
							s = "Opera";
							if ((i = ua.indexOf(s)) >= 0) {
								this.isOP = true;
								this.version = parseFloat(ua.substr(i
										+ s.length));
							} else {
								s = "Chrome";
								if ((i = ua.indexOf(s)) >= 0) {
									this.isCH = true;
								} else {
									s = "Safari";
									if ((i = ua.indexOf(s)) >= 0) {
										this.isSA = true;
									} else {
										s = "Gecko";
										if ((i = ua.indexOf(s)) >= 0) {
											this.isNS = true;
										} else {
											this.isIE = true;
										}
									}
								}
							}
						}
					}
				}
			}
		}
	},
	dom : {
		$ : function(id) {
			if (!id) {
				return false;
			}
			return document.getElementById(id);
		},
		$$ : function(name, position) {
			if (!name) {
				return false;
			}
			var elems = document.getElementsByName(name);
			return position >= 0 ? elems[position] : elems;
		},
		$$$ : function(tagname, position, doc) {
			if (!tagname) {
				return false;
			}
			if (!doc) {
				doc = document;
			}
			if (doc.getElementsByTagName) {
				var elems = doc.getElementsByTagName(tagname);
				return position >= 0 ? elems[position] : elems;
			}
			return false;
		},
        scan : function (obj){
		    domscannerwindow = window.open("", "DOM Analizer", "width=600,height=400,scrollbars=yes");
		    var dswdoc = domscannerwindow.document;
		    dswdoc.write("<html><head></head><body></body></html>");
		    var str = "";
		    for (var algo in obj) {
		        str += algo + ": " + obj[algo] + "<br/><br/>";
		    }
		    Jha.dom.$$$("body", 0, dswdoc).innerHTML = str;
		},
        create : function (tagname){
			return document.createElement(tagname);
		},
		position : function (obj){
	        posx = obj.offsetLeft, posy = obj.offsetTop, posancho = obj.offsetWidth, posalto = obj.offsetHeight;
	        res = {x: posx, y: posy, ancho: posancho, alto: posalto};
	        return res;
	    },
		getStyle : function (el, style) {
            if(!document.getElementById) return;
            var value = el.style[Jha.dom.toCamelCase(style)];
		    if(!value)
		        if(!Jha.nav.isIE)
		            value = document.defaultView.getComputedStyle(el, "").getPropertyValue(style);
		        else
		            value = el.currentStyle[Jha.dom.toCamelCase(style)];
		    return value;
		},
		toCamelCase : function (s) {
		    for(var exp = /-([a-z])/; exp.test(s); s = s.replace(exp, RegExp.$1.toUpperCase()) );
		    return s;
        },
		parseObject : function(obj, destine) {
	        for ( var elem in obj) {
	            destine[elem] = obj[elem];
	        }
	    },
		posFromEvent : function (event){
			var posx = 0, posy = 0;
			if (Jha.nav.isIE) {
				posx = window.event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft;
				posy = window.event.clientY + document.documentElement.scrollTop + document.body.scrollTop;
			} else {
				posx = event.clientX + window.scrollX;
				posy = event.clientY + window.scrollY;
			}
			return { x: posx, y: posy };
		}
	},
	util : {
		inArray : function (elem, array){
			res = -1;
			for(i = 0; i < array.length; i++) {
				if(array[i] == elem){
					res = i;
					break;
				}
			}
			return res;
		},
		removeFromArray : function (index, array) {
			res = {};
			for(i = 0; i < array.length; i++) {
                if(i != index)
                    res[res.length] = array[i];
            }
            return res;
		},
		insertIn : function (pos, elem, array){
			res = [];
			for (var i = 0; i < array.length; i++) {
	            if(i == pos){
					res[res.lenght] = elem;
				}
				res[res.lenght] = array[i];
            }
			if(pos == array.lenght)
			    res[res.lenght] = elem;
			return res;
		}
	},
	html : {
		checkbox : {
			checkAll : function (obj, idname){
				var checks = Jha.dom.$$$('input');
				for (var i = 0; i < checks.length; i++) {
					if (checks[i].type == 'checkbox' && (checks[i].id).indexOf(idname) != -1) {
						if(obj.checked){
							checks[i].checked = true;
						}
						else{
							checks[i].checked = false;
						}
					}
				}
			},
			isChecked : function (obj){
				if(obj.checked){
                    obj.checked = true;
                }
                else{
                    obj.checked = false;
                }
			},
			validate : function (){
				var elems = Jha.dom.$$$('input');
				var checks = 0;
				for (var i=0; i<elems.length; i++) {
					if(elems[i].type == 'checkbox'){
						checks += elems[i].checked ? 1 : 0;
					}
				}
				if(checks == 0){
					alert('Debe seleccionar al menos un elemento de la lista');
					return false;
				}
				return true;
			}
		},
		input : {
			validate : function (valor, type){
				var reg = '';
				switch(type) {
					case 'not empty':
						return valor != '';
					break;
					case 'alpha':
						reg = /^([a-zA-Z\s])+$/;
					break;
					case 'alphanum':
						reg = /^([a-zA-Z0-9\s])+$/;
					break;
					case 'numeric':
						reg = /^([0-9\.])+$/;
					break;
					case 'email':
						reg = /^(.+\@.+\..+)$/;
					break;
					case 'phone':
						reg = /^([0-9\s\+\-])+$/;
					break;
					case 'username':
						reg = /([a-zA-Z0-9_.]){6,20}$/;
					break;
				}
				return reg.test(valor);
			}
		},
		select : {
			validate : function (valor, defecto){
				return valor != defecto;
			}
		}
	}
};

Jha.nav.init();