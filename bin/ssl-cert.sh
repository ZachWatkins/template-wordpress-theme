#! /bin/bash
DOMAIN=localhost
NAME=${DOMAIN%.*}
workdir="$( dirname -- "$0"; )/ssl/";

# Remove existing files.
if [ -d $workdir ]; then
    rm -r ${workdir}
fi
mkdir ${workdir}

# Create root CA & Private key

MSYS_NO_PATHCONV=1 openssl req -x509 \
            -sha256 -days 356 \
            -nodes \
            -newkey rsa:2048 \
            -subj "/CN=${DOMAIN}/C=US/L=College Station" \
            -keyout ${workdir}rootCA.key -out ${workdir}rootCA.crt

# Generate Private key

openssl genrsa -out ${workdir}${NAME}.key 2048

# Create csf conf

cat > ${workdir}csr.conf <<EOF
[ req ]
default_bits = 2048
prompt = no
default_md = sha256
req_extensions = req_ext
distinguished_name = dn
[ dn ]
C = US
ST = Texas
L = College Station
O = NAME
OU = NAME DEVICE
CN = ${DOMAIN}
[ req_ext ]
subjectAltName = @alt_names
[ alt_names ]
DNS.1 = ${DOMAIN}
IP.1 = 127.0.0.1
EOF

# create CSR request using private key

openssl req -new -key ${workdir}${NAME}.key -out ${workdir}${NAME}.csr -config ${workdir}csr.conf

# Create a external config file for the certificate

cat > ${workdir}cert.conf <<EOF
authorityKeyIdentifier=keyid,issuer
basicConstraints=CA:FALSE
keyUsage = digitalSignature, nonRepudiation, keyEncipherment, dataEncipherment
subjectAltName = @alt_names
[alt_names]
DNS.1 = ${DOMAIN}
EOF

# Create SSl with self signed CA

openssl x509 -req \
    -in ${workdir}${NAME}.csr \
    -CA ${workdir}rootCA.crt -CAkey ${workdir}rootCA.key \
    -CAcreateserial -out ${workdir}${NAME}.crt \
    -days 365 \
    -sha256 -extfile ${workdir}cert.conf
sleep 10
