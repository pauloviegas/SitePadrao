<?php

class PermissaoModel extends abstractModel
{

    protected $_table = 'usu_permissao';

    public function __construct()
    {

        parent::__construct();
    }
    
    public function atualizarPermissao($idGrupo, $idAcao)
    {
        $acao = $this->recupera(Array('id_grupo' => $idGrupo, 'id_acao' => $idAcao));
        if ($acao)
        {
            $retorno = $this->deletar($acao[0]->id);
        }
        else
        {
            $retorno = $this->inserir(Array('id_grupo' => $idGrupo, 'id_acao' => $idAcao));
        }
        return $retorno;
    }
}