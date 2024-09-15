<?php

namespace App\Helpers;

use InvalidArgumentException;

class OpenSSL
{
    public static function createPrivateKey($passphrase = "", $keyLength = 4096, $keyType = OPENSSL_KEYTYPE_RSA, $digestAlgorithm = "sha512", $curveName = "prime256v1")
    {
        if (!self::validateKeyType($keyType)) {
            throw new InvalidArgumentException("Key type not supported: {$keyType}");
        }
        if (!self::validateDigestMethod($digestAlgorithm)) {
            throw new InvalidArgumentException("Digest algorithm not supported: {$digestAlgorithm}");
        }
        if (!self::validateCurveName($curveName)) {
            throw new InvalidArgumentException("Curve name not supported: {$curveName}");
        }

        //$cnf = view("openssl.cnf_default")->render();
        $keyConfig = [
            "digest_alg" => $digestAlgorithm,
            "private_key_bits" => (int)$keyLength,
            "private_key_type" => $keyType,
            "config" => storage_path("app/openssl/default.cnf")
        ];
        if (strlen($passphrase) > 0) {
            $keyConfig["encrypt_key"] = $passphrase;
        }
        $privateKeyRes = openssl_pkey_new($keyConfig);
        openssl_pkey_export($privateKeyRes, $privateKeyPEM, $passphrase, $keyConfig);
        $publicKeyPEM = openssl_pkey_get_details($privateKeyRes)["key"];
        return [
            "private" => $privateKeyPEM,
            "public" => $publicKeyPEM,
            "res" => $privateKeyRes
        ];
    }

    public static function getAvailableDigestMethods($aliases = false): array
    {
        return openssl_get_md_methods($aliases);
    }

    public static function validateDigestMethod($digest): bool
    {
        return in_array($digest, self::getAvailableDigestMethods(true));
    }

    public static function getAvailableCurveNames(): array
    {
        return openssl_get_curve_names();
    }

    public static function validateCurveName($curveName): bool
    {
        return in_array($curveName, self::getAvailableCurveNames());
    }

    public static function getAvailableKeyTypes(): array
    {
        return [
            0 => "RSA",
            1 => "DSA",
            2 => "DH",
            3 => "EC"
        ];
    }

    public static function validateKeyType($keyType): bool
    {
        return array_key_exists($keyType, self::getAvailableKeyTypes());
    }

    public static function createCSR($config, $privateKeyRes, $cn, $ou = null, $o = null, $l = null, $st = null, $c = null, $email = null)
    {
        $dn = [
            "commonName" => $cn
        ];
        if (!empty($ou)) $dn["organizationalUnitName"] = $ou;
        if (!empty($o)) $dn["organizationName"] = $o;
        if (!empty($l)) $dn["localityName"] = $l;
        if (!empty($st)) $dn["stateOrProvinceName"] = $st;
        if (!empty($c)) $dn["countryName"] = $c;
        if (!empty($email)) $dn["emailAddress"] = $email;

        $csrConfig = [
            "digest_alg" => "sha512",
            "req_extensions" => "req_exts",
            "config" => storage_path("app/openssl/{$config}.cnf")
        ];

        $csrRes = openssl_csr_new($dn, $privateKeyRes, $csrConfig);
        openssl_csr_export($csrRes, $csrPEM);
        return [
            "csr" => $csrPEM,
            "res" => $csrRes
        ];
    }

    public static function signCSR($config, $csrRes, $privateKeyRes, $days, $serial = 0, $caCertRes = null)
    {
        $signConfig = [
            "digest_alg" => "sha512",
            "x509_extensions" => "req_exts",
            "config" => storage_path("app/openssl/{$config}.cnf")
        ];

        $certRes = openssl_csr_sign($csrRes, $caCertRes, $privateKeyRes, $days, $signConfig, $serial);
        if (!$certRes) {
            //throw new Exception("Could not sign CSR!");
        }

        openssl_x509_export($certRes, $certificate);

        return [
            "pem" => $certificate,
            "res" => $certRes
        ];
    }
}
