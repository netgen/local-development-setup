# Set up Memcached distributed memory object caching system

Memcached is an in-memory key-value store for small chunks of arbitrary data
(strings, objects) from results of database calls, API calls, or page rendering.
It's used as a backend for persistent cache implementation on some older projects
(newer projects mostly use [Redis](../redis)).

## 1 Install

### 1.1 If using MacOS with MacPorts

TODO

### 1.2 If using MacOS with Homebrew

TODO

### 1.3 If using Ubuntu

Execute on the command line:

```console
sudo apt install memcached
sudo apt install libmemcached-tools
```

## 2 Start

### 2.1 Start automatically

#### 2.1.1 If using MacOS with MacPorts

TODO

#### 2.1.2 If using MacOS with Homebrew

TODO

#### 2.1.3 If using Ubuntu

Execute on the command line:

```console
sudo systemctl enable memcached
```

This will start the server and set it up to start automatically after a reboot.

To stop the server and prevent it from running after a reboot, execute:

```console
sudo systemctl disable memcached
```

### 2.2 Start manually when needed

#### 2.2.1 If using MacOS with MacPorts

TODO

#### 2.2.2 If using MacOS with Homebrew

TODO

#### 2.2.3 If using Ubuntu

Memcached is a service in Ubuntu so it can be started and stoped as regular
services:

```console
sudo service memcached start
sudo service memcached stop
sudo service memcached restart
sudo service memcached status
```

## 3 Test

To test if the `memcached` server is running, execute:

```console
ps aux | grep memcached
```

You should see it's process there, altogether with the port on which it
listens to (default `11211`).

Then you can `telnet` to it with:

```console
telnet localhost 11211
```