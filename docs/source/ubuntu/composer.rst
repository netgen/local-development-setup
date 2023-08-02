Set up composer
===============

Composer is a tool for dependency management in PHP. It allows you to
declare the libraries your project depends on and it will manage
(install/update) them for you. You will need composer for any Symfony
based project.

1 Install
---------

Installation procedure should be the same for MacOS and Linux. You can
find detailed instructions on https://getcomposer.org/download/.

Use the above instructions to download the composer to your machine.

Next step is making sure version 2 is available globally under
``composer2`` command:

.. code:: console

   cp composer.phar /usr/local/bin/composer2

We also need version 1, as not all projects support version 2 yet:

.. code:: console

   php composer.phar self-update --1

And now just make sure ``composer`` command is available globally:

.. code:: console

   mv composer.phar /usr/local/bin/composer

That is it!

Now you should be able to run ``composer install`` for projects using
composer1 and ``composer2 install`` for projects using composer2

2 Aliases
---------

For easier usage with different PHP versions, we suggest adding some
aliases: \* Linux default file: ``~/.bash_aliases`` \* if you are
using some custom shell, you will have
to find the place for aliases on your own :)

Copy the following into the alias file:

::

    alias composer561="/usr/bin/php5.6 /usr/local/bin/composer"
    alias composer562="/usr/bin/php5.6 /usr/local/bin/composer2"
    alias composer701="/usr/bin/php7.0 /usr/local/bin/composer"
    alias composer702="/usr/bin/php7.0 /usr/local/bin/composer2"
    alias composer711="/usr/bin/php7.1 /usr/local/bin/composer"
    alias composer712="/usr/bin/php7.1 /usr/local/bin/composer2"
    alias composer721="/usr/bin/php7.2 /usr/local/bin/composer"
    alias composer722="/usr/bin/php7.2 /usr/local/bin/composer2"
    alias composer731="/usr/bin/php7.3 /usr/local/bin/composer"
    alias composer732="/usr/bin/php7.3 /usr/local/bin/composer2"
    alias composer741="/usr/bin/php7.4 /usr/local/bin/composer"
    alias composer742="/usr/bin/php7.4 /usr/local/bin/composer2"
    alias composer801="/usr/bin/php8.0 /usr/local/bin/composer"
    alias composer802="/usr/bin/php8.0 /usr/local/bin/composer2"
    alias composer811="/usr/bin/php8.1 /usr/local/bin/composer"
    alias composer812="/usr/bin/php8.1 /usr/local/bin/composer2"
    alias composer821="/usr/bin/php8.2 /usr/local/bin/composer1"
    alias composer822="/usr/bin/php8.2 /usr/local/bin/composer2"

3 Manual upgrade/downgrade
--------------------------

If you do not wish to use aliases, but manually upgrade/downgrade
composer, you can switch with the following commands:

Switch to version 1:

.. code:: console

   composer self-update --1

Switch to version 2:

.. code:: console

   composer self-update --2
