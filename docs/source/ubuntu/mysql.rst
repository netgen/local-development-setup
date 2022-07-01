Set up MySQL database server
============================

MySQL is an open-source relational database management system.

1 Install
---------

Execute on the command line:

.. code:: console

   sudo apt install mysql-server

2 Start
-------

Since MySQL is an essential part of our web apps, so we want it always
running and started automatically after a reboot.

By default, MySQL server will be started and enabled to automatically
start after reboot on Ubuntu. If you want to manually
start/stop/enable/disable it, you can use following commands:

.. code:: console

   sudo service mysql restart
   sudo service mysql start
   sudo service mysql stop
   sudo service mysql status
   sudo systemctl is-enabled mysql
   sudo systemctl enable mysql
   sudo systemctl disable mysql

3 Secure
--------

3.1 Enable and configure ``root`` user
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

On Ubuntu by default the ``root`` user may be set up in a way that you
can’t log in with credentials. If you’re not able to login with
``root:root``, you will have to enable root user and set it’s password.
In order to fix this, enter the MySQL shell as sudo:

.. code:: console

   sudo mysql

Then inside the MySQL command line execute the following commands:

.. code:: mysql

   ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'root';
   FLUSH PRIVILEGES;

**Note:** You can change ``root`` with another password that you want to
use.

At last, you need to restart the MySQL service:

.. code:: console

   sudo service mysql restart

After that, you will be able to login with:

.. code:: console

   mysql -u root -p

3.2 Run MySQL secure installation
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Improve the security of the installation by executing the following on
the command line (note: Ubuntu will ask for ``root`` user’s password):

.. code:: console

   mysql_secure_installation

Follow the instructions to configure ``root`` as password for the
``root`` user. If MySQL was installed using MacPorts, enter the password
generated at the initialization.

Additionally, follow the instructions to:

-  skip setting up VALIDATE PASSWORD component
-  remove anonymous users and test databases
-  disallow the remote login for ``root``

That will be sufficient for local development needs.

4 Configure
-----------

4 Create admin user
-------------------

To avoid MySQL upgrade borking the database access by resetting the
password authentication method, we will create a new user ``admin`` with
password ``admin`` which will be used to access the server.

First, log into the server by executing the following on the command
line:

.. code:: console

   mysql -uroot -p

Enter the password ``root`` when asked. If you set up everything
correctly, you should arrive at the MySQL command-line client. Execute
on the ``mysql>`` command line:

.. code:: console

   CREATE USER 'admin'@'localhost' IDENTIFIED WITH mysql_native_password BY 'admin';
   GRANT ALL PRIVILEGES ON *.* TO 'admin'@'localhost';
   FLUSH PRIVILEGES;

Now you can exit the MySQL command-line client by typing ``exit``.

5 Test
------

Test that you can use your newly created ``admin`` user to access the
command line by executing:

.. code:: console

   mysql -uadmin -p

Enter the password ``admin`` when asked. You should again arrive at the
MySQL command-line client:

.. code:: text

   Welcome to the MySQL monitor.  Commands end with ; or \g.
   Your MySQL connection id is 49

   Copyright (c) 2000, 2020, Oracle and/or its affiliates. All rights reserved.

   Oracle is a registered trademark of Oracle Corporation and/or its
   affiliates. Other names may be trademarks of their respective
   owners.

   Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

   mysql>

6 Install a GUI client
----------------------

You will probably also want a graphical UI client to work with the
database server. For Ubuntu, you can use `DBeaver
Community <https://dbeaver.io/>`__ which is free and multi-platform tool
with support for all popular databases and offers a lot of features.

Install your preferred GUI client and configure the connection to the
server with the ``admin`` user. If the connection works, you’ve finished
installing and configuring your MySQL server.
