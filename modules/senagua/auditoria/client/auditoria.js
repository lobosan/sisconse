QoDesk.Auditoria = Ext.extend(Ext.app.Module, {
    id:'auditoria',
    type:'senagua/auditoria',

    init:function () {
        this.launcher = {
            text:'Auditoría',
            iconCls:'auditoria-icon',
            handler:this.createWindow,
            scope:this
        }
    },

    createWindow:function () {
        var desktop = this.app.getDesktop();
        var win = desktop.getWindow('grid-win-auditoria');

        this.storeAuditoria = new Ext.data.JsonStore({
            url:'modules/senagua/auditoria/server/crudAuditoria.php',
            root:'data',
            autoLoad:{params:{start:0, limit:50}},
            fields:[
                {name:'usuario'},
                {name:'modulo'},
                {name:'fecha', type:'date', dateFormat:'Y-m-d H:i:s.u'},
                {name:'query'}
            ]
        });
        this.gridAuditoria = new Ext.grid.EditorGridPanel({
            store:this.storeAuditoria,
            columns:[
                new Ext.grid.RowNumberer()
                , {header:'Usuario', dataIndex:'usuario', sortable:true, width:130}
                , {header:'Módulo', dataIndex:'modulo', sortable:true, width:150}
                , {header:'Fecha', dataIndex:'fecha', sortable:true, renderer:Ext.util.Format.dateRenderer('Y-m-d H:i'), width:140}
                , {header:'Consulta', dataIndex:'query', sortable:true, width:420, editor:new Ext.form.TextField({allowBlank:false})}
            ],
            sm:new Ext.grid.RowSelectionModel({singleSelect:true}),
            border:false,

            bbar:new Ext.PagingToolbar({
                displayInfo:true, displayMsg:'Mostrando  {0} - {1} de {2}', emptyMsg:'No hay información que mostrar', pageSize:50, store:this.storeAuditoria
            }),

            stripeRows:true
        });

        if (!win) {
            win = desktop.createWindow({
                id:'grid-win-auditoria',
                title:'Auditoría',
                width:900,
                height:500,
                iconCls:'auditoria-icon',
                shim:false,
                animCollapse:false,
                constrainHeader:true,
                layout:'fit',
                items:this.gridAuditoria
            });
        }
        win.show();
    }
});
