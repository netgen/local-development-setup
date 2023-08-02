Set up PHP
==========

Here you will install multiple versions of PHP and configure them to run
in FPM mode.

1 Install
---------

On latest Ubuntu (20.04 in the time of writing), only the latest PHP
version (PHP 7.4 in the time of writing) is available in the default
repository. For older versions we need to use the ``ondrej/php`` PPA
repository.

To add this repository, execute on the command line:

.. code:: console

   sudo add-apt-repository ppa:ondrej/php

Then, install imagemagick:

.. code:: console

   sudo apt install imagemagick

Then, to install PHP 8.2, 8.1, 8.0, 7.4, 7.3, 7.2, 7.1 and 5.6 execute on the command
line:

.. code:: console
   sudo apt install php8.2 php8.2-fpm php8.2-imagick php8.2-gd php8.2-curl php8.2-opcache php8.2-mbstring php8.2-xsl php8.2-intl php8.2-sqlite3 php8.2-zip php8.2-mysql php8.2-bcmath
   sudo apt install php8.1 php8.1-fpm php8.1-imagick php8.1-gd php8.1-curl php8.1-opcache php8.1-mbstring php8.1-xsl php8.1-intl php8.1-sqlite3 php8.1-zip php8.1-mysql php8.1-bcmath
   sudo apt install php8.0 php8.0-fpm php8.0-imagick php8.0-gd php8.0-curl php8.0-opcache php8.0-mbstring php8.0-xsl php8.0-intl php8.0-sqlite3 php8.0-zip php8.0-mysql php8.0-bcmath
   sudo apt install php7.4 php7.4-fpm php7.4-imagick php7.4-gd php7.4-curl php7.4-opcache php7.4-mbstring php7.4-xsl php7.4-intl php7.4-sqlite3 php7.4-zip php7.4-mysql php7.4-bcmath
   sudo apt install php7.3 php7.3-fpm php7.3-imagick php7.3-gd php7.3-curl php7.3-opcache php7.3-mbstring php7.3-xsl php7.3-intl php7.3-sqlite3 php7.3-zip php7.3-mysql php7.3-bcmath
   sudo apt install php7.2 php7.2-fpm php7.2-imagick php7.2-gd php7.2-curl php7.2-opcache php7.2-mbstring php7.2-xsl php7.2-intl php7.2-sqlite3 php7.2-zip php7.2-mysql php7.2-bcmath
   sudo apt install php7.1 php7.1-fpm php7.1-imagick php7.1-gd php7.1-curl php7.1-opcache php7.1-mbstring php7.1-xsl php7.1-intl php7.1-sqlite3 php7.1-zip php7.1-mysql php7.1-bcmath
   sudo apt install php5.6 php5.6-fpm php5.6-imagick php5.6-gd php5.6-curl php5.6-opcache php5.6-mbstring php5.6-xsl php5.6-intl php5.6-sqlite3 php5.6-zip php5.6-mysql php5.6-bcmath

Now you can select desired default PHP version with:

.. code:: console

   sudo update-alternatives --config php

2 Configure
-----------

2.1 Configure PHP-FPM pool definitions
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

For each PHP version edit PHP-FPM pool definition files (documented
further below) and update it with the following configuration options:

.. code:: ini

   user = brale
   group = staff
   listen = /var/run/php74-fpm.sock
   listen.owner = brale
   listen.group = staff
   pm = ondemand
   pm.max_children = 6
   pm.process_idle_timeout = 15m
   pm.max_requests = 128
   pm.status_path = /status
   ping.path = /ping
   ping.response = "pong"

Make sure to use your own user and group instead of ``brale`` and
``staff``, and name the socket file corresponding to the PHP version.
By default you will have www-data as user and group. Put your own user and group there (by default same as user).
Use configuration already existing in the file and do not create
duplicate entries.

**Note**: Configuration files use ``;`` character as a comment, so make
sure you remove it as needed.

PHP-FPM resource consumption
^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Main PHP-FPM manager process takes up a small amount of memory, but
spawned workers can take up to few hundred megabytes, depending on the
application that was executed. To see how many worker processes are
active and how much memory they use you can check the list of processes
(``ps`` or ``pstree`` on the command line), or open the PHP-FPM status
page for the specific PHP version, for example
https://home.php73/status?full&html.

Find PHP-FPM pool definitions for your PHP versions in following files

.. code:: text

   /etc/php/8.2/fpm/pool.d/www.conf
   /etc/php/8.1/fpm/pool.d/www.conf
   /etc/php/8.0/fpm/pool.d/www.conf
   /etc/php/7.4/fpm/pool.d/www.conf
   /etc/php/7.3/fpm/pool.d/www.conf
   /etc/php/7.2/fpm/pool.d/www.conf
   /etc/php/7.1/fpm/pool.d/www.conf
   /etc/php/5.6/fpm/pool.d/www.conf

Update these pool definition files as described above.

**Note:** don’t forget to use ``sudo`` as these are editable only by the
root user.

3 Configure PHP
---------------

For each PHP version find its configuration file (documented further
below) and update it with the following configuration options:

.. code:: ini

   date.timezone = Europe/Zagreb
   session.gc_maxlifetime = 86400
   memory_limit = 256M

Don’t forget to modify error log path to your user’s home directory, and
set the correct PHP version depending on the ini file you’re modifying.

**Note**: Configuration files use ``;`` character as a comment, so make
sure you remove it as needed.

Find the configuration for your PHP versions in the following files:

.. code:: text

   /etc/php/8.2/fpm/php.ini
   /etc/php/8.1/fpm/php.ini
   /etc/php/8.0/fpm/php.ini
   /etc/php/7.4/fpm/php.ini
   /etc/php/7.3/fpm/php.ini
   /etc/php/7.2/fpm/php.ini
   /etc/php/7.1/fpm/php.ini
   /etc/php/5.6/fpm/php.ini

Update these configuration files as described above.

4 Start PHP-FPM services
------------------------

You can now start PHP services.

.. code:: console

   sudo systemctl start php8.2-fpm 
   sudo systemctl start php8.1-fpm
   sudo systemctl start php8.0-fpm
   sudo systemctl start php7.4-fpm
   sudo systemctl start php7.3-fpm
   sudo systemctl start php7.2-fpm
   sudo systemctl start php7.1-fpm
   sudo systemctl start php5.6-fpm

Except ``start``, you can also use commands such as: \* ``status`` - to
see if PHP-FPM service is running \* ``stop`` - to stop the PHP-FPM
service \* ``restart`` - to restart the PHP-FPM service (does stop then
start)

Remember to restart the FPM server after changing the configuration.

**Note:** by default all PHP-FPM services are set-up to automatically
start after a reboot. To check if a service is enabled to automatically
start on boot use:

.. code:: console

   sudo systemctl is-enabled php7.4-fpm

And then you can enable it with:

.. code:: console

   sudo systemctl enable php7.4-fpm

Or disable with:

.. code:: console

   sudo systemctl disable php7.4-fpm

6 Install PHP extensions
------------------------

Installed PHP will come with built-in extension, but if your project
requires additional extensions, these have to be installed separately.

Simply install the PHP extension you need, for example:

.. code:: console

   sudo apt install php5.6-mysql

**Note:** Some extensions do not have a PHP version in their name, eg.

.. code:: console

   sudo apt install php-memcached

7 Install PHP CS Fixer
----------------------------------

In order for code to be in line with both, general PHP coding standards
and company coding standards, PHP CS Fixer is required on most of the
projects.

Follow globally installation instructions on `official installation
instructions
page <https://github.com/FriendsOfPHP/PHP-CS-Fixer/blob/master/doc/installation.rst>`__.
