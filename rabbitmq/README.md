# Install and configure `RabbitMQ` message-broker

First install `RabbitMQ` using `brew`:

```console
brew install rabbitmq
```

You can now start the server when needed from the command line:

```console
rabbitmq-server
```

On the command line, the server will run in the foreground, and you can stop it
when needed with `Control-C`.

You can also start it with `brew`, but know that this will automatically start
it after a reboot, which you might not want since it takes up valuable system
resources and is not usually needed in a project:

```console
brew services start rabbitmq
```

Test that the server works by opening web management UI at
http://localhost:15672. Login into the UI with user `guest` and password `guest`.

IF you need to configure it for the project, API will be available at
`http://localhost:5672` with the same credentials as mentioned above.
