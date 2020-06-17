# Install and configure PHP

Here you will install multiple versions of PHP and configure them to run in FPM
mode.

If using `MacOS` and `Homebrew`, out of the box it provides current PHP version
in a package named `php` (version 7.4 at the time of writing), and other
officially supported PHP versions in packages namespaced with version number,
for example `php@7.3`.

Officially unsupported PHP packages are not available in official formula
repository ("tap" in `brew` lingo). However, they are still provided in some 3rd
party *taps*, and it's possible to install them from there.

**Note**: You don't have to install all following PHP versions. Install only
those you really need, and in case you need another one, return to this page
and follow the instructions to install that one as well.

## 1 Install

### 1.1 Install multiple PHP versions using `MacPorts`

```console
sudo port install php74-fpm php73-fpm php72-fpm php71-fpm php70-fpm php56-fpm
```

Select wanted PHP version as default with:

```console
sudo port select php php73
```

This PHP version will be available from the command line as `php`.

### 1.2 Install multiple PHP versions using `Homebrew`

Install PHP 7.4, 7.3 and 7.2 using `brew` from the official *tap*:

```console
brew install php php@7.3 php@7.2
```

PHP versions 7.1, 7.0 and 5.6 are available in `exolnet/homebrew-deprecated`
*tap*. First register this *tap* with your local `brew` installation with:

```console
brew tap exolnet/homebrew-deprecated
```

Now you can install PHP 7.1, 7.0 and 5.6 with:

```console
brew install exolnet/deprecated/php@7.1
brew install exolnet/deprecated/php@7.0
brew install exolnet/deprecated/php@5.6
```

## 2 Configure

### 2.1 Configure PHP-FPM pool definitions

For each PHP version edit PHP-FPM pool definition filed and update it with the
following configuration options:

```ini
user = brale
group = staff
listen = /var/run/php74-fpm.sock
listen.owner = brale
listen.group = staff
pm = ondemand
pm.max_children = 2
pm.process_idle_timeout = 15m
pm.max_requests = 128
pm.status_path = /status
ping.path = /ping
ping.response = "pong"
```

Make sure to use your own username instead of `brale`, and name the socket file
corresponding to the PHP version. Use configuration already existing in the
file and do not create duplicate entries.

**Note**: Configuration files use `;` character as a comment, so make sure you
remove it as needed.

#### PHP-FPM resource consumption

Main PHP-FPM manager process takes up a small amount of memory, but spawned
workers can take up to few hundred megabytes, depending on the application that
was executed. To see how many worker processes are active and how much memory
they use you can check the list of processes (`ps` or `pstree` on the command
line), or open the PHP-FPM status page for the specific PHP version, for example
https://home.php73/status?full&html.

### 2.1 Configure PHP-FPM pool definitions if installed using `Homebrew`

Find PHP-FPM pool definitions for your PHP versions in following files

```text
/usr/local/etc/php/7.4/php-fpm.d/www.conf
/usr/local/etc/php/7.3/php-fpm.d/www.conf
/usr/local/etc/php/7.2/php-fpm.d/www.conf
/usr/local/etc/php/7.1/php-fpm.d/www.conf
/usr/local/etc/php/7.0/php-fpm.d/www.conf
/usr/local/etc/php/5.6/php-fpm.conf
```

Update these pool definition files as described above.

### 2.1 Configure PHP-FPM pool definitions if installed using `MacPorts`

First create PHP-FPM configuration files by copying the default ones:

```console
sudo cp /opt/local/etc/php74/php-fpm.conf.default /opt/local/etc/php74/php-fpm.conf
sudo cp /opt/local/etc/php73/php-fpm.conf.default /opt/local/etc/php73/php-fpm.conf
sudo cp /opt/local/etc/php72/php-fpm.conf.default /opt/local/etc/php72/php-fpm.conf
sudo cp /opt/local/etc/php71/php-fpm.conf.default /opt/local/etc/php71/php-fpm.conf
sudo cp /opt/local/etc/php70/php-fpm.conf.default /opt/local/etc/php70/php-fpm.conf
sudo cp /opt/local/etc/php56/php-fpm.conf.default /opt/local/etc/php56/php-fpm.conf
```

You don't need to change the default configuration values.

Next, create PHP-FPM pool definitions by copying the default ones:

```console
sudo cp /opt/local/etc/php74/php-fpm.d/www.conf.default /opt/local/etc/php74/php-fpm.d/www.conf
sudo cp /opt/local/etc/php73/php-fpm.d/www.conf.default /opt/local/etc/php73/php-fpm.d/www.conf
sudo cp /opt/local/etc/php72/php-fpm.d/www.conf.default /opt/local/etc/php72/php-fpm.d/www.conf
sudo cp /opt/local/etc/php71/php-fpm.d/www.conf.default /opt/local/etc/php71/php-fpm.d/www.conf
sudo cp /opt/local/etc/php70/php-fpm.d/www.conf.default /opt/local/etc/php70/php-fpm.d/www.conf
```

**Note**: similar as with `Homebrew`, for PHP 5.6 pool definition in the main FPM
configuration file.

Update the created pool definition files as described above.

## 3 Configure PHP

For each PHP version find its configuration file and update it with the
following configuration options:

```ini
date.timezone = Europe/Zagreb
session.gc_maxlifetime = 86400
```

**Note**: Configuration files use `;` character as a comment, so make sure you
remove it as needed.

### 3.1 Configure PHP if installed using `Homebrew`

Find the configuration for your PHP versions in the following files:

```text
/usr/local/etc/php/7.4/php.ini
/usr/local/etc/php/7.3/php.ini
/usr/local/etc/php/7.2/php.ini
/usr/local/etc/php/7.1/php.ini
/usr/local/etc/php/7.0/php.ini
/usr/local/etc/php/5.6/php.ini
```

Update these configuration files as described above.

### 3.2 Configure PHP if installed using `MacPorts`

First create PHP configuration files by copying the default ones:

```console
sudo cp /opt/local/etc/php74/php.ini-development /opt/local/etc/php74/php.ini
sudo cp /opt/local/etc/php73/php.ini-development /opt/local/etc/php73/php.ini
sudo cp /opt/local/etc/php72/php.ini-development /opt/local/etc/php72/php.ini
sudo cp /opt/local/etc/php71/php.ini-development /opt/local/etc/php71/php.ini
sudo cp /opt/local/etc/php70/php.ini-development /opt/local/etc/php70/php.ini
sudo cp /opt/local/etc/php56/php.ini-development /opt/local/etc/php56/php.ini
```

Update the created configuration files as described above.

## 4 Symlink PHP binaries

**Note**: as `MacPorts` already provides a PHP binary for each PHP version, this
step is needed only if you installed using `Homebrew`.

Symlink each PHP binary to an easily accessible alias:

```console
ln -s /usr/local/Cellar/php@7.4/7.4.xx/bin/php ~/bin/php74
ln -s /usr/local/Cellar/php@7.3/7.3.xx/bin/php ~/bin/php73
ln -s /usr/local/Cellar/php@7.2/7.2.xx/bin/php ~/bin/php72
ln -s /usr/local/Cellar/php@7.1/7.1.xx/bin/php ~/bin/php71
ln -s /usr/local/Cellar/php@7.0/7.0.xx/bin/php ~/bin/php70
ln -s /usr/local/Cellar/php@5.6/5.6.xx/bin/php ~/bin/php56
```

Make sure you use correct paths to the PHP binary. This path will change when
upgrading a PHP version, so you will need to maintain your symlinks through
upgrades.

Test you can access binary aliases by executing:

```console
php74 -v
php73 -v
php72 -v
php72 -v
php70 -v
php56 -v
```

## 5 Start PHP-FPM services

You can now start PHP services.

### 5.1 Start PHP-FPM services if installed using `Homebrew`

```console
sudo brew services start php@7.4
sudo brew services start php@7.3
sudo brew services start php@7.2
sudo brew services start php@7.1
sudo brew services start php@7.0
sudo brew services start php@5.6
```

This will also ensure that `PHP-FPM` server starts automatically after a reboot.

Remember to restart them after changing PHP configuration in the future with:

```console
sudo brew services restart php@x.x
```

### 5.2 Start PHP-FPM services if installed using `MacPorts`

```console
sudo port load php74-fpm
sudo port load php73-fpm
sudo port load php72-fpm
sudo port load php71-fpm
sudo port load php70-fpm
sudo port load php56-fpm
```

This will also ensure that `PHP-FPM` server starts automatically after a reboot.

Remember to restart them after changing PHP configuration in the future with:

```console
sudo port reload phpxx-fpm
```

## 6. Install PHP extensions

Installed PHP will come with built-in extension, but if your project requires
additional extensions, these have to be installed separately.

### 6.1 Install PHP extensions using `MacPorts`

`MacPorts` already provides installable PHP extensions, find them for a
particular PHP version by executing:

```console
port list php56\*
```

Simply install the PHP extension you need, using `MacPorts`, for example:

```console
sudo port install php56-memcached
```

### 6.2 If using `Homebrew`, compile the required PHP extensions manually

todo
