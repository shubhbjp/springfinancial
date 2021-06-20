# Spring Financial Assignment

Code is written in simple Tech Stack using HTML, CSS, Javascript in Frontend and PHP in backend server language.
To  run the code, please follow following setup procedure in ubuntu environment to complete the setup

- Install apache server using following command in terminal "sudo apt-get install apache2"
- Go to /etc/apache2/apache2.conf file and add line "ServerName 127.0.0.1" to keep default servername to localhost:80
- To test if all syntax is ok run command "sudo apachectl configtest"
- To stop nginx service(if already setup) run command "sudo service nginx stop"
- Start Apache server usign command "sudo service apache2 start"
- To give directory permission enter following command sudo chown {your ubuntu username} /var/www/html
- sudo apt-get install php
- install chrome or any browser in the machine
- go to path /var/www/html and paste the springfinancial source code directory and run "http://localhost/springfinancial" on browser tab 
- Start Playing

## Features

- You can add players upto max 10 users in 1 session. Every added player will start from 0 points.
- You cannot pass empty name or address field in name, address. Age has to be >=0.
- More than 1 player with same name cant play in one game session.
- Player points cannot be decreased below 0. (-) pointer is enabled once points > 0 w.r.t each player.
- Points cannot  be increased beyond 1000. (+) pointer can be clicked to increase points.
- You can remove added users on click of (X) icon.
- A player with max points will remain on top of the list. Sorting done on decreasing order of players points.
- On click of the name, all the data corresponding to the player is shown separately.
- Add user functionality has backend server validation along with frontend validation.

## Tech

- [HTML] - HTML used to render web page
- [Inline CSS] - Minified CSS for enhanced design view and styling of elements.
- [AJAX Request] - Send Asynchronous server request to backend in both GET and POST Method.
- [Javascript] - For UI framework.
- [PHP 7.4.3] - for backend server specific module.
- [MVC] - code done following MVC structure on custom framework

## Installation

Assignment Requires PHP installation, apache server installation and runs best with Google Chrome Version of ubuntu operating system. Installation steps are mentioned above to run the code in localhost:80.