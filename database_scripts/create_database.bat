@echo off
sqlite3 webtask.db
timeout 1
echo .read create_tables.sql
echo .read test_insert.sql
echo .exit