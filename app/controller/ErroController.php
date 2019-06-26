<?php

class ErroController
{

	public function index()
	{

		try {

			$loader = new \Twig\Loader\FilesystemLoader('app/view');
			$twig = new \Twig\Environment($loader);

			$variaveis = [];

			$template = $twig->load('erro.html');

			$conteudo = $template->render($variaveis);

			echo $conteudo;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}
