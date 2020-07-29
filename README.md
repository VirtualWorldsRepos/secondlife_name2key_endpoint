
# secondlife_name2key_endpoint
provides a name2key key2name endpoint using docker+php+mysql with data from the w-hat

### I already have it installed how do i use it again?
http://localhost:1234/
 > address to your docker proxy for your docker container
 > with the rest formated as follows endpoint/request/key



| Endpoint  | Request supported | Notes |
|--|--|--|
| add  | NAME\|UUID | used to add entrys localy
| build| rebuild | Remakes the data from w-hat (removes local changes)
| key2name| UUID | searchs the database for a matching UUID
| name2key | Name | Searchs the database looking for a match

## Installing the service
```
version: '2'
services:
    name2key_endpoint:
        container_name: name2key_endpoint
        restart: always
        image: madpeter/secondlife_name2key_endpoint:latest
        expose:
            - 80:80
        ports:
            - 80:80
        links:
            - name2key_mysqli
        environment:
            DB_HOST: name2key_mysqli
            DB_DATABASE: 'name2keydb'
            DB_USERNAME: '{MySQLDBUser}'
            DB_PASSWORD: '{MySQLDBPW}'
            API_KEYS: 'setup'

    name2key_mysqli:
        container_name: name2key_mysqli
        image: mariadb
        restart: always
        environment:
            MYSQL_ROOT_PASSWORD: '{MySQLRootPW}'
            MYSQL_USER: '{MySQLDBUser}'
            MYSQL_PASSWORD: '{MySQLDBPW}'
            MYSQL_DATABASE: 'name2keydb'
        volumes:
            - name2key-db:/var/lib/mysql
```
 - Step 1: replace {MySQLDBUser} with the username you wish to use for    the database
 - Step 2: replace {MySQLDBPW} with the password you wish    to use for the database
 - Step 3: replace {MySQLRootPW} with a totaly    random password we dont care about this

[Optional]
 - Step 3o: Change 80:80 for port and expose to 1234:80
 ```(1234 will be the port you access this on)```


 - Step 4: Deploy the stack
 - Step 5: Check you can access example: http://localhost:1234
```
{"status":false,"message":"in setup mode"}
```

 - Step 6: Edit ENV value "API_KEYS" for the endpoint container "name2key_endpoint" and redeploy
```
this is a CSV of keys used to make requests to this service
example: "magic,popcorn"
Note: The first API key is used to update the dataset please
do not give this out.
```

- Step 7:  install the dataset
http://localhost:1234/build/rebuild/[FIRST_API_KEY]

```this will take awhile```

- Step 8: Make a test call
http://localhost:1234/name2key/Madpeter%20Zond/[ANY_API_KEY]/print

```
Array ( [status] => 1
[found] => 1
[name] => Madpeter Zond
[uuid] => 289c3e36-69b3-40c5-9229-0c6a5d230766
[lookingfor] => Madpeter Zond
[message] => Entry found )
```

## Keeping it localy updated
you can add entrys to the system via calling
http://localhost:1234/add/[NAME|UUID]/[ANY_API_KEY]
example
```
http://localhost:1234/add/Madpeter%20Zond|289c3e36-69b3-40c5-9229-0c6a5d230766/demo
```

## Remote updates
Weekly or monthly (as you need) you can rerun http://localhost:1234/build/rebuild/[FIRST_API_KEY]
this will empty out the database and pull the newest copy.

please note: Abuse of this might result in you losing access or worse the service
going away :(
