# Set up composer

Composer is a tool for dependency management in PHP. It allows you to declare the libraries your project depends on and it will manage (install/update) them for you.
You will need composer for any Symfony based project.

## 1 Install

Installation procedure should be the same for MacOS and Linux. You can find detailed instructions on https://getcomposer.org/download/.

Use the above instructions to download the composer to your machine.

By default, the above instructions will install the **latest** composer version, so we will need to downgrade to version 1 before making it available globally:
```console
php composer.phar self-update --1
```

Next step is making sure `composer` command is available globally:
```console
cp composer.phar /usr/local/bin/composer
```

Now we should also install composer2, in case you will need to use it on some projects. First, get the local composer.phar to latest version:
```console
php composer.phar self-update --1
```

And now just make sure `composer2` command is available globally:
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
