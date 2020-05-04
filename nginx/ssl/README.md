Create Certificate Authority certificate and private key:

```bash
openssl req -x509 -new -keyout root.key -out root.crt -config root.conf
```

Create server certificate signing request:

```
openssl req -nodes -new -keyout server.key -out server.csr -config server.conf
```

Create server certificate and private key:

```
openssl x509 -sha256 -days 3650 -req -in server.csr -CA root.crt -CAkey root.key -set_serial 123 -out server.crt -extfile server.conf -extensions x509_ext
```

Register Certificate Authority certificate with MacOS System Keychain:

```
sudo security add-trusted-cert -d -r trustRoot -k /Library/Keychains/System.keychain root.crt
```
