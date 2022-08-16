Set up RabbitMQ message-broker
==============================

RabbitMQ is an open-source message-broker software, used for sending and
receiving messages using a queue in order to process them
asynchronously.

1 Install
---------

Execute on the command line:

.. code:: console

   sudo apt install rabbitmq-server

2 Enable plugins
----------------

To enable web management UI, enable ``rabbitmq_management`` plugin by
executing on the command line with sudo:

.. code:: console

   sudo rabbitmq-plugins enable rabbitmq_management

3 Start
-------

Since it’s not needed every project, and it takes up valuable system
resources, it’s preferred to start RabbitMQ manually when needed.

3.1 Start manually (recommended)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Execute on the command line:

.. code:: console

   sudo rabbitmq-server

The server will run in the foreground, and you can stop it when needed
with ``Control-C``.

You can also start it as a service:

.. code:: console

   sudo service rabbitmq-server start

Other service commands are also available:

.. code:: console

   sudo service rabbitmq-server status
   sudo service rabbitmq-server stop
   sudo service rabbitmq-server restart

3.2 Start automatically
~~~~~~~~~~~~~~~~~~~~~~~

If wanted, you can also set it up to start automatically after a reboot.

Execute on the command line:

.. code:: console

   sudo systemctl enable rabbitmq-server

To stop the server and prevent it from running after a reboot, execute:

.. code:: console

   sudo systemctl disable rabbitmq-server

To check if the server is enabled to run after a reboot, execute:

.. code:: console

   sudo systemctl is-enabled rabbitmq-server

4 Test
------

Test the server works by opening web management UI at
http://localhost:15672.

Login into the UI with user ``guest`` and password ``guest``.

5 Configure in a project
------------------------

If you need to configure it for a project, API will be available at
``http://localhost:5672`` with the same credentials as mentioned above:
user ``guest`` and password ``guest``.
