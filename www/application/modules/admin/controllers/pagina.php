<?php

class Pagina extends AdminController
{

    public function __construct()
    {

        parent::__construct();
    }

    public function index()
    {
        //Permissões
        $this->data['adicionarPagina'] = $this->viewgrupopaginaModel->verificaPermissao('admin/pagina/criar');
        $this->data['editarPagina'] = $this->viewgrupopaginaModel->verificaPermissao('admin/pagina/editar');
        $this->data['deletarPagina'] = $this->viewgrupopaginaModel->verificaPermissao('admin/pagina/deletar');

        //Avisos
        $this->data['sucesso'] = ($this->session->flashdata('sucesso')) ? $this->session->flashdata('sucesso') : FALSE;
        $this->data['noticia'] = ($this->session->flashdata('noticia')) ? $this->session->flashdata('noticia') : FALSE;
        $this->data['validacao'] = (validation_errors()) ? validation_errors() : FALSE;
        $this->data['erro'] = ($this->session->flashdata('erro')) ? $this->session->flashdata('erro') : FALSE;

        //Recuperação de Dados
        $this->data['paginas'] = $this->paginaModel->ListarTodasAsPaginas();

        //Redirecionamento
        $this->load->view('admin/pagina/index', $this->data);
    }

    public function criar()
    {
        //Avisos
        $this->data['sucesso'] = ($this->session->flashdata('sucesso')) ? $this->session->flashdata('sucesso') : FALSE;
        $this->data['noticia'] = ($this->session->flashdata('noticia')) ? $this->session->flashdata('noticia') : FALSE;
        $this->data['validacao'] = (validation_errors()) ? validation_errors() : FALSE;
        $this->data['erro'] = ($this->session->flashdata('erro')) ? $this->session->flashdata('erro') : FALSE;

        //Redirecionamento
        $this->load->view('admin/pagina/criar', $this->data);
    }

    public function editar($id = NULL)
    {
        //Avisos
        $this->data['sucesso'] = ($this->session->flashdata('sucesso')) ? $this->session->flashdata('sucesso') : FALSE;
        $this->data['noticia'] = ($this->session->flashdata('noticia')) ? $this->session->flashdata('noticia') : FALSE;
        $this->data['validacao'] = (validation_errors()) ? validation_errors() : FALSE;
        $this->data['erro'] = ($this->session->flashdata('erro')) ? $this->session->flashdata('erro') : FALSE;

        //Recuperação de Dados
        $newid = ($this->uri->segment(4)) ? $this->uri->segment(4) : ($id ? $id : $this->_request['idPagina']);
        $this->data['pagina'] = $this->paginaModel->recuperaPaginaPorId($newid);

        //Redirecionamento
        $this->load->view('admin/pagina/editar', $this->data);
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

            $result = $this->paginaModel->inserir($dados);
            if ($result)
            {

                $this->session->set_flashdata('sucesso', 'A Página do Sistema foi'
                        . ' inserida com sucesso!');
                redirect('admin/pagina/index');
            }
            else
            {

                $this->session->set_flashdata(
                        'erro', 'Ops... Ocorreu um erro e a Página do Sistema não'
                        . ' foi inserida! Por favor, tente mais novamente.');
                redirect('admin/pagina/criar');
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

            $result = $this->paginaModel->alterarPagina($dados);
            if ($result)
            {

                $this->session->set_flashdata('sucesso', 'A Página do Sistema ('
                        . $dados['alias_action'] . ') foi alterada com sucesso!');
                redirect('admin/pagina/index');
            }
            else
            {

                $this->session->set_flashdata(
                        'erro', 'Ops... Ocorreu um erro ao alterar a Página do Sistema ('
                        . $dados['alias_action'] . '), por favor, tente novamente.');
                redirect('admin/pagina/editar/' . $dados['id']);
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

        if ($this->paginaModel->deletarPagina($dados['idPagina']))
        {

            $this->session->set_flashdata('sucesso', 'A Página do Sistema ('
                    . $dados['nomePagina'] . ') foi excluida com sucesso!');
            redirect('admin/pagina/index');
        }
        else
        {
            $this->session->set_flashdata(
                    'erro', 'Ops... Ocorreu um erro e a Página do Sistema (' 
                    . $dados['nomePagina'] . ') não foi excluida! Por vavor, tente novamente.');
            redirect('admin/pagina/index');
        }
    }

}
