<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace nagestao\utilitarios;

/**
 * Description of Utils
 *
 * @author breno.mayder
 */
class UtilsData
{

    static function beforeSaveData($data)
    {
        if ($data != null) {
            $data = str_replace('/', '-', $data);
            $data = date('Y-m-d', strtotime($data));
            return $data;
        } else {
            return null;
        }
    }

    static function beforeSaveDataHora($data)
    {
        if ($data != null) {
            $data = explode(" ", $data);
            $hora = $data[1];
            $data = str_replace('/', '-', $data[0]);
            $data = date('Y-m-d', strtotime($data));
            return $data . " " . $hora;
        } else {
            return null;
        }
    }

    static function afterFindData($data)
    {
        if ($data != null) {
            $data = str_replace('-', '/', $data);
            $data = date('d/m/Y', strtotime($data));
            return $data;
        } else {
            return null;
        }
    }

    static function formataDataSimpleseHoraMinutoSegundo($data)
    {
        if ($data != null) {
            $data = explode(" ", $data);
            if (isset($data[1])) {
                $hora = explode(".", $data[1]);
                $hora = " " . $hora[0];
            } else {
                $hora = "";
            }

            if (strstr($data[0], '-')) {
                $data = explode("-", $data[0]);
                return $data[2] . "/" . $data[1] . "/" . $data[0] . $hora;
            } else {
                return $data[0] . $hora;
            }
        } else {
            return null;
        }
    }

    static function formataDataSimplesSemHoraMinutoSegundo($data)
    {
        if ($data != null) {
            $data = explode(" ", $data);
            $hora = explode(".", $data[1]);
            $data = explode("-", $data[0]);
            return $data[2] . "/" . $data[1] . "/" . $data[0];
        } else {
            return null;
        }
    }

    static function dataPT($data)
    {
        //$dia_semana = date('w', strtotime($data));
        $data = explode(" ", $data);
        $data = explode("-", $data[0]);
        $meses = [1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'];
        //$semana = [0 => 'Domingo',1 => 'Segunda-Feira',2 => 'Terça-Feira',3 => 'Quarta-Feira',4 => 'Quinta-Feira',5 => 'Sexta-Feira',6 => 'Sábado'];        
        //$semana[$dia_semana].", ".
        return $data[2] . " de " . $meses[intval($data[1])] . " de " . $data[0];

        //        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        //        date_default_timezone_set('America/Sao_Paulo');
        //        return strftime('%A, %d de %B de %Y', strtotime($data));
    }

    static function diaSemana($dia)
    {
        $semana = [
            '0' => 'Domingo',
            '1' => 'Segunda',
            '2' => 'Terça',
            '3' => 'Quarta',
            '4' => 'Quinta',
            '5' => 'Sexta',
            '6' => 'Sábado'
        ];
        return $semana[$dia];
    }

    static function getMes($mes)
    {
        $meses = [
            '1' => 'Janeiro',
            '2' => 'Fevereiro',
            '3' => 'Março',
            '4' => 'Abril',
            '5' => 'Maio',
            '6' => 'Junho',
            '7' => 'Julho',
            '8' => 'Agosto',
            '9' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro'
        ];
        return $meses[$mes];
    }

    static function idade($data)
    {
        if ($data != null) {
            if (strstr($data, '-')) {
                list($ano, $mes, $dia) = explode('-', $data);
            } else {
                list($dia, $mes, $ano) = explode('/', $data);
            }
            $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);
            $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
            return $idade;
        } else {
            return null;
        }
    }
}
