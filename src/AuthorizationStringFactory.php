<?php


namespace Legionth\Serin;


use Psr\Http\Message\ServerRequestInterface;

class AuthorizationStringFactory
{
    /**
     * @var SignatureFactory
     */
    private SignatureFactory $signatureFactory;

    public function __construct(SignatureFactory $signatureFactory)
    {
        $this->signatureFactory = $signatureFactory;
    }

    public function create(
        array $oAuthHeader,
        string $consumerSecret,
        string $tokenSecret,
        ServerRequestInterface $request
    ) {
        $signature = $this->signatureFactory->create(
            $consumerSecret,
            $tokenSecret,
            $oAuthHeader,
            $request
        );

        $oAuthHeader['oauth_signature'] = $signature;

        ksort($oAuthHeader);
        $dst = 'OAuth ';
        foreach ($oAuthHeader as $key => $value) {
            if ($dst !== 'OAuth ') {
                $dst .= ', ';
            }
            $dst .= rawurlencode($key) . '=' . '"' . rawurlencode($value) . '"';
        }

        return $dst;
    }
}