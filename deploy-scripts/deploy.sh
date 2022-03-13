#!/bin/bash

# Print commands to the screen
set -x

set -eu

if [[ -z "$PRIVATE_KEY" ]]; then
    echo "PRIVATE_KEY is not defined" 1>&2
    exit 1
fi

if [[ -z "$USERNAME" ]]; then
    echo "USERNAME is not defined" 1>&2
    exit 1
fi

if [[ -z "$SERVER_IP" ]]; then
    echo "SERVER_IP is not defined" 1>&2
    exit 1
fi

if [[ -z "$SERVER_DESTINATION" ]]; then
    echo "SERVER_DESTINATION is not defined" 1>&2
    exit 1
fi

echo $HOME

SSHPATH="$HOME/.ssh"
mkdir -p "$SSHPATH"
echo "$PRIVATE_KEY" > "$SSHPATH/authorized_keys"
chmod 600 "$SSHPATH/authorized_keys"
SERVER_DEPLOY_STRING="$USERNAME@$SERVER_IP:$SERVER_DESTINATION"

# Copy files.
sh -c "rsync -vrxc --no-group --no-owner --delete -e 'ssh -i $SSHPATH/authorized_keys -o StrictHostKeyChecking=no' $FOLDER $SERVER_DEPLOY_STRING --exclude-from=./deploy-scripts/distignore.txt"

# Stop printing commands to the screen.
set +x
