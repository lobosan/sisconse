QoDesk.UsosHecho = Ext.extend(Ext.app.Module, {
	id: 'usos-hecho',
	type: 'senagua/usos-hecho',

	createWindow: function(){
		var desktop = this.app.getDesktop();
		var win = desktop.getWindow(this.id);

		if(!win){
			win = desktop.createWindow({
				id: this.id,
				title: 'INFORMACION DE LOS USOS DE HECHO DE LOS APROVECHAMIENTOS HIDRICOS DEL ECUADOR',
				width: 1281,
				height: desktop.getWinHeight(),
				maximizable: false,
				resizable: false,
				iconCls: 'usos-hecho-icon',
				shim: false,
				constrainHeader: true,
				layout: 'fit',
				html: '<iframe src="modules/senagua/usos/index.php" style="width:100%;height:100%;border:none;"></iframe>'
			});
		}
		win.show();
	}
});