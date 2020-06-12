# Install `NGINX` web server

You can install `NGINX` web server using `brew`:

```console
brew install nginx
```

Once `NGINX` is installed, use files given in this directory to configure the
installation.

First, copy the files to `/usr/local/etc/nginx`. Create a new directory
`sites-enabled` and symlink to it all files from `site-available` directory.

Now open [SSL](nginx/ssl) and complete the instructions there, then return here
and continue with instructions below.

Once you finished configuring SSL, start `NGINX` server with:

```console
sudo brew start nginx
```

It's important the server is started using `sudo`, since it needs to run on port
`80`, which is not available to normal user. This will also ensure that it's
started automatically after a reboot.

You can check that created configuration is valid with:

```console
sudo nginx -t
```

Now you can install websites provided in `websites` directory in the root of the
repository. Copy them to `/var/www` and move files found in the `home`
website, `index.php.dist` to `index.php` and `style.css.dist` to `style.css`.

Verify that everything works as expected by opening:

- https://home.php74
- https://phpinfo.php74

The first website will give you your homepage, which you can freely customize
for your needs as needed. Second website will give you PHP info page, useful to
see the details of the particular PHP installation.

You can change the top-level domain to choose which PHP version will be used to
serve the website.
