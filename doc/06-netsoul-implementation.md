# NetSoul Protocol Implementation

The current implementation of the NetSoul Protocol is based on a
Request/Response schema.

Request classes have predefined attributes and can implode them into a raw
request (a string), while Response classes take a raw request (a string) and
explode it into predefined attributes.

## NetSoul server

By default, SoulMeMaybe will connect to the following server:

* **name**: `10.42.1.59`;
* **port**: `4242`.

You can change these values in the `./app/config/parameters.yml` file, however
it is not advised to.

## Steps followed

Here is the steps followed by the client:

1. **server**: `salut <file descriptor> <hash seed> <client host> <client port> <connection timestamp>`;
2. **client**: `auth_ag ext_user none none`;
3. **server**: `rep 002 -- cmd end`;
4. **client**: `ext_user_log <user login> <authentication hash> <client description> <user location>`;
5. **server**: `rep 002 -- cmd end`;
6. **client**: `state active:<timestamp>`;
7. loop:
   * **server**: `ping <timeout in seconds>`;
   * **client**: `ping`.

With:

* `<authentication hash>` being `md5("<hash seed>-<client host>/<client port><password socks>")`;
* `<client description>` being `<client name> <client version>`;
* `<user location>` being `<in PIE> <room> <line> <station>`.
