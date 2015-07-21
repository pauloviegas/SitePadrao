<?php

class Usuario extends AdminController
{

    public function __construct()
    {

        parent::__construct();
    }

    public function index()
    {

        //Permissões
        $this->data['cadastrausuario'] = $this->viewgrupopaginaModel->verificaPermissao('admin/usuario/criar');
        $this->data['editarusuario'] = $this->viewgrupopaginaModel->verificaPermissao('admin/usuario/editar');
        $this->data['ativarusuario'] = $this->viewgrupopaginaModel->verificaPermissao('admin/usuario/ativo');
        $this->data['deletarusuario'] = $this->viewgrupopaginaModel->verificaPermissao('admin/usuario/deletar');

        //Avisos
        $this->data['sucesso'] = ($this->session->flashdata('sucesso')) ? $this->session->flashdata('sucesso') : FALSE;
        $this->data['noticia'] = ($this->session->flashdata('noticia')) ? $this->session->flashdata('noticia') : FALSE;
        $this->data['validacao'] = (validation_errors()) ? validation_errors() : FALSE;
        $this->data['erro'] = ($this->session->flashdata('erro')) ? $this->session->flashdata('erro') : FALSE;

        //Recuperação de Dados
        $this->data['usuarios'] = $this->usuarioModel->recuperaTodosOsUsuarios();

        //Redirecionamento
        $this->load->view('usuario/index', $this->data);
    }

    public function criar()
    {
        //Avisos
        $this->data['sucesso'] = ($this->session->flashdata('sucesso')) ? $this->session->flashdata('sucesso') : FALSE;
        $this->data['noticia'] = ($this->session->flashdata('noticia')) ? $this->session->flashdata('noticia') : FALSE;
        $this->data['validacao'] = (validation_errors()) ? validation_errors() : FALSE;
        $this->data['erro'] = ($this->session->flashdata('erro')) ? $this->session->flashdata('erro') : FALSE;

        //Recuperação de Dados
        $this->data['grupos'] = $this->grupoModel->recuperaTodosOsGrupos();

        //Redirecionamento
        $this->load->view('usuario/criar', $this->data);
    }

    public function editar($id = NULL)
    {
        //Permissões
        $this->data['trocargrupo'] = $this->viewgrupopaginaModel->verificaPermissao('admin/usuario/trocargrupo');
        $this->data['trocarSenhaOutrosUsuarios'] = $this->viewgrupopaginaModel->verificaPermissao('admin/usuario/trocarsenhausuario');

        //Avisos
        $this->data['sucesso'] = ($this->session->flashdata('sucesso')) ? $this->session->flashdata('sucesso') : FALSE;
        $this->data['noticia'] = ($this->session->flashdata('noticia')) ? $this->session->flashdata('noticia') : FALSE;
        $this->data['validacao'] = (validation_errors()) ? validation_errors() : FALSE;
        $this->data['erro'] = ($this->session->flashdata('erro')) ? $this->session->flashdata('erro') : FALSE;

        //Recuperação de Dados
        $newid = ($this->uri->segment(4)) ? $this->uri->segment(4) : ($id ? $id : $this->_request['idUsuario']);
        $this->data['usuario'] = $this->usuarioModel->recuperaUsuario($newid);
        $this->data['grupos'] = $this->grupoModel->recuperaTodosOsGrupos();

        //Redirecionamento
        $this->load->view('usuario/editar', $this->data);
    }

    public function inserir()
    {

        $this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('id_grupo', 'Grupo de Usuário', 'is_natural_no_zero');
        $this->form_validation->set_message('is_natural_no_zero', 'Você deve selecionar um grupo de usuário valido!');
        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email|is_unique[usu_usuario.email]');
        $this->form_validation->set_message('is_unique', 'O E-mail informado já foi cadastrado');
        $this->form_validation->set_rules('password', 'Senha', 'required|min_length[4]|max_length[12]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Repetir Senha', 'required|min_length[4]|max_length[12]');
        $this->form_validation->set_message('matches', 'As senhas não conferem!');

        if ($this->form_validation->run())
        {

            $dados = $this->_request;

            $dados['senha'] = sha1($dados['password']);
            $id = $this->usuarioModel->inserir($dados);
            if (isset($id))
            {

                $this->session->set_flashdata('sucesso', 'O Usuário '
                        . $dados['nome'] . ' inserido com sucesso!');
                redirect('admin/usuario/index');
            }
            else
            {

                $this->session->set_flashdata(
                        'erro', 'Ops... Ocorreu um erro ao inserir o usuário '
                        . $dados['nome'] . ', por favor tente novamente!');
                redirect('admin/usuario/criar');
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

        $this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('id_grupo', 'Grupo de Usuário', 'is_natural_no_zero');
        $this->form_validation->set_message('is_natural_no_zero', 'Você deve selecionar um grupo de usuário valido!');
        $this->form_validation->set_message('is_unique', 'O E-mail informado já foi cadastrado');

        if ($dados["senhaantiga"] != "" || $dados["novasenha1"] != "" || $dados["novasenha2"])
        {
            if ($dados["senhaantiga"] != "" && $dados["novasenha1"] != "" && $dados["novasenha2"])
            {
                if ($dados["senhaantiga"] == $this->data['user']->senha)
                {

                    $this->form_validation->set_rules('novasenha1', 'Nova Senha', 'min_length[4]|max_length[12]|matches[password3]');
                    $this->form_validation->set_rules('novasenha2', 'Repetir Nova Senha', 'min_length[4]|max_length[12]');
                    $this->form_validation->set_message('matches', 'As senhas não conferem!');
                }
            }
            else
            {

                $this->session->set_flashdata(
                        'erro', 'Ops... Vecê esqueceu de preencher um dos campos:'
                        . ' senha antiga, nova senha ou confirmação de nova senha,'
                        . ' por favor, preencha os três campos para efetuar a alteração'
                        . ' da sua senha!');
                redirect('admin/usuario/editar/' . $dados['id']);
            }
        }

        if ($this->form_validation->run())
        {

            $result = $this->usuarioModel->alterarUsuario($dados);
            if ($result)
            {

                $this->session->set_flashdata('sucesso', 'O Usuário '
                        . $dados['nome'] . ' foi alterado com sucesso!');
                redirect('admin/usuario/index');
            }
            else
            {

                $this->session->set_flashdata(
                        'erro', 'ocorreu um erro na alteração das informações do'
                        . ' usuário ' . $dados['nome'] . ', por favor'
                        . ', tente novamente!');
                redirect('admin/usuario/editar/' . $dados['id']);
            }
        }
        else
        {

            $this->editar($dados['id']);
        }
    }

    public function deletar()
    {
        $idUsuario = $this->_request["idUsuario"];
        $nomeUsuario = $this->_request["nomeUsuario"];
        
        if ($this->usuarioModel->deletarUsuario($idUsuario))
        {
            $usuario = $this->session->userdata('usuario');
            if ($idUsuario == $usuario->id)
            {
                $this->authModel->logout();
            }
            $this->session->set_flashdata('sucesso', 'Usuário '
                    . $nomeUsuario . ' excluido com sucesso!');
            redirect('admin/usuario/index');
        }
        else
        {
            $this->session->set_flashdata(
                    'erro', 'Ops... Ocorreu um erro e o Usuário '
                    . $nomeUsuario . ' não foi excluido com sucesso! Tente novamente.');
            redirect('admin/usuario/index');
        }
    }

}
