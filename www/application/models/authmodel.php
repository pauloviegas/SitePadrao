<?php

class AuthModel extends abstractModel
{

    /**
     * Carrega todos os métodos contidos na classe pai, bem como as Models (usuarioModel e VewPerfiAcaoModel), necessárias .
     * @param NULL
     * @author Paulo Viegas <pauloviegas93@gmail.com>
     * @return NULL
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model('ViewUsuarioGrupoModel');
    }

    /**
     * Realiza a autenticação do usuário no sistema, seguindo as seguintes regras:<br>
     * 1) A senha e o e-mail estejam corretos;<br>
     * 2) O usuário não esteja logicamente excluido;<br>
     * 3) O cadastro de usuário já tenha sido aprovado.<br><br>
     * São criadas duas sessions, que só serão destruidas quando o ususário fizer logout do sistema:<br>
     * 1 - usuario: Corresponde a todos os dados do usuário.<br>
     * 2 - permissoes: Corresponde a todas as permissoes dadas ao perfil deste usuário.
     * @param String $email corresponde ao email fornecido pelo unsuario;
     * @param String $senha corresponde a senha fornecida pelo unsuario;
     * @author Paulo Viegas <pauloviegas93@gmail.com>
     * @return Boolean Valor lógico, onde 1 corresponde a sucesso e 0 a erro.
     */
    public function logar($email, $senha)
    {
        $usuario = $this->ViewUsuarioGrupoModel->recupera(Array('senha' => sha1($senha), 'email' => $email));
        if (!$usuario)
        {
            $this->authModel->logout();
            $this->session->set_flashdata('erro', 'Usuário ou senha incorretos!!!');
            redirect('admin/serviceauth/index');
        }
        else
        {
            $permissoes = $this->viewGrupoAcaoModel->gerarAcaoComPermissao($usuario[0]->id_grupo);
            $this->session->set_userdata('usuario', $usuario[0]);
            $this->session->set_userdata('usuarioPaginasPermitidas', $permissoes);
            return TRUE;
        }
    }

    /**
     * Realiza o logout do usuario! Destruido as sessões de usuario e permissão.
     * @param NULL
     * @author Paulo Viegas <pauloviegas93@gmail.com>
     * @return Boolean TRUE para sucesso e FALSE para erro;
     */
    public function logout()
    {
        $usuario = $this->session->userdata('usuario');
        if ($usuario)
        {
            $this->session->unset_userdata('usuario');
            $this->session->unset_userdata('usuarioPaginasPermitidas');
            $this->session->unset_userdata('PaginasNaoPrecisaPermissao');
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Verifica se o usuário está logado, atraves da session usuario populada.
     * @param NULL
     * @author Paulo Viegas <pauloviegas93@gmail.com>
     * @return Boolean TRUE para logado e FALSE quando não existe usuário logado;
     */
    public function verificaLogin()
    {
        if ($this->session->userdata('usuario'))
        {
            return TRUE;
        }
        return FALSE;
    }

    public function getInfo($item)
    {

        if ($this->session->userdata($item))
        {

            return $this->session->userdata($item);
        }

        return FALSE;
    }

}
