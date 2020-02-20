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
class UtilsData {
    
    static function beforeSaveData($data) {
        if($data!=null){
            $data = str_replace('/', '-', $data);
            $data = date('Y-m-d', strtotime($data));
            return $data;
        } else {
            return null;
        }
    }
    
    static function afterFindData($data) {
        if($data!=null){
            $data = str_replace('-', '/', $data);
            $data = date('d/m/Y', strtotime($data));
            return $data;
        } else {
            return null;
        }
    }
    
    static function formataDataSimpleseHoraMinutoSegundo($data) {
        if($data!=null){
            $data = explode(" ", $data);
            if(isset($data[1])){ $hora = explode(".", $data[1]); $hora = " ".$hora[0]; } else { $hora = ""; }
            
            if(strstr($data[0], '-')){
                $data = explode("-", $data[0]);
                return $data[2]."/".$data[1]."/".$data[0].$hora;
            } else {
                return $data[0].$hora;
            }
            
            
        } else {
            return null;
        }
    }
    
    static function formataDataSimplesSemHoraMinutoSegundo($data) {
        if($data!=null){
            $data = explode(" ", $data);
            $hora = explode(".", $data[1]);
            $data = explode("-", $data[0]);
            return $data[2]."/".$data[1]."/".$data[0];
        } else {
            return null;
        }
    }
	
	static function diaSemana($dia) {
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
    
    static function idade($data) {
        if($data!=null){
            if(strstr($data, '-')){
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