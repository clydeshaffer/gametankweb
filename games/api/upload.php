<?php
function generatePresignedUrl($spaceName, $region, $fileKey, $expiry = 900) {
    $key = getenv("SPACES_KEY");
    $secret = getenv("SPACES_SECRET");
    $host = "{$spaceName}.{$region}.digitaloceanspaces.com";
    $endpoint = "https://{$host}";
    $method = "PUT"; // For upload
    $contentType = "application/octet-stream"; // Change based on file type

    $algorithm = "AWS4-HMAC-SHA256";
    $service = "s3";
    $date = gmdate('Ymd');
    $timestamp = gmdate('Ymd\THis\Z');
    $credentialScope = "{$date}/{$region}/{$service}/aws4_request";

    $signedHeaders = "host";
    $canonicalQuery = http_build_query([
        'X-Amz-Algorithm' => $algorithm,
        'X-Amz-Credential' => "{$key}/{$credentialScope}",
        'X-Amz-Date' => $timestamp,
        'X-Amz-Expires' => $expiry,
        'X-Amz-SignedHeaders' => $signedHeaders,
    ], '', '&', PHP_QUERY_RFC3986);

    $canonicalRequest = implode("\n", [
        $method,
        "/{$fileKey}",
        $canonicalQuery,
        "host:{$host}\n",
        $signedHeaders,
        "UNSIGNED-PAYLOAD"
    ]);

    $stringToSign = implode("\n", [
        $algorithm,
        $timestamp,
        $credentialScope,
        hash('sha256', $canonicalRequest)
    ]);

    // Signing key
    function getSignatureKey($key, $date, $region, $service) {
        $kDate = hash_hmac('sha256', $date, "AWS4{$key}", true);
        $kRegion = hash_hmac('sha256', $region, $kDate, true);
        $kService = hash_hmac('sha256', $service, $kRegion, true);
        return hash_hmac('sha256', "aws4_request", $kService, true);
    }

    $signingKey = getSignatureKey($secret, $date, $region, $service);
    $signature = hash_hmac('sha256', $stringToSign, $signingKey);

    return "{$endpoint}/{$fileKey}?{$canonicalQuery}&X-Amz-Signature={$signature}";
}
?>