<?php

class padaweb
{
    
    /**
     * Recebe um data e retorna, o dia, o mes (em numeral, por extenso e 
     * abreviado) e o ano referente a essa dara.
     * @param String $data
     * @return Object 
     */
    public function retornaData($data)
    {
        
        $mes = new stdClass();
        
        $mes->dia = date('d', strtotime($data));
        $mes->mes = date('m', strtotime($data));
        $mes->ano = date('Y', strtotime($data));
        
        switch ($mes->mes)
        {
            case 1:
                $mes->nome_mes = 'Janeiro';
                $mes->nome_mes_abreviacao = 'Jan';
                break;
            case 2:
                $mes->nome_mes = 'Fevereiro';
                $mes->nome_mes_abreviacao = 'Fev';
                break;
            case 3:
                $mes->nome_mes = 'Março';
                $mes->nome_mes_abreviacao = 'Mar';
                break;
            case 4:
                $mes->nome_mes = 'Abril';
                $mes->nome_mes_abreviacao = 'Abr';
                break;
            case 5:
                $mes->nome_mes = 'Maio';
                $mes->nome_mes_abreviacao = 'Maio';
                break;
            case 6:
                $mes->nome_mes = 'Junho';
                $mes->nome_mes_abreviacao = 'Jun';
                break;
            case 7:
                $mes->nome_mes = 'Julho';
                $mes->nome_mes_abreviacao = 'Jul';
                break;
            case 8:
                $mes->nome_mes = 'Agosto';
                $mes->nome_mes_abreviacao = 'Ago';
                break;
            case 9:
                $mes->nome_mes = 'Setembro';
                $mes->nome_mes_abreviacao = 'Set';
                break;
            case 10:
                $mes->nome_mes = 'Outubro';
                $mes->nome_mes_abreviacao = 'Out';
                break;
            case 11:
                $mes->nome_mes = 'Novembro';
                $mes->nome_mes_abreviacao = 'Nov';
                break;
            case 12:
                $mes->nome_mes = 'Dezembro';
                $mes->nome_mes_abreviacao = 'Dez';
                break;
        }
        
        return $mes ? $mes : NULL;
    }

}