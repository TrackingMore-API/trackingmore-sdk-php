<?php
namespace TrackingMore;

trait Request
{
    /**
     * @var string
     */
    private $apiBaseUrl = 'api.trackingmore.com';

    /**
     * @var int
     */
    private $apiPort = 443;

    /**
     * @var string
     */
    private $apiVersion = 'v4';

    /**
     * @var string
     */
    private $apiPath;

    /**
     * @var string
     */
    private $headerKey = 'Tracking-Api-Key';

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $params = [];

    /**
     * @var array
     */
    private $header = [];

    /**
     * @var int
     */
    private $timeout = 60;

    /**
     * @var boolean
     */
    private $isHeader = false;

    public function __construct($apiKey = '')
    {
        if (empty($apiKey)) {
            throw new TrackingMoreException('API Key is missing');
        }
        $this->setApiKey($apiKey);
    }

    /**
     * Sets the API key to be used for requests.
     *
     * @param string $apiKey
     */
    private function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * gets the header to be used for requests.
     *
     * @return array $header.
     */
    private function getRequestHeader()
    {
        $header = [
            'Accept: application/json',
            'Content-Type: application/json',
            $this->headerKey . ': ' . $this->apiKey,
        ];
        return $header;
    }

    /**
     * get the BaseUrl
     *
     * @param string $path
     * @return string The complete url.
     */
    private function getBaseUrl($path = '')
    {
        $port = $this->apiPort === 443 ? 'https' : 'http';
        $this->apiModule = $this->apiModule ? $this->apiModule . '/' : '';
        $url = $port . '://' . $this->apiBaseUrl . '/' . $this->apiVersion . '/' . $this->apiModule  . $path;
        return $url;
    }

    /**
     * send api request.
     *
     * @param array $params
     * @param string $method
     * @return mixed
     */
    public function sendApiRequest($params = [], $method = 'GET')
    {
        $this->url = $this->getBaseUrl($this->apiPath);
        $this->params = $params;
        $this->header = $this->getRequestHeader();
        return $this->send($method);
    }

    /**
     * send api request.
     *
     * @param string $method
     * @return mixed $response.
     */
    private function send($method){
        $method = strtoupper($method);
        if (!empty($this->params) && !is_string($this->params)) $this->params = json_encode($this->params);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        switch ($method) {
            case 'GET' :
                curl_setopt($curl, CURLOPT_HTTPGET, true);
                break;
            case 'POST' :
                curl_setopt($curl, CURLOPT_POST, true);
                break;
            default :
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
                break;
        }
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, $this->isHeader);
        if (!empty($this->params)) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->params);
            $this->header[] = 'Content-Length: ' . strlen($this->params);
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->header);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $response = curl_exec($curl);
        $err      = curl_error($curl);
        if ($err) {
            curl_close($curl);
            throw new TrackingMoreException("failed to request: $err");
        }
        curl_close($curl);
        return json_decode($response, true);
    }

}
