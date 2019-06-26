<?php


abstract class SharedMemory
{

    public static function save($key, $message)
    {
        //transforma a mensagem de array
        //para um string em formato de json
        $data_json = json_encode($message);
        //abre um espaço na memoria com o 
        //nome/chave passado como parametro
        $memory = shm_attach($key);
        //coloca na memoria aberta o nome da 
        //variavel e o valor 
        shm_put_var($memory, $key, $data_json);
        //fecha a memoria aberta
        shm_detach($memory);
    }

    public static function read($key)
    {
        //abre um espaço na memoria com o 
        //nome/chave passado como parametro
        $memory = shm_attach($key);
        //se houver uma variael naquela
        //memoria com aquele nome então:
        if (shm_has_var($memory, $key)) {
            //pega o valor da variavel
            $return = shm_get_var($memory, $key);
            //imprime já codificada em json
            echo $return;
            //e remove a variavel/valor da memoria
            shm_remove_var($memory, $key);
        }
        //fecha a memoria aberta
        shm_detach($memory);
    }
}
