# Install and configure PHP

Here you will install multiple PHP versions and configure them to run in FPM
mode.

Out of the box `brew` provides current PHP version in a package named `php`
(version 7.4 at the time of writing), and other officially supported PHP
versions in packages namespaced with version number, for example `php@7.3`.

Officially unsupported PHP packages are not available in official formula
repository ("tap" in `brew` lingo). However, they are still provided in some 3rd
party *taps*, and it's possible to install them from there.

**Note**: You don't have to install all following PHP versions. Install only
those you really need, and in case you need another one, return to this page
and follow the instructions to install that one as well.

## Install PHP versions 7.4, 7.3 and 7.2

Install PHP 7.4, 7.3 and 7.2 using `brew` from the official *tap*:

```bash
brew install php
brew install php@7.3
brew install php@7.2
```

## Install PHP versions and 7.1, 7.0 and 5.6

PHP versions 7.1, 7.0 and 5.6 are available in `exolnet/homebrew-deprecated`
*tap*. First register this *tap* with your local `brew` installation with:

```bash
brew tap exolnet/homebrew-deprecated
```

Now you can install PHP 7.1, 7.0 and 5.6 with:

```bash
brew install exolnet/deprecated/php@7.1
brew install exolnet/deprecated/php@7.0
brew install exolnet/deprecated/php@5.6
```

## Configure PHP-FPM pool definitions

Find PHP-FPM pool definitions for these PHP versions in following files:

```
/usr/local/etc/php/7.4/php-fpm.d/www.conf
/usr/local/etc/php/7.3/php-fpm.d/www.conf
/usr/local/etc/php/7.2/php-fpm.d/www.conf
/usr/local/etc/php/7.1/php-fpm.d/www.conf
/usr/local/etc/php/7.0/php-fpm.d/www.conf
/usr/local/etc/php/5.6/php-fpm.conf
```

Edit each of them and update it with the following configuration options:

```
user = brale
group = staff
listen = /var/run/php74-fpm.sock
listen.owner = brale
listen.group = staff
pm.status_path = /status
ping.path = /ping
ping.response = "pong"
```

Make sure to use your own username instead of `brale`, and name the socket file
corresponding to the PHP version. Use configuration already existing in the
file and do not create duplicate entries.

### Optionally optimize PHP-FPM to limit resource consumption

Main PHP-FPM manager process takes up a small amount of memory, but spawned
workers can take up to few hundred megabytes, depending on the application that
was executed. To see how many worker processes are active and how much memory
they use you can check the list of processes (`ps` or `pstree` on the command
line), or open the PHP-FPM status page for the specific PHP version, for example
https://home.php73/status?full&html.

If you don't have enough hardware resources, configure `pm` setting to
`ondemand` and corresponding `pm.process_idle_timeout` to something like `15m`.
That will ensure that worker processes get killed after idling for 15 minutes,
and started again automatically when needed. When that happens, first request
will be few hundred milliseconds slower, but subsequent requests will reuse
existing workers without process initialization penalty.

## Symlink PHP binaries

You will need access to a specific PHP version from the command line. Symlink
each PHP binary to an easily accessible alias:

```bash
ln -s /usr/local/Cellar/php@7.4/7.4.xx/bin/php php74
ln -s /usr/local/Cellar/php@7.3/7.3.xx/bin/php php73
ln -s /usr/local/Cellar/php@7.2/7.2.xx/bin/php php72
ln -s /usr/local/Cellar/php@7.1/7.1.xx/bin/php php71
ln -s /usr/local/Cellar/php@7.0/7.0.xx/bin/php php70
ln -s /usr/local/Cellar/php@5.6/5.6.xx/bin/php php56
```

Make sure you use correct paths to the PHP binary. This path will change when
upgrading a PHP version, so you will need to maintain your symlinks through
upgrades.

## Start PHP-FPM services

```bash
sudo brew services restart php@7.4
sudo brew services restart php@7.3
sudo brew services restart php@7.2
sudo brew services restart php@7.1
sudo brew services restart php@7.0
sudo brew services restart php@5.6
```

## Compile specific PHP extensions

todo
