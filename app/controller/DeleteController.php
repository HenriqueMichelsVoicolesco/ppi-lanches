<?php

class DeleteController
{

    public function aluno($params)
    {

        try {

            Session::verificaLogin();

            Delete::deletarAluno($params);
            header('Location: ?pagina=admin&operacao=deletado');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function servidor($params)
    {

        try {

            Session::verificaLogin();

            Delete::deletarServidor($params);
            header('Location: ?pagina=admin&operacao=deletado');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function turma($params)
    {

        try {

            Session::verificaLogin();

            Delete::deletarTurma($params);
            header('Location: ?pagina=admin&operacao=deletado');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
