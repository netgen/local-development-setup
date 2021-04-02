# Set up cURL

cURL (short for Client URL) is a library and command-line tool for transferring
data using various network protocols. You should already have it installed as a
dependency of PHP cURL extension, and this page only documents how to configure
you certificates so that cURL can find and use them.

## If using macOS, add the root certificate to the OpenSSL certificate bundle

Since `curl` on macOS will not check System Keychain to validate the
certificate, you will need to add it to the `openssl` RCA certificates bundle.
First, check where is the correct location of the bundle with:

```console
php -r "print_r(openssl_get_cert_locations());"
```

You should receive an output similar to:

```text
Array
(
    [default_cert_file] => /opt/local/etc/openssl/cert.pem
    [default_cert_file_env] => SSL_CERT_FILE
    [default_cert_dir] => /opt/local/etc/openssl/certs
    [default_cert_dir_env] => SSL_CERT_DIR
    [default_private_dir] => /opt/local/etc/openssl/private
    [default_default_cert_area] => /opt/local/etc/openssl
    [ini_cafile] =>
    [ini_capath] =>
)
```

The value of `default_cert_file` key from above is the location of the bundle
where the RCA certificates are stored. Add your own RCA certificate to the
bundle with:

```console
sudo bash -c "cat ~/ssl/root.crt  >> /opt/local/etc/openssl/cert.pem"
```

With this, you should be able to use `curl` from the command line to access
your local installation over HTTPS. Provided you have installed the websites in
the NGiNX step, check that everything is correct with:

```console
curl --head https://phpinfo.php74
```

You should receive an output like below:

```console
HTTP/1.1 200 OK
Server: nginx/1.19.8
Date: Wed, 31 Mar 2021 08:31:24 GMT
Content-Type: text/html; charset=UTF-8
Connection: keep-alive
X-Powered-By: PHP/7.4.16
```
