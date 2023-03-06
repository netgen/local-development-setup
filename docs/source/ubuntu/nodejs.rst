Set up Node.js version management
=================================

Different projects often require different Node.js versions. For switching
between multiple versions, you can use the Node.js version manager - `nvm`.
While other Node.js version managers are available, `nvm` is recommended
since the `Netgen Media Site` Makefile is configured to be used with that one.


1 Install ``nvm``
-----------------

First uninstall Node.js, as it will conflict with the versions installed
through the version manager.

The installation should be fairly straightforward if you follow the instructions at
`Github <https://github.com/nvm-sh/nvm#install--update-script>`_:

.. code:: console

    curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.3/install.sh | bash

Make sure to check the correct version, please do not just copy the link above as
it could be an old/deprecated version.

This will install the `nvm` to `~/.nvm` folder, and attempt to modify your profile file
(it will attempt to go through the following: `~/.bash_profile`, `~/.zshrc`, `~/.profile`, or `~/.bashrc`).
If you have any other profile file, please add the following to the file your self:

.. code:: console

    export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")"
    [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" # This loads nvm

Troubleshooting
~~~~~~~~~~~~~~~

If you are getting `nvm: command not found` after the installation, try to source your
profile file (eg. `source ~/.bashrc`), or simply close your current terminal and open
a new one.


2 Install Node.js through ``nvm``
---------------------------------

You can now use ``nvm`` to install Node.js, for example the latest and LTS
versions:

.. code:: console

   nvm install node # "node" is an alias for the latest version
   nvm install --lts

To install a specific version of Node.js, for example ``19.7.0``, execute on
the command line:

.. code:: console

   nvm install 19.7.0

You can also install the latest release of a specific major version,
for example ``12``, with:

.. code:: console

   nvm install 12

Note that each version of Node.js installed through ``nvm`` will come with
its own version of ``npm``.


3 Switch between different versions of Node.js
----------------------------------------------

To switch between different versions of Node.js, execute on the command
line:

.. code:: console

   nvm list

This will show you the currently installed versions of Node.js on your system.
You can select one of those, or install another one, and then execute the
following:

.. code:: console

   nvm use 19.7.0

However, you will rarely need to do that - usually, your project should have
a ``.nvmrc`` file, which already has the required Node.js version defined.
In that case, all you need to do is run:

.. code:: console

   nvm use

This command, however, will fail if the requested version of Node.js is not
already installed, and will require you to install it first.
To get around this, you can run:

.. code:: console

   nvm use || nvm install

You can also add this to your alias list, so it is simpler to use (``nvmuse``
for example).


4 Switch between different versions of Node.js automatically
------------------------------------------------------------

If you want to have ``nvm`` automatically switch to a different Node.js version
upon navigating inside a directory which contains a ``.nvmrc`` file, you can
configure the function for this in the ``~/.cdnvm`` file:

.. code:: console

    cdnvm() {
        command cd "$@";
        nvm_path=$(nvm_find_up .nvmrc | tr -d '\n')

        # If there are no .nvmrc file, use the default nvm version
        if [[ ! $nvm_path = *[^[:space:]]* ]]; then

            declare default_version;
            default_version=$(nvm version default);

            # If there is no default version, set it to `node`
            # This will use the latest version on your machine
            if [[ $default_version == "N/A" ]]; then
                nvm alias default node;
                default_version=$(nvm version default);
            fi

            # If the current version is not the default version, set it to use the default version
            if [[ $(nvm current) != "$default_version" ]]; then
                nvm use default;
            fi

        elif [[ -s $nvm_path/.nvmrc && -r $nvm_path/.nvmrc ]]; then
            declare nvm_version
            nvm_version=$(<"$nvm_path"/.nvmrc)

            declare locally_resolved_nvm_version
            # `nvm ls` will check all locally-available versions
            # If there are multiple matching versions, take the latest one
            # Remove the `->` and `*` characters and spaces
            # `locally_resolved_nvm_version` will be `N/A` if no local versions are found
            locally_resolved_nvm_version=$(nvm ls --no-colors "$nvm_version" | tail -1 | tr -d '\->*' | tr -d '[:space:]')

            # If it is not already installed, install it
            # `nvm install` will implicitly use the newly-installed version
            if [[ "$locally_resolved_nvm_version" == "N/A" ]]; then
                nvm install "$nvm_version";
            elif [[ $(nvm current) != "$locally_resolved_nvm_version" ]]; then
                nvm use "$nvm_version";
            fi
        fi
    }
    alias cd='cdnvm'
    cd "$PWD"

and add this to your ``~/.bashrc`` (or whichever other profile file you are
using):

.. code:: console

   if [ -f ~/.cdnvm ]; then
      . ~/.cdnvm # This enables automatic switch of nvm on folder change
   fi


5 Managing packages with ``nvm``
--------------------------------

For some packages (``yarn`` usually), it is best to let ``nvm`` install it
together with a new Node.js version.
To accomplish this, you can add package names, one per line, to the file
``$NVM_DIR/default-packages``

NOTE: ``$NVM_DIR`` is usually ``~/.nvm/``.

(https://github.com/nvm-sh/nvm#default-global-packages-from-file-while-installing)
