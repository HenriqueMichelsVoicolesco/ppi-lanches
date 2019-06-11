<?php 
session_start();
date_default_timezone_set('America/Sao_Paulo');

require_once 'app/core/Core.php';
require_once 'app/controller/HomeController.php';
require_once 'app/controller/AdminController.php';
require_once 'app/controller/ErroController.php';
require_once 'app/controller/LoginController.php';
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

require_once 'lib/Connection.php';
require_once 'lib/Session.php';

require_once 'vendor/autoload.php';

$template = file_get_contents('app/template/base.html');

$teste = new HomeController;

ob_start();

$core = new Core;
$core->start($_GET);

$saida = ob_get_contents();
ob_end_clean();

$templatePronto = str_replace('{{area_dinamica}}', $saida, $template);

echo $templatePronto;
