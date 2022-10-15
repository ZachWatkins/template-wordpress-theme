now=$(date +'%Y-%m-%d_%H-%M-%S_%N')
# Archive existing credentials if found.
if [[ -f secrets/db_user ]]; then
    mkdir secrets/$now
    mv secrets/db_user "secrets/$now"
fi
if [[ -f secrets/db_password ]]; then
    mv secrets/db_password "secrets/$now"
fi
if [[ -f secrets/db_root_password ]]; then
    mv secrets/db_root_password "secrets/$now"
fi
# Make Docker secrets for database credentials.
username=$(openssl rand -base64 32 | tr -cd '[:alpha:]')
username=${username:0:14}
echo "$username" > secrets/db_user
openssl rand -base64 32 > secrets/db_password
openssl rand -base64 32 > secrets/db_root_password