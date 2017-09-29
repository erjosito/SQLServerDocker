sqlcmd -S MININT-7CE6LKT,1401 -U SA -P Microsoft123! -Q "CREATE DATABASE Voting"
sqlcmd -S MININT-7CE6LKT,1401 -U SA -P Microsoft123! -d Voting -Q "CREATE TABLE Voting (Name varchar(32), Number int)"
sqlcmd -S MININT-7CE6LKT,1401 -U SA -P Microsoft123! -d Voting -Q "INSERT INTO Voting (Name, Number) VALUES ('Option1', 0)"
sqlcmd -S MININT-7CE6LKT,1401 -U SA -P Microsoft123! -d Voting -Q "INSERT INTO Voting (Name, Number) VALUES ('Option2', 0)"