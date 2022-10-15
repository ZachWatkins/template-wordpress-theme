#!/bin/bash
# Make Docker secrets from WordPress salts API.
salts=$(curl https://api.wordpress.org/secret-key/1.1/salt/)
while IFS= read -r line; do
    key=${line:8:18}
    key=${key/"',"/}
    key=$(echo ${key/ */} | tr '[:upper:]' '[:lower:]')
    value=${line:28:-3}
    echo "$value" > secrets/$key
done <<< "$salts"