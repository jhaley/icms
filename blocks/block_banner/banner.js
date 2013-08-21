/**
 * @autor:  Richard Jaldin <ric.jhaley@gmail.com>
 * 
 * Efectos de intercambio de banners.
 * Sobreponer, Vertical, Horizontal.
 * Los tres efectos van cambiando un nuevo banner mientras la anterior va desapareciendo.
 */

imagesList = new Array()

function initializeEffectsBanner(effecttype){
	if(effecttype == 'none') return false;
	for (var i = 0; i < totalImages; i++) {
		imagesList[i] = Jha.dom.$('banner' + i);
		switch(effecttype){
			case 'overlay':
				imagesList[i].style.display = (i == 0 ? 'block' : 'none');
				imagesList[i].style.opacity = (i == 0 ? '1' : '0');
			break;
			case 'vertical':
				imagesList[i].oldHeightSize = parseInt(imagesList[i].offsetHeight);
				imagesList[i].style.height = (i == 0 ? imagesList[i].offsetHeight : 0) + 'px';
				imagesList[i].style.display = 'block';
				imagesList[i].style.overflow = 'hidden';
			break;
			case 'horizontal':
				imagesList[i].oldWidthSize = parseInt(imagesList[i].offsetWidth);
				imagesList[i].style.width = (i == 0 ? imagesList[i].offsetWidth : 0) + 'px';
				imagesList[i].style.display = 'block';
				imagesList[i].style.overflow = 'hidden';
			break;
		}
	}
	setTimeout(effecttype + "Banner(0, 1);", 10000);
}

function overlayBanner(indexHide, indexShow){
	if(totalImages <= 1) 	return false;
	objHide = null;
	objShow = null;
	if(indexHide < totalImages){
		objHide = imagesList[indexHide];
	}
	if(indexShow < totalImages){
		objShow = imagesList[indexShow];
	}
	if(!objHide && !objShow)	return false;
	Jha.effect.desvanecer(objHide, objShow);
	indexHide = indexHide + 1 == totalImages ? 0 : indexHide + 1;
	indexShow = indexShow + 1 == totalImages ? 0 : indexShow + 1;
	setTimeout("overlayBanner(" + indexHide + ", " + indexShow + ");", 12000);
}

function verticalBanner(indexHide, indexShow){
	if(totalImages <= 1) 	return false;
	objHide = null;
	objShow = null;
	if(indexHide < totalImages){
		objHide = imagesList[indexHide];
	}
	if(indexShow < totalImages){
		objShow = imagesList[indexShow];
	}
	if(!objHide && !objShow)	return false;
	Jha.effect.hideUp(objHide, objShow);
	indexHide = indexHide + 1 == totalImages ? 0 : indexHide + 1;
	indexShow = indexShow + 1 == totalImages ? 0 : indexShow + 1;
	setTimeout("verticalBanner(" + indexHide + ", " + indexShow + ");", 12000);
}

function horizontalBanner(indexHide, indexShow){}
