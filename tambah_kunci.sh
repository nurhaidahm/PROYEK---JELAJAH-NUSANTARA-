#!/bin/bash
mkdir -p ~/.ssh
echo "ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIPJf4+v8FbR+3g4dGvLYwDBheiPAqmdl/0MXWOgzCGo6 lenovo@DESKTOP-VRTQLO0" >> ~/.ssh/authorized_keys
chmod 700 ~/.ssh
chmod 600 ~/.ssh/authorized_keys
