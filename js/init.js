Ext.onReady(function(){
	Ext.BLANK_IMAGE_URL = '/ext3/resources/images/default/s.gif';
	Ext.QuickTips.init();
	Ext.Ajax.timeout=720000;
	Doc_width=document.body.clientWidth;
	Doc_height=document.body.clientHeight;
	
    viewport_master();

	
});
//-----------Общие--------------------------
var Doc_width, Doc_height;
var tb;
//------------------------------------------

	function form_podpis()
	{
		now=new Date;
		d=now.getDate();
		if (d<10) d="0"+d;
		m=(now.getMonth()+1);
		if (m<10) m="0"+m;
		y=(now.getYear()-100);
		if (y<10) y="0"+y;
		str1="Дата: "+d+"."+m+".20"+y;
		h=now.getHours();
		if (h<10) h="0"+h;
		M=now.getMinutes();
		if (M<10) M="0"+M;
		s=now.getSeconds();
		if (s<10) s="0"+s;
		str1=str1+' Время: '+h+':'+M+':'+s;
		return(str1);
	}
