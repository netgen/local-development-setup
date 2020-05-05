First write down your chosen password in `password.txt` in case you need to
regenerate server certificate later on.

**1. Create Root Certificate Authority certificate and its private key:**

```bash
openssl req -x509 -new -keyout root.key -out root.crt -config root.conf
```

**2. Create server certificate signing request:**

```bash
openssl req -nodes -new -keyout server.key -out server.csr -config server.conf
```

**3. Create server certificate (valid for 10 years) and its private key:**

```bash
openssl x509 -sha256 -days 3650 -req -in server.csr -CA root.crt -CAkey root.key -CAcreateserial -out server.crt -extfile server.conf -extensions x509_ext
```

**4. Register Root Certificate Authority certificate with MacOS System Keychain:**

```bash
sudo security add-trusted-cert -d -r trustRoot -k /Library/Keychains/System.keychain root.crt
```

## Browser specifics

### Firefox

Firefox maintains its own certificate store and by default it will not consider
operating system certificate store when validating a server certificate. In
order to enable using operating system certificate store, open `about:config`
and set `security.enterprise_roots.enabled` configuration option to `true`.
