<?php

namespace App\Service;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Retry\Retry;
use Throwable;
use function Hyperf\Config\config;
use function Hyperf\Support\make;

class EmailService implements EmailServiceInterface
{
    const PROVIDER_URL = 'https://run.mocky.io/v3/54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6';

    public function sendEmail(string $address, string $subject, string $body): bool
    {
        $succeeded = false;

        Retry::whenThrows(Exception::class)
            ->max(config('max_email_retries'))
            ->fallback(function (Throwable $e) {
                make(StdoutLoggerInterface::class)->error($e->getMessage());
            })->call(function () use ($address, $subject, $body, &$succeeded) {
                $response = $this->callEmailProvider([
                    'address' => $address,
                    'subject' => $subject,
                    'body' => $body
                ]);

                $succeeded = $response['message'];
            });

        return $succeeded;
    }

    private function callEmailProvider(array $data)
    {
        $client = make(Client::class);

        $response = $client->post(self::PROVIDER_URL, [
            RequestOptions::JSON => $data
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
