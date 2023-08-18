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
aliases: \* MacOS default file: ``~/.zshrc`` \* if you are using some
custom shell, you will have to find the place for aliases on your own :)

Copy the following into the alias file:

::

    alias composer561="/usr/local/bin/php56 /usr/local/bin/composer"
    alias composer562="/usr/local/bin/php56 /usr/local/bin/composer2"
    alias composer701="/usr/local/bin/php70 /usr/local/bin/composer"
    alias composer702="/usr/local/bin/php70 /usr/local/bin/composer2"
    alias composer711="/usr/local/bin/php71 /usr/local/bin/composer"
    alias composer712="/usr/local/bin/php71 /usr/local/bin/composer2"
    alias composer721="/usr/local/bin/php72 /usr/local/bin/composer"
    alias composer722="/usr/local/bin/php72 /usr/local/bin/composer2"
    alias composer731="/usr/local/bin/php73 /usr/local/bin/composer"
    alias composer732="/usr/local/bin/php73 /usr/local/bin/composer2"
    alias composer741="/usr/local/bin/php74 /usr/local/bin/composer"
    alias composer742="/usr/local/bin/php74 /usr/local/bin/composer2"
    alias composer801="/usr/local/bin/php80 /usr/local/bin/composer"
    alias composer802="/usr/local/bin/php80 /usr/local/bin/composer2"
    alias composer811="/usr/local/bin/php81 /usr/local/bin/composer"
    alias composer812="/usr/local/bin/php81 /usr/local/bin/composer2"

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
