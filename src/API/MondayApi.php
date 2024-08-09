<?php

namespace RobinThijsen\LaravelMonday\API;

use ErrorException;

class MondayApi
{
    private $APIV2_Token;
    private $API_VERSION = "2024-04";
    private $API_Url = "https://api.monday.com/v2/";
    private $debug = false;
    public $error = '';

    const TYPE_QUERY = 'query';
    const TYPE_MUTAT = 'mutation';

    function __construct(Bool $debug = false)
    {
        $this->debug = $debug;
    }

    private function printDebug($print)
    {
        echo '<div style="background: #f9f9f9; padding: 20px; position: relative; border: solid 1px #dedede;">
        '.$print.'
        </div>';
    }

    public function setToken(Token $token)
    {
        $this->APIV2_Token = $token;
        return $this;
    }

    public function setVersion($version)
    {
        $this->API_VERSION = $version;
        return $this;
    }

    private function content($type, $request)
    {
        if($this->debug){
            $this->printDebug( $type.' { '.$request.' } ' );
        }
        return json_encode(['query' => $type.' { '.$request.' } ']);
    }

    protected function request($type = self::TYPE_QUERY, $request = null)
    {
        set_error_handler(
        /**
         * @throws ErrorException
         */ function ($severity, $message, $file, $line) {
                throw new ErrorException($message, $severity, $severity, $file, $line);
            }
        );

        try {
            $headers = [
                'Content-Type: application/json',
                'Authorization: ' . $this->APIV2_Token->getToken(),
                'API-Version: ' . $this->API_VERSION,
            ];

            $data = @file_get_contents($this->API_Url, false, stream_context_create([
                'http' => [
                    'method' => 'POST',
                    'header' => $headers,
                    'content' => $this->content($type, $request),
                ]
            ]));
            return $this->response($data);
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    protected function response($data)
    {
        if(!$data)
            return false;

        $json = json_decode($data, true);

        if( isset($json['data']) ){
            return $json['data'];
        }else if( isset($json['errors']) && is_array($json['errors']) ){
            return $json['errors'];
        }

        return false;
    }

    /**
     * @throws ErrorException
     */
    public function customQuery($query)
    {
        return $this->request(self::TYPE_QUERY, $query);
    }

    /**
     * @throws ErrorException
     */
    public function customMutator($query)
    {
        return $this->request(self::TYPE_MUTAT, $query);
    }
}
