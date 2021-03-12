function addEvent(pObjeto,psEvent,pFunction)
{
	if(window.addEventListener)
	{
		pObjeto.addEventListener(psEvent,pFunction,false);
	}
	else if(window.attachEvent)
	{
		pObjeto.attachEvent('on'+psEvent,function(){pFunction.call(pObjeto);});
	}
}
