Set up NGINX web server
=======================

1 Install
---------

In order to install NGINX web server on Ubuntu, execute the following
command:

.. code:: console

   sudo apt install nginx

**Note**: depending on the type of your Ubuntu installation, your OS
might have Apache web server preinstalled. In that case, you might have
problems starting NGINX because Apache is already listening on the port
where NGINX wants to listen to.

In that case, you should stop Apache service and disable it from
starting on boot:

.. code:: console

   sudo systemctl stop apache2
   sudo systemctl disable apache2

In case you will need Apache, you need to stop NGINX first and then
start Apache.

**Optional**: if you don’t need Apache at all, you can remove it to save
some space:

.. code:: console

   sudo service apache2 stop
   sudo apt purge apache2 apache2-utils apache2.2-bin
   sudo apt autoremove
   sudo rm -rf /etc/apache2

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

Copy the configuration files to the configuration directory:

.. code:: console

   sudo cp -r ~/projects/local-development-setup/nginx/* /etc/nginx

Don’t forget to edit file ``/etc/nginx/nginx.conf`` and change user and
user group.

Now position into the directory for enabled sites and symlink all
available site configurations:

.. code:: console

   cd /etc/nginx/sites-enabled
   sudo ln -s ../sites-available/* ./

Ubuntu uses different directories for enabled vhosts and log files, so
we need to update these:

.. code:: console

   cd /etc/nginx
   find . -type f -exec sudo sed -i 's/\/opt\/local\/etc\/nginx/\/etc\/nginx/g' {} +
   find . -type f -exec sudo sed -i 's/\/opt\/local\/var\/log/\/var\/log/g' {} +

Then we need to set permissions for this repository:

.. code:: console

   sudo chown -R brale:staff /var/log/nginx
   sudo chmod -R u+X /var/log/nginx

3 Link SSL certificates
-----------------------

SSL certificates created in one of the previous steps need to be linked
to the NGINX configuration directory.

Execute on the command line:

.. code:: console

   cd /etc/nginx
   sudo ln -s ~/ssl/server.crt
   sudo ln -s ~/ssl/server.key

4 Start the server
------------------

.. code:: console

   sudo service nginx start

Except ``start``, you can also use commands such as: \* ``status`` - to
see if Nginx service is running \* ``stop`` - to stop the Nginx service
\* ``restart`` - to restart the Nginx service (does stop then start)

To check if Nginx service is enabled to start after reboot, try:

.. code:: console

   sudo systemctl is-enabled nginx

To enable it to automatically start after a reboot:

.. code:: console

   sudo systemctl enable nginx

5 Installation of websites
--------------------------

Now you can install websites provided in ``websites`` directory in the
root of the repository. Websites will be located in ``/var/www``
directory.

Then we need to set the permissions on this directory:

.. code:: console

   sudo chown -R brale:staff /var/www

Now you can copy the websites to the created directory:

.. code:: console

   cp -r ~/projects/local-development-setup/websites/* /var/www

Verify that everything works as expected by opening:

-  https://home.php74
-  https://phpinfo.php74

The first website is your homepage, which you can freely customize as
you find fit. Second website will give you PHP info page, useful to see
the details of the particular PHP installation.

You can change the top-level domain to choose which PHP version will be
used to serve the website.

Testing your website on a different device
==========================================

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
