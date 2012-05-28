/*
 * File: app/store/Subcuencas.js
 *
 * This file was generated by Ext Designer version 1.2.2.
 * http://www.sencha.com/products/designer/
 *
 * This file will be auto-generated each and everytime you export.
 *
 * Do NOT hand edit this file.
 */

Ext.define('sisconse.store.Subcuencas', {
	extend: 'Ext.data.Store',

	constructor: function(cfg) {
		var me = this;
		cfg = cfg || {};
		me.callParent([Ext.apply({
			storeId: 'Subcuencas',
			pageSize: 23,
			proxy: {
				type: 'ajax',
				url: 'app/data/subcuencas.php',
				reader: {
					type: 'json',
					root: 'data'
				}
			},
			fields: [
				{
					name: 'hid_codigo'
				},
				{
					name: 'hid_nombre'
				}
			]
		}, cfg)]);

		this.load();
	}
});