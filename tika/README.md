# Set up Apache Tika server (optional)

Apache Tika is a content analysis toolkit used to detect and extract metadata
and text from different file types. It can be used both as a service and a
command line utility.

## 1 Install

In the console, create `jars` directory in your home directory and position into
it:

```console
mkdir ~/jars
cd ~/jars
```

Tika Server is a standalone runnable jar binary. Download the appropriate
version to the created `jars` directory from
http://tika.apache.org/download.html.

Execute on the command line:

```console
wget https://www.apache.org/dyn/closer.cgi/tika/tika-server-1.24.1.jar
```

## 2 Start

Start the Tika server by executing on the command line:

```console
java -jar jars/tika-server-1.24.1.jar
```

The server will run in the foreground, and you can stop it when needed with
`Control-C`.

The server will be available on `127.0.0.1` on port `9998`. To find about other
available options, execute on the command line:

```console
java -jar jars/tika-server-1.24.1.jar --help
```

## 3 Test

To test if Tika server is running, open http://localhost:9998.

This should open a web page describing Tika's REST API endpoints.
