FROM microsoft/mssql-server-linux
MAINTAINER Jose Moreno <jose.moreno@microsoft.com>

# Run SQL Server process.
RUN /opt/mssql/bin/sqlservr

# Environment Variables
ENV ACCEPT_EULA Y
ENV MSSQL_SA_PASSWORD Microsoft123!
ENV MSSQL_PID Developer

# Create DB
RUN /opt/mssql-tools/bin/sqlcmd -S localhost,1433 -U SA -P Microsoft123! -Q "CREATE DATABASE Voting"
RUN /opt/mssql-tools/bin/sqlcmd -S localhost,1433 -U SA -P Microsoft123! -d Voting -Q "CREATE TABLE Voting (Name varchar(32), Number int)"
RUN /opt/mssql-tools/bin/sqlcmd -S localhost,1433 -U SA -P Microsoft123! -d Voting -Q "INSERT INTO Voting (Name, Number) VALUES ('Option1', 0)"
RUN /opt/mssql-tools/bin/sqlcmd -S localhost,1433 -U SA -P Microsoft123! -d Voting -Q "INSERT INTO Voting (Name, Number) VALUES ('Option2', 0)"


# Expose apache.
EXPOSE 1433
