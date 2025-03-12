Set up Memcached distributed memory object caching system
=========================================================

Memcached is an in-memory key-value store for small chunks of arbitrary
data (strings, objects) from results of database calls, API calls, or
page rendering. It’s used as a backend for persistent cache
implementation on some older projects (newer projects mostly use
`Redis <../redis>`__).

1 Install
---------

1.1 If using MacOS with MacPorts
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Execute on the command line:

.. code:: console

   sudo port install memcached
   sudo port install libmemcached

You’ll also need to install PHP extension, which depends on your PHP
version so modify the next command to suit your version:

.. code:: console

   sudo port install php74-memcached

You can check the available ports
`here <https://ports.macports.org/?search=memcached>`__.

1.2 If using MacOS with Homebrew
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

TODO

2 Start
-------

2.1 Start automatically
~~~~~~~~~~~~~~~~~~~~~~~

2.1.1 If using MacOS with MacPorts
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Execute on the command line:

.. code:: console

   sudo port load memcached

This will start the server and set it up to start automatically after a
reboot.

To stop the server and prevent it from running after a reboot, execute:

.. code:: console

   sudo port unload memcached

2.1.2 If using MacOS with Homebrew
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

TODO

2.2 Start manually when needed
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

2.2.1 If using MacOS with MacPorts
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

To start memcached manually, simply execute:

.. code:: console

   memcached

It will run in the foreground, and you can stop it when needed with
Control-C.

2.2.2 If using MacOS with Homebrew
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

TODO

3 Test
------

To test if the ``memcached`` server is running, execute:

.. code:: console

   ps aux | grep memcached

You should see its process there, altogether with the port on which it
listens to (default ``11211``).

Then you can ``telnet`` to it with:

.. code:: console

   telnet localhost 11211
