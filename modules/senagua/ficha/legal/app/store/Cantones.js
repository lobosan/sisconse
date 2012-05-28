/*
 * File: app/store/Cantones.js
 *
 * This file was generated by Ext Designer version 1.2.2.
 * http://www.sencha.com/products/designer/
 *
 * This file will be auto-generated each and everytime you export.
 *
 * Do NOT hand edit this file.
 */

Ext.define('sisconse.store.Cantones', {
	extend: 'Ext.data.Store',

	constructor: function(cfg) {
		var me = this;
		cfg = cfg || {};
		me.callParent([Ext.apply({
			storeId: 'Cantones',
			pageSize: 220,
			proxy: {
				type: 'ajax',
				url: 'app/data/cantones.php',
				reader: {
					type: 'json',
					root: 'data'
				}
			},
			fields: [
				{
					name: 'dpa_codigo'
				},
				{
					name: 'dpa_descripcion'
				}
			]
		}, cfg)]);

		this.load();
	}
});