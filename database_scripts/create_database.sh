#!/bin/bash
rm "webtask.db"
sqlite3 webtask.db -init create_database.sql ""
rm "../webtask.db"
cp "webtask.db" "../"
rm "webtask.db"
