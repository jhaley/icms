/*
* Do not remove this notice.
*
* Copyright 2011 by Richard Jaldin <ric.jhaley@gmail.com>.
* JSON Object for ajax functions.
* 
* Based in Goaamb Framework 2009 <goaamb@gmail.com>
*/

Jha.ajax = function(object){
    this.idUpdate = "";
    this.action = "";
    this.responseText = "";
    this.responseXML = "";
    this.url = "";
    this.post = null;
    this.json = false;
    if (object) {
        Jha.dom.parseObject(object, this);
    }    
    var xmlhttp = false;
    if (typeof ActiveXObject != 'undefined') {
        try { xmlhttp = new ActiveXObject("Msxml2.XMLHTTP"); } 
        catch (e) {
            try { xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); } 
            catch (E) { xmlhttp = false; }
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    
    this.verificarDireccion = function(){
        var dirlocal = document.location.href.split("http://");
        if (dirlocal.length > 1) {
            dirlocal = dirlocal[1].split("/");
            if (dirlocal.length > 0) {
                dirlocal = dirlocal[0].toLowerCase();
            }
            else {
                return false;
            }
            var dirurl = this.url.split("http://");
            if (dirurl.length > 1) {
                dirurl = dirurl[1].split("/");
                if (dirurl.length > 0) {
                    dirurl = dirurl[0].toLowerCase();
                    if (dirurl === dirlocal) {
                        return true;
                    }
                    else {
                        window.open(this.url);
                    }
                }
            }
            else {
                return true;
            }
        }
        return false;
    };
    
    this.enviarpeticion = function(){
        if (this.url !== "" && this.verificarDireccion()) {
            xmlhttp.open("post", this.url, true);
            xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            if (this.post != null) {
                var envio = "";
                for (var elementos in this.post) {
                    envio += "&" + elementos + "=" + this.post[elementos];
                }
                xmlhttp.send(envio);
                this.enviado = true;
            }
            else {
                xmlhttp.send("");
                this.enviado = true;
            }
            if (this.idUpdate !== "") {
                var capares = Jha.dom.$(this.idUpdate);
                var cargando = document.createTextNode("Cargando Contenido...");
                capares.innerHTML = "";
                capares.appendChild(cargando);
            }
        }
    }
    this.conectado = false;
    this.error = 0;
    this.enviado = false;
    var elobjeto = this;
    this.responseJSON = "";
    xmlhttp.onreadystatechange = function(){
        if (xmlhttp.readyState === 4) {
            if (xmlhttp.status === 200) {
                elobjeto.responseText = xmlhttp.responseText;
                if (elobjeto.json) {
                    eval("elobjeto.responseJSON=" + elobjeto.responseText + ";");
                }
                else {
                    elobjeto.responseXML = xmlhttp.responseXML;
                    if (elobjeto.idUpdate !== "") {
                        var capares = Jha.dom.$(elobjeto.idUpdate);
                        if (capares !== undefined && capares !== null) {
                            if (elobjeto.responseText !== undefined && elobjeto.responseText !== null) {
                                capares.innerHTML = elobjeto.responseText;
                            }
                            else {
                                capares.innerHTML = "Contenido XML";
                            }
                        }
                        if (elobjeto.responseText !== undefined && elobjeto.responseText !== null) {
                            var intercapa = Jha.dom.create("div");
                            intercapa.innerHTML = elobjeto.responseText;
                            var arr = intercapa.getElementsByTagName("script");
                            var links = intercapa.getElementsByTagName("link");
                            for (var i = 0; i < arr.length; i += 1) {
                                if (arr[i].innerHTML === "" && arr[i].getAttribute("src")) {
                                    var srcjs = arr[i].getAttribute("src");
                                    var cabecera = Jha.dom.$$$("head", 0);
                                    var scriptarray = cabecera.getElementsByTagName("script");
                                    var encontro = false;
                                    for (var j = 0; j < scriptarray.length; j++) {
                                        if (scriptarray[j].src === srcjs) {
                                            encontro = true;
                                            break;
                                        }
                                    }
                                    if (!encontro) {
                                        cabecera.appendChild(arr[i]);
                                        i--;
                                    }
                                }
                                else {
                                    var dinjs = arr[i].innerHTML;
                                    eval(dinjs);
                                }
                            }
                            for (var i = 0; i < links.length; i += 1) {
                                if (links[i].innerHTML === "" && links[i].getAttribute("href")) {
                                    var hrefcss = links[i].getAttribute("href");
                                    var cabecera = Jha.dom.$$$("head", 0);
                                    var linkarray = cabecera.getElementsByTagName("link");
                                    var encontro = false;
                                    for (var j = 0; j < linkarray.length; j++) {
                                        if (linkarray[j].href === hrefcss) {
                                            encontro = true;
                                        }
                                    }
                                    if (!encontro) {
                                        cabecera.appendChild(links[i]);
                                        i--;
                                    }
                                }
                            }
                        }
                    }
                }
                if (elobjeto.action) {
                    elobjeto.action();
                }
                elobjeto.conectado = true;
            }
            else {
                elobjeto.error = this.status;
                if (elobjeto.erroraction) {
                    elobjeto.erroraction.call();
                }
            }
        }
    }
};

function ajaxupdate(direccion, idcapa, action){
    var objajax = new Jha.ajax();
    objajax.url = direccion;
    objajax.idUpdate = idcapa;
    objajax.action = action;
    objajax.enviarpeticion();
}
