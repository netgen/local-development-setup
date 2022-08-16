Set up Node.js version management
=================================

If your project requires a specific Node.js version that is not
available from your package manager, you can use ``n``, Node.js version
manager. With it, you can maintain and switch between multiple versions
of Node.js.

1 Install ``n``
---------------

First uninstall Node.js, as it will conflict with the versions installed
through the version manager.

1.1 If using macOS with MacPorts
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Execute on the command line:

.. code:: console

   sudo port install n

1.2 If using macOS with Homebrew
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Execute on the command line:

.. code:: console

   brew install n


2 Configure
-----------

To avoid requiring ``sudo`` for ``n`` and ``npm`` global installs,
configure environment variable ``N_PREFIX``, which will point to the
place where ``n`` will store Node.js binaries. With this you will also
need to update the ``PATH`` environment variable, so that the system can
find the active binaries. Execute on the command line:

.. code:: console

   cd ~
   mkdir n

You can now update environment variables. If you use ``zsh`` shell, add
to the end of the ``~/.zprofile`` file:

.. code:: shell

   export N_PREFIX=~/"n"
   export PATH=~/"n/bin:$PATH"

Before starting with the next step, restart your terminal app to make
sure that the path changes are picked up by the shell.

3 Install Node.js through ``n``
-------------------------------

You can now use ``n`` to install Node.js, for example latest and LTS
versions:

.. code:: console

   n latest
   n lts

To install exact version of Node.js, for example ``10.16.0``, execute on
the command line:

.. code:: console

   n 10.16.0

You can also install the latest release of the specific major version,
for example ``12``, with:

.. code:: console

   n 12

Note that each version on Node.js installed through ``n`` will come with
its own version of ``npm``.

4 Install a package with ``npm``
--------------------------------

To install a package globally, for example ``yarn``, execute on the
command line:

.. code:: console

   npm install -g yarn

Packages installed globally with ``npm`` will be installed independently
of the version of Node.js that is currently active.

5 Switch between different versions of Node.js
----------------------------------------------

To switch between different versions of Node.js, execute on the command
line:

.. code:: console

   n

Then select between available versions of Node.js.

Note that switching between different versions of Node.js will also
switch the accompanied version of ``npm``.

For more details on how to use ``n``, see https://github.com/tj/n.
