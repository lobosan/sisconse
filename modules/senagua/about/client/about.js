QoDesk.About = Ext.extend(Ext.app.Module, {
	id: 'about',
	type: 'senagua/about',

	createWindow: function(){
		var desktop = this.app.getDesktop();
		var win = desktop.getWindow(this.id);

		if(!win){
            win = desktop.createWindow({
				id: this.id,
				title: 'Acerca de',
				width: 600,
				height: 400,
                bodyStyle: 'background-color: #FFF; font-size: 13px; font-family: arial; color: #333;',
                padding: '15px 30px',
				iconCls: 'about-icon',
                minimizable: false,
                maximizable: false,
				html: '<div id="usaid-fonag"><img src="modules/senagua/about/client/assets/images/usaid-fonag.png" width="425" height="108" alt="usaid"></div>' +
                    '<p>VISOR del SISTEMA DE INFORMACION GEOGRAFICA DE SENAGUA es fruto del convenio de cooperación ' +
                    'existente entre el Fondo para la Protección del Agua - FONAG y la Secretaría Nacional del Agua - SENAGUA</p>' +
                    '<p>Además, este COMPONENTE DEL SISTEMA DE INFORMACION GEOGRAFICA DE SENAGUA ha sido posible gracias al apoyo del pueblo ' +
                    'de los Estados Unidos de América a través de la Agencia de los Estados Unidos para el Desarrollo Internacional - USAID conforme ' +
                    'a los términos de la Adjudicación No. [518-A-00-07-00056-00].</p><p>Las opiniones aquí expresadas pertenecen al autor o autores y no ' +
                    'reflejan necesariamente el punto de vista de USAID o del Gobierno de los Estados Unidos de América.</p>'
			});
		}
		win.show();
	}
});