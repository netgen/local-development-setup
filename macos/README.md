# MacOS prerequisites

## Install Xcode Command Line Tools

To install Xcode Command Line Tools, execute the following on the command line
and follow the instructions:

```console
xcode-select --install
```

## Install a package manager

You will need to choose between `Homebrew` and `MacPorts` for your package
manager. Note that you should not use both the same time, since the way
`Homebrew` works might interfere with `MacPorts` compiling its package binaries.

Using `MacPorts` is recommended, since it's better at isolating packages from OS
changes and makes older (officially unsupported) versions of packages available.
In particular, it makes installing older versions of PHP with some non-standard
extensions trivial, while with `Homebrew` you will have to use 3rd party taps
and manual building of the extension binaries.

However, both `MacPorts` and `Homebrew` will do fine, and this documentation
provides necessary instructions for both.

### Install MacPorts

Visit https://www.macports.org/install.php and follow the instructions to
install `MacPorts`.

### Install Homebrew

**Note**: Do not install `Homebrew` if you already installed `MacPorts`.

Visit https://brew.sh/ and follow the instructions to install `Homebrew`.
