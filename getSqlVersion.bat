@echo off
for /f "tokens=*" %%a in ('hostname') do set myhostname=%%a
echo Local hostname: %myhostname%
sqlcmd -S %myhostname%,1401 -U SA -P Microsoft123! -Q "set nocount on; SELECT @@VERSION" -h -1 -W