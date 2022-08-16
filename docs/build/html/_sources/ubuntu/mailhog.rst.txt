Set up MailHog development SMTP server
======================================

MailHog is a simple development SMPT server that can be used to test
sending of emails.

1 Install
---------

Execute on the command line:

.. code:: console

   cd /usr/local/bin
   sudo wget -O /usr/local/bin/mailhog https://github.com/mailhog/MailHog/releases/download/v1.0.0/MailHog_linux_amd64
   sudo chmod a+x /usr/local/bin/mailhog

2 Start
-------

As we don’t always need it in a project, MailHog is to be started when
needed.

Execute on the command line:

.. code:: console

   mailhog

You should receive output similar to the following:

.. code:: text

   2020/06/17 09:42:57 Using in-memory storage
   2020/06/17 09:42:57 [SMTP] Binding to address: 0.0.0.0:1025
   [HTTP] Binding to address: 0.0.0.0:8025
   2020/06/17 09:42:57 Serving under http://0.0.0.0:8025/
   Creating API v1 with WebPath:
   Creating API v2 with WebPath:

The server will run in the foreground, and you can stop it with
``Control-C``.

If needed, find the additional options by executing:

.. code:: console

   mailhog --help

3 Test
------

When started, web interface will be available at http://0.0.0.0:8025.
Open it to confirm that it is working.

4 Configure in a project
------------------------

To use it in a web application, configure the mailer DSN to
``smtp://0.0.0.0:1025``.
