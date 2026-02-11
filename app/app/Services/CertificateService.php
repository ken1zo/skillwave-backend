<?php

namespace App\Services;

use App\Models\Enrollment;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class CertificateService
{
    public function generate(Enrollment $enrollment): string
    {
        $baseUrl = rtrim(config('services.certificate.url'), '/');
        $response = Http::timeout(5)->post($baseUrl.'/get-series', [
            'enrollment_id' => $enrollment->id,
        ]);

        if (!$response->successful()) {
            throw new RuntimeException('Certificate API error.');
        }

        $payload = $response->json();
        $series = $payload['series'] ?? null;
        $checksum = $payload['checksum'] ?? null;

        if (!$series || !$checksum) {
            throw new RuntimeException('Certificate API invalid response.');
        }

        return sprintf('%s-%d-%s', $series, $enrollment->id, $checksum);
    }
}
