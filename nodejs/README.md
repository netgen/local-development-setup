# Set up Node.js version management

If your project requires a specific Node.js version that is not available from
your package manager, you can use `n`, Node.js version manager. With it you can
maintain and switch between multiple versions of Node.js.

## 1 Install n

First uninstall Node.js, as it will conflict with the versions installed through
the version manager. To install `n` these instructions will use `n-install`, 3rd
party installer that does not require Node.js preinstalled. For more details see
https://github.com/mklement0/n-install.

Execute on the command line:

```console
curl -L https://git.io/n-install | bash
```

This will install `n` in your home directory, together with `lts` version of
Node.js and `npm` package manager for that version.

## 2 Install a package

To install a package globally, for example `yarn`, execute on the command line:

```console
npm install -g yarn
```

All packages installed globally with `npm` will be installed for the version of
Node.js that is currently active, and switching to different version of Node.js
will also switch the packages installed for the selected version.

## 3 Install another version of Node.js

To install another version of Node.js, for example `10.16.0`, execute on the
command line:

```console
n 10.16.0
```

## 4 Switch between different versions of Node.js

To switch between different versions of Node.js, execute on the command line:

```console
n
```

Then select between available versions of Node.js.

For more details on how to use `n`, see https://github.com/tj/n.
