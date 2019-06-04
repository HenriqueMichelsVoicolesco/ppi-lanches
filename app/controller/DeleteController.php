<?php

class DeleteController
{

    public function aluno($params)
    {

        try {

            Delete::deletarAluno($params);
            header('Location: ?pagina=admin&operacao=deletado');

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function servidor($params)
    {

        try {

            Delete::deletarServidor($params);
            header('Location: ?pagina=admin&operacao=deletado');

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function turma($params)
    {
        var_dump($params);

        try {

            Delete::deletarTurma($params);
            header('Location: ?pagina=admin&operacao=deletado');

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
