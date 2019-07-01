<?php

class Core
{

	public function start($urlGet)
	{

		if (isset($urlGet['metodo'])) {
			$acao = $urlGet['metodo'];
		} else {
			$acao = 'index';
		}

		if (isset($urlGet['pagina'])) {
			$controller = ucfirst($urlGet['pagina'] . 'Controller');
		} else {
			$controller = 'HomeController';
		}

		if (isset($urlGet['id']) && $urlGet['id'] != null) {
			$id = $urlGet['id'];
		} else {
			$id = null;
		}

		if (!class_exists($controller) || !method_exists($controller, $acao)) {
			$controller = 'ErroController';
			$acao = 'index';
			$id = $urlGet['id'] ?? 404;
		}

		call_user_func_array(array(new $controller, $acao), array('id' => $id));
	}
}
