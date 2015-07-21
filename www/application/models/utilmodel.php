<?php

class UtilModel extends CI_Model
{
    
    
    
    /**
     * Recupera os nomes de todas as linhas da tabela
     * @param String $table
     * @return Array 
     */
    public function descreverTabela($table)
    {
        
        $resultado = $this->db->query('describe ' . $table);
        $dados = $resultado->result_array();
        
        $colunas = Array();
        foreach ($dados as $dado)
        {
            
            array_push($colunas, $dado['Field']);
        }
        
        return $colunas;
    }
}