<?php

class PermissaoModel extends abstractModel
{

    protected $_table = 'usu_permissao';

    public function __construct()
    {

        parent::__construct();
    }

    public function recuperaPermissaoPorIdGrupo($id)
    {

        $query = $this->db->get_where($this->_table, Array('id_grupo' => $id));
        return $query->result();
    }

    public function atualizarPermissao(Array $dados)
    {

       $query =  $this->db->get_where($this->_table, Array(
            'id_grupo' => $dados['idGrupo'],
            'id_pagina' => $dados['idPagina']));
        if ($query->num_rows())
        {

            $this->db->delete($this->_table, Array(
                'id_grupo' => $dados['idGrupo'],
                'id_pagina' => $dados['idPagina']));
            return $this->db->affected_rows();
        }
        else
        {
            
            $this->db->insert($this->_table, Array(
                'id_grupo' => $dados['idGrupo'],
                'id_pagina' => $dados['idPagina']));
            return $this->db->affected_rows();
        }
    }
    
    public function checados($id_grupo)
    {
        
        $this->db->select('id_pagina');
        $query = $this->db->get_where($this->_table, Array('id_grupo' => $id_grupo));
        $dados = $query->result();
        
        $newdado = Array();
        
        foreach ($dados as $dado)
        {
            
            $newdado[] = $dado->id_pagina;
        }
        
        return $newdado;
    }

}