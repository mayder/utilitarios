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
class UtilsMask {
    
    static function beforeSaveRemoveMascara($valor) {
        if($valor!=null){
            $valor = str_replace(['.', '-', '(', ')', ' ', '_', '/'], "", $valor);
            return $valor;
        } else {
            return null;
        }
    }
    
    static function beforeSaveRemoveMascaraMoeda($valor) {
        if($valor!=null){
            $valor = str_replace('R$ ', '', $valor);
            $valor = str_replace('.', '', $valor);
            $valor = str_replace(',', '.', $valor);
            return $valor;
        } else {
            return null;
        }
    }
    
    static function afterFindMoeda($valor) {
        if($valor!=null){
            $valor = str_replace('.', ',', $valor);
            $valor = 'R$ '.$valor;
            return $valor;
        } else {
            return null;
        }
    }
    
    static function limpaPalavraChave($string) {
        $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ');
        $by = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'a', 'a', 'e', 'i', 'o', 'u', 'n', 'n', 'c', 'c', '-');
        $string = str_replace($what, $by, $string);
        $string = strtolower($string);
        return $string;
    }
    
    static function mascaraCPF($valor)
    {
        $valor = preg_replace("/\D/", '', $valor);
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $valor);
    }
    
    static function mascaraCNPJ($valor)
    {
        $valor = preg_replace("/\D/", '', $valor);
        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $valor);
    }
    
    static function mascaraTelefone($valor){
        $formatedPhone = preg_replace('/[^0-9]/', '', $valor);
        $matches = [];
        preg_match('/^([0-9]{2})([0-9]{4,5})([0-9]{4})$/', $formatedPhone, $matches);
        if ($matches) {
            return '('.$matches[1].') '.$matches[2].'-'.$matches[3];
        }
        return $valor;
    }
    
}