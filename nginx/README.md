# Set up NGINX web server

## 1 Install

## 1.1 Install on MacOS using MacPorts

```console
sudo port install nginx
```

## 1.2 Install on MacOS using Homebrew

```console
brew install nginx
```

## 1.3 Install on Ubuntu

In order to install NGINX web server on Ubuntu, execute the following command:

```console
sudo apt install nginx
```

**Note**: depending on the type of your Ubuntu installation, your OS might have
Apache web server preinstalled. In that case, you might have problems starting NGINX
because Apache is already listening on the port where NGINX wants to listen to.

In that case, you should stop Apache service and disable it from starting on boot:

```console
sudo systemctl stop apache2
sudo systemctl disable apache2
```

In case you will need Apache, you need to stop NGINX first and then start Apache.

**Optional**: if you don't need Apache at all, you can remove it to save some
space:

```console
sudo service apache2 stop
sudo apt purge apache2 apache2-utils apache2.2-bin
sudo apt autoremove
sudo rm -rf /etc/apache2
```

## 2 Configure

Once NGINX is installed, use files given in this directory to configure the
installation. First you will need to find the location of configuration files
and logs, which depends on the OS and package manager.

todo note about repo path

### 2.1 If using MacOS with MacPorts

Copy the configuration files to the configuration directory:

```console
sudo cp -r /part/to/repository/nginx/* /opt/local/etc/nginx
```

Don't forget to edit file `/etc/nginx/nginx.conf` and change user and user group.

Create a directory where configuration for the enabled sites will be located:

```console
sudo mkdir /opt/local/etc/nginx/sites-enabled
```

Now position into the created directory and symlink all available site
configurations:

```console
cd /opt/local/etc/nginx/sites-enabled
sudo ln -s ../sites-available/* ./
```

Paths in the copied configuration files are already correct for MacOS using
MacPorts, so you are done with this step.

### 2.2 If using MacOS with Homebrew

Copy the configuration files to the configuration directory:

```console
cp -r /path/to/repository/nginx/* /usr/local/etc/nginx
```

Don't forget to edit file `/etc/nginx/nginx.conf` and change user and user group.

Create a directory where configuration for the enabled sites will be located:

```console
cd /usr/local/etc/nginx/sites-enabled
```

Now position into the created directory and symlink all available site
configurations:

```console
mkdir /usr/local/etc/nginx/sites-enabled
ln -s ../sites-available/* ./
```

Since the configuration files were created for NGINX installed on MacOS with
MacPorts, you will need to update them with paths that are correct for MacOS
with Homebrew.

In case you use GNU sed (you will know if you do), execute the following on the
command line:

```console
cd /usr/local/etc/nginx
find . -type f -exec sed -i 's/\/opt\/local/\/usr\/local/g' {} +
```

Otherwise, execute:

```console
cd /usr/local/etc/nginx
LC_ALL=C find . -type f -exec sed -i '' 's/\/opt\/local/\/usr\/local/g' {} +
```

### 2.3 If using Ubuntu

Copy the configuration files to the configuration directory:

```console
sudo cp -r /path/to/repository/nginx/* /etc/nginx
```

Don't forget to edit file `/etc/nginx/nginx.conf` and change user and user group.

Now position into the directory for enabled sites and symlink
all available site configurations:

```console
cd /etc/nginx/sites-enabled
sudo ln -s ../sites-available/* ./
```

Ubuntu uses different directory for log files so we need to update these:

```console
cd /etc/nginx
find . -type f -exec sudo sed -i 's/\/opt\/local\/var\/log/\/var\/log/g' {} +
```

Then we need to set permissions for this repository:

```console
sudo chown -R brale:staff /var/log/nginx
sudo chmod -R u+X /var/log/nginx
```

## 3 Link SSL certificates

SSL certificates created in one of the previous steps need to be linked to the
NGINX configuration directory.

### 3.1 If using MacOS with MacPorts

Execute on the command line:

```console
cd /opt/local/etc/nginx
sudo ln -s ~/ssl/server.crt
sudo ln -s ~/ssl/server.key
```

### 3.2 If using MacOS with Homebrew

Execute on the command line:

```console
cd /usr/local/etc/nginx
sudo ln -s ~/ssl/server.crt
sudo ln -s ~/ssl/server.key
```

### 3.3 If using Ubuntu

Execute on the command line:

```console
cd /etc/nginx
sudo ln -s ~/ssl/server.crt
sudo ln -s ~/ssl/server.key
```

## 4 Start the server

### 4.1 If using MacOS with MacPorts

```console
sudo port load nginx
```

This will also start the server automatically after a reboot.

### 4.2 If using MacOS with Homebrew

```console
sudo brew services start nginx
```

This will also start the server automatically after a reboot.

### 4.3 If using Ubuntu

```console
sudo service nginx start
```

Except `start`, you can also use commands such as:
* `status` - to see if Nginx service is running
* `stop` - to stop the Nginx service
* `restart` - to restart the Nginx service (does stop then start)

To check if Nginx service is enabled to start after reboot, try:

```console
sudo systemctl is-enabled nginx
```

To enable it to automatically start after reboot:

```console
sudo systemctl enable nginx
```

## 5 Install websites

Now you can install websites provided in `websites` directory in the root of the
repository. Websites will be located in `/var/www` directory. While this folder
already exists on Ubuntu, on MacOS you need to generate it first:

```console
sudo mkdir /var/www
```

Then we need to set the permissions on this directory:

```console
sudo chown -R brale:staff /var/www
```

Now you can copy the websites to the created directory:

```console
cp -r /path/to/repository/websites/* /var/www
```

Verify that everything works as expected by opening:

- https://home.php74
- https://phpinfo.php74

The first website is your homepage, which you can freely customize as you find
fit. Second website will give you PHP info page, useful to see the details of
the particular PHP installation.

You can change the top-level domain to choose which PHP version will be used to
serve the website.
