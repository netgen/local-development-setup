# Generate server SSL certificate

Here you will generate SLL certificate for your server, together with Root
Certificate Authority certificate. You will register Root Certificate Authority
certificate in the operating system Root Certificate Store, so that any newly
generated server certificate gets automatically validated by the browser.

First write down your chosen password in `password.txt` in case you need to
regenerate server certificate later on.

**Step 1**: Create Root Certificate Authority certificate and its private key with your chosen password:

```bash
openssl req -x509 -new -keyout root.key -out root.crt -config root.conf
```

**Step 2**: Create server certificate signing request:

```bash
openssl req -nodes -new -keyout server.key -out server.csr -config server.conf
```

**Step 3**: Create server certificate (valid for 10 years) and its private key, providing your chosen password:

```bash
openssl x509 -sha256 -days 3650 -req -in server.csr -CA root.crt -CAkey root.key -CAcreateserial -out server.crt -extfile server.conf -extensions x509_ext
```

**Step 4**: Register Root Certificate Authority certificate with MacOS System Keychain:

```bash
sudo security add-trusted-cert -d -r trustRoot -k /Library/Keychains/System.keychain root.crt
```

## Adding new domains

If you need a certificate for a new domain not supported by the default
configuration, edit `server.conf` file and add your domain to the bottom of it.
Then repeat steps 2 and 3 to generate a new server certificate. You won't need
to register it with the certificate store, as the Root CA certificate stays the
same and is already registered there.  Just make sure to restart NGINX so that
it becomes aware of the server certificate change.

## Browser specifics

### Firefox

Firefox maintains its own Root Certificate Store and by default it will not
consider operating system Root Certificate Store when validating a server
certificate. In order to enable using operating system own Root Certificate
Store, open `about:config` and set `security.enterprise_roots.enabled`
configuration option to `true`.

If you regenerate Root Certificate Authority certificate, Firefox will refuse
the new certificate with `SEC_ERROR_BAD_SIGNATURE` error. In that case you will
need to delete its certificate database file named `cert9.db`. This file is
located in the Firefox profile directory, which you can find on `about:profiles`
page. Make sure you restart Firefox after deleting it.
