/opt/mssql-tools/bin/sqlcmd -S sqlserver,1433 -U SA -P Microsoft123! -Q "CREATE DATABASE Voting"
/opt/mssql-tools/bin/sqlcmd -S sqlserver,1433 -U SA -P Microsoft123! -d Voting -Q "CREATE TABLE Voting (Name varchar(32), Number int)"
/opt/mssql-tools/bin/sqlcmd -S sqlserver,1433 -U SA -P Microsoft123! -d Voting -Q "INSERT INTO Voting (Name, Number) VALUES ('Option1', 0)"
/opt/mssql-tools/bin/sqlcmd -S sqlserver,1433 -U SA -P Microsoft123! -d Voting -Q "INSERT INTO Voting (Name, Number) VALUES ('Option2', 0)"