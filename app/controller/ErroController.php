<?php

class ErroController
{

	public function index($params)
	{

		$mensagemErro = new Erro;
		$mensagemErro = $mensagemErro->retornarMensagem($params);

		$loader = new \Twig\Loader\FilesystemLoader('app/view');
		$twig = new \Twig\Environment($loader);

		$variaveis = [];

		$template = $twig->load('erro.html');

		$variaveis['erro'] = $mensagemErro;

		$conteudo = $template->render($variaveis);

		echo $conteudo;
	}
}
