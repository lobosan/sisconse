QoDesk.Cubo = Ext.extend(Ext.app.Module, {
	id: 'cubo',
	type: 'senagua/cubo',

	init: function(){
		this.locale = QoDesk.Cubo.Locale;
	},

	createWindow: function(){
		var desktop = this.app.getDesktop();
		var win = desktop.getWindow(this.id);

		if(!win){
            win = desktop.createWindow({
				id: this.id,
				title: 'Reportes dinámicos',
				width: 1280,
				height: desktop.getWinHeight(),
                bodyStyle: 'background-color:#FFF;',
				iconCls: 'cubo-icon',
				shim: false,
				constrainHeader: true,
				layout: 'fit',
				html: '<iframe src="http://186.66.127.99:8085/reportes/" style="width:100%;height:100%;border:none;"></iframe>'
			});
		}
		win.show();
	}
});