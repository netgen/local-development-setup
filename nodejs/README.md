# Set up Node.js version management

If your project requires a specific Node.js version that is not available from
your package manager, you can use `n`, Node.js version manager. With it you can
maintain and switch between multiple versions of Node.js.

## 1 Install n

First uninstall Node.js, as it will conflict with the versions installed through
the version manager.

### 1.1 If using MacOS with MacPorts

Execute on the command line:

```console
sudo port install n
```

### 1.2 If using MacOS with Homebrew

Execute on the command line:

```console
brew install n
```

## 2 Install a package

To install a package globally, for example `yarn`, execute on the command line:

```console
sudo npm install -g yarn
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
