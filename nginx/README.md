# Install and configure `NGINX` web server

## 1 Install

## 1.1 Install on `MacOS` using `MacPorts`

```console
sudo port install nginx
```

## 1.2 Install on `MacOS` using `Homebrew`

```console
brew install nginx
```

## 2 Configure

Once `NGINX` is installed, use files given in this directory to configure the
installation. First you will need to find the location of configuration files
and logs, which depends on the OS and package manager.

todo note about repo path

### 2.1 If using `MacOS` with `MacPorts`

Copy the configuration files to the configuration directory:

```console
sudo cp -r /part/to/repository/nginx/* /opt/local/etc/nginx
```

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

Paths in the copied configuration files are already correct for `MacOS` using
`MacPorts`, so you are done with this step.

### 2.2 If using `MacOS` with `Homebrew`

Copy the configuration files to the configuration directory:

```console
cp -r /path/to/repository/nginx/* /usr/local/etc/nginx
```

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

Since the configuration files were created for `NGINX` installed on `MacOS` with
`MacPorts`, you will need to update them with paths that are correct for `MacOS`
with `Homebrew`.

In case you use GNU sed (you will know if you do), execute the following:

```console
cd /usr/local/etc/nginx
find . -type f -exec sed -i 's/\/opt\/local/\/usr\/local/g' {} +
```

Otherwise, execute:

```console
cd /usr/local/etc/nginx
LC_ALL=C find . -type f -exec sed -i '' 's/\/opt\/local/\/usr\/local/g' {} +
```

## 3 Create SSL certificates

Open [SSL](ssl) and complete the instructions there, then return here and
continue with instructions below.

## 4 Start the server

### 4.1 If using `MacOS` with `MacPorts`

```console
sudo port load nginx
```

This will also start the server automatically after a reboot.

### 4.2 If using `MacOS` with `Homebrew`

```console
sudo brew services start nginx
```

This will also start the server automatically after a reboot.

## 5 Install websites

Now you can install websites provided in `websites` directory in the root of the
repository. Websites will be located in `/var/www` directory , which needs to be
created first:

```console
sudo mkdir /var/www
sudo chown brale:staff /var/www
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
