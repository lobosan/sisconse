<?php
    function getListDCZ()
    {
        require_once 'modules/common/server/conexion.php';
        $sql = "SELECT a.id_dcz, (SELECT b.nombre_dcz  FROM fic_dcz b WHERE b.id_dcz = substring(a.id_dcz from 1 for 2)) || ' - ' || a.nombre_dcz  nombre
            FROM fic_dcz a
            WHERE char_length(a.id_dcz) = 4
            ORDER BY id_dcz";
        $registro = $db->getRecords($sql);

        foreach ($registro as &$row) {
            echo '<option value="' . $row["id_dcz"] . '">' . $row["nombre"] . '</option>
        ';
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SENAGUA - Registro</title>

    <link rel="stylesheet" type="text/css" href="resources/css/login.css"/>
    <link rel="stylesheet" type="text/css" href="resources/css/signup.css"/>

    <script type="text/javascript" src="client/misc/ext-core.js"></script>
    <script type="text/javascript" src="client/misc/signup.js"></script>
</head>

<body>
<img id="login-background" src="resources/images/default/login/background.jpg" alt="logo-senagua"/>

<div id="signup-panel">
    <div class="signup-div">
        <div class="signup-container">
            <div id="login-logo"></div>
            <div class="signup-msg">
                Ingrese sus datos y espere que el Administrador active su cuenta.
            </div>
            <div class="signup-nombre">Nombre:</div>
            <div class="login-input signup-nombre-div">
                <input type="text" id="nombre" tabindex="1" spellcheck="false"/>
            </div>
            <div class="signup-apellido">Apellido:</div>
            <div class="login-input signup-apellido-div">
                <input type="text" id="apellido" tabindex="2" spellcheck="false"/>
            </div>
            <div class="signup-cedula">Cédula:</div>
            <div class="login-input signup-cedula-div">
                <input type="text" id="cedula" tabindex="3" spellcheck="false" maxlength="10"/>
            </div>
            <div class="signup-email">Email:</div>
            <div class="login-input signup-email-div">
                <input type="text" id="email" tabindex="4" spellcheck="false"/>
            </div>
            <div class="signup-dcz">Demarcación y Centro Zonal:</div>
            <div class="login-input signup-dcz-div">
                <select id="dcz" tabindex="5">
                    <option value =""></option>
                    <?php getListDCZ() ?>
                </select>
            </div>
            <div class="signup-password">Contraseña:</div>
            <div class="login-input signup-password-div">
                <input type="password" id="password" tabindex="6" spellcheck="false" maxlength="12"/>
            </div>
            <div class="signup-v-password">Verificar contraseña:</div>
            <div class="login-input signup-v-password-div">
                <input type="password" id="vpassword" tabindex="7" spellcheck="false" maxlength="12"/>
            </div>
            <div id="submitBtn" class="signup-send" tabindex="8"></div>
            <div class="signup-footer">
                <div class="login-division"></div>
                <div class="signup-back">
                    <a href="login.html" tabindex="9">Regresar al inicio de sesión</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>