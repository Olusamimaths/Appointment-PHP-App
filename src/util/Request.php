<?php
include_once 'IRequest.php';

class Request implements IRequest
{
  function __construct()
  {
    $this->phpSelf = $_SERVER['PHP_SELF'];
    $this->serverName = $_SERVER['SERVER_NAME'];
    $this->serverSoftware = $_SERVER['SERVER_SOFTWARE'];
    $this->serverProtocol = $_SERVER['SERVER_PROTOCOL'];
    $this->requestMethod = $_SERVER['REQUEST_METHOD'];
    $this->requestTime = $_SERVER['REQUEST_TIME'];
    $this->queryString = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : null;
    $this->documentRoot = $_SERVER['DOCUMENT_ROOT'];
    $this->https = isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : null;
    $this->remoteAddr = $_SERVER['REMOTE_ADDR'];
    $this->remoteHost = isset($_SERVER['REMOTE_HOST']) ? $_SERVER['REMOTE_HOST'] : null;
    $this->remotePort = $_SERVER['REMOTE_PORT'];
    $this->remoteUser = isset($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'] : null;
    $this->serverPort = $_SERVER['SERVER_PORT'];
    $this->requestUri = $_SERVER['REQUEST_URI'];
    $this->phpAuthDigest = isset($_SERVER['PHP_AUTH_DIGEST']) ? $_SERVER['PHP_AUTH_DIGEST'] : null;
    $this->phpAuthUser = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : null;
  }

  // private function bootstrapSelf()
  // {
  //   foreach($_SERVER as $key => $value)
  //   {
  //     $this->{$this->toCamelCase($key)} = $value;
  //   }
  // }

  // private function toCamelCase($string)
  // {
  //   $result = strtolower($string);
        
  //   preg_match_all('/_[a-z]/', $result, $matches);

  //   foreach($matches[0] as $match)
  //   {
  //       $c = str_replace('_', '', strtoupper($match));
  //       $result = str_replace($match, $c, $result);
  //   }

  //   return $result;
  // }

  public function getBody()
  {
    if($this->requestMethod === "GET" || $this->requestMethod === "DELETE")
    {
      return;
    }

    if ($this->requestMethod == "POST" || $this->requestMethod == "PUT")
    {
      // Takes raw data from the request
      $json = file_get_contents('php://input');
      $data = json_decode($json);
      return $data;
    }
  }
}
