Ext.onReady(function () {
	
	Ext.get("field1").focus();
   
	document.onkeypress = function(e) {
		var esIE = (document.all);
		tecla = (esIE) ? event.keyCode : e.which;
		if(tecla==13){
			onClick();
		}
	}
   
	var btn = Ext.get('submitBtn');
	btn.on({
		'click': {
			fn: onClick
		}
	});

	function onClick() {
		var emailField = Ext.get("field1");
		var email = emailField.dom.value;

		if (validate(email) === false) {
			alert('Su email de usuario es requerido.');
			return;
		}

		Ext.Ajax.request({
			url: 'services.php',
			params: {
				service: 'forgotPassword',
				user: email
			},
			success: function (o) {
				if (typeof o == 'object') {
					var d = Ext.decode(o.responseText);

					if (typeof d == 'object') {
						if (d.success == true) {
							alert('Su contraseña ha sido enviada a su email.');
						} else {
							if (d.errors) {
								alert(d.errors[0].msg);
							} else {
								alert('Errores encontrados en el servidor.');
							}
						}
					}
				}
			},
			failure: function () {
				alert('Conexión perdida con el servidor.');
			}
		});
	}

	function validate(field) {
		if (field === '') {
			return false;
		}
		return true;
	}
});