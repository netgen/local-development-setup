Set up Mailpit development SMTP server
======================================

Mailpit is a simple development SMPT server that can be used to test
sending of emails.

1 Install
---------

Execute on the command line:

.. code:: console

   cd /usr/local/bin
   sudo wget https://github.com/axllent/mailpit/releases/download/v1.14.0/mailpit-darwin-arm64.tar.gz
   sudo gunzip < mailpit-darwin-arm64.tar.gz | tar xv --file=- mailpit && rm mailpit-darwin-arm64.tar.gz
   sudo chmod a+x /usr/local/bin/mailpit

2 Start
-------

As we don’t always need it in a project, Mailpit is to be started when
needed.

Execute on the command line:

.. code:: console

   mailpit

You should receive output similar to the following:

.. code:: text

   INFO[2024/02/27 08:50:24] [smtpd] starting on [::]:1025
   INFO[2024/02/27 08:50:24] [http] starting on [::]:8025
   INFO[2024/02/27 08:50:24] [http] accessible via http://localhost:8025/

The server will run in the foreground, and you can stop it with
``Control-C``.

If needed, find the additional options by executing:

.. code:: console

   mailpit --help

3 Test
------

When started, web interface will be available at http://localhost:8025 or http://0.0.0.0:8025.
Open it to confirm that it is working.

4 Configure in a project
------------------------

To use it in a web application, configure the mailer DSN to
``smtp://0.0.0.0:1025``.
