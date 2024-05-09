<?php

namespace App\Service;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Retry\Retry;
use Throwable;
use function Hyperf\Config\config;
use function Hyperf\Support\make;

class EmailService implements EmailServiceInterface
{
    private string $providerUrl;

    public function __construct()
    {
        $this->providerUrl = config('email_provider_url');
    }

    public function sendEmail(string $address, string $subject, string $body): bool
    {
        $succeeded = false;

        Retry::whenThrows(Exception::class)
            ->max(config('max_email_retries'))
            ->inSeconds(config('email_retry_interval'))
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

    /**
     * @throws GuzzleException
     */
    private function callEmailProvider(array $data)
    {
        $client = make(Client::class);

        $response = $client->post($this->providerUrl, [
            RequestOptions::JSON => $data
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
