<?php
require_once '../../../server/os.php';
$os = new os();
if(!$os->session_exists()){
    die('NO EXISTE SESION ACTIVA !');
}
$group_id = $os->get_group_id();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>sisconse</title>
		<link rel="stylesheet" type="text/css" href="../../common/ext-4.0.7/resources/css/ext-all.css" />
		<link rel="stylesheet" type="text/css" href="../../common/ext-4.0.7/ux/grid/css/GridFilters.css" />
		<link rel="stylesheet" type="text/css" href="../../common/ext-4.0.7/ux/grid/css/RangeMenu.css" />
		<link rel="stylesheet" type="text/css" href="../ficha/legal/assets/css/grid-filter.css" />
		<script type="text/javascript" src="../../common/ext-4.0.7/bootstrap.js"></script>
		<script type="text/javascript" src="../../common/ext-4.0.7/locale/ext-lang-es.js"></script>
		<script type="text/javascript">
        Ext.Loader.setConfig({
            enabled:true
        });

        Ext.Loader.setPath('Ext.ux', '../../common/ext-4.0.7/ux');

        Ext.require([
            'Ext.grid.*',
            'Ext.data.*',
            'Ext.ux.grid.FiltersFeature',
            'Ext.toolbar.Paging',
            'Ext.selection.CheckboxModel'
        ]);

        Ext.define('Ficha', {
            extend:'Ext.data.Model',
            fields:[
                {name:'con_id', type:'int'},
                {name:'con_formulario', type:'string'},
                {name:'rio_autoriz_actual_id', type:'string'},
                {name:'dpa_provincia', type:'string'},
                {name:'dpa_canton', type:'string'},
                {name:'dpa_parroquia', type:'string'},
                {name:'hid_id', type:'string'},
                {name:'cue_id', type:'string'},
                {name:'sub_id', type:'string'},
                {name:'mic_id', type:'string'}
            ]
        });

        Ext.onReady(function () {
            Ext.QuickTips.init();

            var store = Ext.create('Ext.data.JsonStore', {
                model:'Ficha',
                proxy:{
                    type:'ajax',
                    api:{
                        read:'server/store-grid-filter-hecho.php?tipo=hecho',
                        destroy:'server/delete.php'
                    },
                    reader:{
                        type:'json',
                        root:'data',
                        idProperty:'con_id',
                        totalProperty:'total'
                    },
                    writer:{
                        root:'data',
                        encode:true
                    }
                },
                remoteSort:true,
                sorters:[
                    {property:'con_formulario', direction:'ASC'}
                ],
                pageSize:500
            });

            var grid = Ext.create('Ext.grid.Panel', {
                border:false,
                store:store,
                width:1265,
                height:Ext.Element.getDocumentHeight() - 54,
                selModel:Ext.create('Ext.selection.CheckboxModel'),
                columns:[
                    {dataIndex:'con_formulario', text:'Ficha No.', width:80, filterable:true},
                    {dataIndex:'rio_autoriz_actual_id', text:'Autorizado actual', flex:1, filterable:true},
                    {dataIndex:'dpa_provincia', text:'Provincia', width:95, filterable:true},
                    {dataIndex:'dpa_canton', text:'Cantón', width:95, filterable:true},
                    {dataIndex:'dpa_parroquia', text:'Parroquia', width:95, filterable:true},
                    {dataIndex:'hid_id', text:'Sistema Hidrográfico', width:150, filterable:true},
                    {dataIndex:'cue_id', text:'Cuenca', width:120, filterable:true},
                    {dataIndex:'sub_id', text:'Subcuenca', width:120, filterable:true},
                    {dataIndex:'mic_id', text:'Microcuenca', width:193, filterable:true},
                    {
                        xtype:'actioncolumn',
                        width:65,
                        items:[
                            {
                                icon:'../ficha/legal/assets/images/view_details_off.png',
                                tooltip:'Ver detalles',
                                handler:function (grid, rowIndex, colIndex) {
                                    var row = store.getAt(rowIndex);
                                    tabs.add({
                                        title:'Ficha No. ' + row.get('con_formulario'),
                                        html:'<iframe src="lectura/lectura.php?ficha=' + row.get('con_id') + '" style="width:100%;height:100%;border:none;"></iframe>',
                                        iconCls:'tab-view',
                                        closable:true
                                    }).show();
                                }
                            },
                            {
                                icon:'../ficha/legal/assets/images/edit16x16_off.png',
                                tooltip:'Editar ficha',
                                disabled: <?=($os->is_group_allowed($group_id, 'usos-hecho', 'editarHecho')) ? 'false' : 'true'?>,
                                handler:function (grid, rowIndex, colIndex) {
                                    var row = store.getAt(rowIndex);
                                    tabs.add({
                                        title:'Ficha No. ' + row.get('con_formulario'),
                                        html:'<iframe src="usos_hecho.php?ficha=' + row.get('con_id') + '" style="width:100%;height:100%;border:none;"></iframe>',
                                        iconCls:'tab-edit',
                                        closable:true
                                    }).show();
                                }
                            },
                            {
                                icon:'../ficha/legal/assets/images/delete16x16_off.png',
                                tooltip:'Eliminar ficha',
                                disabled: <?=($os->is_group_allowed($group_id, 'usos-hecho', 'eliminarHecho')) ? 'false' : 'true'?>,
                                handler:function () {
                                    var sm = grid.getSelectionModel();
                                    Ext.MessageBox.msgButtons['yes'].text = "Sí";
                                    Ext.Msg.show({
                                        title:'Eliminar registro',
                                        msg:'El registro seleccionado será eliminado permanentemente, desea continuar?',
                                        buttons:Ext.Msg.YESNO,
                                        icon:Ext.Msg.QUESTION,
                                        fn:function (btn) {
                                            if (btn === 'yes') {
                                                store.remove(sm.getSelection());
                                                store.sync();
                                            }
                                        }
                                    });
                                }
                            }
                        ]
                    }
                ],
                listeners:{
                    itemdblclick:function (dataview, record, item, index, e) {
                        var row = grid.getView().getSelectionModel().getSelection()[0].data;
                        tabs.add({
                            title:'Ficha No. ' + row.con_formulario,
                            html:'<iframe src="lectura/lectura.php?ficha=' + row.con_id + '" style="width:100%;height:100%;border:none;"></iframe>',
                            iconCls:'tab-view',
                            closable:true
                        }).show();
                    }
                },
                features:{
                    ftype:'filters',
                    encode:true,
                    local:false
                },
                dockedItems:[Ext.create('Ext.toolbar.Paging', {
                    dock:'bottom',
                    store:store,
                    displayInfo:true,
                    emptyMsg:'No existen datos que mostrar'
                })]
            });

            var tabs = Ext.createWidget('tabpanel', {
                renderTo:'fichas',
                resizeTabs:true,
                enableTabScroll:true,
                width:1267,
                height:Ext.Element.getDocumentHeight(),
                items:[
                    {
                        title:'Fichas',
                        id:'filtros',
                        autoScroll:true,
                        tbar:[
                            {
                                text:'Añadir',
                                tooltip:'Crear una nueva ficha',
                                iconCls:'add-icon',
                                disabled: <?=($os->is_group_allowed($group_id, 'usos-hecho', 'crearHecho')) ? 'false' : 'true'?>,
                                handler:function () {
                                    tabs.add({
                                        title:'Nueva ficha',
                                        html:'<iframe src="server/nuevaficha.php" style="width:100%;height:100%;border:none;"></iframe>',
                                        iconCls:'tab-add',
                                        closable:true
                                    }).show()
                                }
                            },
                            '-',
                            {
                                text:'Eliminar',
                                tooltip:'Eliminar fichas seleccionadas',
                                iconCls:'delete-icon',
                                disabled: <?=($os->is_group_allowed($group_id, 'usos-hecho', 'eliminarHecho')) ? 'false' : 'true'?>,
                                handler:function () {
                                    var sm = grid.getSelectionModel();
                                    Ext.MessageBox.msgButtons['yes'].text = "Sí";
                                    Ext.Msg.show({
                                        title:'Eliminar registros',
                                        msg:'Los registros seleccionados serán eliminados permanentemente, desea continuar?',
                                        buttons:Ext.Msg.YESNO,
                                        icon:Ext.Msg.QUESTION,
                                        fn:function (btn) {
                                            if (btn === 'yes') {
                                                store.remove(sm.getSelection());
                                                store.sync();
                                            }
                                        }
                                    });
                                }
                            },
                            '-',
                            {
                                text:'Excel',
                                tooltip:'Importar un archivo Excel',
                                iconCls:'import-icon',
                                disabled: <?=($os->is_group_allowed($group_id, 'usos-hecho', 'importarExcelHecho')) ? 'false' : 'true'?>,
                                handler:function () {
                                    var win;
                                    if (!win) {
                                        win = Ext.create('widget.window', {
                                            title:'Importar Excel',
                                            iconCls:'import-icon',
                                            width:350,
                                            height:150,
                                            resizable:false,
                                            modal:true,
                                            items:Ext.create('Ext.form.Panel', {
                                                border:0,
                                                height:116,
                                                bodyPadding:'10 15',
                                                items:[
                                                    {
                                                        html:'Seleccione una ficha en formato Excel',
                                                        border:0,
                                                        padding:'5 0 10 0'
                                                    },
                                                    {
                                                        xtype:'filefield',
                                                        anchor:'100%',
                                                        padding:'0 0 5 0',
                                                        allowBlank:false,
                                                        msgTarget:'side',
                                                        name:'excel-path',
                                                        buttonText:'Buscar...'
                                                    },
                                                    {
                                                        xtype:'button',
                                                        id:'xls-button',
                                                        text:'Importar',
                                                        width:70,
                                                        height:27,
                                                        handler:function () {
                                                            var form = this.up('form').getForm();
                                                            if (form.isValid()) {
                                                                form.submit({
                                                                    url:'server/import/migrarFichasAutoHecho.php',
                                                                    waitTitle:'Espere por favor',
                                                                    waitMsg:'Importando Excel...',
                                                                    success:function (form, action) {
                                                                        Ext.MessageBox.show({
                                                                            title:'Éxito',
                                                                            msg:action.result.msg,
                                                                            buttons:Ext.MessageBox.OK,
                                                                            icon:Ext.MessageBox.INFO
                                                                        });
                                                                    },
                                                                    failure:function (form, action) {
                                                                        Ext.MessageBox.show({
                                                                            title:'Error!',
                                                                            msg:action.result.msg,
                                                                            buttons:Ext.MessageBox.OK,
                                                                            icon:Ext.MessageBox.ERROR
                                                                        });
                                                                    }
                                                                });
                                                            }
                                                        }
                                                    }
                                                ]
                                            })
                                        });
                                    }
                                    win.show();
                                }
                            },
                            '-',
                            {
                                text:'CSV',
                                tooltip:'Importar un archivo CSV',
                                iconCls:'csv-icon',
                                disabled: <?=($os->is_group_allowed($group_id, 'usos-hecho', 'importarCSVHecho')) ? 'false' : 'true'?>,
                                handler:function () {
                                    var win;
                                    if (!win) {
                                        win = Ext.create('widget.window', {
                                            title:'Importar CSV',
                                            iconCls:'csv-icon',
                                            width:350,
                                            height:150,
                                            resizable:false,
                                            modal:true,
                                            items:Ext.create('Ext.form.Panel', {
                                                border:0,
                                                height:116,
                                                bodyPadding:'10 15',
                                                items:[
                                                    {
                                                        html:'Seleccione una ficha en formato CSV',
                                                        border:0,
                                                        padding:'5 0 10 0'
                                                    },
                                                    {
                                                        xtype:'filefield',
                                                        anchor:'100%',
                                                        padding:'0 0 5 0',
                                                        allowBlank:false,
                                                        msgTarget:'side',
                                                        name:'csv-path',
                                                        buttonText:'Buscar...'
                                                    },
                                                    {
                                                        xtype:'button',
                                                        text:'Importar',
                                                        id:'csv-button',
                                                        width:70,
                                                        height:27,
                                                        handler:function () {
                                                            var form = this.up('form').getForm();
                                                            if (form.isValid()) {
                                                                form.submit({
                                                                    url:'server/import/migrarFichasCSVHecho.php',
                                                                    waitTitle:'Espere por favor',
                                                                    waitMsg:'Importando Excel...',
                                                                    success:function (form, action) {
                                                                        Ext.MessageBox.show({
                                                                            title:'Éxito',
                                                                            msg:action.result.msg,
                                                                            buttons:Ext.MessageBox.OK,
                                                                            icon:Ext.MessageBox.INFO
                                                                        });
                                                                    },
                                                                    failure:function (form, action) {
                                                                        Ext.MessageBox.show({
                                                                            title:'Error!',
                                                                            msg:action.result.msg,
                                                                            buttons:Ext.MessageBox.OK,
                                                                            icon:Ext.MessageBox.ERROR
                                                                        });
                                                                    }
                                                                });
                                                            }
                                                        }
                                                    }
                                                ]
                                            })
                                        });
                                    }
                                    win.show();
                                }
                            },
                            '-',
                            {
                                text:'Exportar',
                                tooltip:'Exportar datos a Excel',
                                iconCls:'export-icon',
                                disabled: <?=($os->is_group_allowed($group_id, 'usos-hecho', 'exportarExcelHecho')) ? 'false' : 'true'?>,
                                url:'../../common/server/exportarExcel.php?tipo=hecho'
                            },
                            '-',
                            '->',
                            {
                                text:'Quitar filtros',
                                iconCls:'filters',
                                handler:function () {
                                    grid.filters.clearFilters();
                                }
                            }
                        ],
                        items:[grid]
                    }
                ],
                closable:false
            }).show();

            var myMask = new Ext.LoadMask(grid, {
                msg:"Cargando...",
                store:store
            });
            myMask.show();

            store.load();
        });
		</script>
	</head>

	<body>
		<div id="fichas"></div>
	</body>
</html>