<?php

class Erro
{

    public function retornarMensagem($id)
    {
        $mensagem = '';

        if ($id == 2002 || $id == 1049 || $id == 1045) {
            $mensagem = 'Não foi possível conectar com o banco de dados!';
        } else if ($id == 404) {
            $mensagem = 'Não foi possível encontrar a página solicitada!';
        } else {
            $mensagem = 'Erro inesperado!';
        }

        return $mensagem;
    }
}
