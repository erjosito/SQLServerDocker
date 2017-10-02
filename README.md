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

* git clone http://github.com/erjosito/SQLServerDocker YourDirectory
* git checkout -b mynewbranch
* Change the code in web-centos/index.php, for example the variables at the beginning of the script (set $label1 and $label2 to other words of your choice, for example)
* docker build -t centos\_httpd\_php web-centos (creates locally the image required for the web tier of our app) 
* docker-compose up -d: verify that the application is now working as expected
* git commit -a
* git push --set-upstream origin mynewbranch

## 4. Deployment to production in an ACS cluster

**Prerequisites**: a working ACS cluster, a working Jenkins server connected to the Github account, a Docker Hub account to publish the new builds

Due to the prerequisites for this lab, you probably want to prepare all this in advance. The idea here is to take the concept one step forward and have the code automatically pushed to the cloud, with no further changes. For this we will use Jenkins as automation tool. In a few words, this is what should happen:

 1. Launch the initial version of the application in a existing ACS cluster using the provided file (voting_sqlserver_httpd.yaml). Verify that the app is reachable, and note the labels with the old value
    * kubectl --kubeconfig ./your-acs-kubectl-config-file create -f ./voting_sqlserver_httpd.yaml 
 2. The previously created branch will be merged into the Github repo's main branch 
    * git checkout master (change branch back to master)
    * git commit -a
    * git push
 3. Jenkins will be notified by Github of the new commit into the main branch and will do the following steps:
    * Clone the new version of the main branch
    * Build a new container image with docker build
    * Publish the new build to Docker hub
    * Update the Kubernetes cluster in ACS to refer to the new build with kubectl
 4. You can compare the URL to the application in the Kubernetes cluster both before and after doing the commit
