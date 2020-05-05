First write down your chosen password in `password.txt` in case you need to
regenerate server certificate later on.

Create Certificate Authority certificate and its private key:

```bash
openssl req -x509 -new -keyout root.key -out root.crt -config root.conf
```

Create server certificate signing request:

```
openssl req -nodes -new -keyout server.key -out server.csr -config server.conf
```

Create server certificate (valid for 10 years) and its private key:

```
openssl x509 -sha256 -days 3650 -req -in server.csr -CA root.crt -CAkey root.key -set_serial 123 -out server.crt -extfile server.conf -extensions x509_ext
```

Register Certificate Authority certificate with MacOS System Keychain:

```
sudo security add-trusted-cert -d -r trustRoot -k /Library/Keychains/System.keychain root.crt
```

## Browser specifics

### Firefox

Firefox maintains its own certificate store and by default it will not consider
operating system certificate store when validating a server certificate. In
order to enable operating system certificate store, open `about:config` and
set `security.enterprise_roots.enabled` configuration option to `true`.

Additionally, when generating a new server certificate to replace existing one,
Firefox might refuse the new certificate with `SEC_ERROR_REUSED_ISSUER_AND_SERIAL`
error. If that happens open your profile location (found on `about:profiles`)
page and delete `cert9.db` file. This must be done while Firefox is closed.
