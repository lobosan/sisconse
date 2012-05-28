/*
 * File: app/view/BtnGuardar.js
 *
 * This file was generated by Ext Designer version 1.2.2.
 * http://www.sencha.com/products/designer/
 *
 * This file will be generated the first time you export.
 *
 * You should implement event handling and custom methods in this
 * class.
 */

Ext.define('usos.view.BtnGuardar', {
	extend: 'usos.view.ui.BtnGuardar',
	alias: 'widget.btnguardar',

	initComponent: function() {
		var me = this;
		me.callParent(arguments);

		me.on('click', function() {
			var form = this.up('form').getForm();
			if(form.isValid()) {
				var numficha = Ext.urlDecode(window.location.search.substring());
				form.submit({
					url: 'server/updateform.php?ficha='+numficha.ficha,
					waitTitle: 'Espere por favor',
					waitMsg: 'Guardando información...',
					success: function(form, action) {
						Ext.MessageBox.show({
							title: 'Éxito',
							msg: action.result.msg,
							buttons: Ext.MessageBox.OK,
							icon: Ext.MessageBox.INFO
						});
					},
					failure: function(form, action) {
						Ext.MessageBox.show({
							title: 'Error!',
							msg: action.result.msg,
							buttons: Ext.MessageBox.OK,
							icon: Ext.MessageBox.ERROR
						});
					}
				});
			} else {
				Ext.MessageBox.show({
					title: 'Datos no válidos',
					msg: 'Corrija los campos resaltados en rojo',
					buttons: Ext.MessageBox.OK,
					icon: Ext.MessageBox.WARNING
				});
			}
		});
	}
});