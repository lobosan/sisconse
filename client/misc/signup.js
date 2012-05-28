Ext.onReady(function () {

    Ext.get("nombre").focus();

    document.onkeypress = function (e) {
        var esIE = (document.all);
        tecla = (esIE) ? event.keyCode : e.which;
        if (tecla == 13) {
            onClick();
        }
    }

    function validate(field) {
        if (field === '') {
            return false;
        }
        return true;
    }

    function validateCedula(field) {
        if (field.length === 10) {
            return true;
        }
        return false;
    }

    function validateEmail(valor) {
        var filtro = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!filtro.test(valor)) {
            return false
        }
        return true;

    }


    var btn = Ext.get("submitBtn");
    btn.on({
        'click':{
            fn:onClick
        }
    });

    function onClick() {
        var nombreField = Ext.get("nombre");
        var nombre = nombreField.dom.value;

        var apellidoField = Ext.get("apellido");
        var apellido = apellidoField.dom.value;

        var cedulaField = Ext.get("cedula");
        var cedula = cedulaField.dom.value;

        var emailField = Ext.get("email");
        var email = emailField.dom.value;

        var dczField = Ext.get("dcz");
        var dcz = dczField.dom.value;

        var passwordField = Ext.get("password");
        var password = passwordField.dom.value;

        var vpasswordField = Ext.get("vpassword");
        var vpassword = vpasswordField.dom.value;

        if (validate(nombre) === false) {
            alert("Su nombre es requerido.");
            return;
        }

        if (validate(apellido) === false) {
            alert("Su apellido es requerido.");
            return;
        }

        if (validate(cedula) === false) {
            alert("Su número de cédula es requerido.");
            return;
        } else {
            if (validateCedula(cedula) === false) {
                alert("Su número de cédula debe tener 10 dígitos.");
                return;
            }
        }

        if (validate(email) === false) {
            alert("Su email de usuario es requerido.");
            return;
        } else {
            if (validateEmail(email) === false) {
                alert("Su dirección de email no es válida.");
                return;
            }
        }

        if (validate(dcz) === false) {
            alert("Seleccione una demarcación.");
            return;
        }

        if (validate(vpassword) === false || (password !== vpassword)) {
            alert("Las contraseñas no coinciden.");
            return;
        }

        Ext.Ajax.request({
            url:'services.php',
            params:{
                service:'signup',
                nombre:nombre,
                apellido:apellido,
                cedula:cedula,
                email:email,
                dcz:dcz,
                password:password,
                vpassword:vpassword
            },
            success:function (o) {
                if (typeof o == 'object') {
                    var d = Ext.decode(o.responseText);

                    if (typeof d == 'object') {
                        if (d.success == true) {
                            nombreField.dom.value = "";
                            apellidoField.dom.value = "";
                            cedulaField.dom.value = "";
                            emailField.dom.value = "";
                            dczField.dom.value = "";
                            passwordField.dom.value = "";
                            vpasswordField.dom.value = "";

                            alert('Su solicitud de registro ha sido enviada. \n\nUna vez que el Administrador active su cuenta tendrá acceso al sistema.');
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
            failure:function () {
                alert('Conexión perdida con el servidor.');
            }
        });
    }
});