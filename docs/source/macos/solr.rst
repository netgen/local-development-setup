Set up Apache Solr
==================

Here you will install Apache Solr. Open
https://downloads.apache.org/lucene/solr in your browser and find the
Solr package for the version you want to install. Copy the link to it.

Set up recent version of Solr
-----------------------------

If you want to use multiple versions of Solr, this is the recommended
way to install it, and the procedure is the same for both macOS and
Ubuntu. This type of setup allows you to easily have multiple Solr
versions and start/stop them when needed. The only drawback is that you
have to manually start it each time you need it.

If you want to install it as a service instead, there are instructions
at the end of this document.

1 Install
~~~~~~~~~

In the console, create ``solr`` directory in your home directory and
position into it:

.. code:: console

   mkdir ~/solr
   cd ~/solr

Now download your chosen Solr package from
https://lucene.apache.org/solr/downloads.html, extract it, delete the
archive and position into the extracted directory:

.. code:: console

   wget https://archive.apache.org/dist/lucene/solr/7.7.3/solr-7.7.3.tgz
   tar xzf solr-7.7.3.tgz && rm solr-7.7.3.tgz
   cd solr-7.7.3

2 Start
~~~~~~~

From the installation directory you can start the Solr server using the
provided ``solr`` command:

.. code:: console

   ./bin/solr start

After the server has started, verify that you can access its web
interface on http://localhost:8983.

The command above will start the server in the background, and you can
stop it with:

.. code:: console

   ./bin/solr stop

For debugging purposes you might want to have the server running in the
foreground with ``-f`` switch:

.. code:: console

   ./bin/solr start -f

In this case, stop the server when needed with ``Control-C``.

If you run Solr version 7 or higher, you might need to disable the shard
whitelisting if so required by your consumer code (for example eZ
Platform Solr Search Engine). You can do that either in the
``solrconfig.xml`` file, or by adding a parameter to the start command
documented above:

.. code:: console

   ./bin/solr start -f -Dsolr.disable.shardsWhitelist=true

Add a new core
~~~~~~~~~~~~~~

You can use ``solr`` command to create a new core using a specific
configuration. Prepare your configuration in a separate directory, then
execute:

.. code:: console

   ./bin/solr create_core -c my_new_core -d /path/to/my/solr/config

Core can also be removed from the server:

.. code:: console

   ./bin/solr delete -c my_new_core

**Note**: Solr must be running for these commands to work.

To find out about other available options, execute the ``solr`` command
without arguments and follow the given instructions.

Use a specific Java version
---------------------------

If your Solr version requires a different Java version than the one you
have installed globally, you can install that specific Java version on
aside, and use it to run that specific version of Solr.

First, in the console create ``java`` directory in your home directory
and position into it:

.. code:: console

   mkdir ~/java
   cd ~/java

Download your chosen Java SE Runtime Environment in the archive format
from
https://www.oracle.com/java/technologies/javase/javase7-archive-downloads.html
and place it in the previously created directory ``~/java``.

Extract it and delete the archive:

.. code:: console

   cd ~/java
   tar xzf jre-8u202-macosx-x64.tar.gz && rm jre-8u202-macosx-x64.tar.gz

Now you can use that specific version of Java with commands documented
above by defining ``SOLR_JAVA_HOME`` environment variable on the command
line. For example:

.. code:: console

   SOLR_JAVA_HOME=~/java/jre1.8.0_202.jre/Contents/Home ./bin/solr start -f

Move Java out of the quarantine on macOS
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

For security reasons macOS will ask for user confirmation the first time
the downloaded program is run. However, the option to allow the program
to run will not be available for Java installed in the way documented
above. To allow it to run, remove the quarantine flag from the
downloaded Java version by executing:

.. code:: console

   xattr -d com.apple.quarantine ~/java/jre1.8.0_202.jre

Set up Solr version 4.10.4
--------------------------

1 Install
~~~~~~~~~

In the console, create ``solr`` directory in your home directory and
position into it:

.. code:: console

   mkdir ~/solr
   cd ~/solr

Now download your chosen Solr package from
https://archive.apache.org/dist/lucene/solr/, extract it, delete the
archive and position into the extracted directory:

.. code:: console

   wget https://archive.apache.org/dist/lucene/solr/4.10.4/solr-4.10.4.tgz
   tar xzf solr-4.10.4.tgz && rm solr-4.10.4.tgz
   cd solr-4.10.4

To run this version of Solr, you will also need Java 7. In the console,
create ``java`` directory in your home directory and position into it:

.. code:: console

   mkdir ~/java
   cd ~/java

Download your chosen Java package in the archive format from
https://www.oracle.com/java/technologies/javase/javase7-archive-downloads.html.
Download Java SE Runtime Environment 7u51 and place it in the previously
created directory ``~/java``.

Now you can extract it and delete the archive:

.. code:: console

   cd ~/java
   tar xzf jre-7u51-macosx-x64.tar.gz && rm jre-7u51-macosx-x64.tar.gz

If you use macOS, it will prevent you from executing an unverified
binary, so make sure you remove the quarantine flag from the downloaded
Java version by executing:

.. code:: console

   xattr -d com.apple.quarantine ~/java/jre1.7.0_51.jre

You can now use Java directly from the extracted directory, for example:

.. code:: console

   ~/java/jre1.7.0_51.jre/Contents/Home/bin/java -version

2 Configure
~~~~~~~~~~~

A big Solr query might fail because of request header size limitation
set on the Jetty connector. If this happens, you will get an error like:

.. code:: text

   11380 [qtp853119666-17] WARN  org.eclipse.jetty.http.HttpParser  – HttpParser Full for /0:0:0:0:0:0:0:1:8983 <--> /0:0:0:0:0:0:0:1:57176

To fix this problem, open ``~/solr/solr-4.10.4/example/etc/jetty.xml``
file and configure a bigger request query size:

.. code:: diff

   <Call name="addConnector">
       <Arg>
           <New class="org.eclipse.jetty.server.bio.SocketConnector">
               <Set name="host"><SystemProperty name="jetty.host" /></Set>
               <Set name="port"><SystemProperty name="jetty.port" default="8983"/></Set>
               <Set name="maxIdleTime">50000</Set>
               <Set name="lowResourceMaxIdleTime">1500</Set>
               <Set name="statsOn">false</Set>
   +            <Set name="requestHeaderSize">10240000</Set>
           </New>
       </Arg>
   </Call>

3 Start
~~~~~~~

To start Solr, prepare your cores in
``~/solr/solr-4.10.4/example/multicore`` and position into
``~/solr/solr-4.10.4/example``. Then execute:

.. code:: console

   ~/java/jre1.7.0_51.jre/Contents/Home/bin/java -Djetty.port=8983 -Dsolr.solr.home=multicore -jar start.jar

The server will run in the foreground, and you can stop it when needed
with ``Control-C``.

Tips
----

If you need to access Solr Admin UI of a Solr instance on a remote server,
which is not exposed to the outside access, you can forward the port to
your host with an SSH client:

.. code:: console

   ssh -L 8983:localhost:8983 remote_server

After executing the above and logging into the remote server, just open the
Solr Admin UI in your browser on http://localhost:8983.
