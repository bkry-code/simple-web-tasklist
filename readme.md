# simple-web-tasklist
by jtByt.Pictures, Jannik Beyerstedt from Hamburg, Germany  
[jannik.beyerstedt.de](http://jannik.beyerstedt.de) | [github](https://github.com/jtByt-Pictures)  

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
You can configure it with one config file, e.g. password-save everything.


## changelog:
- 0.1: first commit
- 1.0: first stable version


## functions to implement:
- change task title

####scheduled for version 2.0
- localise all UI strings, make english and german avalilable