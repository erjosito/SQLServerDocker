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
 * sqlcmd -S YOURPCNAME,1401 -U SA -P MyVeryStrongPassw0rd! -Q "SELECT @@VERSION"
 * docker rm -f sqlserver1

 ## 2. SQL Server packaged in a Docker application

**Prerequisites**: a Windows laptop with git and Docker installed (verify that the docker-compose is installed too by running docker-compose -v).

A SQL Server on its own cannot do much, a database is only useful as part of an application. You can use docker-compose to describe application stacks made out of multiple containers. This example demonstrates a Web server (using httpd and PHP) packaged along SQL Server.

 * git clone http://github.com/erjosito/SQLServerDocker YourDirectory
 * cd YourDirectory
 * docker-compose up -d
 * Browse with your favorite browser to the URL http://YOURPCNAME:8080 and verify that the Web page is showing correctly, and the Vote buttons work

 ## 3. Portability of SQL Server containers to other platforms

 **Prerequisites**: a non-Windows laptop (for example a Mac) with git and docker installed

One of the main benefits of Linux containers is their portability. For example, you can have a team of developers working on both Windows and Mac OS X, and collaborating with each other. Besides, as the next demo item will follow, portability to a production DC (on premises or in the public cloud) is possible as well.

* Make a new branch of the project
  * git checkout -b mynewbranch
  * git push --set-upstream origin mynewbranch
  * Change the code in web-centos/index.php, for example the variables at the beginning of the script (set $label1 and $label2 to other words of your choice, for example)