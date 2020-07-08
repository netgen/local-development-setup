# Set up SSL certificates with OpenSSL

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
DNS.45=*.test.php84.ez
DNS.46=*.test.php83.ez
DNS.47=*.test.php82.ez
DNS.48=*.test.php81.ez
DNS.49=*.test.php80.ez
DNS.50=*.test.php74.ez
DNS.51=*.test.php73.ez
DNS.52=*.test.php72.ez
DNS.53=*.test.php71.ez
DNS.54=*.test.php70.ez
DNS.55=*.test.php56.ez
DNS.56=*.local.php84.ez
DNS.57=*.local.php83.ez
DNS.58=*.local.php82.ez
DNS.59=*.local.php81.ez
DNS.60=*.local.php80.ez
DNS.61=*.local.php74.ez
DNS.62=*.local.php73.ez
DNS.63=*.local.php72.ez
DNS.64=*.local.php71.ez
DNS.65=*.local.php70.ez
DNS.66=*.local.php56.ez
DNS.67=*.local_dev.php84.ez
DNS.68=*.local_dev.php83.ez
DNS.69=*.local_dev.php82.ez
DNS.70=*.local_dev.php81.ez
DNS.71=*.local_dev.php80.ez
DNS.72=*.local_dev.php74.ez
DNS.73=*.local_dev.php73.ez
DNS.74=*.local_dev.php72.ez
DNS.75=*.local_dev.php71.ez
DNS.76=*.local_dev.php70.ez
DNS.77=*.local_dev.php56.ez
DNS.78=*.local_prod.php84.ez
DNS.79=*.local_prod.php83.ez
DNS.80=*.local_prod.php82.ez
DNS.81=*.local_prod.php81.ez
DNS.82=*.local_prod.php80.ez
DNS.83=*.local_prod.php74.ez
DNS.84=*.local_prod.php73.ez
DNS.85=*.local_prod.php72.ez
DNS.86=*.local_prod.php71.ez
DNS.87=*.local_prod.php70.ez
DNS.88=*.local_prod.php56.ez
DNS.89=*.local_test.php84.ez
DNS.90=*.local_test.php83.ez
DNS.91=*.local_test.php82.ez
DNS.92=*.local_test.php81.ez
DNS.93=*.local_test.php80.ez
DNS.94=*.local_test.php74.ez
DNS.95=*.local_test.php73.ez
DNS.96=*.local_test.php72.ez
DNS.97=*.local_test.php71.ez
DNS.98=*.local_test.php70.ez
DNS.99=*.local_test.php56.ez
DNS.100=*.ng.php84.ez
DNS.101=*.ng.php83.ez
DNS.102=*.ng.php82.ez
DNS.103=*.ng.php81.ez
DNS.104=*.ng.php80.ez
DNS.105=*.ng.php74.ez
DNS.106=*.ng.php73.ez
DNS.107=*.ng.php72.ez
DNS.108=*.ng.php71.ez
DNS.109=*.ng.php70.ez
DNS.110=*.ng.php56.ez
DNS.111=*.ng_dev.php84.ez
DNS.112=*.ng_dev.php83.ez
DNS.113=*.ng_dev.php82.ez
DNS.114=*.ng_dev.php81.ez
DNS.115=*.ng_dev.php80.ez
DNS.116=*.ng_dev.php74.ez
DNS.117=*.ng_dev.php73.ez
DNS.118=*.ng_dev.php72.ez
DNS.119=*.ng_dev.php71.ez
DNS.120=*.ng_dev.php70.ez
DNS.121=*.ng_dev.php56.ez
DNS.122=*.ng_prod.php84.ez
DNS.123=*.ng_prod.php83.ez
DNS.124=*.ng_prod.php82.ez
DNS.125=*.ng_prod.php81.ez
DNS.126=*.ng_prod.php80.ez
DNS.127=*.ng_prod.php74.ez
DNS.128=*.ng_prod.php73.ez
DNS.129=*.ng_prod.php72.ez
DNS.130=*.ng_prod.php71.ez
DNS.131=*.ng_prod.php70.ez
DNS.132=*.ng_prod.php56.ez
DNS.133=*.ng_test.php84.ez
DNS.134=*.ng_test.php83.ez
DNS.135=*.ng_test.php82.ez
DNS.136=*.ng_test.php81.ez
DNS.137=*.ng_test.php80.ez
DNS.138=*.ng_test.php74.ez
DNS.139=*.ng_test.php73.ez
DNS.140=*.ng_test.php72.ez
DNS.141=*.ng_test.php71.ez
DNS.142=*.ng_test.php70.ez
DNS.143=*.ng_test.php56.ez
DNS.144=*.dev.php84.sf
DNS.145=*.dev.php83.sf
DNS.146=*.dev.php82.sf
DNS.147=*.dev.php81.sf
DNS.148=*.dev.php80.sf
DNS.149=*.dev.php74.sf
DNS.150=*.dev.php73.sf
DNS.151=*.dev.php72.sf
DNS.152=*.dev.php71.sf
DNS.153=*.dev.php70.sf
DNS.154=*.dev.php56.sf
DNS.155=*.prod.php84.sf
DNS.156=*.prod.php83.sf
DNS.157=*.prod.php82.sf
DNS.158=*.prod.php81.sf
DNS.159=*.prod.php80.sf
DNS.160=*.prod.php74.sf
DNS.161=*.prod.php73.sf
DNS.162=*.prod.php72.sf
DNS.163=*.prod.php71.sf
DNS.164=*.prod.php70.sf
DNS.165=*.prod.php56.sf
DNS.166=*.test.php84.sf
DNS.167=*.test.php83.sf
DNS.168=*.test.php82.sf
DNS.169=*.test.php81.sf
DNS.170=*.test.php80.sf
DNS.171=*.test.php74.sf
DNS.172=*.test.php73.sf
DNS.173=*.test.php72.sf
DNS.174=*.test.php71.sf
DNS.175=*.test.php70.sf
DNS.176=*.test.php56.sf
DNS.177=*.local.php84.sf
DNS.178=*.local.php83.sf
DNS.179=*.local.php82.sf
DNS.180=*.local.php81.sf
DNS.181=*.local.php80.sf
DNS.182=*.local.php74.sf
DNS.183=*.local.php73.sf
DNS.184=*.local.php72.sf
DNS.185=*.local.php71.sf
DNS.186=*.local.php70.sf
DNS.187=*.local.php56.sf
DNS.188=*.local_dev.php84.sf
DNS.189=*.local_dev.php83.sf
DNS.190=*.local_dev.php82.sf
DNS.191=*.local_dev.php81.sf
DNS.192=*.local_dev.php80.sf
DNS.193=*.local_dev.php74.sf
DNS.194=*.local_dev.php73.sf
DNS.195=*.local_dev.php72.sf
DNS.196=*.local_dev.php71.sf
DNS.197=*.local_dev.php70.sf
DNS.198=*.local_dev.php56.sf
DNS.199=*.local_prod.php84.sf
DNS.200=*.local_prod.php83.sf
DNS.201=*.local_prod.php82.sf
DNS.202=*.local_prod.php81.sf
DNS.203=*.local_prod.php80.sf
DNS.204=*.local_prod.php74.sf
DNS.205=*.local_prod.php73.sf
DNS.206=*.local_prod.php72.sf
DNS.207=*.local_prod.php71.sf
DNS.208=*.local_prod.php70.sf
DNS.209=*.local_prod.php56.sf
DNS.210=*.local_test.php84.sf
DNS.211=*.local_test.php83.sf
DNS.212=*.local_test.php82.sf
DNS.213=*.local_test.php81.sf
DNS.214=*.local_test.php80.sf
DNS.215=*.local_test.php74.sf
DNS.216=*.local_test.php73.sf
DNS.217=*.local_test.php72.sf
DNS.218=*.local_test.php71.sf
DNS.219=*.local_test.php70.sf
DNS.220=*.local_test.php56.sf
DNS.221=*.ng.php84.sf
DNS.222=*.ng.php83.sf
DNS.223=*.ng.php82.sf
DNS.224=*.ng.php81.sf
DNS.225=*.ng.php80.sf
DNS.226=*.ng.php74.sf
DNS.227=*.ng.php73.sf
DNS.228=*.ng.php72.sf
DNS.229=*.ng.php71.sf
DNS.230=*.ng.php70.sf
DNS.231=*.ng.php56.sf
DNS.232=*.ng_dev.php84.sf
DNS.233=*.ng_dev.php83.sf
DNS.234=*.ng_dev.php82.sf
DNS.235=*.ng_dev.php81.sf
DNS.236=*.ng_dev.php80.sf
DNS.237=*.ng_dev.php74.sf
DNS.238=*.ng_dev.php73.sf
DNS.239=*.ng_dev.php72.sf
DNS.240=*.ng_dev.php71.sf
DNS.241=*.ng_dev.php70.sf
DNS.242=*.ng_dev.php56.sf
DNS.243=*.ng_prod.php84.sf
DNS.244=*.ng_prod.php83.sf
DNS.245=*.ng_prod.php82.sf
DNS.246=*.ng_prod.php81.sf
DNS.247=*.ng_prod.php80.sf
DNS.248=*.ng_prod.php74.sf
DNS.249=*.ng_prod.php73.sf
DNS.250=*.ng_prod.php72.sf
DNS.251=*.ng_prod.php71.sf
DNS.252=*.ng_prod.php70.sf
DNS.253=*.ng_prod.php56.sf
DNS.254=*.ng_test.php84.sf
DNS.255=*.ng_test.php83.sf
DNS.256=*.ng_test.php82.sf
DNS.257=*.ng_test.php81.sf
DNS.258=*.ng_test.php80.sf
DNS.259=*.ng_test.php74.sf
DNS.260=*.ng_test.php73.sf
DNS.261=*.ng_test.php72.sf
DNS.262=*.ng_test.php71.sf
DNS.263=*.ng_test.php70.sf
DNS.264=*.ng_test.php56.sf
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

### 8.1 If using MacOS

Register the created RCA with MacOS RCS (System Keychain), by executing on the
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
