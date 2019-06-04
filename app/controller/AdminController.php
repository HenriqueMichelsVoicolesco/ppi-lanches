<?php

class AdminController
{

    public function index()
    {

        try {

            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader);

            $variaveis = [];

            if (isset($_SESSION['nome'])) {
                $template = $twig->load('admin.html');

                $variaveis['dados'] = unserialize($_SESSION['nome']);
                $variaveis['operacao'] = isset($_GET['operacao']) ? $_GET['operacao'] : null;
            } else {
                $template = $twig->load('home.html');

                $variaveis['dados'] = 'erro';
            }

            $conteudo = $template->render($variaveis);

            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function login()
    {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        try {
            $status = Login::logar($email, $senha);

            if ($status) {
                header('Location: ?pagina=admin');
            } else {
                self::index();
            }
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        header('Location: ?pagina=home');
    }
}
