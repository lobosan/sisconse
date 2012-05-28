QoDesk.Visor = Ext.extend(Ext.app.Module, {
   id: 'visor',
   type: 'senagua/visor',

	createWindow: function(){
		var desktop = this.app.getDesktop();
		var win = desktop.getWindow(this.id);

		if(!win){
			var winWidth = desktop.getWinWidth() / 1.1;
			var winHeight = desktop.getWinHeight() / 1.1;

			win = desktop.createWindow({
				id: this.id,
				title: 'Visor geográfico',
				width: winWidth,
				height: winHeight,
				iconCls: 'visor-icon',
				shim: false,
				constrainHeader: true,
				layout: 'fit',
				html: '<iframe src="http://186.66.127.99:8085/sisconse/visor/" style="width:100%;height:100%;border:none;"></iframe>'
			});
		}
		win.show();
   }
});