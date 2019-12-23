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
class UtilsFind {
    
    static function filtroTexto($query, $coluna, $valor) {
        if($valor!=null ) {
            return $query->andWhere(['like', $coluna, $valor]);
        } else {
            return $query;
        }
    }
    
    static function filtroValorExato($query, $coluna, $valor) {
        if($valor!=null ) {
            return $query->andWhere([$coluna => $valor]);
        } else {
            return $query;
        }
    }
    
    static function filtroTextoSemMascara($query, $coluna, $valor) {
        if($valor!=null ) {
            $valor = str_replace(['.', '-', '(', ')', ' ', '_', '/'], "", $valor);
            return $query->andWhere(['like', $coluna, $valor]);
        } else {
            return $query;
        }
    }
    
    static function filtroLista($query, $coluna, $valor) {
        if($valor!=null) {
            $lista = ['OR'];
            foreach ($valor as $cod){
                array_push($lista, [$coluna => $cod]);
            }
            return $query->andWhere($lista);
        } else {
            return $query;
        }
    }
    
    static function filtroData($query, $coluna, $valor) {
        if($valor!=null ) {
            $data = str_replace('/', '-', $valor);
            $data = date('Y-m-d', strtotime($data));
            return $query->andWhere([$coluna => $data]);
        } else {
            return $query;
        }
    }
    
    static function filtroDataMaior($query, $coluna, $valor) {
        if($valor!=null ) {
            $data = str_replace('/', '-', $valor);
            $data = date('Y-m-d', strtotime($data));
            return $query->andWhere(['>=', $coluna, $data]);
        } else {
            return $query;
        }
    }
    
    static function filtroDataMenor($query, $coluna, $valor) {
        if($valor!=null ) {
            $data = str_replace('/', '-', $valor);
            $data = date('Y-m-d', strtotime($data));
            return $query->andWhere(['<=', $coluna, $data]);
        } else {
            return $query;
        }
    }
    
    static function filtroPeriodo($query, $coluna, $valor, $formato = 'Y-m-d') {
        if($valor!=null ) {
            $data = explode(' - ', $valor);
            $data_inicio = str_replace('/', '-', $data[0]);
            $data_inicio = date($formato, strtotime($data_inicio));
            $data_fim = str_replace('/', '-', $data[1]);
            $data_fim = date($formato, strtotime($data_fim));
            // $data_fim = date('Y-m-d', strtotime("+1 days",strtotime($data_fim)));
            return $query->andWhere(['BETWEEN', $coluna, $data_inicio, $data_fim]);
        } else {
            return $query;
        }
    }
}