<?php

class grupoModel extends CI_Model
{

    public function __construct()
    {

        parent::__construct();
        $this->load->model('utilModel');
        $this->_table = 'usu_grupo';
    }
    
    public function pegarTabela()
    {
        return $this->_table;
    }

    public function recuperaTodosOsGrupos()
    {

        $query = $this->db->get($this->_table);
        return $query->result();
    }

    public function RecuperaGrupoPorId($id)
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

    public function deletarGrupo($id)
    {

        $this->db->delete($this->_table, Array('id' => $id));
        return $this->db->affected_rows();
    }

    public function alterarGrupo($dados)
    {

        $oldgrupo = $this->RecuperaGrupoPorId($dados['id']);

        if ($oldgrupo->grupo != $dados['grupo'])
        {

            $this->db->update($this->_table, Array(
                'grupo' => $dados['grupo']
                    ), Array('id' => $dados['id']));
            return $this->db->affected_rows();
        }
        else
        {

            $this->session->set_flashdata('error', 'Para realizar essa ação você precisa informar um nome diferente para o gupo de usuário!');
            redirect('admin/grupo/alterar/' . $dados['id']);
        }
    }

}