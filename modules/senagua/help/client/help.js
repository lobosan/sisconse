QoDesk.Help = Ext.extend(Ext.app.Module, {
	id: 'help',
	type: 'senagua/help',

	createWindow: function(){
		var desktop = this.app.getDesktop();
		var win = desktop.getWindow(this.id);

        var tree = new Ext.tree.TreePanel({
            region: 'west',
            title: 'Contenido',
            titleCollapse: true,
            width: 250,
            split: true,
            collapsible: true,
            animate: true,
            border: false,
            autoScroll: true,
            dataUrl: 'modules/senagua/help/server/get-files.php',
            rootVisible: false,
            root: new Ext.tree.AsyncTreeNode({
                id: '.',
                text: 'User files'
            })
        });

        var main = new Ext.Panel({
            region: 'center',
            layout: 'fit',
            border: false,
            bodyStyle: 'background-color: #EDF1F7'
        });

		if(!win){
            win = desktop.createWindow({
				id: this.id,
				title: 'Ayuda y soporte técnico',
                layout: 'border',
				width: 1280,
                height: desktop.getWinHeight(),
				iconCls: 'help-icon',
                items: [tree, main]
			});
		}
		win.show();

        tree.expandAll();

        tree.on('click', function(node){
            var el = Ext.get(Ext.DomQuery.select('.x-panel-body', main.el.dom)[0]);
            while (el.dom.childNodes[0]){
                el.dom.removeChild(el.dom.childNodes[0]);
            }
            el.createChild({
                tag:'iframe',
                src:'modules/senagua/help/files/'+node.id,
                style:'border:none;width:100%;height:100%;'
            });
        });
	}
});