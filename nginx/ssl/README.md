# Generate SSL certificates with openssl

Here you will generate SLL certificates for your NGINX server. This is not about
generating a self-signed certificate - you will generate both Root Certificate
Authority (RCA) and end-entity (server) certificates. RCA certificate will be
registered in the operating system's Root Certificate Store (RCS), so that any
additionally generated server certificates get automatically validated by the
browser without defining exceptions or importing them into operating system's
RCS.

Start with writing down your chosen password in `password.txt` file in case you
need to generate new server certificate using the same RCA later on.

**Step 1**: Create RCA certificate (3650 days means it will be valid for 10 years) and private key with your chosen password:

```console
openssl req -x509 -new -days 3650 -keyout root.key -out root.crt -config root.conf
```

**Step 2**: Create server certificate signing request:

```console
openssl req -nodes -new -keyout server.key -out server.csr -config server.conf
```

**Step 3**: Create server certificate and its private key (825 days is maximum allowed end-entity certificate validity), providing your chosen password:

```console
openssl x509 -sha256 -req -days 825 -in server.csr -CA root.crt -CAkey root.key -CAcreateserial -out server.crt -extfile server.conf -extensions x509_ext
```

**Step 4**: Register RCA certificate with MacOS RCS (System Keychain):

```console
sudo security add-trusted-cert -d -r trustRoot -k /Library/Keychains/System.keychain root.crt
```

## Adding new domains

If you need a certificate for an additional domain that's not supported by the
default configuration, edit `server.conf` file and add your domain to the bottom
of it. Then repeat steps 2 and 3 to generate a new server certificate. You won't
need to register it with the RCS, as the RCA certificate stays the same and is
already registered there.  Just make sure to restart NGINX so that it becomes
aware of the new server certificate.

You can also generate a new server certificate, using your own  configuration
file. In this case you can optionally reuse the existing RCA certificate and
execute only steps 2 and 3, adapting the commands to provide your own
configuration and output files.

## Browser specifics

### Firefox

1. Firefox maintains its own RCS and by default it won't use operating system's
RCS to validate a server certificate. In order to enable operating system's own
RCS in Firefox, open `about:config` and set `security.enterprise_roots.enabled`
configuration option to `true`.

2. If you regenerate RCA certificate, Firefox will refuse the new certificate
with `SEC_ERROR_BAD_SIGNATURE` error. In that case you will need to delete its
certificate database file named `cert9.db`. This file is located in the Firefox
profile directory, which you can find on `about:profiles` page. Make sure you
restart Firefox after deleting it.
