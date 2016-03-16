count=0;
function viewport_master()
{
    x459_store = new Ext.data.Store({
                proxy: new Ext.data.HttpProxy({url: 'phps/x459.php'}),
                reader: new Ext.data.JsonReader({
                root: 'dan',
                totalProperty: 'total'},
                [{name: 'x459'}])
        });
        
    x459_store.load({params:{x453:v_x453}});
          
    x459 = new Ext.form.ComboBox({
                store: x459_store,
                name:'x459',
                width: 50,
                minListWidth: 50,
                displayField:'x459',
                valueField:'x459',
                mode: 'local',
                triggerAction: 'all'
        });
        
    x459.setValue(v_x459);
    x459.on('collapse',function(){isp_store.load({params:{x453:v_x453,x459:x459.getValue()}});});

    date = new Ext.form.DateField({
                name: 'date',
                width:80,
                format:'d.m.Y',
                fieldClass:'text'
	   });


    now=new Date;
    d=now.getDate();
    if (d<10) d="0"+d;
    m=(now.getMonth()+1);
    if (m<10) m="0"+m;
    y=(now.getYear()-100);
    if (y<10) y="0"+y;
    str1=d+"."+m+".20"+y;

    date.setValue(str1);
//------------------------------------------------------------------------------
    c051_store = new Ext.data.Store({
                proxy: new Ext.data.HttpProxy({url: 'phps/c051.php'}),
                reader: new Ext.data.JsonReader({
                root: 'dan',
                totalProperty: 'total'},
                [{name: 'c051'}])
        });
    c051_store.load({params:{x453:v_x453}});
   
    c051_form = new Ext.form.ComboBox({
                store: c051_store,
                width: 70,
                name:'c051_form',
                minListWidth: 70,
                displayField:'c051',
                valueField: 'c051',
                fieldLabel: 'Заказ',
                labelSeparator:'',
                mode: 'local',
                triggerAction: 'all'
    });

    c051_form.on('change',function(){c052_form.reset(); c052_store.load({params:{x453:v_x453,c051:c051_form.getValue()}});});
//------------------------------------------------------------------------------
    c052_store = new Ext.data.Store({
                proxy: new Ext.data.HttpProxy({url: 'phps/c052.php'}),
                reader: new Ext.data.JsonReader({
                root: 'dan',
                totalProperty: 'total'},
                [{name: 'c052'}])
        });

   
    c052_form = new Ext.form.ComboBox({
                store: c052_store,
                width: 70,
                name:'c052_form',
                minListWidth: 70,
                displayField:'c052',
                valueField: 'c052',
                fieldLabel: 'Вариант',
                labelSeparator:'',
                editable: false,
                mode: 'local',
                triggerAction: 'all'
        });

//------------------------------------------------------------------------------
    but = new Ext.Button({
                name:'but',
                icon:'images/search.png',
                handler:function()
                    {
                        nomen_store.load({params:{x453:v_x453,c051:c051_form.getValue(),c052:c052_form.getValue()}}); 
                        oper_store.removeAll();
                    }
        });

    add = new Ext.Button({
                name:'add',
                icon:'images/add.png',
                text:'<span class="text">Добавить</span>',
                handler:smen_add,
                disabled:true
        });

    skip = new Ext.Button({
                name:'skip',
                icon:'images/delete.gif',
                text:'<span class="text">Cбросить</span>',
                disabled:true,
                handler:function()
                    {
                        for(var i=0;i<oper_store.getCount();i++)
                            {
                                oper_table.selModel.deselectRow(i);
                            }
                    }
        });

    del = new Ext.Button({
                name:'del',
                icon:'images/delete.gif',
                text:'<span class="text">Удалить строку</span>',
                disabled:true,
                handler:function()
                    {
                        v_kk=1;
                        smen_save();
                        for(var i=0;i<smen_table.selModel.getCount();i++)
                            {
                                for(var j=0;j<smen_store.getCount();j++)
                                    {
                                        if(smen_store.data.items[j].data.x36302==smen_table.selModel.selections.items[i].data.x36302)
                                        smen_store.removeAt(j);
                                    }
                            }
	   
                        del.disable();
                    }
        });
        
    save = new Ext.Button({
                name:'save',
                icon:'images/drop-yes.gif',
                text:'<span class="text">Записать</span>',
                disabled:true,
                handler:function () { v_kk=3; smen_save(); }
        });
        
    print = new Ext.Button({
                name:'print',
                icon:'images/printer.png',
                width:180,
                text:'<span class="text">Печать сменного задания</span>',
                disabled:true,
                handler:function()
                    {
                        window.open("phps/print.php?p704="+isp_table.selModel.selections.items[0].data.p704+'&date='+date.getValue().format('d.m.Y')+'&x453='+v_x453,"directoties=yes,resizable=yes,scrollbars=yes,toolbar=yes,target=_blank");    
                    }
        });

    oborud_store = new Ext.data.Store({
                proxy: new Ext.data.HttpProxy({url: 'phps/oborud.php'}),
                reader: new Ext.data.JsonReader({
                root: 'dan',
                totalProperty: 'total'},
                [{name: 'oborud'}])
        });
        
    inv = new Ext.form.ComboBox({
                store: oborud_store,
                name:'inv',
                width: 80,
                minListWidth: 80,
                displayField:'oborud',
                valueField:'oborud',
                editable: false,
                mode: 'local',
                triggerAction: 'all'
        });
  
  
//----------------------------таблицы-------------------------------------------
    nomen_store = new Ext.data.GroupingStore({
                proxy: new Ext.data.HttpProxy({url: 'phps/nomen.php'}),
                groupField:'p006',
                reader: new Ext.data.JsonReader({
                root: 'dan',
                groupOnSort:'true',
                totalProperty: 'total',
                id: 'id'}, 
                [{name:'p006'},
			    {name:'p006_oper'},
			    {name:'p006_text'},
			    {name:'x684'},
			    {name:'x684_text'},
			    {name:'x822'},
			    {name:'kolvo'},
			    {name:'text'}
			    ])
        });

    nomen_check = new Ext.grid.CheckboxSelectionModel({
                header: "",
                listeners:{
                    rowselect:oper_search,
                    rowdeselect:oper_search
			    }
	   });

    nomen_shapka= new Ext.grid.ColumnModel({
                columns:[nomen_check,
                        {header:"", 
                        width: Doc_width*0.2, 
                        align: 'center', 
                        dataIndex: 'p006',  
                        resizable:false, 
                        renderer:function(value,metaData,record){return '<span class="text">' + value + '</span>';},
                        hidden:true},
                        
                        {header:"<span class='text'>ПЗ</span>", 
                        width: Doc_width*0.3, 
                        align: 'center', 
                        dataIndex: 'x822',  
                        resizable:false, 
                        renderer:function(value,metaData,record){return '<span class="text">' + value + '</span>';}},
                                
                        {header:"<span class='text'>Номер СП,<br>дата формирования</span>", 
                        width: Doc_width*0.4, 
                        align: 'center', 
                        dataIndex: 'x684_text',  
                        resizable:false, 
                        renderer:function(value,metaData,record){return '<span class="text">' + value + '</span>';}},
                                
                        {header:"<span class='text'>Кол-во</span>", 
                        width: Doc_width*0.2, 
                        align: 'center', 
                        dataIndex: 'kolvo',  
                        resizable:false, 
                        renderer:function(value,metaData,record){return '<span class="text">' + value + '</span>';}}]
});
//------------------------------------------------------------------------------
    nomen_table = new Ext.grid.GridPanel({
                store: nomen_store,
                cm:nomen_shapka,
                sm: nomen_check,
                width: '100%',
                height: Doc_height*0.37,
                autoResize: true,
                monitorResize: true,
                iconCls: 'icon-grid',
                bodyStyle: 'border:0pt;',
                viewConfig: {forceFit: true},
                view: new Ext.grid.GroupingView({
                    forceFit:true,
                    groupTextTpl:'{text}'}),
                listeners:{render: function(grid)
					   {
					       var store = grid.getStore();
					       var view = grid.getView();
					   
					       grid.tip = new Ext.ToolTip({  target: view.mainBody,
									 delegate: '.x-grid3-cell',
									 trackMouse: true,
									 autoWidth: true,
									 shadow:true,
									 anchor:'left',
									 dismissDelay: 180000,
									 showDelay: 1000,
									 renderTo: document.body,
									 listeners: {
                                                          beforeshow: function (tip)
                                                                     {
                                                                        var rowIndex = view.findRowIndex(tip.triggerElement);
                                                                        html = '';
                                                                        if (store.getAt(rowIndex).data.text=='1')
                                                                        {
                                                                            html = '<p style="width:80pt;">Одна или несколько операций паспорта<br>являются частью сменного задания</p>';
                                                                            tip.body.dom.innerHTML = html;
                                                                        }
                                                                        
                                                                        else{tip.body.dom.innerHTML = '';}
                                                                     },
                                                          show: function (tip)
                                                                  {
                                                                    var rowIndex = view.findRowIndex(tip.triggerElement);
                                                                     if (store.getAt(rowIndex).data.text=='0')
                                                                     tip.hide();
                                                                  }
                                                }
                                            });
					}},
                columnLines: true,
                enableColumnMove:true,
                frame:true,
                tbar:['<span class="text"><b>ПОИСК</b></span>','-','<span class="text">Заказ</span>',c051_form,'-','<span class="text">Вариант</span>',c052_form,'-',but,'->','кол-во выбрано: <span id="count" class="text" >'+count+'</span>']
              
        });
//------------------------------------------------------------------------------
    oper_store = new Ext.data.GroupingStore({
                proxy: new Ext.data.HttpProxy({url: 'phps/oper.php'}),
                groupField:'p006',
                reader: new Ext.data.JsonReader({
                root: 'dan',
                totalProperty: 'total',
                id: 'id'}, 
                [{name:'p016'},
			    {name:'p017'},
			    {name:'p016_text'},
			    {name:'p006'},
			    {name:'p006_text'},
			    {name:'c034'},
			    {name:'oborud'},
			    {name:'kolvo'},
			    {name:'time'},
			    {name:'x684'},
			    {name:'p450'},
			    {name:'x684_text'},
			    {name:'x36302_text'},
			    {name:'p704f_text'}
			    ])
        });

    oper_check = new Ext.grid.CheckboxSelectionModel({
                header: "",
                listeners:{
			    rowselect:function(){add.enable();skip.enable();},
			    rowdeselect:function(){ if (oper_table.selModel.getCount()==0){add.disable();skip.disable();}}
			    }
	   });

    oper_shapka= new Ext.grid.ColumnModel({
                columns: [oper_check,
                {header:"", 
                width: Doc_width*0.05,
                align: 'center', 
                dataIndex: 'p006',  
                resizable:false,
                renderer:function(value,metaData,record){return '<span class="text">' + value + '</span>';},
                hidden:true },
                
                {header:"<span class='text'>Номер<br>операции</span>", 
                width: Doc_width*0.15, 
                align: 'center', 
                dataIndex: 'p016_text',  
                resizable:false, 
                renderer:function(value,metaData,record){return '<span class="text">' + value + '</span>';}},
                
                
                {header:"<span class='text'>Наименование<br>операции</span>", 
                width: Doc_width*0.35, 
                align: 'center', 
                dataIndex: 'c034',  
                resizable:false,
                renderer:function(value,metaData,record){return '<span class="text">' + value + '</span>';}},
                
                
                {header:"<span class='text'>Оборудование</span>", 
                width: Doc_width*0.35, 
                align: 'center', 
                dataIndex: 'oborud',  
                resizable:false,
                renderer:function(value,metaData,record){return '<span class="text">' + value + '</span>';}},
                
                
                {header:"<span class='text'>Время на партию</span>", 
                width: Doc_width*0.15, 
                align: 'center', 
                dataIndex: 'time',  
                resizable:false,
                renderer:function(value,metaData,record){return '<span class="text">' + value + '</span>';}}]
        });
//------------------------------------------------------------------------------
        oper_table = new Ext.grid.GridPanel({
                store: oper_store,
                cm:oper_shapka,
                sm:oper_check,
                width: '100%',
                height: Doc_height*0.37,
                autoResize: true,
                monitorResize: true,
                iconCls: 'icon-grid',
                bodyStyle: 'border:0pt;',
                viewConfig: {forceFit: true},
                view: new Ext.grid.GroupingView({
                    forceFit:true,
                    groupTextTpl:'{text}'}),
                columnLines: true,
                enableColumnMove:true,
                frame:true,
                tbar:['->',add,'-',skip],
                listeners:{render: function(grid)
					{
					   var store = grid.getStore();
					   var view = grid.getView();
					   
					   grid.tip = new Ext.ToolTip({  target: view.mainBody,
									 delegate: '.x-grid3-cell',
									 trackMouse: true,
									 autoWidth: true,
									 shadow:true,
									 anchor:'left',
									 dismissDelay: 180000,
									 showDelay: 1000,
									 renderTo: document.body,
									 listeners: {
                                                    beforeshow: function (tip)
                                                                 {
                                                                        var rowIndex = view.findRowIndex(tip.triggerElement);
                                                                        html = '';
                                                                        if (store.getAt(rowIndex).data.x684_text!='')
                                                                        {
                                                                            html = '<p style="width:150pt;">В составе сменного задания<br>'+store.getAt(rowIndex).data.p704f_text+
									    ' на '+store.getAt(rowIndex).data.x36302_text+'<br>паспорт &#8470; '+store.getAt(rowIndex).data.x684_text+'</p>';
                                                                            tip.body.dom.innerHTML = html;
                                                                        }
                                                                        
                                                                        else{tip.body.dom.innerHTML = '';}
                                                                     },
                                                               show: function (tip)
                                                                  {
                                                                    var rowIndex = view.findRowIndex(tip.triggerElement);
                                                                     if (store.getAt(rowIndex).data.x684_text=='')
                                                                     tip.hide();
                                                                  }
                                                                  }
                                                      });
					}}
              
        });
    
//------------------------------------------------------------------------------
    isp_store = new Ext.data.GroupingStore({
                proxy: new Ext.data.HttpProxy({url: 'phps/isp.php'}),
                reader: new Ext.data.JsonReader({
                root: 'dan',
                totalProperty: 'total',
                id: 'id'}, 
                [{name:'p704'},
			    {name:'p710'},
			    {name:'time'},
			    {name:'check'}
			    ])
        });
        
    isp_store.load({params:{x453:v_x453,x459:x459.getValue()}});

    isp_check = new Ext.grid.CheckboxSelectionModel({
                singleSelect: true,
                header: "",
                listeners:{
			    rowselect:function()
                    {
                        smen_search();
                        if(smen_store.getCount()>0) {save.enable();print.enable();}
                    },
                rowdeselect:function(){
                        smen_store.removeAll();
                        save.disable();
                        print.disable();
				    }
			    }
	   });

    isp_shapka= new Ext.grid.ColumnModel({
                columns: [isp_check,
                        {header:"<span class='text'>Табельный<br>номер</span>", 
                        width: Doc_width*0.3, 
                        align: 'center', 
                        dataIndex: 'p704',  
                        resizable:false,
                        renderer:function(value,metaData,record){return '<span class="text">' + value + '</span>';}},
                        
                        {header:"<center><span class='text'>ФИО</span></center>", 
                        width: Doc_width*0.5, 
                        align: 'left', 
                        dataIndex: 'p710',  
                        resizable:false,
                        renderer:function(value,metaData,record){return '<span class="text">' + value + '</span>';}},
                        
                        {header:"<span class='text'>Время<br>на смену</span>", 
                        width: Doc_width*0.2, 
                        align: 'center', 
                        dataIndex: 'time',  
                        resizable:false,
                        renderer:function(value,metaData,record){return '<span class="text">' + value + '</span>';}}]
        });
 
 
    isp_table = new Ext.grid.GridPanel({
                store: isp_store,
                cm:isp_shapka,
                sm: isp_check,
                width: '100%',
                height: Doc_height*0.42,
                autoResize: true,
                monitorResize: true,
                iconCls: 'icon-grid',
                bodyStyle: 'border:0pt;',
                viewConfig: {forceFit: true},
                columnLines: true,
                enableColumnMove:true,
                frame:true
        });

//------------------------------------------------------------------------------
    smen_zapis = Ext.data.Record.create([
                {name:'x36302'},
                {name:'x36303'},
                {name:'x684'},
                {name:'p006'},
                {name:'vyp'},
                {name:'kolvo'},
                {name:'oborud'},
                {name:'inv'},
                {name:'p450'},
                {name:'p016'},
                {name:'p017'}
	   ]);


    smen_store = new Ext.data.GroupingStore({
                proxy: new Ext.data.HttpProxy({url: 'phps/smen.php'}),
                reader: new Ext.data.JsonReader({
                root: 'dan',
                totalProperty: 'total',
                id: 'id'}, 
                smen_zapis)
        });

//------------------------------------------------------------------------------
    time1 =new Ext.form.TimeField({
                minValue: '7:30',
                maxValue: '16:30',
                increment: 30,
                format:'H:i' 
        });
    time2 =new Ext.form.TimeField({
                minValue: '7:30',
                maxValue: '16:30',
                increment: 30,
                format:'H:i' 
        });
        
    smen_check = new Ext.grid.CheckboxSelectionModel({
                header: "",
                listeners:{
                    rowselect:function()
                        {
                            del.enable();
                            oborud_store.load({params:{p450:smen_table.selModel.getSelected().data.p450}});
                        },
                    rowdeselect:function(){if(smen_table.selModel.getCount()==0){del.disable();}}
			    }
	   });

    smen_shapka= new Ext.grid.ColumnModel({
                columns: [smen_check,
                        {header:"", 
                        width: Doc_width*0.075, 
                        align: 'center', 
                        dataIndex: 'x36302',  
                        resizable:false, 
                        renderer:function(value,metaData,record){return '<span class="text">' + value + '</span>';},
                        editor:time1},
                
                        {header:"", 
                        width: Doc_width*0.075, 
                        align: 'center', 
                        dataIndex: 'x36303',  
                        resizable:false, 
                        renderer:function(value,metaData,record){return '<span class="text">' + value + '</span>';},
                        editor:time2},
                        
                        {header:"", 
                        width: Doc_width*0.25,
                        align: 'center', 
                        dataIndex: 'p006',  
                        resizable:false, 
                        renderer:function(value,metaData,record){return '<span class="text">' + value + '</span>';}},
                        
                        {header:"", 
                        width: Doc_width*0.125, 
                        align: 'center', 
                        dataIndex: 'x684',  
                        resizable:false, 
                        renderer:function(value,metaData,record){return '<span class="text">' + value + '</span>';}},
		    
                        {header:"", 
                        width: Doc_width*0.1, 
                        align: 'center',
                        dataIndex: 'kolvo',  
                        resizable:false, 
                        renderer:function(value,metaData,record){return '<span class="text">' + value + '</span>';}},
		    
                        {header:"", 
                        width: Doc_width*0.23, 
                        align: 'center',
                        dataIndex: 'oborud',  
                        resizable:false, 
                        renderer:function(value,metaData,record){return '<span class="text">' + value + '</span>';}},
		     
                        {header:"", 
                        width: Doc_width*0.075, 
                        align: 'center', 
                        dataIndex: 'inv',  
                        resizable:false,
                        renderer:function(value,metaData,record){return '<span class="text">' + value + '</span>';},
                        editor:inv},
                        
                        {header:"", 
                        width: Doc_width*0.07, 
                        align: 'center', 
                        dataIndex: 'vyp',  
                        resizable:false,
                        renderer:function(value,metaData,record){return '<span class="text">' + value + '</span>';} }],
                rows: [[
                        {},
                        {header:"<span class='text'>Время выполнения</span>",
                        align: 'center',
                        resizable:false,
                        colspan: 2},
                        
                        {header:"<span class='text'>Обозначение,<br>наименование</span>",align: 'center'},
                        {header:"<span class='text'>Номера СП</span>",align: 'center'},
                        {header:"<span class='text'>Кол-во</span>",align: 'center'},
                        {header:"<span class='text'>Оборудование</span>",align: 'center'},
                        {header:"<span class='text'>Инв. &#8470;</span>",align: 'center'},
                        {header:"<span class='text'>Выпол-<br>нение</span>",align: 'center'}
                        ]]
        });

//------------------------------------------------------------------------------
    smen_table = new Ext.grid.EditorGridPanel({
                store: smen_store,
                cm:smen_shapka,
                sm:smen_check,
                width: '100%',
                height: Doc_height*0.42,
                autoResize: true,
                monitorResize: true,
                iconCls: 'icon-grid',
                bodyStyle: 'border:0pt;',
	           viewConfig: {forceFit: true},
	           columnLines: true,
	           enableColumnMove:true,
	           clicksToEdit:1,
	           frame:true,
	           plugins : [new Ext.ux.plugins.GroupHeaderGrid()],
    	       tbar:[del,'->',save,'-',print]
              
        });
//------------------------------------------------------------------------------
    master_form = new Ext.FormPanel({
                width: '100%',
                autoScroll:true,
	           height:'100%',
                bodyStyle:' background-color: #f9f9f9; padding:5px 5px 5px 5px;',
                tbar:[{
                    icon:'images/refresh.gif',
                    scale:'medium',
                    tooltip:'Смена цеха',
                    tooltipType:'title',
                    handler:function ()
                        {Ext.Msg.prompt('<span class="text">Сменить цех</span>', '<span class="text">Введите номер цеха</span>',
                            function(btn,text){if (btn == 'ok')
                                {
                                    v_x453 = text;
                                    document.getElementById('x453').textContent=text;
                                    c051_store.load({params:{x453:v_x453}});
                                    x459.setValue();
                                    x459_store.load({params:{x453:v_x453}});
                                    isp_store.removeAll();
                                }});
			             }
							      
			         }],
                items:[ {layout:'column',
				    bodyStyle:'background-color: #f9f9f9;',
				    border:false,
				    items:[{columnWidth:0.44,
                            layout:'form',
                            border:false,
                            bodyStyle:'background-color: #f9f9f9;',
                            labelWidth:60,
                            items:[{
                                    xtype:'fieldset',
                                    title:'<span style="font-size:9pt;">Номенклатура</span>',
                                    labelWidth:60,
                                    itemCls:'text-align:center;',
                                    cls:'field',
                                    labelAlign:'center',
                                    items:[nomen_table]
                              }]
                            },
                            {columnWidth:0.55,
                            layout:'form',
                            border:false,
                            bodyStyle:'background-color: #f9f9f9;',
                            labelWidth:70,
                            items:[ {
                                        xtype:'fieldset',
                                        title:'<span style="font-size:9pt;">Операции</span>',
                                        labelWidth:60,
                                        itemCls:'text-align:center;',
                                        labelAlign:'center',
                                        items:[oper_table]
                                    }]
                            }]
		              },
                        {layout:'column',
                        bodyStyle:'background-color: #f9f9f9;',
                        border:false,
                        items:[{columnWidth:0.3,
                            layout:'form',
                            border:false,
                            bodyStyle:'background-color: #f9f9f9;',
                            labelWidth:60,
                            items:[{
                                        xtype:'fieldset',
                                        title:'<span style="font-size:9pt;">Исполнители</span>',
                                        labelWidth:60,
                                        itemCls:'text-align:center;',
                                        labelAlign:'center',
                                        items:[isp_table]
                                         }]
                                        },
                            {columnWidth:0.7,
                            layout:'form',
                            border:false,
                            bodyStyle:'background-color: #f9f9f9;',
                            labelWidth:70,
                            items:[ {
                                        xtype:'fieldset',
                                        title:'<span style="font-size:9pt;">Сменное задание</span>',
                                        labelWidth:60,
                                        itemCls:'text-align:center;',
                                        cls:'field',
                                        labelAlign:'center',
                                        items:[smen_table]
                                  }]
                            }]
			             }]
        });
//------------------------------------------------------------------------------	
    viewport_master = new Ext.Viewport({
                layout: 'border',
                id:'viewport_master',
                autoScroll:true,
                items: [{
                        region: 'center',
                        id      : 'center',
                        layout: 'fit',
                        width: '100%',
                        items:[master_form]
                        }]
        });
    
}
//------------------------------------------------------------------------------
function oper_search()
{
    
    
    var mas_p006='';
    var mas_p006_text='';
    var mas_x684='';
    var mas_kolvo=0;			
    for(var i=0;i<nomen_table.selModel.getCount();i++)
	{
	    
	    if(i==0)
		{
		    mas_p006=nomen_table.selModel.selections.items[i].data.p006_oper;
		    mas_p006_text=nomen_table.selModel.selections.items[i].data.p006_text;
		    mas_x684=nomen_table.selModel.selections.items[i].data.x684;
		    mas_kolvo=nomen_table.selModel.selections.items[i].data.kolvo;
		}
	    else
		{
		    mas_p006=mas_p006+'***'+nomen_table.selModel.selections.items[i].data.p006_oper;
		    mas_p006_text=mas_p006_text+'***'+nomen_table.selModel.selections.items[i].data.p006_text;
		    mas_x684=mas_x684+'***'+nomen_table.selModel.selections.items[i].data.x684;
		    mas_kolvo=mas_kolvo+'***'+nomen_table.selModel.selections.items[i].data.kolvo;
		}
				    
	}
    				
    oper_store.load({params:{x453:v_x453,x684:mas_x684,p006:mas_p006,kolvo:mas_kolvo,p006_text:mas_p006_text}});
    oper_store.on('load',function()
		  {
		    count=document.getElementById('count').textContent=oper_store.reader.jsonData.v_sum;
		    });
}
//------------------------------------------------------------------------------
function smen_search()
{
    smen_store.load({params:{p704:isp_table.selModel.selections.items[0].data.p704, date:date.getValue().format('d.m.Y')}});
    smen_store.on('load',function()
		  {
		    if(isp_table.selModel.getCount()>0 && smen_store.getCount()>0)
		    {
			print.enable();
			save.enable();
		    }
		    });
    
}
//------------------------------------------------------------------------------
function smen_add()
{
	var i,time11,time22;
	
	
	for(var ii=0;ii<oper_table.selModel.getCount();ii++)
	{
	    if(smen_store.getCount()>0)
	    {
		i=smen_store.getCount()-1;
		time11=smen_store.data.items[i].data.x36303;
	    
	    switch (time11)
	    {
		case '7:30':time22='09:30';break;
		case '9:30':time22='11:30';break;
		case '11:30':time11='12:30'; time22='14:30';break;
		case '14:30':time22='16:30';break;
		default:time22='16:30';break;
	    }
	    }
	    else {time11='7:30';time22='9:30';}
	    
	    
	    var p = new smen_zapis({
		x36302:time11,
		x36303:time22,
		x684:oper_table.selModel.selections.items[ii].data.x684,
		p006:oper_table.selModel.selections.items[ii].data.p006_text,
		vyp:'',
		kolvo:oper_table.selModel.selections.items[ii].data.kolvo,
		oborud:oper_table.selModel.selections.items[ii].data.oborud,
		inv:'',
		p450:oper_table.selModel.selections.items[ii].data.p450,
		p016:oper_table.selModel.selections.items[ii].data.p016,
		p017:oper_table.selModel.selections.items[ii].data.p017
	    });
	
	    smen_store.insert(smen_store.getCount(), p);
	}
	save.enable();print.enable();

}
//------------------------------------------------------------------------------
function smen_save()
{
    var mas_inv="";
    var mas_x684="";
    var mas_p016="";
    var mas_p017="";
    var mas_x36302="";
    var mas_x36303="";
    
    if(v_kk==3)
    {
	for (var i=0;i<smen_store.getCount();i++)
	    {
		
		v_inv=smen_store.data.items[i].data.inv;
		v_p016=smen_store.data.items[i].data.p016;
		v_p017=smen_store.data.items[i].data.p017;
		v_x684=smen_store.data.items[i].data.x684;
		v_x36302=date.getValue().format('d.m.Y')+' '+smen_store.data.items[i].data.x36302;
		v_x36303=date.getValue().format('d.m.Y')+' '+smen_store.data.items[i].data.x36303;
		
		if(v_inv==''){v_inv=0;}
		if(i==0)
		{
		    mas_inv=v_inv;
		    mas_p016=v_p016;
		    mas_p017=v_p017;
		    mas_x684=v_x684;
		    mas_x36302=v_x36302;
		    mas_x36303=v_x36303;
		   
		}
		else
		{
		    mas_inv=mas_inv+'***'+v_inv;
		    mas_p016=mas_p016+'***'+v_p016;
		    mas_p017=mas_p017+'***'+v_p017;
		    mas_x684=mas_x684+'***'+v_x684;
		    mas_x36302=mas_x36302+'***'+v_x36302;
		    mas_x36303=mas_x36303+'***'+v_x36303;
		}
	    }
    }
    
    if (v_kk==1)
    {
	for (var i=0;i<smen_table.selModel.getCount();i++)
	    {
		
		v_inv=smen_table.selModel.selections.items[i].data.inv;
		v_p016=smen_table.selModel.selections.items[i].data.p016;
		v_p017=smen_table.selModel.selections.items[i].data.p017;
		v_x684=smen_table.selModel.selections.items[i].data.x684;
		v_x36302=date.getValue().format('d.m.Y')+' '+smen_table.selModel.selections.items[i].data.x36302;
		v_x36303=date.getValue().format('d.m.Y')+' '+smen_table.selModel.selections.items[i].data.x36303;
		
		if(v_inv==''){v_inv=0;}
		if(i==0)
		{
		    mas_inv=v_inv;
		    mas_p016=v_p016;
		    mas_p017=v_p017;
		    mas_x684=v_x684;
		    mas_x36302=v_x36302;
		    mas_x36303=v_x36303;
		   
		}
		else
		{
		    mas_inv=mas_inv+'***'+v_inv;
		    mas_p016=mas_p016+'***'+v_p016;
		    mas_p017=mas_p017+'***'+v_p017;
		    mas_x684=mas_x684+'***'+v_x684;
		    mas_x36302=mas_x36302+'***'+v_x36302;
		    mas_x36303=mas_x36303+'***'+v_x36303;
		}
	    }
    }
    
    
    Ext.Ajax.request(
    	{
    		url: 'phps/save.php',
    		method: 'post',
    		params:{inv:mas_inv,
			p016:mas_p016,
			p017:mas_p017,
			x684:mas_x684,
			x36302:mas_x36302,
			x36303:mas_x36303,
    		p704:isp_table.selModel.selections.items[0].data.p704,
			x453:v_x453,
			x459:x459.getValue(),
			v_kk:v_kk
    		        },		
    		callback:   function(opts,suss,resp)
    				{
    				    var v=Ext.decode(resp.responseText);
				    if (v=='1')
					{
					    if(v_kk==3){Ext.Msg.alert('<br>Изменения выполены');}
					    if(v_kk==1){Ext.Msg.alert('<br>Строки удалены<br>из сменного задания');smen_search();}
					}
       				}
      	});
    
}
