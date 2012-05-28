<?php
require_once '../../../common/server/conexion.php';
require_once '../../../common/server/libreriascomunes.php';

require_once '../legal/server/functions.php';
require_once '../legal/server/upload.php';

$sql = "SELECT dpa_parroquia, con_proceso, con_formulario FROM fichas WHERE con_id = ?";
$result = $db->getRecord($sql, $_GET['ficha']);

$ruta_fotos = '../../../../fotos/legales/' . $result['dpa_parroquia'] . '/' . $result['con_proceso'] . '/' . $result['con_formulario'];

if ($result['dpa_parroquia'] != '' AND $result['con_formulario'] != '' AND is_dir($ruta_fotos)) {
    $fotos = fileNamesFromDirectory($ruta_fotos);
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>sisconse</title>

		<script src="../legal/assets/prettyPhoto/js/jquery-1.6.1.min.js"></script>
		<link rel="stylesheet" type="text/css" href="../legal/assets/prettyPhoto/css/prettyPhoto.css" />
		<script src="../legal/assets/prettyPhoto/js/jquery.prettyPhoto.js"></script>

		<link rel="stylesheet" type="text/css" href="../../../common/ext-4.0.7/resources/css/ext-all.css"/>
		<link rel="stylesheet" type="text/css" href="../legal/assets/css/sisconse.css"/>
		<link rel="stylesheet" type="text/css" href="../legal/assets/css/impresion.css"/>
		<script type="text/javascript" src="../../../common/ext-4.0.7/bootstrap.js"></script>
		<script type="text/javascript" src="../../../common/ext-4.0.7/locale/ext-lang-es.js"></script>
		<script type="text/javascript" src="designer.js"></script>

		<script type="text/javascript">
			Ext.onReady(function() {
				$("a[rel^='prettyPhoto']").prettyPhoto();

				var galeria = $('#galeria');

				$('#Anexos-body').append(galeria);
				$('#galeria').removeClass('oculta');
			});
		</script>
	</head>

	<body >
		<div id="galeria" class="oculta" style="top: 15px !important;">
			<ul class="gallery clearfix">
                <?php muestra_croquis ($_GET['ficha']); ?>
				<?php if (isset ($fotos) AND $fotos != "") :
                    if (!is_dir($ruta_fotos . '/thumbnails/')) :
                        mkdir($ruta_fotos . '/thumbnails', 0777);
                    endif;
					foreach ($fotos as $foto) :
                        $thumbnail = '<li>
							<a href="' . $ruta_fotos . '/' . $foto . '" rel="prettyPhoto[gallery1]">';
                        if (!file_exists($ruta_fotos . '/thumbnails/' . $foto)) :
                            $params = array('size' => 80, 'file' => $ruta_fotos . '/thumbnails/' . $foto);
                            thumbnail_generator($ruta_fotos . '/'. $foto, $params);
                        endif;
                        $thumbnail .= '<img src="' . $ruta_fotos . '/thumbnails/' . $foto . '" width="80" height="60" />
                            </a>
						</li>';
                        echo $thumbnail;
					endforeach;
				endif; ?>
			</ul>
		</div>
	</body>
</html>