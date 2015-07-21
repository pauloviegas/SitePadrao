<?php

class serviceauth extends MY_Controller
{

    public function __construct()
    {

        parent::__construct();
    }

    public function index()
    {
        //Recuperar Dados
        $this->session->set_userdata('PaginasNaoPrecisaPermissao', $this->viewGrupoAcaoModel->gerarAcoesSemPermissao());
        
        //Avisos
        $this->data['sucesso'] = ($this->session->flashdata('sucesso')) ? $this->session->flashdata('sucesso') : FALSE;
        $this->data['noticia'] = ($this->session->flashdata('noticia')) ? $this->session->flashdata('noticia') : FALSE;
        $this->data['validacao'] = (validation_errors()) ? validation_errors() : FALSE;
        $this->data['erro'] = ($this->session->flashdata('erro')) ? $this->session->flashdata('erro') : FALSE;
        
        //Redirecionamento
        $this->load->view('admin/service_auth/index', $this->data);
    }

    public function logar()
    {
        
        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');
        $this->form_validation->set_rules('senha', 'Senha', 'required|min_length[4]|max_length[12]');
        
        if ($this->form_validation->run())
        {

            $login = $this->_request;
            if ($this->authModel->logar($login['email'], $login['senha']))
            {
                $this->session->set_flashdata('sucesso', 'Você foi logado com sucesso!!!');
                redirect('/admin/home/index');
            }
        }
        else
        {

            $this->index();
        }
    }

    public function logout()
    {

        if ($this->authModel->logout())
        {

            return redirect('admin/serviceauth/index');
        }
    }

}