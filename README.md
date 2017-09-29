# SQL Server on a Linux Container Demo

This repository contains some scripts that can be used to demonstrate the portability of Linux containers using Microsoft SQL Server. Overall, the demo would follow these steps:

1. Concepts: launching the container on a Windows laptop (docker run)
2. App packaging with docker-compose: launching the example app on a Windows laptop (docker-compose up)
3. Collaboration across multiple OS: branching out the Github repo on a Mac, changing something and committing back
4. CI/CD to Azure: merging back the branch, and using Jenkins to publish the app to an Azure Container Services cluster

The following paragraphs offer additional details on how to demonstrate each one of the previous points 

## 1. SQL Server and Docker basics

**Prerequisites**: a Windows laptop with Docker and sqlcmd installed.

Launching SQL Server in a Linux container is very easy, as documented in https://docs.microsoft.com/en-us/sql/linux/quickstart-install-connect-docker. From a cmd/Powershell prompt, follow these steps (make sure you have configured the memory available to Docker to at least 4GB, as documented in the link in this paragraph):

 * docker run -e "ACCEPT_EULA=Y" -e "MSSQL_SA_PASSWORD=MyVeryStrongPassw0rd!" -e "MSSQL_PID=Developer" -p 1401:1433 --name sqlserver1 -d microsoft/mssql-server-linux
 * docker ps
 * sqlcmd -S YOURMACHINENAME,1401 -U SA -P MyVeryStrongPassw0rd! -Q "SELECT @@VERSION"
 * docker rm -f sqlserver1

 ## 2. SQL Server packaged in a Docker application

**Prerequisites**: a Windows laptop with git and Docker installed (verify that the docker-compose is installed to by running docker-compose -v).

A SQL Server on its own cannot do much, a database is only useful as part of an application. You can use docker-compose to describe application stacks made out of multiple containers. This example demonstrates a Web server (using httpd and PHP) packaged along SQL Server.

 * git clone

