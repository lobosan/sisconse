/*
 * File: app/view/FichaSenagua.js
 *
 * This file was generated by Ext Designer version 1.2.2.
 * http://www.sencha.com/products/designer/
 *
 * This file will be generated the first time you export.
 *
 * You should implement event handling and custom methods in this
 * class.
 */

Ext.define('usos.view.FichaSenagua', {
	extend: 'usos.view.ui.FichaSenagua',

	initComponent: function() {
		var me = this;

		Ext.define('Ficha', {
			extend: 'Ext.data.Model',
			fields: ['con_id', 'con_formulario', 'con_responsable_datos', 'con_fecha_toma_datos', 'dpa_provincia', 'dpa_canton', 'dpa_parroquia', 'pfastetter', 'hid_id',
				'cue_id', 'sub_id', 'mic_id', 'con_proceso', 'con_fecha_autoriz_ini', 'con_fecha_autoriz_fin', 'rio_autoriz_inicial_id', 'rio_autoriz_actual_id', 'rio_telefono', 'rio_celular', 'rio_email',
				'con_tarifa', 'con_fecha_pago_ini', 'con_fecha_pago_fin', 'con_observaciones', 'con_path', 'con_representante_junta', 'con_direccion',
				'con_telefonos', 'con_responsable_validacion', 'con_fecha_validacion', 'dom_consumo_humano_yn', 'ter_termales_yn', 'rie_riego_yn',
				'abr_abrevadero_yn', 'hid_hidrolectricas_yn', 'env_agua_envasada_yn', 'pis_piscicola_yn', 'tur_turistico_yn', 'mec_fuerza_mecanica_yn',
				'ind_industria_yn', 'otros_yn', 'dom_caudal_autorizado', 'dom_caudal_medido', 'dom_poblacion', 'dom_dotacion', 'pis_caudal_autorizado',
				'pis_caudal_medido', 'pis_truchas_yn', 'pis_truchas_anual', 'pis_tilapias_yn', 'pis_tilapias_anual', 'pis_camarones_yn', 'pis_camarones_anual',
				'pis_otros_yn', 'pis_otros_anual', 'pis_receptor', 'pis_cota', 'pis_latitud', 'pis_longitud', 'pis_impactos_yn', 'pis_estanques', 'pis_area_total',
				'env_caudal_autorizado', 'env_caudal_medido', 'env_anual', 'ter_caudal_autorizado', 'ter_caudal_medido', 'ter_dias', 'ter_volumen', 'ter_cota',
				'ter_latitud', 'ter_longitud', 'ind_caudal_autorizado', 'ind_caudal_medido', 'ind_uso', 'ind_receptor', 'ind_explotacion', 'rie_caudal_autorizado',
				'rie_caudal_medido', 'rie_estado_sistema_riego', 'rie_metodo_riego_gravedad', 'rie_metodo_riego_goteo', 'rie_metodo_riego_aspersion',
				'rie_metodo_riego_otros', 'rie_area', 'rie_tipo_cultivo1', 'rie_tipo_cultivo2', 'rie_nfamilias', 'rie_dotacion', 'rie_tipo_regante',
				'mec_caudal_autorizado', 'mec_caudal_medido', 'mec_potencia', 'mec_altura', 'abr_caudal_autorizado', 'abr_caudal_medido', 'abr_sem_vacuno',
				'abr_sem_porcino', 'abr_sem_caprino', 'abr_sem_aves', 'abr_sem_bovino', 'abr_sem_otros', 'hid_caudal_autorizado', 'hid_caudal_medido', 'hid_central',
				'hid_potencia', 'hid_altura', 'hid_receptor', 'hid_cota', 'hid_latitud', 'hid_longitud', 'nombre', 'tipo_fuente_quebrada', 'tipo_fuente_rio',
				'tipo_fuente_pozo', 'tipo_fuente_vertiente', 'tipo_fuente_lago', 'tipo_fuente_estero', 'tipo_fuente_drenajes', 'tipo_fuente_remanentes',
				'tipo_fuente_canales', 'tipo_fuente_otros', 'cota', 'latitud', 'longitud', 'sector', 'existe_captacion_yn', 'tipo_captacion_tanques',
				'tipo_captacion_tuberias', 'tipo_captacion_equipos', 'tipo_captacion_acequias', 'tipo_captacion_compuertas', 'tipo_captacion_ovalos',
				'tipo_captacion_diques', 'tipo_captacion_otros', 'metodo_medicion', 'estado_captacion', 'operacion_actual', 'anio_inicio', 'tenencia', 'propietario',
				'percepcion_contaminacion_yn', 'color_agua', 'olor_agua', 'cobertura_vegetal', 'flora', 'tipo_contaminacion', 'pot_nombre', 'pot_organizacion',
				'pot_poblacion', 'pot_anios', 'pot_dotacion', 'pot_cloracion_yn', 'pot_medidores_yn', 'pot_n_medidores', 'pot_tipo_almacenamiento', 'pot_tratamiento',
				'pot_abastecimiento', 'pot_volumen_reservas', 'pot_vida_util', 'pot_longitud', 'san_nombre', 'san_organizacion', 'san_tipo_descarga', 'san_caudal',
				'san_receptor', 'san_tratamiento', 'san_tipo_receptor', 'san_cota', 'san_latitud', 'san_longitud', 'san_tipo_alcantarillado', 'res_organizacion',
				'res_volumen', 'res_tipo_residuos', 'res_receptor', 'res_cota', 'res_latitud', 'res_longitud', 'ruta'
			],
			proxy: {
				type: 'ajax',
				url: 'server/loadform.php',
				reader: {
					type: 'json',
					root: 'data'
				}
			}
		});

		var numficha = Ext.urlDecode(window.location.search.substring());

		Ext.ModelMgr.getModel('Ficha').load(numficha, {
			success: function(numficha) {
				me.getForm().loadRecord(numficha);
			}
		});

		me.callParent(arguments);
	}
});