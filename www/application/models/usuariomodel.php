<?php

class UsuarioModel extends abstractModel
{

    protected $_table = 'usu_usuario';

    public function __construct()
    {

        parent::__construct();
        $this->load->model('utilModel');
    }

    public function recuperaUsuarioPorEmail($email)
    {

        $query = $this->db->get_where($this->_table, Array('email' => $email));
        return $query->row();
    }

    public function recuperaTodosOsUsuarios()
    {

        $this->db->select('usu_usuario.id, id_grupo, grupo, nome, senha, email');
        $this->db->from('usu_usuario');
        $this->db->join('usu_grupo', 'usu_grupo.id = usu_usuario.id_grupo');
        $query = $this->db->get();

        return $query->result();
    }

    public function recuperaUsuario($id)
    {

        $query = $this->db->get_where($this->_table, Array('id' => $id));
        return $query->row();
    }

    private function getColunas()
    {

        return $this->utilModel->descreverTabela($this->_table);
    }

    public function inserir($dados)
    {

        foreach ($dados as $coluna => $value)
        {

            if (!in_array($coluna, $this->getColunas()))
            {

                unset($dados[$coluna]);
            }
        }

        $this->db->insert($this->_table, $dados);
        return $this->db->insert_id();
    }

    public function deletarUsuario($id)
    {

        $this->db->delete($this->_table, Array('id' => $id));
        return $this->db->affected_rows();
    }

    public function alterarUsuario($dados)
    {


        if ($dados['novasenha1'] != '')
        {

            $dados['senha'] = sha1($dados['novasenha1']);
        }
        else
        {

            $oldusuario = $this->recuperaUsuario($dados['id']);
            $dados['senha'] = $oldusuario->senha;
        }

        $this->db->update($this->_table, Array(
            'id_grupo' => $dados['id_grupo'],
            'nome' => $dados['nome'],
            'senha' => $dados['senha'],
            'email' => $dados['email']
                ), Array('id' => $dados['id']));
        
        $this->session->set_userdata('usuario', $this->recuperaUsuarioPorEmail($dados['email']));
        
        return $this->db->affected_rows();
    }

    public function alterarPerfil($dados)
    {


        if ($dados['password'] != '')
        {

            $dados['senha'] = sha1($dados['password']);
        }
        else
        {

            $oldusuario = $this->recuperaUsuario($dados['id']);
            $dados['senha'] = $oldusuario->senha;
        }

        if ($this->viewgrupopaginaModel->verificaPermissao('admin/usuario/trocarusuario'))
        {

            $this->db->update($this->_table, Array(
                'id_grupo' => $dados['id_grupo'],
                'nome' => $dados['nome'],
                'senha' => $dados['senha'],
                'email' => $dados['email']
                    ), Array('id' => $dados['id']));
            return $this->db->affected_rows();
        }
        else
        {

            $this->db->update($this->_table, Array(
                'nome' => $dados['nome'],
                'senha' => $dados['senha'],
                'email' => $dados['email'],
                'ativo' => $dados['gender']
                    ), Array('id' => $dados['id']));
            return $this->db->affected_rows();
        }
    }

    public function mudaSenha($dados)
    {

        $usuario = $this->recuperaUsuario($dados['id']);
        $dados['senha'] = sha1($dados['password']);

        if ($dados['senha'] != $usuario->senha)
        {

            $this->db->update($this->_table, Array('senha' => $dados['senha']), Array('id' => $dados['id']));
            return $this->db->affected_rows();
        }
        else
        {

            $this->session->set_flashdata('error', 'As senhas correspondem a mesma senha antiga!');
            redirect('admin/usuario/senha/' . $dados['id']);
        }
    }

}