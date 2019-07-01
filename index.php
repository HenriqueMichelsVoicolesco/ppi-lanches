<?php 
session_start();
date_default_timezone_set('America/Sao_Paulo');

require_once 'app/core/Core.php';

require_once 'app/controller/HomeController.php';
require_once 'app/controller/AdminController.php';
require_once 'app/controller/ErroController.php';
require_once 'app/controller/UpdateController.php';

require_once 'app/controller/CreateController.php';
require_once 'app/controller/ReadController.php';
require_once 'app/controller/UpdateController.php';
require_once 'app/controller/DeleteController.php';

require_once 'app/model/Login.php';
require_once 'app/model/Create.php';
require_once 'app/model/Read.php';
require_once 'app/model/Update.php';
require_once 'app/model/Delete.php';
require_once 'app/model/Error.php';

require_once 'lib/Connection.php';
require_once 'lib/Session.php';
require_once 'lib/SharedMemory.php';
require_once 'lib/Relatorio.php';

require_once 'vendor/autoload.php';

//pega o html base
$template = file_get_contents('app/template/base.html');

//abre uma região da memoria para executar e armazenar
//o que o usuario pedir, então após finalizar
//continua a execução do script
ob_start();

$core = new Core;
$core->start($_GET);

$saida = ob_get_contents();
ob_end_clean();

//se for setado um get com nome indice ajax e igual a sim
//entao ter dizer que é um json pro ajax
if(isset($_GET['ajax']) && $_GET['ajax'] == 'sim'){
    echo $saida;
//do contrario é para carregar uma pagina
} else {
    $templatePronto = str_replace('{{area_dinamica}}', $saida, $template);
    
    echo $templatePronto;
}

