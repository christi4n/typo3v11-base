#!/usr/bin/env bash

source .env

echo "Creating admin with $TYPO3_ADMIN_USERNAME username..."

./vendor/bin/typo3cms backend:createadmin $TYPO3_ADMIN_USERNAME $TYPO3_ADMIN_PASSWORD