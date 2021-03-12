/********************************************************************************
****************************************************************/
/* Campo de inserção das notícias */
/********************************************************************************
****************************************************************/

var pausecontent=new Array()
pausecontent[0]='Sistemas Brasileiros'
pausecontent[1]='Aureo Sistemas'
pausecontent[2]='WebHoje'
pausecontent[3]='Leilao'

/* Pausa no letreiro ao passar o mouse */
function pausescroller(content, divId, divClass, delay){
    this.content=content
    this.tickerid=divId
    this.delay=delay
    this.mouseoverBol=0
    this.hiddendivpointer=1
    document.write('<div id="'+divId+'" class="'+divClass+'" style="position: relative; overflow: hidden; width:938px;"><div class="innerDiv" style=" width:938px;" id="'+divId+'1">'+content[0]+'</div><div class="innerDiv" style="position: absolute; width: 100%; visibility: hidden" id="'+divId+'2">'+content[1]+'</div></div>')
    var scrollerinstance=this
    if (window.addEventListener)
        window.addEventListener("load", function(){scrollerinstance.initialize()}, false)
    else if (window.attachEvent)
        window.attachEvent("onload", function(){scrollerinstance.initialize()})
    else if (document.getElementById)
        setTimeout(function(){scrollerinstance.initialize()}, 500)
}

// -------------------------------------------------------------------
// initialize()
// Inicialização dos métodos do letreito
// -------------------------------------------------------------------
pausescroller.prototype.initialize=function(){
    this.tickerdiv=document.getElementById(this.tickerid)
    this.visiblediv=document.getElementById(this.tickerid+"1")
    this.hiddendiv=document.getElementById(this.tickerid+"2")
    this.visibledivtop=parseInt(pausescroller.getCSSpadding(this.tickerdiv))
    //Definir a largura do interior das DIVs
    this.getinline(this.visiblediv, this.hiddendiv)
    this.hiddendiv.style.visibility="visible"
    var scrollerinstance=this
    document.getElementById(this.tickerid).onmouseover=function(){scrollerinstance.mouseoverBol=1}
    document.getElementById(this.tickerid).onmouseout=function(){scrollerinstance.mouseoverBol=0}
    if (window.attachEvent)
        window.attachEvent("onunload", function(){scrollerinstance.tickerdiv.onmouseover=scrollerinstance.tickerdiv.onmouseout=null})
    setTimeout(function(){scrollerinstance.animateup()}, this.delay)
}

// -------------------------------------------------------------------
// animateup()
// Move as duas divs interiores do letreito em sincronia
// -------------------------------------------------------------------
pausescroller.prototype.animateup=function(){
    var scrollerinstance=this
    if (parseInt(this.hiddendiv.style.top)>(this.visibledivtop+0)){
        this.visiblediv.style.top=parseInt(this.visiblediv.style.top)-1+"px"
        this.hiddendiv.style.top=parseInt(this.hiddendiv.style.top)-1+"px"
        setTimeout(function(){scrollerinstance.animateup()}, 50)
    }else{
        this.getinline(this.hiddendiv, this.visiblediv)
        this.swapdivs()
        setTimeout(function(){scrollerinstance.setmessage()}, this.delay)
    }
}

// -------------------------------------------------------------------
// swapdivs()
// Altera entre a div que é visível e a que está escondida
// -------------------------------------------------------------------
pausescroller.prototype.swapdivs=function(){
    var tempcontainer=this.visiblediv
    this.visiblediv=this.hiddendiv
    this.hiddendiv=tempcontainer
}

pausescroller.prototype.getinline=function(div1, div2){
    div1.style.top=this.visibledivtop+"px"
    div2.style.top=Math.max(div1.parentNode.offsetHeight, div1.offsetHeight)+"px"
}

// -------------------------------------------------------------------
// setmessage()
// Insere a div oculta na próxima mensagem antes de ficar visível
// -------------------------------------------------------------------
pausescroller.prototype.setmessage=function(){
    var scrollerinstance=this
    if (this.mouseoverBol==1) //Se o mouse é atuado, para o letreiro
        setTimeout(function(){scrollerinstance.setmessage()}, 100)
    else{
        var i=this.hiddendivpointer
        var ceiling=this.content.length
        this.hiddendivpointer=(i+1>ceiling-1)? 0 : i+1
        this.hiddendiv.innerHTML=this.content[this.hiddendivpointer]
        this.animateup()
    }
}

pausescroller.getCSSpadding=function(tickerobj){ //Pega o valor do CSS
    if (tickerobj.currentStyle)
        return tickerobj.currentStyle["paddingTop"]
    else if (window.getComputedStyle)
        return window.getComputedStyle(tickerobj, "").getPropertyValue("padding-top")
    else
        return 0
}