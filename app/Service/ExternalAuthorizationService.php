<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Hyperf\Contract\StdoutLoggerInterface;
use Throwable;
use function Hyperf\Support\make;

class ExternalAuthorizationService implements ExternalAuthorizationServiceInterface
{
    const AUTHORIZATION_URL = 'https://run.mocky.io/v3/5794d450-d2e2-4412-8131-73d0293ac1cc';
    const AUTHORIZED_MESSAGE = 'Autorizado';

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

    private function callExternalAuthorizer($data): array
    {
        $client = make(Client::class);

        $response = $client->post(self::AUTHORIZATION_URL, [
            RequestOptions::JSON => $data
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
