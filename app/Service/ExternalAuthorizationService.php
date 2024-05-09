<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Hyperf\Contract\StdoutLoggerInterface;
use Throwable;
use function Hyperf\Config\config;
use function Hyperf\Support\make;

class ExternalAuthorizationService implements ExternalAuthorizationServiceInterface
{
    const AUTHORIZED_MESSAGE = 'Autorizado';

    private string $providerUrl;

    public function __construct()
    {
        $this->providerUrl = config('external_authorizer_provider_url');
    }

    public function checkAuthorization(string $payerDocument, string $payeeDocument, float $value): bool
    {
        try {
            $response = $this->callExternalAuthorizer([
                'payer_document' => $payerDocument,
                'payee_document' => $payeeDocument,
                'value' => $value
            ]);

            return $response['message'] === self::AUTHORIZED_MESSAGE;
        } catch (Throwable $th) {
            make(StdoutLoggerInterface::class)->error($th->getMessage());

            return false;
        }
    }

    /**
     * @throws GuzzleException
     */
    private function callExternalAuthorizer($data): array
    {
        $client = make(Client::class);

        $response = $client->post($this->providerUrl, [
            RequestOptions::JSON => $data
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
