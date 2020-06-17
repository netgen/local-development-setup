# Set up SSL certificates with `openssl`

Here you will generate SLL certificates for your NGINX server. This is not about
generating a self-signed certificate - you will generate both Root Certificate
Authority (RCA) and end-entity (server) certificates. RCA certificate will be
registered in the Operating System's Root Certificate Store (RCS), so that any
additionally generated server certificates get automatically validated by the
browser without defining exceptions or importing them into Operating System's
RCS.

## 1 Create installation directory

Execute on the command line:

```console
mkdir ~/ssl
```

## 2 Write down your chosen password

Write down your chosen password in `~/ssl/password.txt` file in case you need to
generate new server certificate using the same RCA later on.

## 3 Create RCA configuration

Create `~/ssl/root.conf` file with the following content:

```dosini
[req]
prompt=no
string_mask=default
default_bits=2048
distinguished_name=req_distinguished_name
x509_extensions=x509_ext

[req_distinguished_name]
countryName=hr
organizationName=Local
commonName=Local Development Root CA

[x509_ext]
basicConstraints=critical,CA:true,pathlen:0
keyUsage=critical,keyCertSign,cRLSign
```

## 4 Create server certificate configuration

Create `~/ssl/server.conf` file with the following content:

```dosini
[req]
prompt=no
string_mask=default
default_bits=2048
distinguished_name=req_distinguished_name
x509_extensions=x509_ext

[req_distinguished_name]
countryName=hr
organizationName=Local
commonName=Local Development

[x509_ext]
keyUsage=critical,digitalSignature,keyAgreement
subjectAltName=@alt_names

[alt_names]
DNS.1=home.php84
DNS.2=home.php83
DNS.3=home.php82
DNS.4=home.php81
DNS.5=home.php80
DNS.6=home.php74
DNS.7=home.php73
DNS.8=home.php72
DNS.9=home.php71
DNS.10=home.php70
DNS.11=home.php56
DNS.12=phpinfo.php84
DNS.13=phpinfo.php83
DNS.14=phpinfo.php82
DNS.15=phpinfo.php81
DNS.16=phpinfo.php80
DNS.17=phpinfo.php74
DNS.18=phpinfo.php73
DNS.19=phpinfo.php72
DNS.20=phpinfo.php71
DNS.21=phpinfo.php70
DNS.22=phpinfo.php56
DNS.23=*.dev.php84.ez
DNS.24=*.dev.php83.ez
DNS.25=*.dev.php82.ez
DNS.26=*.dev.php81.ez
DNS.27=*.dev.php80.ez
DNS.28=*.dev.php74.ez
DNS.29=*.dev.php73.ez
DNS.30=*.dev.php72.ez
DNS.31=*.dev.php71.ez
DNS.32=*.dev.php70.ez
DNS.33=*.dev.php56.ez
DNS.34=*.prod.php84.ez
DNS.35=*.prod.php83.ez
DNS.36=*.prod.php82.ez
DNS.37=*.prod.php81.ez
DNS.38=*.prod.php80.ez
DNS.39=*.prod.php74.ez
DNS.40=*.prod.php73.ez
DNS.41=*.prod.php72.ez
DNS.42=*.prod.php71.ez
DNS.43=*.prod.php70.ez
DNS.44=*.prod.php56.ez
DNS.45=*.dev.php84.sf
DNS.46=*.dev.php83.sf
DNS.47=*.dev.php82.sf
DNS.48=*.dev.php81.sf
DNS.49=*.dev.php80.sf
DNS.50=*.dev.php74.sf
DNS.51=*.dev.php73.sf
DNS.52=*.dev.php72.sf
DNS.53=*.dev.php71.sf
DNS.54=*.dev.php70.sf
DNS.55=*.dev.php56.sf
DNS.56=*.prod.php84.sf
DNS.57=*.prod.php83.sf
DNS.58=*.prod.php82.sf
DNS.59=*.prod.php81.sf
DNS.60=*.prod.php80.sf
DNS.61=*.prod.php74.sf
DNS.62=*.prod.php73.sf
DNS.63=*.prod.php72.sf
DNS.64=*.prod.php71.sf
DNS.65=*.prod.php70.sf
DNS.66=*.prod.php56.sf
```

## 5 Create RCA certificate and private key

**Note**: 3650 days means the certificate will be valid for 10 years.

When prompted, use the password you chose previously.

Execute on the command line:

```console
cd ~/ssl
sudo openssl req -x509 -new -days 3650 -keyout root.key -out root.crt -config root.conf
```

## 6 Create server certificate signing request

Execute on the command line:

```console
cd ~/ssl
sudo openssl req -nodes -new -keyout server.key -out server.csr -config server.conf
```

## 7 Create server certificate and its private key

**Note**: 825 days is maximum allowed end-entity certificate validity.

When prompted, use the password you chose previously.

Execute on the command line:

```console
cd ~/ssl
sudo openssl x509 -sha256 -req -days 825 -in server.csr -CA root.crt -CAkey root.key -CAcreateserial -out server.crt -extfile server.conf -extensions x509_ext
```

## 8 Register RCA certificate with the OS

### 8.1 If using `MacOS`

Register the created RCA with `MacOS` RCS (System Keychain), by executing on the
command line:

```console
cd ~/ssl
sudo security add-trusted-cert -d -r trustRoot -k /Library/Keychains/System.keychain root.crt
```

## 9 Configure Firefox to use OS RCS

If you are using Firefox, open `about:config` and set
`security.enterprise_roots.enabled` configuration option to `true`. This will
make Firefox use OS Root Certificate Store instead of its own implementation.

# Adding new domains

If you need a certificate for an additional domain that's not supported by the
default configuration, edit `server.conf` file and add your domain to the bottom
of it. Then repeat steps 2 and 3 to generate a new server certificate. You won't
need to register it with the RCS, as the RCA certificate stays the same and is
already registered there. Just make sure to restart NGINX so that it becomes
aware of the new server certificate.

You can also generate a new server certificate, using your own  configuration
file. In this case you can optionally reuse the existing RCA certificate and
execute only steps 2 and 3, adapting the commands to provide your own
configuration and output files.

# Browser specifics

## Chrome

If you generate a server certificate as valid for more than the agreed
limitation of 825 days, Chrome will react with `NET::ERR_CERT_VALIDITY_TOO_LONG`
error. The solution is to generate a new server certificate that respects the
agreed maximum validity time.

While this rule is valid in general, so far only Chrome has chosen to enforce
this rule.

## Firefox

1. Firefox maintains its own RCS and by default it won't use Operating System's
RCS to validate a server certificate. In order to enable Operating System's own
RCS in Firefox, open `about:config` and set `security.enterprise_roots.enabled`
configuration option to `true`.

2. If you regenerate both RCA and server certificates with the same
configuration, Firefox will refuse the new certificate with
`SEC_ERROR_BAD_SIGNATURE` error. This seems to be caused by caching and can be
solved by deleting its certificate database file named `cert9.db`. The file is
located in the Firefox profile directory, which you can find on `about:profiles`
page. Make sure you restart Firefox after deleting it.
