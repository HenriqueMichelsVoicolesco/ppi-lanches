<?php

abstract class Relatorio
{
    public static function gerarTabela($dados, $nome_arquivo)
    {
        // Definimos o nome do arquivo que será exportado
        $arquivo = "$nome_arquivo.csv";

        // Configurações header para forçar o download
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/csv; charset=utf-8;");
        header("Content-Disposition: attachment; filename='$arquivo'");
        header("Content-Description: PHP Generated Data");
        
        //pega os indices do objeto pra serem a primeira linha
        //da planilha
        $titulos = array_keys(get_object_vars($dados[0]));
        
        //"cria" um arquivo para armazenar
        $fp = fopen('php://output', 'w');
        //adiciona a codificação correta dos caracteres
        fprintf($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));
        //printa a primeira linha da tabela
        fputcsv($fp, $titulos, ';');
        //itera cada posição do array e coloca no arquivo
        foreach ($dados as $line) {
            //coloca no arquivo aberto, com os valores 
            //do objeto separados por ;
            fputcsv($fp, get_object_vars($line), ';');
        }
        //fecha o arquivo
        fclose($fp);
        //fecha os headers
        exit;
    }
}
