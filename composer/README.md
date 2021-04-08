# Set up composer

Composer is a tool for dependency management in PHP. It allows you to declare the libraries your project depends on and it will manage (install/update) them for you.
You will need composer for any of Symfony based project.

## 1 Install

Installation procedure should be the same for MacOS and Linux. You can find detailed instructions on https://getcomposer.org/download/ and https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos

By default, the above instructions will install the **latest** composer version.
As composer2 is not (yet) used on most projects, we will first install composer1 and make it available globally:
```console
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php --version=1.10.21
php -r "unlink('composer-setup.php');"
```

Next step is making sure `composer` command is available globally:
```console
mv composer.phar /usr/local/bin/composer
```

Now we should also install composer2, in case you will need to use it on some projects:
```console
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

And make it available under `composer2` command:
```console
mv composer.phar /usr/local/bin/composer2
```

That is it!

Now you should be able to run `composer install` for projects using composer1 and `composer2 install` for projects using composer2

## 2 Aliases

For easier usage with different PHP versions, we suggest adding some aliases:
* Linux default file: `~/.bash_aliases`
* MacOS default file: `~/.zshrc`
* if you are using some custom shell, you will have to find the place for aliases on your own :)

Copy the following into the alias file:
```
alias composer56='php5.6 /usr/local/bin/composer'
alias composer71='php7.1 /usr/local/bin/composer'
alias composer72='php7.2 /usr/local/bin/composer'
alias composer73='php7.3 /usr/local/bin/composer'
alias composer74='php7.4 /usr/local/bin/composer'
alias composer256='php5.6 /usr/local/bin/composer2'
alias composer271='php7.1 /usr/local/bin/composer2'
alias composer272='php7.2 /usr/local/bin/composer2'
alias composer273='php7.3 /usr/local/bin/composer2'
alias composer274='php7.4 /usr/local/bin/composer2'
```

## 3 Manual upgrade/downgrade

If you do not wish to use aliases, but manually upgrade/downgrade composer, you can switch with the following commands:

Switch to version 1:
```console
composer self-update --1
```

Switch to version 2:
```console
composer self-update --2
```
