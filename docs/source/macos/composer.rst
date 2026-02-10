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

Don't forget adding composer into a directory on PATH
.. code:: console

   sudo mv composer.phar /opt/local/bin/composer

That is it!

Now you should be able to run ``composer install`` in projects.

2 Aliases
---------

For easier usage with different PHP versions, we suggest adding some
aliases: \* MacOS default file: ``~/.zshrc`` \* if you are using some
custom shell, you will have to find the place for aliases on your own :)

Copy the following into the alias file:

::

    alias composer74="/opt/local/bin/php74 /opt/local/bin/composer"
    alias composer80="/opt/local/bin/php80 /opt/local/bin/composer"
    alias composer81="/opt/local/bin/php81 /opt/local/bin/composer"
    alias composer82="/opt/local/bin/php81 /opt/local/bin/composer"
    alias composer83="/opt/local/bin/php81 /opt/local/bin/composer"
    alias composer84="/opt/local/bin/php81 /opt/local/bin/composer"