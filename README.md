VC_Fund
=======

UCLA VC Fund Project: Creating a list of UCLA Alumni accessible to the members of VC Fund

Steps:
------

  1. Use the <a href='https://api.angel.co/1/search?query=ucla&type=User'>AngelList search API</a> to return a list of UCLA-affiliated users.
  2. Query the AngelList User API for additional information on each user from the search API response.
  3. Store all of the user information in a database of your choice (MySQL, MongoDB, PostgreSQL)
  4. Create a simple way for non-technical users to view the contents of the database, preferably a web page.
