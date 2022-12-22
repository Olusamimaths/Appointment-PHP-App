<?php
include_once 'IRequest.php';

class Request implements IRequest
{
  function __construct()
  {
    $this->bootstrapSelf();
  }

  private function bootstrapSelf()
  {
    foreach($_SERVER as $key => $value)
    {
      $this->{$this->toCamelCase($key)} = $value;
    }
  }

  private function toCamelCase($string)
  {
    $result = strtolower($string);
        
    preg_match_all('/_[a-z]/', $result, $matches);

    foreach($matches[0] as $match)
    {
        $c = str_replace('_', '', strtoupper($match));
        $result = str_replace($match, $c, $result);
    }

    return $result;
  }

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
