Set up SSL certificates with OpenSSL
====================================

Here you will generate SLL certificates for your NGINX server. This is
not about generating a self-signed certificate - you will generate both
Root Certificate Authority (RCA) and end-entity (server) certificates.
RCA certificate will be registered in the Operating System’s Root
Certificate Store (RCS), so that any additionally generated server
certificates get automatically validated by the browser without defining
exceptions or importing them into Operating System’s RCS.

1 Create installation directory
-------------------------------

Execute on the command line:

.. code:: console

   mkdir ~/ssl

2 Write down your chosen password
---------------------------------

Write down your chosen password in ``~/ssl/password.txt`` file in case
you need to generate new server certificate using the same RCA later on.

3 Create RCA configuration
--------------------------

Create ``~/ssl/root.conf`` file with the following content:

.. code:: dosini

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

4 Create server certificate configuration
-----------------------------------------

Create ``~/ssl/server.conf`` file with the following content:

.. code:: dosini

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
   DNS.1=home.php94
   DNS.2=home.php93
   DNS.3=home.php92
   DNS.4=home.php91
   DNS.5=home.php90
   DNS.6=home.php85
   DNS.7=home.php84
   DNS.8=home.php83
   DNS.9=home.php82
   DNS.10=home.php81
   DNS.11=home.php80
   DNS.12=home.php74
   DNS.13=phpinfo.php94
   DNS.14=phpinfo.php93
   DNS.15=phpinfo.php92
   DNS.16=phpinfo.php91
   DNS.17=phpinfo.php90
   DNS.18=phpinfo.php85
   DNS.19=phpinfo.php84
   DNS.20=phpinfo.php83
   DNS.21=phpinfo.php82
   DNS.22=phpinfo.php81
   DNS.23=phpinfo.php80
   DNS.24=phpinfo.php74
   DNS.25=*.dev.php94.ez
   DNS.26=*.dev.php93.ez
   DNS.27=*.dev.php92.ez
   DNS.28=*.dev.php91.ez
   DNS.29=*.dev.php90.ez
   DNS.30=*.dev.php85.ez
   DNS.31=*.dev.php84.ez
   DNS.32=*.dev.php83.ez
   DNS.33=*.dev.php82.ez
   DNS.34=*.dev.php81.ez
   DNS.35=*.dev.php80.ez
   DNS.36=*.dev.php74.ez
   DNS.37=*.prod.php94.ez
   DNS.38=*.prod.php93.ez
   DNS.39=*.prod.php92.ez
   DNS.40=*.prod.php91.ez
   DNS.41=*.prod.php90.ez
   DNS.42=*.prod.php85.ez
   DNS.43=*.prod.php84.ez
   DNS.44=*.prod.php83.ez
   DNS.45=*.prod.php82.ez
   DNS.46=*.prod.php81.ez
   DNS.47=*.prod.php80.ez
   DNS.48=*.prod.php74.ez
   DNS.49=*.test.php94.ez
   DNS.50=*.test.php93.ez
   DNS.51=*.test.php92.ez
   DNS.52=*.test.php91.ez
   DNS.53=*.test.php90.ez
   DNS.54=*.test.php85.ez
   DNS.55=*.test.php84.ez
   DNS.56=*.test.php83.ez
   DNS.57=*.test.php82.ez
   DNS.58=*.test.php81.ez
   DNS.59=*.test.php80.ez
   DNS.60=*.test.php74.ez
   DNS.61=*.dev.php94.sf
   DNS.62=*.dev.php93.sf
   DNS.63=*.dev.php92.sf
   DNS.64=*.dev.php91.sf
   DNS.65=*.dev.php90.sf
   DNS.66=*.dev.php85.sf
   DNS.67=*.dev.php84.sf
   DNS.68=*.dev.php83.sf
   DNS.69=*.dev.php82.sf
   DNS.70=*.dev.php81.sf
   DNS.71=*.dev.php80.sf
   DNS.72=*.dev.php74.sf
   DNS.73=*.prod.php94.sf
   DNS.74=*.prod.php93.sf
   DNS.75=*.prod.php92.sf
   DNS.76=*.prod.php91.sf
   DNS.77=*.prod.php90.sf
   DNS.78=*.prod.php85.sf
   DNS.79=*.prod.php84.sf
   DNS.80=*.prod.php83.sf
   DNS.81=*.prod.php82.sf
   DNS.82=*.prod.php81.sf
   DNS.83=*.prod.php80.sf
   DNS.84=*.prod.php74.sf
   DNS.85=*.test.php94.sf
   DNS.86=*.test.php93.sf
   DNS.87=*.test.php92.sf
   DNS.88=*.test.php91.sf
   DNS.89=*.test.php90.sf
   DNS.90=*.test.php85.sf
   DNS.91=*.test.php84.sf
   DNS.92=*.test.php83.sf
   DNS.93=*.test.php82.sf
   DNS.94=*.test.php81.sf
   DNS.95=*.test.php80.sf
   DNS.96=*.test.php74.sf

5 Create RCA certificate and private key
----------------------------------------

**Note**: 3650 days means the certificate will be valid for 10 years.

When prompted, use the password you chose previously.

Execute on the command line:

.. code:: console

   cd ~/ssl
   sudo openssl req -x509 -new -days 3650 -keyout root.key -out root.crt -config root.conf

6 Create server certificate signing request
-------------------------------------------

Execute on the command line:

.. code:: console

   cd ~/ssl
   sudo openssl req -nodes -new -keyout server.key -out server.csr -config server.conf

7 Create server certificate and its private key
-----------------------------------------------

**Note**: 825 days is maximum allowed end-entity certificate validity.

When prompted, use the password you chose previously.

Execute on the command line:

.. code:: console

   cd ~/ssl
   sudo openssl x509 -sha256 -req -days 825 -in server.csr -CA root.crt -CAkey root.key -CAcreateserial -out server.crt -extfile server.conf -extensions x509_ext

8 Create certificate chain file
-------------------------------

Execute on the command line:

.. code:: console

   cd ~/ssl
   cat server.crt server.key root.crt > chain.pem

9 Register RCA certificate with the OS
--------------------------------------

Register the created RCA with Ubuntu RCS by executing on the command
line:

.. code:: console

   cd ~/ssl
   sudo cp root.crt /usr/local/share/ca-certificates
   sudo update-ca-certificates

10 Create regenerate script for future convenience
--------------------------------------------------

Create ``~/ssl/regenerate.sh`` file with the following content:

.. code:: bash

   #!/usr/bin/env bash

   # edit server.conf

   echo "Creating server certificate signing request..."
   sudo openssl req -nodes -new -keyout server.key -out server.csr -config server.conf
   echo -e "Done.\n"

   echo "Creating server certificate and its private key..."
   sudo openssl x509 -sha256 -req -days 825 -in server.csr -CA root.crt -CAkey root.key -CAcreateserial -out server.crt -extfile server.conf -extensions x509_ext
   echo -e "Done.\n"

   echo "Creating certificate chain file..."
   sudo cat server.crt server.key root.crt > chain.pem
   echo -e "Done.\n"

   echo "Finished."

Make the script executable with:

.. code:: bash

   chmod ug+x ~/ssl/regenerate.sh

When needed, edit ``alt_names`` section in ``~/ssl/server.conf`` and execute the script:

.. code:: bash

   cd ~/ssl
   ./regenerate.sh

11 Configure Firefox to use OS RCS
----------------------------------

If you are using Firefox, open ``about:config`` and set
``security.enterprise_roots.enabled`` configuration option to ``true``.
This will make Firefox use OS Root Certificate Store instead of its own
implementation.

Adding new domains
------------------

If you need a certificate for an additional domain that’s not supported
by the default configuration, edit ``server.conf`` file and add your
domain to the bottom of it. Then repeat steps 6 and 7 to generate a new
server certificate. You won’t need to register it with the RCS, as the
RCA certificate stays the same and is already registered there. Just
make sure to restart NGINX so that it becomes aware of the new server
certificate.

You can also generate a new server certificate, using your own
configuration file. In this case you can optionally reuse the existing
RCA certificate and execute only steps 6 and 7, adapting the commands to
provide your own configuration and output files.

Browser specifics
-----------------

Chrome
~~~~~~

If you generate a server certificate as valid for more than the agreed
limitation of 825 days, Chrome will react with
``NET::ERR_CERT_VALIDITY_TOO_LONG`` error. The solution is to generate a
new server certificate that respects the agreed maximum validity time.

While this rule is valid in general, so far only Chrome has chosen to
enforce it.

Firefox
~~~~~~~

1. Firefox maintains its own RCS and by default it won’t use Operating
   System’s RCS to validate a server certificate. In order to enable
   Operating System’s own RCS in Firefox, open ``about:config`` and set
   ``security.enterprise_roots.enabled`` configuration option to
   ``true``.

2. If you regenerate both RCA and server certificates with the same
   configuration, Firefox will refuse the new certificate with
   ``SEC_ERROR_BAD_SIGNATURE`` error. This seems to be caused by caching
   and can be solved by deleting its certificate database file named
   ``cert9.db``. The file is located in the Firefox profile directory,
   which you can find on ``about:profiles`` page. Make sure you restart
   Firefox after deleting it.
