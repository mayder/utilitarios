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
            $hora = explode(".", $data[1]);
            $data = explode("-", $data[0]);
            return $data[2]."/".$data[1]."/".$data[0]." ".$hora[0];
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
    
}