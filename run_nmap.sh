#!/bin/bash

# Allowed commands
ALLOWED_COMMANDS=("nmap" "ping" "traceroute" "whois" "dig" "nslookup")

# Get command from PHP (passed as an argument)
COMMAND="$1"

# Extract base command
BASE_COMMAND=$(echo "$COMMAND" | awk '{print $1}')

# Ensure it's an allowed command
if [[ ! " ${ALLOWED_COMMANDS[@]} " =~ " ${BASE_COMMAND} " ]]; then
    echo "Error: Command not allowed!"
    exit 1
fi

# Run the command with sudo
sudo $COMMAND 2>&1
