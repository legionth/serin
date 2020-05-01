<?php


namespace Legionth\Serin;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;

class SignatureFactory
{
    public function create($consumerSecret, $tokenSecret, $oAuthHeader, ServerRequestInterface $request)
    {
        $body = $request->getBody();
        $content = $body->getContents();
        $contentArray = explode('&', $content);

        $parameters = [];
        foreach ($contentArray as $value) {
            $keyValuePair = explode('=', $value);
            if  (count($keyValuePair) > 1) {
                $parameters[$keyValuePair[0]] = $keyValuePair[1];
            }
        }
        $collectParameters = array_merge($oAuthHeader, $request->getQueryParams());

        array_walk($collectParameters, function(&$key, &$value) {
            $key = rawurlencode($key);
            $value = rawurlencode($value);
        });

        $collectParameters = array_merge($collectParameters, $parameters);


        ksort($collectParameters);

        $collectedParametersString = '';

        foreach ($collectParameters as $key => $value) {
            if ($collectedParametersString !== '') {
                $collectedParametersString .= '&';
            }
            $collectedParametersString .= $key . '=' . $value;
        }

        $signatureBaseString = strtoupper($request->getMethod());
        $signatureBaseString .= '&';
        $signatureBaseString .= rawurlencode($request->getUri());
        $signatureBaseString .= '&';
        $signatureBaseString .= rawurlencode($collectedParametersString);

        $signingKey = rawurlencode($consumerSecret) . '&' . rawurlencode($tokenSecret);

        $signature = base64_encode(hash_hmac('sha1', $signatureBaseString, $signingKey, true));

        return $signature;
    }

}