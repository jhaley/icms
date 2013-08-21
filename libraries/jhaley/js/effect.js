/*
* Do not remove this notice.
*
* Copyright 2011 by Richard Jaldin <ric.jhaley@gmail.com>.
* JSON Object for Effects.
* 
*/

Jha.effect = {
	//efectos de sobreponer.
    desvanecer : function (objHide, objShow){
		if (objHide.widthChangeMemInt) window.clearInterval(objHide.widthChangeMemInt);
		objHide.widthChangeMemInt = window.setInterval(function(){
	        opacity = Jha.effect.getOpacity(objHide);
			if(opacity > 0){
				if (Jha.nav.isIE) {
					objHide.style.filter = 'alpha(opacity=' + parseInt((opacity - 0.02) * 100) + ')';
				}
				else {
					objHide.style.opacity = parseFloat(opacity - 0.02);
				}	
			}
	        else{
				objHide.style.display = 'none';
	            window.clearInterval(objHide.widthChangeMemInt);
				Jha.effect.envanecer(objShow);
	        }
	    },1);
	},
	envanecer : function (obj){
		if (obj.widthChangeMemInt) window.clearInterval(obj.widthChangeMemInt);
		obj.style.display = 'block';
	    obj.widthChangeMemInt = window.setInterval(function(){
	        opacity = Jha.effect.getOpacity(obj);
			if(opacity < 1){
				if (Jha.nav.isIE) {
					obj.style.filter = 'alpha(opacity=' + parseInt((opacity + 0.02) * 100) + ')';
				}
				else {
					obj.style.opacity = parseFloat(opacity + 0.02);
				}
			}
	        else{
	            window.clearInterval(obj.widthChangeMemInt);
	        }
	    },1);
	},
	getOpacity : function (obj){
		return parseFloat(obj.style.opacity);
	},
	//efectos verticales
	hideUp : function(objHide, objShow){
		if (objHide.widthChangeMemInt) window.clearInterval(objHide.widthChangeMemInt);
		//obj.style.display = 'block';
		objHide.widthChangeMemInt = window.setInterval(function(){
	        alto = Jha.effect.getValue(objHide.style.height);
			if(alto > 0){
				objHide.style.height = parseInt(alto - 2) + 'px';
			}
	        else{
				//objHide.style.display = 'none';
	            window.clearInterval(objHide.widthChangeMemInt);
				Jha.effect.showDown(objShow);
	        }
	    },1);
	},
	showDown : function(obj){
		if (obj.widthChangeMemInt) window.clearInterval(obj.widthChangeMemInt);
		//obj.style.display = 'block';
		obj.widthChangeMemInt = window.setInterval(function(){
	        alto = Jha.effect.getValue(obj.style.height);
			if(alto < obj.oldHeightSize){
				obj.style.height = parseInt(alto + 2) + 'px';
			}
	        else{
	            window.clearInterval(obj.widthChangeMemInt);
	        }
	    },1);
	},
	getValue : function (size){
		parts = size.split('p');
		return parseInt(parts[0]); 
	}
};
