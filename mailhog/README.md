# Install `MailHog` development SMTP server

`MailHog` is a simple development SMPT server that can be used to test sending
of emails.

You can install it by downloading the appropriate binary from GitHub at
https://github.com/mailhog/MailHog/releases (in case of Mac, search for the one
containing `darwin` in its name). If you go that way, put the downloaded binary
as `mailhog` to the appropriate place that is configured in your `PATH`
environment variable, usually `bin` directory in your home directory.

You can also install it using `brew`:

```console
brew install mailhog
```

Start the server by executing from the command line:

```console
mailhog
```

When started, web interface will be available at http://0.0.0.0:8025. To use it
in your Symfony application, configure the mailer DSN to `smtp://0.0.0.0:1025`.

The server will run in the foreground, and you can stop it with `Control-C`.

If needed, find the additional options by executing:

```console
mailhog --help
```
