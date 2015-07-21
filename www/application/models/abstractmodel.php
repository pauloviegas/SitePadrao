<?php

class abstractModel extends CI_Model
{
    /**
     * @var String $_table variável abstrata que será sobrescrita nas classes filhas, representando a tabela na qual a model vai atuar.
     */
    protected $_table = "";

    /**
     * Carrega todos os métodos contidos na classe pai.
     * @param NULL
     * @author Paulo Viegas <pauloviegas93@gmail.com>
     * @return NULL
     */
    public function __construct()
    {

        parent::__construct();
    }

    /**
     * Busca no banco todas as colunas da tabela.
     * @param NULL
     * @author Paulo Viegas <pauloviegas93@gmail.com>
     * @return Array Os valores contidos no array correspondem as colunas da tabela.
     */
    public function descreverTabela()
    {

        $resultado = $this->db->query('describe ' . $this->_table);
        $dados = $resultado->result_array();

        $colunas = Array();
        foreach ($dados as $dado)
        {

            array_push($colunas, $dado['Field']);
        }

        return $colunas;
    }

    /**
     * Insere o log e em seguida insere um registro na tabela.
     * @param Array $dados contem as informações a serem inseridas;
     * @author Paulo Viegas <pauloviegas93@gmail.com>
     * @return Int Id do registro inserido;
     */
    public function inserir(Array $dados)
    {
        $colunasBanco = $this->descreverTabela();
        foreach ($dados as $coluna => $valor)
        {
            if (!in_array($coluna, $colunasBanco))
            {
                unset($dados[$coluna]);
            }
        }
        if ($this->db->insert($this->_table, $dados))
        {
            return $this->db->insert_id();
        }
        else
        {
            return 0;
        }
    }

    /**
     * Altera as informações da tabela setada na classe filha, atraves do id, caso não seja informado o segundo parâmetro, ou atraves do segundo parâmetro, caso este seja populado.<br>
     * <b>OBS:</b> No Array $dados deve estar contido o id a ser alterado, caso se deseje fazer a alteração pelo mesmo.
     * @param stdClass $dados Será convertido para Array e deve conter as informações a serem substitutas.
     * @param Array $parametroAlteracao A chave corresponde a coluna da tabela no banco e o valor da chave corresponde ao valor do filtro a ser usado na busca.
     * @author Paulo Viegas <pauloviegas93@gmail.com>
     * @return Boolean Valor lógico, onde 1 corresponde a sucesso e 0 a erro.
     */
    public function alterar(stdClass $dados, Array $parametroAlteracao = NULL)
    {
        $arrayDados = (Array) $dados;
        $colunasBanco = $this->descreverTabela();
        $novoDados = Array();
        if ($parametroAlteracao)
        {
            $where = $parametroAlteracao;
        }
        else
        {
            $where['id'] = $arrayDados['id'];
        }
        foreach ($arrayDados as $coluna => $valor)
        {
            if (in_array($coluna, $colunasBanco) && $coluna != 'id')
            {
                $novoDados[$coluna] = $valor;
            }
        }
        if (count($novoDados) > 0)
        {
            $dadosLog = Array(0 => $arrayDados, 1 => $novoDados);
            if ($this->db->update($this->_table, $novoDados, $where))
            {
                return $this->db->affected_rows();
            }
            else
            {
                return 0;
            }
        }
    }

    /**
     * Exclui logicamente (alterando para 0 o campo excluido do registro), ou fisicamente, um ou mais registros da tabela setada na classe filha, a partir de id, caso ele exista, ou a partir do segundo parâmetro, caso o id seja NULL e segundo parâmetro seja populado.<br>
     * <b>OBS 1:</b> Se houver mais de um registro que correspondam aos valores dos parâmetros de busca passados, todos serão excluidos.
     * <b>OBS 2:</b> Se os dois parâmetros forem setados os dois serão parâmetros para busca.
     * @param Int $id corresponde ao id linha a ser excluida;
     * @param Array $parametros A chave corresponde a coluna da tabela no banco e o valor da chave corresponde ao valor do filtro a ser usado na exclusao.
     * @author Paulo Viegas <pauloviegas93@gmail.com>
     * @return Boolean Valor lógico, onde 1 corresponde a sucesso e 0 a erro.
     */
    public function deletar($id = NULL, Array $parametros = NULL)
    {
        if ($id)
        {
            $parametros['id'] = $id;
        }
        $colunasBanco = $this->descreverTabela();
        $dados = $this->recuperaPorParametro(NULL, $parametros);
        if (in_array('excluido', $colunasBanco))
        {
            if ($this->db->update($this->_table, Array('excluido' => 1), $parametros))
            {
                return $this->db->affected_rows();
            }
            else
            {
                return 0;
            }
        }
        else
        {
            if ($this->db->delete($this->_table, $parametros))
            {
                return $this->db->affected_rows();
            }
            else
            {
                return 0;
            }
        }
    }

    /**
     * Recuperas todas as linas (da tabela setada na classe filha) que não estão logicamnete excuidas.
     * @param NULL
     * @author Paulo Viegas <pauloviegas93@gmail.com>
     * @return Array Todas as linhas da tabela;
     */
    public function recuperaTodos($parametro = NULL, $ordem = NULL, $excluido = NULL)
    {

        $colunasBanco = $this->descreverTabela();
        ($ordem && $parametro) ? $this->db->order_by($parametro, $ordem) : '';
        if (in_array('excluido', $colunasBanco) && !$excluido)
        {
            $query = $this->db->get_where($this->_table, Array('excluido' => 0));
        }
        else
        {
            $query = $this->db->get($this->_table);
        }

        return $query->result();
    }

    /**
     * Recuperas todas as linhas (da tabela setada na classe filha) por id, caso exista, ou a partir do segundo parâmetro, caso o id seja NULL e segundo parâmetro seja populado.
     * <b>OBS:</b> Caso sejam setados os dois parâmetros o id que será o parâmetro para busca.
     * @param Int $id corresponde ao id linha a ser recuperada;
     * @param Array $parametrosBusca a chave corresponde a coluna de busca e o valor corresponde ao valor usado como filtro de busca;
     * @author Paulo Viegas <pauloviegas93@gmail.com>
     * @return Array Todas as linhas afetadas pelo(s) parâmetro(s) de busca;
     */
    public function recuperaPorParametro($id = NULL, Array $parametrosBusca = NULL, Array $ordens = NULL)
    {
        if ($id)
        {
            $parametrosBusca = Array('id' => $id);
        }
        if (count($ordens) > 0)
        {
            foreach ($ordens as $coluna => $ordenacao)
            {
                $this->db->order_by($coluna, $ordenacao);
            }
        }
        $query = $this->db->get_where($this->_table, $parametrosBusca);
        return $query->result();
    }

    public function recuperaUrl()
    {
        $modulo = $this->uri->segment('1');
        $controller = $this->uri->segment('2');
        $action = $this->uri->segment('3');
        $acao = $modulo . '/' . $controller . '/' . $action;
        return $acao;
    }

}
