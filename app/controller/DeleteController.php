<?php

class DeleteController
{

    public function aluno($params)
    {

        try {

            Session::verificaLogin();

            $status = new Delete;
            $status = $status->deletarAluno($params);

            header("Location: ?pagina=read&metodo=usuarios&operacao=$status");
            exit;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function servidor($params)
    {

        try {

            Session::verificaLogin();

            $status = new Delete;
            $status = $status->deletarServidor($params);

            header("Location: ?pagina=read&metodo=usuarios&operacao=$status");
            exit;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function turma($params)
    {

        try {

            Session::verificaLogin();

            $status = new Delete;
            $status = $status->deletarTurma($params);

            header("Location: ?pagina=read&metodo=turmas&operacao=$status");
            exit;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
