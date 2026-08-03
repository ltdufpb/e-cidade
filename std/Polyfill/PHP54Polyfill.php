<?php 
/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */
class PHP54Polyfill {

  public static function sendHTTPResponseCode($code = NULL) {

    if ($code !== NULL) {

      $text = match ($code) {
          100 => 'Continue',
          101 => 'Switching Protocols',
          200 => 'OK',
          201 => 'Created',
          202 => 'Accepted',
          203 => 'Non-Authoritative Information',
          204 => 'No Content',
          205 => 'Reset Content',
          206 => 'Partial Content',
          300 => 'Multiple Choices',
          301 => 'Moved Permanently',
          302 => 'Moved Temporarily',
          303 => 'See Other',
          304 => 'Not Modified',
          305 => 'Use Proxy',
          400 => 'Bad Request',
          401 => 'Unauthorized',
          402 => 'Payment Required',
          403 => 'Forbidden',
          404 => 'Not Found',
          405 => 'Method Not Allowed',
          406 => 'Not Acceptable',
          407 => 'Proxy Authentication Required',
          408 => 'Request Time-out',
          409 => 'Conflict',
          410 => 'Gone',
          411 => 'Length Required',
          412 => 'Precondition Failed',
          413 => 'Request Entity Too Large',
          414 => 'Request-URI Too Large',
          415 => 'Unsupported Media Type',
          500 => 'Internal Server Error',
          501 => 'Not Implemented',
          502 => 'Bad Gateway',
          503 => 'Service Unavailable',
          504 => 'Gateway Time-out',
          505 => 'HTTP Version not supported',
          default => ' ',
      };

      $protocol = ($_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.0');
      header($protocol . ' ' . $code . ' ' . $text);
      $GLOBALS['http_response_code'] = $code;

    } else {
      $code = ($GLOBALS['http_response_code'] ?? 200);
    }

    return $code;
  }

  public static function hex2bin($data) {

    static $old;
    if ($old === null) {
      $old = version_compare(PHP_VERSION, '5.2', '<');
    }
    $isobj = false;
    if (is_scalar($data) || (($isobj = is_object($data)) && method_exists($data, '__toString'))) {
      if ($isobj && $old) {
        ob_start();
        echo $data;
        $data = ob_get_clean();
      }
      else {
        $data = (string) $data;
      }
    }
    else {
      trigger_error(__FUNCTION__.'() expects parameter 1 to be string, ' . gettype($data) . ' given', E_USER_WARNING);
      return;//null in this case
    }
    $len = strlen($data);
    if ($len % 2) {
      trigger_error(__FUNCTION__.'(): Hexadecimal input string must have an even length', E_USER_WARNING);
      return false;
    }
    if (strspn($data, '0123456789abcdefABCDEF') != $len) {
      trigger_error(__FUNCTION__.'(): Input string must be hexadecimal string', E_USER_WARNING);
      return false;
    }
    return pack('H*', $data);
  }

}

