<?php

class viewGrupoAcaoModel extends abstractModel
{

    /**
     * @var String $_table Nome da tabela no banco na qual este Model atua.
     */
    protected $_table = 'view_grupo_acao';

    /**
     * Carrega todos os métodos contidos na classe pai.
     * @param NULL
     * @author Paulo Viegas <pauloviegas93@gmail.com>
     * @return NULL
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model('acaoModel');
    }

    public function gerarAcoesSemPermissao()
    {
        $Permissoes = $this->acaoModel->recuperaPorParametro(NULL, Array('permissao' => 0));
        foreach ($Permissoes as $Permissao)
        {
            $novoObjeto = new stdClass();
            $novoObjeto->acao = $Permissao->modulo . '/' . $Permissao->controller . '/' . $Permissao->action;
            $novoObjeto->alias_controller = $Permissao->alias_controller;
            $novoObjeto->alias_action = $Permissao->alias_action;
            $novoObjeto->permissao = $Permissao->permissao;
            $perm[] = $novoObjeto;
        }
        return $perm;
    }

    /**
     * Gera todas as ações que o perfil de usuário tem acesso.
     * @param $id_perfil Correspode ao id do perfil desse usuário.
     * @author Paulo Viegas <pauloviegas93@gmail.com>
     * @return Array Todas as permissões que o perfil do usuário tem e mais as ações que não precisam de permissão.
     */
    public function gerarAcaoComPermissao($idGrupo)
    {
        $permissoesGrupo = $this->recuperaPorParametro(NULL, Array('id_grupo' => $idGrupo));
        return $permissoesGrupo;
    }

    /**
     * Verifica se o usuário tem permissão para realizar uma ação passada por parâmetro ou (caso esta seja NULL) a que se encontra disposta na URL. 
     * @param String $acao Corresponde a um endereço de ação ou de página.
     * @author Paulo Viegas <pauloviegas93@gmail.com>
     * @return Boolean Valor lógico, TRUE se o usuário tiver permissão para realizar tal ação e FALSE se o usuário não tiver permissão para realizar tal ação.
     */
    public function verificaPermissao($acao = NULL)
    {
        $PaginasNaoPrecisaPermissao = $this->session->userdata('PaginasNaoPrecisaPermissao');
        $usuarioPaginasPermitidas = $this->session->userdata('usuarioPaginasPermitidas');
        $url = $this->recuperaUrl();
        $acaoAtual = ($acao != NULL) ? $acao : $url;
        foreach ($PaginasNaoPrecisaPermissao as $PaginaNaoPrecisaPermissao)
        {
            if ($PaginaNaoPrecisaPermissao->acao == $acaoAtual)
            {
                return TRUE;
            }
        }
        foreach ($usuarioPaginasPermitidas as $usuarioPaginaPermitida)
        {
            if ($usuarioPaginaPermitida->acao == $acaoAtual)
            {
                return TRUE;
            }
        }
        return FALSE;
    }

}
