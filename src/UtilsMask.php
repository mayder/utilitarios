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
    
}