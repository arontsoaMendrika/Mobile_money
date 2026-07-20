#!/bin/bash
rm -f writable/db/mobile.db
sqlite3 writable/db/mobile.db < base.sql
echo "Base réinitialisée"