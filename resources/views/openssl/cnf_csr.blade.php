[req]
distinguished_name = req_dn
req_extensions = req_exts

[req_dn]
commonName = CN
commonName_default = $1
organizationalUnitName = OU
organizationalUnitName_default =
organizationName = O
organizationName_default =
localityName = L
localityName_default =
stateOrProvinceName = SP
stateOrProvinceName_default =
countryName = C
countryName_default =

[req_exts]
basicConstraints = CA:FALSE
subjectKeyIdentifier = hash
keyUsage = critical, digitalSignature, keyEncipherment
extendedKeyUsage = critical, serverAuth, clientAuth
#subjectAltName = @alt_names

[alt_names]
DNS.0 = {{ $common_name }}
@foreach ($sans as $san)
DNS.{{ $loop->index + 1 }} = {{ $san['value'] }}
@endforeach