# Set up RabbitMQ message-broker

RabbitMQ is an open-source message-broker software, used for sending and
receiving messages using a queue in order to process them asynchronously.

## 1 Install

### 1.1 If using MacOS with Homebrew

Execute on the command line:

```console
brew install rabbitmq
```

### 1.2 If using MacOS with MacPorts

Execute on the command line:

```console
sudo port install rabbitmq-server
```

## 2 Start

Since it's not needed every project, and it takes up valuable system resources,
it's preferred to start RabbitMQ manually when needed.

### 2.1 Start manually

Execute on the command line:

```console
rabbitmq-server
```

The server will run in the foreground, and you can stop it when needed with
`Control-C`.

### 2.2 Start automatically

If wanted, you can also set it up to start automatically after a reboot.

#### 2.2.1 If using MacOS with MacPorts

Execute on the command line:

```console
sudo port load rabbitmq-server
```

To stop the server and prevent it from running after a reboot, execute:

```console
sudo port unload rabbitmq-server
```

#### 2.2.2 If using MacOS with Homebrew

Execute on the command line:

```console
sudo brew services start rabbitmq
```

To stop the server and prevent it from running after a reboot, execute:

```console
sudo brew services stop rabbitmq
```

## 3 Test

Test the server works by opening web management UI at http://localhost:15672.

Login into the UI with user `guest` and password `guest`.

## 4 Configure in a project

If you need to configure it for a project, API will be available at
`http://localhost:5672` with the same credentials as mentioned above: user
`guest` and password `guest`.
