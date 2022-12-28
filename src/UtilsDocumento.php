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
class UtilsDocumento
{

    /**
     * isCpfValid
     *
     * Esta função testa se um cpf é valido ou não. 
     *
     * @author	Raoni Botelho Sporteman <raonibs@gmail.com>
     * @version	1.0 Debugada em 26/09/2011 no PHP 5.3.8
     * @param	string		$cpf			Guarda o cpf como ele foi digitado pelo cliente
     * @param	array		$num			Guarda apenas os números do cpf
     * @param	boolean		$isCpfValid		Guarda o retorno da função
     * @param	int			$multiplica 	Auxilia no Calculo dos Dígitos verificadores
     * @param	int			$soma			Auxilia no Calculo dos Dígitos verificadores
     * @param	int			$resto			Auxilia no Calculo dos Dígitos verificadores
     * @param	int			$dg				Dígito verificador
     * @return	boolean						"true" se o cpf é válido ou "false" caso o contrário
     *
     */
    public static function isCpfValid($cpf)
    {
        //Etapa 1: Cria um array com apenas os digitos numéricos, isso permite receber o cpf em diferentes formatos como "000.000.000-00", "00000000000", "000 000 000 00" etc...
        $j = 0;
        for ($i = 0; $i < (strlen($cpf)); $i++) {
            if (is_numeric($cpf[$i])) {
                $num[$j] = $cpf[$i];
                $j++;
            }
        }
        //Etapa 2: Conta os dígitos, um cpf válido possui 11 dígitos numéricos.
        if (count($num) != 11) {
            $isCpfValid = false;
        }
        //Etapa 3: Combinações como 00000000000 e 22222222222 embora não sejam cpfs reais resultariam em cpfs válidos após o calculo dos dígitos verificares e por isso precisam ser filtradas nesta parte.
        else {
            for ($i = 0; $i < 10; $i++) {
                if ($num[0] == $i && $num[1] == $i && $num[2] == $i && $num[3] == $i && $num[4] == $i && $num[5] == $i && $num[6] == $i && $num[7] == $i && $num[8] == $i) {
                    $isCpfValid = false;
                    break;
                }
            }
        }
        //Etapa 4: Calcula e compara o primeiro dígito verificador.
        if (!isset($isCpfValid)) {
            $j = 10;
            for ($i = 0; $i < 9; $i++) {
                $multiplica[$i] = $num[$i] * $j;
                $j--;
            }
            $soma = array_sum($multiplica);
            $resto = $soma % 11;
            if ($resto < 2) {
                $dg = 0;
            } else {
                $dg = 11 - $resto;
            }
            if ($dg != $num[9]) {
                $isCpfValid = false;
            }
        }
        //Etapa 5: Calcula e compara o segundo dígito verificador.
        if (!isset($isCpfValid)) {
            $j = 11;
            for ($i = 0; $i < 10; $i++) {
                $multiplica[$i] = $num[$i] * $j;
                $j--;
            }
            $soma = array_sum($multiplica);
            $resto = $soma % 11;
            if ($resto < 2) {
                $dg = 0;
            } else {
                $dg = 11 - $resto;
            }
            if ($dg != $num[10]) {
                $isCpfValid = false;
            } else {
                $isCpfValid = true;
            }
        }
        //Trecho usado para depurar erros.
        /*
          if($isCpfValid==true)
          {
          echo "<font color="GREEN">Cpf é Válido</font>";
          }
          if($isCpfValid==false)
          {
          echo "<font color="RED">Cpf Inválido</font>";
          }
         */
        //Etapa 6: Retorna o Resultado em um valor booleano.
        return $isCpfValid;
    }

    public static function isCnpjValid($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
        // Valida tamanho
        if (strlen($cnpj) != 14)
            return false;
        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
            return false;
        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }

    static function getBrowser()
    {
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

    static function curl_get_contents($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }

    static function sanitizeString($string)
    {

        // matriz de entrada
        $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç');

        // matriz de saída
        $by = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C');

        // devolver a string
        return str_replace($what, $by, $string);
    }
}
