<?php

class Acao extends AdminController
{

    public function __construct()
    {

        parent::__construct();
        $this->load->model('acaoModel');
    }

    public function index()
    {
        //Permissões
        $this->data['adicionarAcao'] = $this->viewGrupoAcaoModel->verificaPermissao('admin/acao/criar');
        $this->data['editarAcao'] = $this->viewGrupoAcaoModel->verificaPermissao('admin/acao/editar');
        $this->data['deletarAcao'] = $this->viewGrupoAcaoModel->verificaPermissao('admin/acao/deletar');

        //Avisos
        $this->data['sucesso'] = ($this->session->flashdata('sucesso')) ? $this->session->flashdata('sucesso') : FALSE;
        $this->data['noticia'] = ($this->session->flashdata('noticia')) ? $this->session->flashdata('noticia') : FALSE;
        $this->data['validacao'] = (validation_errors()) ? validation_errors() : FALSE;
        $this->data['erro'] = ($this->session->flashdata('erro')) ? $this->session->flashdata('erro') : FALSE;

        //Recuperação de Dados
        $this->data['acoes'] = $this->acaoModel->recupera();
        //var_dump($this->acaoModel->recupera());
        //die();

        //Redirecionamento
        $this->load->view('admin/acao/index', $this->data);
    }

    public function criar()
    {
        //Avisos
        $this->data['sucesso'] = ($this->session->flashdata('sucesso')) ? $this->session->flashdata('sucesso') : FALSE;
        $this->data['noticia'] = ($this->session->flashdata('noticia')) ? $this->session->flashdata('noticia') : FALSE;
        $this->data['validacao'] = (validation_errors()) ? validation_errors() : FALSE;
        $this->data['erro'] = ($this->session->flashdata('erro')) ? $this->session->flashdata('erro') : FALSE;

        //Redirecionamento
        $this->load->view('admin/acao/criar', $this->data);
    }

    public function editar($id = NULL)
    {
        //Avisos
        $this->data['sucesso'] = ($this->session->flashdata('sucesso')) ? $this->session->flashdata('sucesso') : FALSE;
        $this->data['noticia'] = ($this->session->flashdata('noticia')) ? $this->session->flashdata('noticia') : FALSE;
        $this->data['validacao'] = (validation_errors()) ? validation_errors() : FALSE;
        $this->data['erro'] = ($this->session->flashdata('erro')) ? $this->session->flashdata('erro') : FALSE;

        //Recuperação de Dados
        $newid = ($this->uri->segment(4)) ? $this->uri->segment(4) : ($id ? $id : $this->_request['idAcao']);
        $this->data['acao'] = $this->acaoModel->recupera(Array('id' => $newid));

        //Redirecionamento
        $this->load->view('admin/acao/editar', $this->data);
    }

    public function inserir()
    {

        $dados = $this->_request;

        $this->form_validation->set_rules('modulo', 'Módulo', 'required');
        $this->form_validation->set_rules('controller', 'Controller', 'required');
        $this->form_validation->set_rules('action', 'Action', 'required');
        $this->form_validation->set_rules('alias_controller', 'Apelido Para o Controller', 'required');
        $this->form_validation->set_rules('alias_action', 'Apelido Para a Action', 'required');

        if ($this->form_validation->run())
        {

            $result = $this->acaoModel->inserir($dados);
            if ($result)
            {

                $this->session->set_flashdata('sucesso', 'A Ação do Sistema foi'
                        . ' inserida com sucesso!');
                redirect('admin/acao/index');
            }
            else
            {

                $this->session->set_flashdata(
                        'erro', 'Ops... Ocorreu um erro e a Ação do Sistema não'
                        . ' foi inserida! Por favor, tente mais novamente.');
                redirect('admin/acao/criar');
            }
        }
        else
        {

            $this->criar();
        }
    }

    public function alterar()
    {

        $dados = $this->_request;

        $this->form_validation->set_rules('modulo', 'Módulo', 'required');
        $this->form_validation->set_rules('controller', 'Controller', 'required');
        $this->form_validation->set_rules('action', 'Action', 'required');
        $this->form_validation->set_rules('alias_controller', 'Apelido Para o Controller', 'required');
        $this->form_validation->set_rules('alias_action', 'Apelido Para a Action', 'required');

        if ($this->form_validation->run())
        {

            $result = $this->acaoModel->alterar($dados);
            if ($result)
            {

                $this->session->set_flashdata('sucesso', 'A Ação do Sistema ('
                        . $dados['alias_action'] . ') foi alterada com sucesso!');
                redirect('admin/acao/index');
            }
            else
            {

                $this->session->set_flashdata(
                        'erro', 'Ops... Ocorreu um erro ao alterar a Ação do Sistema ('
                        . $dados['alias_action'] . '), por favor, tente novamente.');
                redirect('admin/acao/editar/' . $dados['id']);
            }
        }
        else
        {

            $this->editar();
        }
    }

    public function deletar()
    {

        $dados = $this->_request;

        if ($this->acaoModel->deletar($dados['idAcao']))
        {

            $this->session->set_flashdata('sucesso', 'A Ação do Sistema ('
                    . $dados['nomeAcao'] . ') foi excluida com sucesso!');
            redirect('admin/acao/index');
        }
        else
        {
            $this->session->set_flashdata(
                    'erro', 'Ops... Ocorreu um erro e a Ação do Sistema (' 
                    . $dados['nomeAcao'] . ') não foi excluida! Por vavor, tente novamente.');
            redirect('admin/acao/index');
        }
    }

}
