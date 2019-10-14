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
class Utils {

    static function formataTelefone($numero) {
        $tam = strlen(preg_replace("/[^0-9]/", "", $numero));
        if ($tam == 13) { // COM CÓDIGO DE ÁREA NACIONAL E DO PAIS e 9 dígitos
            return "+" . substr($numero, 0, $tam - 11) . "(" . substr($numero, $tam - 11, 2) . ")" . substr($numero, $tam - 9, 5) . "-" . substr($numero, -4);
        }
        if ($tam == 12) { // COM CÓDIGO DE ÁREA NACIONAL E DO PAIS
            return "+" . substr($numero, 0, $tam - 10) . "(" . substr($numero, $tam - 10, 2) . ")" . substr($numero, $tam - 8, 4) . "-" . substr($numero, -4);
        }
        if ($tam == 11) { // COM CÓDIGO DE ÁREA NACIONAL e 9 dígitos
            return "(" . substr($numero, 0, 2) . ")" . substr($numero, 2, 5) . "-" . substr($numero, 7, 11);
        }
        if ($tam == 10) { // COM CÓDIGO DE ÁREA NACIONAL
            return "(" . substr($numero, 0, 2) . ")" . substr($numero, 2, 4) . "-" . substr($numero, 6, 10);
        }
        if ($tam <= 9) { // SEM CÓDIGO DE ÁREA
            return substr($numero, 0, $tam - 4) . "-" . substr($numero, -4);
        }
    }

    static function formataValor($valor) {
        if ($valor != 0 && $valor != null) {
            return 'R$ ' . number_format($valor, 2, ',', '.');
        }
        return "R$ 0,00";
    }
	
	static function formataValorDuasCasas($valor) {
        if ($valor != 0 && $valor != null) {
            return 'R$ ' . number_format($valor, 2, ',', '.');
        }
        return "R$ 0,0000";
    }

    static function formataValorQuatroCasas($valor) {
        if ($valor != 0 && $valor != null) {
            return 'R$ ' . number_format($valor, 4, ',', '.');
        }
        return "R$ 0,0000";
    }

    static function formataDecimalDuasCasas($valor) {
        if ($valor != 0 && $valor != null) {
            return number_format($valor, 2, ',', '.');
        }
        return "0,0000";
    }

    static function formataDecimalQuatroCasas($valor) {
        if ($valor != 0 && $valor != null) {
            return number_format($valor, 4, ',', '.');
        }
        return "0,0000";
    }

    static function getBrowser() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
                ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }

        return array(
            'userAgent' => $u_agent,
            'name' => $bname,
            'version' => $version,
            'platform' => $platform,
            'pattern' => $pattern
        );
    }

    static function curl_get_contents($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }

    static function sanitizeString($string) {

        // matriz de entrada
        $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç');

        // matriz de saída
        $by = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C');

        // devolver a string
        return str_replace($what, $by, $string);
    }

}
