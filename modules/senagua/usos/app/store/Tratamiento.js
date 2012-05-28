/*
 * File: app/store/Tratamiento.js
 * Date: Thu Dec 22 2011 09:30:38 GMT-0500 (Hora est. Pacífico, Sudamérica)
 *
 * This file was generated by Ext Designer version 1.2.2.
 * http://www.sencha.com/products/designer/
 *
 * This file will be auto-generated each and everytime you export.
 *
 * Do NOT hand edit this file.
 */

Ext.define('usos.store.Tratamiento', {
	extend: 'Ext.data.Store',

	constructor: function(cfg) {
		var me = this;
		cfg = cfg || {};
		me.callParent([Ext.apply({
			storeId: 'Tratamiento',
			proxy: {
				type: 'ajax',
				url: 'app/data/tratamiento.php',
				reader: {
					type: 'json',
					root: 'data'
				}
			},
			fields: [
				{
					name: 'par_id'
				},
				{
					name: 'par_descripcion'
				}
			]
		}, cfg)]);

		this.load();
	}
});