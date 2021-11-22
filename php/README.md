# Set up PHP

Here you will install multiple versions of PHP and configure them to run in FPM
mode.

If using MacOS and Homebrew, out of the box it provides current PHP version
in a package named `php` (version 7.4 at the time of writing), and other
officially supported PHP versions in packages namespaced with version number,
for example `php@7.3`. Officially unsupported PHP packages are not available in
official formula repository ("tap" in `brew` lingo). However, they are still
provided in some 3rd party *taps*, and it's possible to install them from there.

## 1 Install

### 1.1 If using MacOS with MacPorts

Execute on the command line:

```console
sudo port install php74-fpm php74-mysql php74-imagick php74-gd php74-curl php74-opcache php74-mbstring php74-xsl php74-intl php74-sqlite php74-zip php74-openssl php74-iconv
sudo port install php73-fpm php73-mysql php73-imagick php73-gd php73-curl php73-opcache php73-mbstring php73-xsl php73-intl php73-sqlite php73-zip php73-openssl php73-iconv
sudo port install php72-fpm php72-mysql php72-imagick php72-gd php72-curl php72-opcache php72-mbstring php72-xsl php72-intl php72-sqlite php72-zip php72-openssl php72-iconv
sudo port install php71-fpm php71-mysql php71-imagick php71-gd php71-curl php71-opcache php71-mbstring php71-xsl php71-intl php71-sqlite php71-zip php71-openssl php71-iconv
sudo port install php70-fpm php70-mysql php70-imagick php70-gd php70-curl php70-opcache php70-mbstring php70-xsl php70-intl php70-sqlite php70-zip php70-openssl php70-iconv
sudo port install php56-fpm php56-mysql php56-imagick php56-gd php56-curl php56-opcache php56-mbstring php56-xsl php56-intl php56-sqlite php56-zip php56-openssl php56-iconv php56-memcached
```

Select desired default PHP version:

```console
sudo port select php php73
```

This PHP version will be available from the command line as `php`.

### 1.2 If using MacOS with Homebrew

Install PHP 7.4, 7.3 and 7.2 using Homebrew from the official *tap*:

```console
brew install php php@7.3 php@7.2
```

PHP versions 7.1, 7.0 and 5.6 are available in `exolnet/homebrew-deprecated`
*tap*. First register this *tap* with your local Homebrew installation with:

```console
brew tap exolnet/homebrew-deprecated
```

Now you can install PHP 7.1, 7.0 and 5.6 with:

```console
brew install exolnet/deprecated/php@7.1
brew install exolnet/deprecated/php@7.0
brew install exolnet/deprecated/php@5.6
```

### 1.3 If using Ubuntu

On latest Ubuntu (20.04 in the time of writing), only the latest PHP version
(PHP 7.4 in the time of writing) is available in the default repository. For
older versions we need to use the `ondrej/php` PPA repository. 

To add this repository, execute on the command line:

```console
sudo add-apt-repository ppa:ondrej/php
```

Then, install imagemagick:

```console
sudo apt install imagemagick
```

Then, to install PHP 7.4, 7.3, 7.2, 7.1 and 5.6 execute on the command line:

```console
sudo apt install php7.4 php7.4-fpm php7.4-imagick php7.4-gd php7.4-curl php7.4-opcache php7.4-mbstring php7.4-xsl php7.4-intl php7.4-sqlite3 php7.4-zip php7.4-mysql php7.4-bcmath
sudo apt install php7.3 php7.3-fpm php7.3-imagick php7.3-gd php7.3-curl php7.3-opcache php7.3-mbstring php7.3-xsl php7.3-intl php7.3-sqlite3 php7.3-zip php7.3-mysql php7.3-bcmath
sudo apt install php7.2 php7.2-fpm php7.2-imagick php7.2-gd php7.2-curl php7.2-opcache php7.2-mbstring php7.2-xsl php7.2-intl php7.2-sqlite3 php7.2-zip php7.2-mysql php7.2-bcmath
sudo apt install php7.1 php7.1-fpm php7.1-imagick php7.1-gd php7.1-curl php7.1-opcache php7.1-mbstring php7.1-xsl php7.1-intl php7.1-sqlite3 php7.1-zip php7.1-mysql php7.1-bcmath
sudo apt install php5.6 php5.6-fpm php5.6-imagick php5.6-gd php5.6-curl php5.6-opcache php5.6-mbstring php5.6-xsl php5.6-intl php5.6-sqlite3 php5.6-zip php5.6-mysql php5.6-bcmath
```

**Note**: some PHP packages differ from macOS instructions because eg. `php-openssl`
is included in the main PHP package on Ubuntu and doesn't exist as a standalone
package, while `php-mysql` and `php-bcmath` are needed but not included by default.

Now you can select desired default PHP version with:

```console
sudo update-alternatives --config php
```

## 2 Configure

### 2.1 Configure PHP-FPM pool definitions

For each PHP version edit PHP-FPM pool definition files (documented further below)
and update it with the following configuration options:

```ini
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
```

Make sure to use your own user and group instead of `brale` and `staff`, and
name the socket file corresponding to the PHP version. Use configuration already
existing in the file and do not create duplicate entries.

**Note**: Configuration files use `;` character as a comment, so make sure you
remove it as needed.

#### PHP-FPM resource consumption

Main PHP-FPM manager process takes up a small amount of memory, but spawned
workers can take up to few hundred megabytes, depending on the application that
was executed. To see how many worker processes are active and how much memory
they use you can check the list of processes (`ps` or `pstree` on the command
line), or open the PHP-FPM status page for the specific PHP version, for example
https://home.php73/status?full&html.

### 2.1 Configure PHP-FPM pool definitions if installed using Homebrew

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

### 2.2 Configure PHP-FPM pool definitions if installed using MacPorts

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

**Note**: similar as with Homebrew, for PHP 5.6 pool definition in the main FPM
configuration file.

Update the created pool definition files as described above.

### 2.3 Configure PHP-FPM pool definitions on Ubuntu

Find PHP-FPM pool definitions for your PHP versions in following files

```text
/etc/php/7.4/fpm/pool.d/www.conf
/etc/php/7.3/fpm/pool.d/www.conf
/etc/php/7.2/fpm/pool.d/www.conf
/etc/php/7.1/fpm/pool.d/www.conf
/etc/php/5.6/fpm/pool.d/www.conf
```

Update these pool definition files as described above.

**Note:** don't forget to use `sudo` as these are editable only by the root user.

## 3 Configure PHP

For each PHP version find its configuration file (documented further below) and
update it with the following configuration options:

```ini
date.timezone = Europe/Zagreb
session.gc_maxlifetime = 86400
memory_limit = 256M
error_log = /Users/brale/php73.log
```

Don't forget to modify error log path to your user's home directory, and set the
correct PHP version depending on the ini file you're modifying.

**Note**: Configuration files use `;` character as a comment, so make sure you
remove it as needed.

### 3.1 Configure PHP if using macOS and Homebrew

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

### 3.2 Configure PHP if using macOS and MacPorts

First create PHP configuration files by copying the default ones:

```console
sudo cp /opt/local/etc/php74/php.ini-development /opt/local/etc/php74/php.ini
sudo cp /opt/local/etc/php73/php.ini-development /opt/local/etc/php73/php.ini
sudo cp /opt/local/etc/php72/php.ini-development /opt/local/etc/php72/php.ini
sudo cp /opt/local/etc/php71/php.ini-development /opt/local/etc/php71/php.ini
sudo cp /opt/local/etc/php70/php.ini-development /opt/local/etc/php70/php.ini
sudo cp /opt/local/etc/php56/php.ini-development /opt/local/etc/php56/php.ini
```

Update the created configuration files as described above and additionally with:

```ini
pdo_mysql.default_socket=/opt/local/var/run/mysql8/mysqld.sock
mysqli.default_socket=/opt/local/var/run/mysql8/mysqld.sock
```

This will enable using `localhost` as the database host from your application.

### 3.3 Configure PHP on Ubuntu

Find the configuration for your PHP versions in the following files:

```text
/etc/php/7.4/fpm/php.ini
/etc/php/7.3/fpm/php.ini
/etc/php/7.2/fpm/php.ini
/etc/php/7.1/fpm/php.ini
/etc/php/5.6/fpm/php.ini
```

Update these configuration files as described above.

## 4 Symlink PHP binaries

### 4.1 Symlink PHP binaries on macOS with Homebrew

Symlink each PHP binary to an easily accessible alias:

```console
ln -s /usr/local/Cellar/php@7.4/7.4.xx/bin/php ~/bin/php7.4
ln -s /usr/local/Cellar/php@7.3/7.3.xx/bin/php ~/bin/php7.3
ln -s /usr/local/Cellar/php@7.2/7.2.xx/bin/php ~/bin/php7.2
ln -s /usr/local/Cellar/php@7.1/7.1.xx/bin/php ~/bin/php7.1
ln -s /usr/local/Cellar/php@7.0/7.0.xx/bin/php ~/bin/php7.0
ln -s /usr/local/Cellar/php@5.6/5.6.xx/bin/php ~/bin/php5.6
```

Make sure you use correct paths to the PHP binary. This path will change when
upgrading a PHP version, so you will need to maintain your symlinks through
upgrades.

### 4.2 Symlink PHP binaries on macOS with MacPorts

**Note**: while MacPorts already provides binaries for each PHP version, we want
to add new symlinks to make it in line with Linux, which is used on production
servers. The only difference between them is in the dot placed between major and
minor version numbers.

Symlink each PHP binary to an easily accessible alias:

```console
ln -s /opt/local/bin/php74 ~/bin/php7.4
ln -s /opt/local/bin/php73 ~/bin/php7.3
ln -s /opt/local/bin/php72 ~/bin/php7.2
ln -s /opt/local/bin/php71 ~/bin/php7.1
ln -s /opt/local/bin/php70 ~/bin/php7.0
ln -s /opt/local/bin/php56 ~/bin/php5.6
```

### 4.3 Symlink PHP binaries on Ubuntu

On Ubuntu this step is not needed as the binaries are already provided in the
format we rely on.

### 4.4 Test

Test you can access PHP binary aliases by executing:

```console
php7.4 -v
php7.3 -v
php7.2 -v
php7.1 -v
php7.0 -v
php5.6 -v
```

## 5 Start PHP-FPM services

You can now start PHP services.

### 5.1 Start PHP-FPM services if installed using Homebrew

```console
sudo brew services start php@7.4
sudo brew services start php@7.3
sudo brew services start php@7.2
sudo brew services start php@7.1
sudo brew services start php@7.0
sudo brew services start php@5.6
```

This will also ensure that PHP-FPM server starts automatically after a reboot.

Remember to restart them after changing PHP configuration in the future with:

```console
sudo brew services restart php@x.x
```

To stop the server and prevent it from running after a reboot, execute:

```console
sudo brew services stop phpxx-fpm
```

### 5.2 Start PHP-FPM services if installed using MacPorts

```console
sudo port load php74-fpm
sudo port load php73-fpm
sudo port load php72-fpm
sudo port load php71-fpm
sudo port load php70-fpm
sudo port load php56-fpm
```

This will also ensure that PHP-FPM server starts automatically after a reboot.

Remember to restart them after changing PHP configuration in the future with:

```console
sudo port reload phpxx-fpm
```

To stop the server and prevent it from running after a reboot, execute:

```console
sudo port unload phpxx-fpm
```

### 5.3 Start PHP-FPM services on Ubuntu

```console
sudo systemctl start php7.4-fpm
sudo systemctl start php7.3-fpm
sudo systemctl start php7.2-fpm
sudo systemctl start php7.1-fpm
sudo systemctl start php5.6-fpm
```

Except `start`, you can also use commands such as:
* `status` - to see if PHP-FPM service is running
* `stop` - to stop the PHP-FPM service
* `restart` - to restart the PHP-FPM service (does stop then start)

Remember to restart the FPM server after changing the configuration.

**Note:** by default all PHP-FPM services are set-up to automatically start
after a reboot. To check if a service is enabled to automatically start on
boot use:

```console
sudo systemctl is-enabled php7.4-fpm
```

And then you can enable it with:

```console
sudo systemctl enable php7.4-fpm
```

Or disable with:

```console
sudo systemctl disable php7.4-fpm
```

## 6 Install PHP extensions

Installed PHP will come with built-in extension, but if your project requires
additional extensions, these have to be installed separately.

### 6.1 Install PHP extensions using MacPorts

MacPorts already provides installable PHP extensions, find them for a
particular PHP version by executing:

```console
port list php56\*
```

Simply install the PHP extension you need, using MacPorts, for example:

```console
sudo port install php56-memcached
```

### 6.2 If using Homebrew, compile the required PHP extensions manually

Install extensions using pecl for the specific version of php, for example:

```console
/usr/local/Cellar/php@7.1/7.1.33/bin/pecl install imagick
```

Add the extension ini file to the `conf.d` folder for the specific version of php, for example:

```console
echo "extension=imagick.so" > /usr/local/etc/php/7.1/conf.d/ext-imagick.ini
```

Make sure to replace the path to the pecl binary, the extension and the extension ini file to match your version of php and the extension you want to install.

### 6.3 Install PHP extensions on Ubuntu

Simply install the PHP extension you need, for example:

```console
sudo apt install php5.6-mysql
```

**Note:** Some extensions do not have a PHP version in their name, eg.

```console
sudo apt install php-memcached
```

## 7 Install and symlink PHP CS Fixer

In order for code to be in line with both, general PHP coding standards and company coding standards, PHP CS Fixer 
is required on most of the projects.

### 7.1 Install PHP CS Fixer

Follow globally installation instructions on [official installation instructions page](https://github.com/FriendsOfPHP/PHP-CS-Fixer/blob/master/doc/installation.rst).

### 7.2 Add correct symlink (Mac only)

On Mac, if system doesn't allow you to move file to /usr/local/bin/php-cs-fixer (last step in installation instructions), you can add symlink instead:

```console
sudo ln -s [/path/to/original/php-cs-fixer] /usr/local/bin/php-cs-fixer
```
