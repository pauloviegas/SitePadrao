<?php

class grupo extends AdminController {

    public function __construct() {

        parent::__construct();
        $this->load->model('grupoModel');
    }

    public function index() {

        //Permissões
        $this->data['cadastragrupousuario'] = $this->viewgrupopaginaModel->verificaPermissao('admin/grupo/criar');
        $this->data['editargrupousuario'] = $this->viewgrupopaginaModel->verificaPermissao('admin/grupo/editar');
        $this->data['permissaogrupousuario'] = $this->viewgrupopaginaModel->verificaPermissao('admin/grupo/permitir');
        $this->data['deletargrupousuario'] = $this->viewgrupopaginaModel->verificaPermissao('admin/grupo/deletar');

        //Avisos
        $this->data['sucesso'] = ($this->session->flashdata('sucesso')) ? $this->session->flashdata('sucesso') : FALSE;
        $this->data['noticia'] = ($this->session->flashdata('noticia')) ? $this->session->flashdata('noticia') : FALSE;
        $this->data['validacao'] = (validation_errors()) ? validation_errors() : FALSE;
        $this->data['erro'] = ($this->session->flashdata('erro')) ? $this->session->flashdata('erro') : FALSE;
        
        //Recuperação de Dados
        $this->data['grupos'] = $this->grupoModel->recuperaTodosOsGrupos();

        //Redirecionamento
        $this->load->view('admin/grupo/index', $this->data);
    }

    public function criar() {

        //Avisos
        $this->data['sucesso'] = ($this->session->flashdata('sucesso')) ? $this->session->flashdata('sucesso') : FALSE;
        $this->data['noticia'] = ($this->session->flashdata('noticia')) ? $this->session->flashdata('noticia') : FALSE;
        $this->data['validacao'] = (validation_errors()) ? validation_errors() : FALSE;
        $this->data['erro'] = ($this->session->flashdata('erro')) ? $this->session->flashdata('erro') : FALSE;

        //Redirecionamento
        $this->load->view('admin/grupo/criar', $this->data);
    }

    public function editar($id = NULL) {

        //Avisos
        $this->data['sucesso'] = ($this->session->flashdata('sucesso')) ? $this->session->flashdata('sucesso') : FALSE;
        $this->data['noticia'] = ($this->session->flashdata('noticia')) ? $this->session->flashdata('noticia') : FALSE;
        $this->data['validacao'] = (validation_errors()) ? validation_errors() : FALSE;
        $this->data['erro'] = ($this->session->flashdata('erro')) ? $this->session->flashdata('erro') : FALSE;

        //Recuperação de Dados
        $newid = ($this->uri->segment(4)) ? $this->uri->segment(4) : ($id ? $id : $this->_request['idGrupo']);
        $this->data['grupo'] = $this->grupoModel->RecuperaGrupoPorId($newid);

        //Redirecionamento
        $this->load->view('admin/grupo/editar', $this->data);
    }

    public function permitir($id = NULL) {

        //Avisos
        $this->data['sucesso'] = ($this->session->flashdata('sucesso')) ? $this->session->flashdata('sucesso') : FALSE;
        $this->data['noticia'] = ($this->session->flashdata('noticia')) ? $this->session->flashdata('noticia') : FALSE;
        $this->data['validacao'] = (validation_errors()) ? validation_errors() : FALSE;
        $this->data['erro'] = ($this->session->flashdata('erro')) ? $this->session->flashdata('erro') : FALSE;

        //Recuperação de Dados
        $newid = ($this->uri->segment(4)) ? $this->uri->segment(4) : ($id ? $id : $this->_request['idGrupo']);
        $this->data['id'] = $newid;
        $this->data['nomeGrupo'] = $this->_request['nomeGrupo'];
        $this->data['paginas'] = $this->paginaModel->recuperaTodasAsPaginas();
        $this->data['permitidos'] = $this->permissaoModel->checados($newid);

        //Redirecionamento
        $this->load->view('admin/grupo/permissao', $this->data);
    }

    public function inserir() {

        $dados = $this->_request;
        $this->form_validation->set_rules('grupo', 'Grupo de Usuário', 'required');

        if ($this->form_validation->run()) {

            $result = $this->grupoModel->inserir($dados);
            if ($result) {

                $this->session->set_flashdata('sucesso', 'O Grupo de Usuário '
                        . $dados['grupo'] . ' foi inserido com sucesso!');
                redirect('admin/grupo/index');
            } else {

                $this->session->set_flashdata(
                        'erro', 'Ops... Ocorreu um erro e o Grupo de Usuário '
                        . $dados['grupo'] . ' não foi cadastrado com sucesso,'
                        . ' tente novamente!');
                redirect('admin/grupo/criar');
            }
        } else {

            $this->criar();
        }
    }

    public function alterar() {

        $dados = $this->_request;
        $this->form_validation->set_rules('grupo', 'Grupo de Usuário', 'required');

        if ($this->form_validation->run()) {

            $result = $this->grupoModel->alterarGrupo($dados);
            if ($result) {

                $this->session->set_flashdata(
                        'sucesso', 'O Grupo de Usuário ' . $dados['grupo'] .
                        ' foi alteradoo com sucesso!');
                redirect('admin/grupo/index');
            } else {

                $this->session->set_flashdata(
                        'erro', 'Ops... Ocorreu um erro e o Grupo de Usuário '
                        . $dados['grupo'] . ' não foi alterado com sucesso!'
                        . ' Tente novamente.');
                redirect('admin/grupo/editar/' . $dados['id']);
            }
        } else {

            $this->editar($dados['id']);
        }
    }

    public function atualizarPermissao() {

        $dados = $this->_request;

        $result = $this->permissaoModel->atualizarPermissao($dados);
        if ($result) {

            $resposta = Array('success' => true);
        } else {

            $resposta = Array('success' => false);
        }
        return print json_encode($resposta);
    }

    public function deletar() {

        $idGrupo = $this->_request['idGrupo'];
        $nomeGrupo = $this->_request['nomeGrupo'];

        if ($this->grupoModel->deletarGrupo($idGrupo)) {
            $this->session->set_flashdata('sucesso', 'O Grupo de Usuário '
                    . $nomeGrupo . ' foi excluido com sucesso!');
            redirect('admin/grupo/index');
        }
        else
        {
            $this->session->set_flashdata(
                    'erro', 'Ops... Ocorreu um erro e o Grupo de Usuário '
                    . $nomeGrupo . ' não foi excluido com sucesso! Tente novamente');
            redirect('admin/grupo/index');
        }
    }

}
