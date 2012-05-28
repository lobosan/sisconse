QoDesk.Ficha = Ext.extend(Ext.app.Module, {
	id: 'ficha',
	type: 'senagua/ficha',

	createWindow: function(){
		var desktop = this.app.getDesktop();
		var win = desktop.getWindow(this.id);

		if(!win){
			win = desktop.createWindow({
				id: this.id,
				title: 'INFORMACION DE LOS USOS Y APROVECHAMIENTOS HIDRICOS DEL ECUADOR',
				width: 1281,
				height: desktop.getWinHeight(),
				maximizable: false,
				resizable: false,
				iconCls: 'ficha-icon',
				shim: false,
				constrainHeader: true,
				layout: 'fit',
				html: '<iframe src="modules/senagua/ficha/legal/index.php" style="width:100%;height:100%;border:none;"></iframe>'
			});
		}
		win.show();
	}
});