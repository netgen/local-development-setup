Set up RabbitMQ message-broker
==============================

RabbitMQ is an open-source message-broker software, used for sending and
receiving messages using a queue in order to process them
asynchronously.

1 Install
---------

1.1 If using MacOS with Homebrew
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Execute on the command line:

.. code:: console

   brew install rabbitmq

1.2 If using MacOS with MacPorts
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Execute on the command line:

.. code:: console

   sudo port install rabbitmq-server

2 Enable plugins
----------------

**Note**: This step is needed only if you are using MacOS with MacPorts

.. _if-using-macos-with-macports-1:

2.1 If using MacOS with MacPorts
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

To enable web management UI, enable ``rabbitmq_management`` plugin by
executing on the command line:

.. code:: console

   rabbitmq-plugins enable rabbitmq_management


3 Start
-------

Since it’s not needed every project, and it takes up valuable system
resources, it’s preferred to start RabbitMQ manually when needed.

3.1 Start manually (recommended)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. _if-using-macos-with-homebrew-1:

3.1.1 If using MacOS with Homebrew
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Execute on the command line:

.. code:: console

   rabbitmq-server

.. _if-using-macos-with-macports-2:

3.1.2 If using MacOS with MacPorts
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Execute on the command line:

.. code:: console

   sudo rabbitmq-server

The server will run in the foreground, and you can stop it when needed
with ``Control-C``.


3.2 Start automatically
~~~~~~~~~~~~~~~~~~~~~~~

If wanted, you can also set it up to start automatically after a reboot.

.. _if-using-macos-with-macports-3:

3.2.1 If using MacOS with MacPorts
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Execute on the command line:

.. code:: console

   sudo port load rabbitmq-server

To stop the server and prevent it from running after a reboot, execute:

.. code:: console

   sudo port unload rabbitmq-server

.. _if-using-macos-with-homebrew-2:

3.2.2 If using MacOS with Homebrew
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Execute on the command line:

.. code:: console

   sudo brew services start rabbitmq

To stop the server and prevent it from running after a reboot, execute:

.. code:: console

   sudo brew services stop rabbitmq

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
