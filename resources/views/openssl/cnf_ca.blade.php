[req]
distinguished_name = req_dn
req_extensions = req_exts
x509_extensions = v3_ca

[req_dn]
commonName = CN
commonName_default =
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
basicConstraints = CA:TRUE
subjectKeyIdentifier = hash
keyUsage = digitalSignature, keyEncipherment, keyCertSign
extendedKeyUsage = critical, clientAuth

[v3_ca]
subjectKeyIdentifier = hash
authorityKeyIdentifier = keyid:always,issuer:always
issuerAltName = issuer:copy

[ca]
default_ca = CA_default # The default ca section

[CA_default]
default_days = 375
default_md = sha256
preserve = yes
x509_extensions = v3_ca
email_in_dn = no
copy_extensions = copy
new_certs_dir = ./
database = ./certs.db
serial = ./serial.seq
policy = ca_policy

[ca_policy]
commonName = supplied
countryName = optional
stateOrProvinceName = optional
localityName = optional
organizationName = optional
organizationalUnitName = optional
emailAddress = optional