/*
 * File: app/view/BtnImprimir.js
 *
 * This file was generated by Ext Designer version 1.2.2.
 * http://www.sencha.com/products/designer/
 *
 * This file will be generated the first time you export.
 *
 * You should implement event handling and custom methods in this
 * class.
 */
Ext.define('usoslectura.view.BtnImprimir', {
    extend:'usoslectura.view.ui.BtnImprimir',
    alias:'widget.btnimprimir',

    initComponent:function () {
        var me = this;
        me.on('click', function () {
            /* Codigo de impresion */
            var tipoForm = '.x-form-checkbox';
            var totalCheckboxes = Ext.DomQuery.select(tipoForm).length;
            for (var i = 0; i < totalCheckboxes; i++) {
                Ext.DomQuery.select(tipoForm)[i].type = "checkbox";
                var ariaRadio = Ext.DomQuery.select(tipoForm)[i].attributes[5].value;
                if (ariaRadio == 'true')
                    Ext.DomQuery.select(tipoForm)[i].checked = true;
                else
                    Ext.DomQuery.select(tipoForm)[i].checked = false;
            }
            /*cambio radio js*/
            tipoForm = '.x-form-radio';
            var totalRadio = Ext.DomQuery.select(tipoForm).length;
            for (i = 0; i < totalRadio; i++) {
                Ext.DomQuery.select(tipoForm)[i].type = "radio";
                var ariaRadio = Ext.DomQuery.select(tipoForm)[i].attributes[5].value;
                if (ariaRadio == 'true')
                    Ext.DomQuery.select(tipoForm)[i].checked = true;
                else
                    Ext.DomQuery.select(tipoForm)[i].checked = false;
            }
            window.print();
        });
        me.on('mouseout', function () {
            window.setTimeout(4000);
            if (Ext.DomQuery.select('.x-form-checkbox')[0].type == "checkbox") {
                var tipoForm = '.x-form-checkbox';
                var totalCheckboxes = Ext.DomQuery.select(tipoForm).length;
                for (i = 0; i < totalCheckboxes; i++) {
                    Ext.DomQuery.select(tipoForm)[i].type = "button";
                }
                tipoForm = '.x-form-radio';
                var totalRadio = Ext.DomQuery.select(tipoForm).length;
                for (i = 0; i < totalRadio; i++) {
                    Ext.DomQuery.select(tipoForm)[i].type = "button";
                }
            }
        });
        me.callParent(arguments);
    }
});