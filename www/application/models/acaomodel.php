<?php

class acaoModel extends abstractModel
{

    /**
     * @var String $_table Nome da tabela no banco na qual este Model atua.
     */
    protected $_table = 'usu_acao';

    /**
     * Carrega todos os métodos contidos na classe pai.
     * @param NULL
     * @author Paulo Viegas <pauloviegas93@gmail.com>
     * @return NULL
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model('permissaoModel');
    }

    public function recuperaAcoesParaPermissao($idGrupo)
    {
        $permissoes = $this->recupera(Array('permissao' => 1));
        $permissoesGrupo = $this->permissaoModel->recupera(Array('id_grupo' => $idGrupo));
        $idPermissoesGrupo = Array();
        if (count($permissoesGrupo) > 0)
        {
            foreach ($permissoesGrupo as $permissaoGrupo)
            {
                $idPermissoesGrupo[] = $permissaoGrupo->id_acao;
            }
        }
        foreach ($permissoes as $permissao)
        {
            if (in_array($permissao->id, $idPermissoesGrupo))
            {
                $permissao->permitido = 1;
            }
            else
            {
                $permissao->permitido = 0;
            }
            $controllers[$permissao->alias_controller][] = $permissao;
        }

        return $controllers;
    }

}
