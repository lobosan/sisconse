/*
 * File: app/store/FormaAbastecimiento.js
 *
 * This file was generated by Ext Designer version 1.2.2.
 * http://www.sencha.com/products/designer/
 *
 * This file will be auto-generated each and everytime you export.
 *
 * Do NOT hand edit this file.
 */

Ext.define('sisconse.store.FormaAbastecimiento', {
	extend: 'Ext.data.Store',

	constructor: function(cfg) {
		var me = this;
		cfg = cfg || {};
		me.callParent([Ext.apply({
			storeId: 'FormaAbastecimiento',
			proxy: {
				type: 'ajax',
				url: 'app/data/formasabastecimiento.php',
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