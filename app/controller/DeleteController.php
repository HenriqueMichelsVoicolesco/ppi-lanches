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
        } catch (Error $e) {
            header('Location: ?pagina=error&id='. $e->getCode());
			exit;
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
        } catch (Error $e) {
            header('Location: ?pagina=error&id='. $e->getCode());
			exit;
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
        } catch (Error $e) {
            header('Location: ?pagina=error&id='. $e->getCode());
			exit;
        }
    }
}
