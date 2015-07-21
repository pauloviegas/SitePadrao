<?php

class PaginaModel extends CI_Model
{

    private $_table = 'usu_paginas';

    public function __construct()
    {

        parent::__construct();
        $this->load->model('utilModel');
    }
    
    public function ListarTodasAsPaginas()
    {
        
        $query = $this->db->get($this->_table);
        return $query->result();
    }
    
    public function recuperaPaginaPorId($id)
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

    public function alterarPagina($integrante)
    {

        $this->db->update($this->_table, Array(
            'modulo' => $integrante['modulo'],
            'controller' => $integrante['controller'],
            'action' => $integrante['action'],
            'alias_controller' => $integrante['alias_controller'],
            'alias_action' => $integrante['alias_action'],
            'ativo' => $integrante['ativo']
        ), Array('id' => $integrante['id']));
        return $this->db->affected_rows();
    }

    public function verificaPaginaNecessitaPermissao()
    {

        $modulo = $this->uri->segment('1');
        $controller = $this->uri->segment('2');
        $action = $this->uri->segment('3');
        $query = $this->db->get_where($this->_table, Array(
            'modulo' => $modulo,
            'controller' => $controller,
            'action' => $action,
            'ativo' => '1'));
        return $query->num_rows();
    }

    public function recuperaTodasAsPaginas()
    {

        $query = $this->db->get_where($this->_table, Array('ativo' => '1'));
        $paginas = $query->result();

        $newcontrollers = Array();

        foreach ($paginas as $pagina)
        {

            $newcontrollers[$pagina->alias_controller] = Array ();
        }
        
        foreach ($paginas as $pagina)
        {
            
            if (key_exists($pagina->alias_controller, $newcontrollers))
            {
                
                $data = Array(
                    'id' => $pagina->id,
                    'action' => $pagina->alias_action
                );
                
                array_push($newcontrollers[$pagina->alias_controller], $data);
                unset($data);
            }
        }
        return $newcontrollers ? $newcontrollers : FALSE;
    }

    public function deletarPagina($id)
    {

        $this->db->delete($this->_table, Array('id' => $id));
        return $this->db->affected_rows();
    }

}