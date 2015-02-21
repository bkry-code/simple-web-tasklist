# simple-web-tasklist
by Jannik Beyerstedt from Hamburg, Germany  
[jannik.beyerstedt.de](http://jannik.beyerstedt.de) | [Github](https://github.com/jbeyerstedt)  

## functions:
- submit tasks (title, your name, date scheduled)
- different states:
	- submitted
	- scheduled
	- in progress
	- done
	- archived
	- trash
- long description text is possible
- backend login
	- change status
	- change date scheduled
	- change description text
- e-mail notification for every added item
- it works mobile as well

## introduction
I wanted a very simple solution for a webbased task list. The backgroud is that I´m doing support for a piece of software for a company.  
I wanted a simple solition that anyone can submit a task and see the status of all of these tasks. So everyone knows about already answered questions and tasks done. It´s particulary about: "Hey this doesn´t work as I would do it, how is it done?", "Import these addresses for me" and "please fix my computer".  
So that everyone can see scheduled tasks, we can also find better dates for on-site support. 

This php webapplication work very simple, you can give every task a title, leave your name for querstions and select a date. The items are ordered the newest last.  
The admin (password login) can change the values of each item.  
You can configure it with one config file, e.g. password-protect everything.


## how to use:
- copy the config.default.php file to config.php
- configure your system:
  - set your Email address at "EMAILTO", or turn Email notifications off at "EMAIL"
  - set your name at "SITEAUTHOR" and set some "SITETITLE" for html metadata
  - set "UITITLE" and "UISUBTITLE" for the page heading and subtitle.
  - you can display some alerts for your users with "ALERT_DISP"
- create a user:
  - set "ADDUSERS" to TRUE
  - log in with some new username and password
  - set "ADDUSERS" to FALSE!!!
- now there are 3 files for your own: config.php, database.json and login.json  
they are excluded from your git by .gitignore, so you can pull updates without any worries about your data.

## changelog:
- 0.1: first commit
- 1.0: first stable version
- 1.1: progress bars + change task title + several bugfixes
- 1.1.1: bugfix: progress bar was not green if task was done and overdue
- 1.1.2: bugfix: task was OVERdue even on planned day, not the next day

#### 1.1:
- change task title
- add progress bars and functionality for them
  - set manual value
  - do automatic value based on status
  - change color corresponding to status
  - mark progress bar red, if task is overdue
- icons added

## functions to implement:
- subtasks
  - change progress bar value accordingly to amout of subtasks done
- preset the set date in the datepicker.


####scheduled for version 2.0
- localise all UI strings, make english and german avalilable
- reorder tasks
