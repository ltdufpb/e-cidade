<?php


namespace App\Domain\Core\Base\Http\Response;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;

class DBJsonResponse extends JsonResponse
{
    /**
     * DBJsonResponse constructor.
     * @param null $data
     * @param string $message
     * @param int $status
     * @param bool $encode
     * @param array $headers
     * @param int $options
     */
    public function __construct($data = null, $message = '', $status = 200, $encode = true, $headers = [], $options = 0)
    {
        if ($encode) {
            $message = mb_convert_encoding($message, 'UTF-8', 'ISO-8859-1');
            $data = self::convertFromLatin1ToUTF8Recursively($data);
        }

        parent::__construct([
            'message' => $message,
            'error' => $this->statusCodeIsError($status),
            'data' => $data
        ], $status, $headers, $options);
    }

    /**
     * @param $statusCode
     * @return bool
     */
    private function statusCodeIsError($statusCode)
    {
        return $statusCode < 200 || $statusCode >= 300;
    }

    /**
     * Encode array from latin1 to utf8 recursively
     * @param $data
     * @return array|string
     */
    public static function convertFromLatin1ToUTF8Recursively($data)
    {
        if ($data instanceof Arrayable) {
            return $data = self::convertFromLatin1ToUTF8Recursively($data->toArray());
        } elseif (is_array($data)) {
            $ret = [];
            foreach ($data as $i => $d) {
                $ret[ $i ] = self::convertFromLatin1ToUTF8Recursively($d);
            }

            return $ret;
        } elseif (is_object($data)) {
            foreach ($data as $i => $d) {
                $data->$i = self::convertFromLatin1ToUTF8Recursively($d);
            }

            return $data;
        } else {
            if (!mb_detect_encoding((string) $data, 'utf-8', true)) {
                return mb_convert_encoding($data, 'UTF-8', 'ISO-8859-1');
            }
        }

        return $data;
    }
}
