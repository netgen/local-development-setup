Set up Redis in-memory data store
=================================

Redis is an open source in-memory data structure store and key–value
database with optional durability. It’s used as a backend for persistent
cache implementation.

1 Install
---------

1.1 If using macOS with MacPorts
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Execute on the command line:

.. code:: console

   sudo port install redis

1.2 If using macOS with Homebrew
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Execute on the command line:

.. code:: console

   brew install redis

2 Start
-------

Since Redis is usually used in our web apps, we want it always running
and started automatically after a reboot.

2.1 Start automatically (recommended)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

2.1.1 If using MacOS with MacPorts
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Execute on the command line:

.. code:: console

   sudo port load redis

This will start the server and set it up to start automatically after a
reboot.

To stop the server and prevent it from running after a reboot, execute:

.. code:: console

   sudo port unload redis

2.1.2 If using macOS with Homebrew
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Execute on the command line:

.. code:: console

   sudo brew services start redis

This will start the server and set it up to start automatically after a
reboot.

To stop the server and prevent it from running after a reboot, execute:

.. code:: console

   sudo brew services stop redis


2.2 Start manually when needed
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

You can start the server manually by executing on the command line:

.. code:: console

   redis-server

The server will run in the foreground, and you can stop it when needed
with ``Control-C``.

3 Test
------

To test if the ``Redis`` server is running, execute:

.. code:: console

   redis-cli ping

If correctly started, Redis should respond with ``PONG``.
