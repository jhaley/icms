/**
 * @autor:  Richard Jaldin <ric.jhaley@gmail.com>
 * 
 * Efectos de intercambio de noticias.
 * Sobreponer, Vertical, Horizontal.
 * Los tres efectos van cambiando una nueva noticia mientras la anterior va desapareciendo.
 */

newsList = new Array()

function initializeEffectsNew(effecttype){
	if(effecttype == 'noneffect') return false;
	for (var i = 0; i < totalNews; i++) {
		newsList[i] = Jha.dom.$('new' + i);
		switch(effecttype){
			case 'overlay':
				newsList[i].style.display = (i == 0 ? 'block' : 'none');
				newsList[i].style.opacity = (i == 0 ? '1' : '0');
			break;
			case 'vertical':
				newsList[i].oldHeightSize = parseInt(newsList[i].offsetHeight);
				newsList[i].style.height = (i == 0 ? newsList[i].offsetHeight : 0) + 'px';
				newsList[i].style.display = 'block';
				newsList[i].style.overflow = 'hidden';
			break;
			case 'horizontal':
				newsList[i].oldWidthSize = parseInt(newsList[i].offsetWidth);
				newsList[i].style.width = (i == 0 ? newsList[i].offsetWidth : 0) + 'px';
				newsList[i].style.display = 'block';
				newsList[i].style.overflow = 'hidden';
			break;
		}
	}
	setTimeout(effecttype + "New(0, 1);", 10000);
}

function overlayNew(indexHide, indexShow){
	if(totalNews <= 1) 	return false;
	objHide = null;
	objShow = null;
	if(indexHide < totalNews){
		objHide = newsList[indexHide];
	}
	if(indexShow < totalNews){
		objShow = newsList[indexShow];
	}
	if(!objHide && !objShow)	return false;
	Jha.effect.desvanecer(objHide, objShow);
	indexHide = indexHide + 1 == totalNews ? 0 : indexHide + 1;
	indexShow = indexShow + 1 == totalNews ? 0 : indexShow + 1;
	setTimeout("overlayNew(" + indexHide + ", " + indexShow + ");", 12000);
}

function verticalNew(indexHide, indexShow){
	if(totalNews <= 1) 	return false;
	objHide = null;
	objShow = null;
	if(indexHide < totalNews){
		objHide = newsList[indexHide];
	}
	if(indexShow < totalNews){
		objShow = newsList[indexShow];
	}
	if(!objHide && !objShow)	return false;
	Jha.effect.hideUp(objHide, objShow);
	indexHide = indexHide + 1 == totalNews ? 0 : indexHide + 1;
	indexShow = indexShow + 1 == totalNews ? 0 : indexShow + 1;
	setTimeout("verticalNew(" + indexHide + ", " + indexShow + ");", 12000);
}

function horizontalNew(indexHide, indexShow){}