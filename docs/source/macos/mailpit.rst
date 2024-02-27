Set up Mailpit development SMTP server
======================================

Mailpit is a simple development SMPT server that can be used to test
sending of emails.

1 Install
---------

1.1 If using MacOS without Homebrew
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

You can install it by downloading the appropriate binary from GitHub at
https://github.com/axllent/mailpit/releases (in case of MacOS, search
for the one containing ``darwin`` in its name). If you go that way, put
the downloaded binary as ``mailpit`` to the appropriate place that is
configured in your ``PATH`` environment variable, usually ``bin``
directory in your home directory.

Execute the following on the command line, replacing the path with the
correct one for your OS:

.. code:: console

   cd ~/bin
   wget https://github.com/axllent/mailpit/releases/download/v1.14.0/mailpit-darwin-arm64.tar.gz
   gunzip < mailpit-darwin-arm64.tar.gz | tar xv --file=- mailpit && rm mailpit-darwin-arm64.tar.gz
   chmod a+x ~/bin/mailpit

1.2 If using MacOS with Homebrew
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Execute on the command line:

.. code:: console

   brew install mailpit

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
