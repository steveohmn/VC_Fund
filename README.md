VC_Fund
=======

UCLA VC Fund Project: Creating a list of UCLA Alumni accessible to the members of VC Fund

Steps:
------

  1. Use the <a href='https://api.angel.co/1/search?query=ucla&type=User'>AngelList search API</a> to return a list of UCLA-affiliated users.
  2. Query the AngelList User API for additional information on each user from the search API response.
  3. Store all of the user information in a database of your choice (MySQL, MongoDB, PostgreSQL)
  4. Create a simple way for non-technical users to view the contents of the database, preferably a web page.

How to use:
-----------
The database is implemented using MySQL and at the top of the webpage, three buttons are available: <br>
"Load AngelList"   "Delete AngelList"   "Show ALL AngelList"

Each button's fuction is self-explanatory.<br>

  A. <b>Load AngelList</b> gets all those UCLA Alumni who are accessible to members of UCLA VC Fund. <br>
  B. <b>Delete AngelList</b> deletes all the loaded data in the database. <br>
  C. <b>Show ALL AngelList</b> displays 20 UCLA Alumni in a user-friendly way. <br>

In <b>Show ALL AngelList</b>, each user's name is hyperlinked to a page where it provides more detailed information about that particular user. This was done by using passing in the unique user ID to query more information about him/her.
