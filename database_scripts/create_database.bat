@echo off
del ".\webtask.db"
sqlite3 webtask.db -init create_database.sql ""