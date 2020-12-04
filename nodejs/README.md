# Set up Node.js version management

If your project requires a specific Node.js version that is not available from
your package manager, you can use `n`, Node.js version manager. With it, you can
maintain and switch between multiple versions of Node.js.

## 1 Install `n`

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

### 1.3 If using Ubuntu

Execute on the command line:

```console
sudo apt install n
```

## 2 Install Node.js through `n`

You can now use `n` to install Node.js, for example latest and LTS versions:

```console
sudo n lts
sudo n latest
```

To install exact version of Node.js, for example `10.16.0`, execute on the
command line:

```console
sudo n 10.16.0
```

Note that each version on Node.js installed through `n` will come with its own
version of `npm`.

## 3 Install a package with `npm`

To install a package globally, for example `yarn`, execute on the command line:

```console
sudo npm install -g yarn
```

Packages installed globally with `npm` will be installed independently of the
version of Node.js that is currently active.

## 4 Switch between different versions of Node.js

To switch between different versions of Node.js, execute on the command line:

```console
sudo n
```

Then select between available versions of Node.js.

Note that switching between different versions of Node.js will also switch the
accompanied version of `npm`.

For more details on how to use `n`, see https://github.com/tj/n.
