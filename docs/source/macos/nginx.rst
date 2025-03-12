Set up NGINX web server
=======================

1 Install
---------

1.1 Install on macOS using MacPorts
-----------------------------------

.. code:: console

   sudo port install nginx

1.2 Install on macOS using Homebrew
-----------------------------------

.. code:: console

   brew install nginx

2 Configure
-----------

Once NGINX is installed, use files given in this directory to configure
the installation. First you will need to clone this repository in order
to copy configuration files and websites:

.. code:: console

   cd ~/projects
   git clone git@github.com:netgen/local-development-setup.git

They you will also need to find the location of configuration files and
logs, which depends on the OS and package manager.

2.1 If using macOS with MacPorts
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Copy the configuration files to the configuration directory:

.. code:: console

   sudo cp -r ~/projects/local-development-setup/nginx/* /opt/local/etc/nginx

Don’t forget to edit file ``/opt/local/etc/nginx/nginx.conf`` and change
user and user group.

Create a directory where configuration for the enabled sites will be
located:

.. code:: console

   sudo mkdir /opt/local/etc/nginx/sites-enabled

Now position into the created directory and symlink all available site
configurations:

.. code:: console

   cd /opt/local/etc/nginx/sites-enabled
   sudo ln -s ../sites-available/* ./

Paths in the copied configuration files are already correct for macOS
using MacPorts, so no adjustments are needed.

To finish this step set permissions on the log directory:

.. code:: console

   sudo chown -R brale:staff /opt/local/var/log/nginx

2.2 If using macOS with Homebrew
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Copy the configuration files to the configuration directory:

.. code:: console

   cp -r ~/projects/local-development-setup/nginx/* /usr/local/etc/nginx

Don’t forget to edit file ``/etc/nginx/nginx.conf`` and change user and
user group.

Create a directory where configuration for the enabled sites will be
located:

.. code:: console

   mkdir /usr/local/etc/nginx/sites-enabled

Now position into the created directory and symlink all available site
configurations:

.. code:: console

   cd /usr/local/etc/nginx/sites-enabled
   ln -s ../sites-available/* ./

Since the configuration files were created for NGINX installed on MacOS
with MacPorts, you will need to update them with paths that are correct
for MacOS with Homebrew.

In case you use GNU sed (you will know if you do), execute the following
on the command line:

.. code:: console

   cd /usr/local/etc/nginx
   find . -type f -exec sed -i 's/\/opt\/local/\/usr\/local/g' {} +

Otherwise, execute:

.. code:: console

   cd /usr/local/etc/nginx
   LC_ALL=C find . -type f -exec sed -i '' 's/\/opt\/local/\/usr\/local/g' {} +

3 Link SSL certificates
-----------------------

SSL certificates created in one of the previous steps need to be linked
to the NGINX configuration directory.

3.1 If using macOS with MacPorts
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Execute on the command line:

.. code:: console

   cd /opt/local/etc/nginx
   sudo ln -s ~/ssl/server.crt
   sudo ln -s ~/ssl/server.key

3.2 If using macOS with Homebrew
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Execute on the command line:

.. code:: console

   cd /usr/local/etc/nginx
   sudo ln -s ~/ssl/server.crt
   sudo ln -s ~/ssl/server.key

4 Start the server
------------------

4.1 If using macOS with MacPorts
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code:: console

   sudo port load nginx

This will also start the server automatically after a reboot.

4.2 If using macOS with Homebrew
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code:: console

   sudo brew services start nginx

This will also start the server automatically after a reboot.

5 Installation of websites
--------------------------

Now you can install websites provided in ``websites`` directory in the
root of the repository. Websites will be located in ``/var/www``
directory. While this folder already exists on Ubuntu, on macOS you need
to generate it first:

.. code:: console

   sudo mkdir /var/www

Then we need to set the permissions on this directory:

.. code:: console

   sudo chown -R brale:staff /var/www

Now you can copy the websites to the created directory:

.. code:: console

   cp -r ~/projects/local-development-setup/websites/* /var/www

Verify that everything works as expected by opening:

-  https://home.php74:8443
-  https://phpinfo.php74:8443

The first website is your homepage, which you can freely customize as
you find fit. Second website will give you PHP info page, useful to see
the details of the particular PHP installation.

You can change the top-level domain to choose which PHP version will be
used to serve the website.

.. caution::

   Before configuring HAProxy (in the next section) you will be able to
   access the websites only through ports ``8080`` (HTTP) and ``8443``
   (HTTPS). After configuring HAProxy, you will be able to access them
   though default ports ``80`` and ``443``.

Testing your website on a different device
------------------------------------------

This setup works with multiple custom local domains, which is not
trivial to directly expose on a local network, since it would need to
involve a DNS server.

However, is possible to expose a specific website on your local IP,
which you can then use to open the website on a different device
connected to your local network, for example smartphone or a tablet. To
do that, uncomment the configuration block found in:

::

   /usr/local/etc/nginx/sites-enabled/local_network_proxy

Then adjust the IP and local website address as needed.

After restarting nginx server, you should be able to use the IP to open
the website on a different device which is also connected to your local
network.
