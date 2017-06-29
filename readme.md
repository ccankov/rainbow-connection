# Rainbow Connection
A web site to find and manage a large number of connections between users. A user is a person with a first and last name, a favorite color, and any number of connections to other users.  Connections are always mutual (ie bi-directional).

## Getting Started
1. Clone this GitHub repository.
2. Navigate to the project directory and run:
```sh
composer install
```
This will install the necessary PHP packages and run post install scripts to configure the development environment.
3. Run the following command to set up a Vagrant VM that hosts the development environment:
```sh
vagrant up
```
Once this command has been run, the VM should be up and running and the environment is hosted.

**Note:** The environment is set up with a site mapping to www.rainbowconnection.com. After setting up an entry in /etc/hosts, the project can be accessed at www.rainbowconnection.com on the development machine.

## Architeture
Database: SQLite
  - SQLite was chosen because it is lightweight and easy to set up. This choice was made early on in the development process due to time constraints. However, a significant tradeoff in choosing SQLite was discovered later in the development process - SQLite has a very low limit on the number of bulk insertions, which makes it impossible to seed the database with over 800 users in a reasonable amount of time. Its performance is also much slower compared to a more robust database option like mySQL or PostgreSQL. One of these databases would be highly preferable for production deployment.

Backend: Laravel PHP 5.2
  - Laravel PHP 5.2 is used to host a RESTful web API that allows querying users and deleting connections. A User model was set up to simplifying creating and deleting connections between users. Seeding the database can be done at a testdata endpoint, and supports the creation of up to 800 users at once. Random data generation is done using Faker, and connections are populated randomly.
  - Bidirectional connections between users are stored in a users join table, and both directions (A -> B *plus* B -> A) are stored. Storing both directions is redundant and has the negative effect of slightly denormalizing the database, but this concern is significantly offset by the fact that creation and deletion operations are coupled in a transaction to ensure data integrity. The notable advantage of this approach is the simplification of database queries.

Frontend: Ember 2.x
  - Rainbow Connection is a single page application made possible by the Ember.js 2.x framework. Ember handles dynamic rendering of view templates on the front end without the need for synchronous queries to the backend API. View data is loaded from the root path, and any additional data requests are sent asynchronously and data is parsed from JSON. This allows for the "infinite pagination" feature through small, consecutive user queries made to the backend.
  - The Ember source files are built for production using the ember build tool which minifies and combines them into a single source file. The build output is placed directly inside the /public directory in the project root, where is it served to the client from the root API route. This allows a single server to run both the frontend and the backend. In development, the command
  ```sh
  ember build --watch
  ```
  can be used to continuously watch files for changes and update the build.

## Features/Requirements
1. Site should only use ajax beyond initial index page load
  - **Complete**. Initial page load loads all JS assets, while the remaining data calls for additional users and managing connections are all done using asynchronous AJAX requests.
2. All endpoints should follow REST protocol
  - **Partially complete**. Querying multiple users and a single user follows the REST protocol exactly. Deleting connections was implemented using a custom route due to time constraints; using a custom route breaks from the REST protocol but allowed managing connections without having to introduce a connection model or controller in the backend.
3. Site should be developed using Laravel PHP and Ember.js
  - **Complete**. A Laravel PHP backend was set up to serve assets at root path and deliver data via API Endpoints under the /api/ namespace. Ember.js is loaded at the root path and then uses asynchronous AJAX requests to request additional data and update frontend views.
4. Domain should be "www.rainbowconnection.com".  In osx/linux you can edit your /etc/hosts file to point this domain to your local instance (recommend homestead or laradock).
  - **Complete**. The composer post-intall scripts set up a site mapping to www.rainbowconnection.com for the Vagrant VM, which allows accessing the dev site at that URL after running "vagrant up". Note that the development /etc/hosts file must be manually pointed at the local Vagrant VM.
5. All lists should be displayed using "infinite pagination".  Any list with more than 25 results should be paginated in this way.  Upon scrolling down, an additional 25 results should load at a time.
  - **Partially complete**. The users list on the initial view features "infinite pagination" exactly as described. Because connections are eager-loaded along with users and due to time constraints, "infinite pagination" was not implemented for the connections list on the user view.
6. Color options include all primary, secondary & tertiary colors
  - **Partially complete**. Randomly generated colors use Laravel's Faker library to generate a large number of possible colors including all primary, secondary, & tertiary colors. The color dropdown on the User View was not implemented due to time constraints.
7. Anywhere a user's favorite color appears, the text should be colored corresponding to the value.
  - **Complete**. Wherever a color is listed (initial view and user view), the text is colored corresponding to the value.
8. Code should be well documented with appropriate comments.
  - **Complete**. User-generated code has been appropriately commented for clarity.
9. Please include a top-level README.md explaining your major architectural decisions.  Most important requirement is shipping on time, so if you have to make feature cuts or take shortcuts in order to finish, please explain what trade-offs you made and why you chose them.
  - **Complete**. This document satisfies this requirement.

## Initial View (www.rainbowconnection.com)
* Displays a list of all users with three columns: [full name], [favorite color], [comma-separated list of full names of all connections]
  - **Complete**
* Favorite color text should be colored with the relevant color
  - **Complete**
* User's full name, and each connection name should be clickable.  Clicking should take you to User View page.
  - **Complete**

## User View (www.rainbowconnection.com/[userid])
* Displays a title with this user's full name and favorite color
  - **Complete**
* Displays a list of all user's connections with three columns: [full name], [favorite color], [remove button]
  - **Complete**
* Clicking a list item's remove button should remove that connection and update the current view.
  - **Complete**
* Clicking on the favorite color of the current user in the title bar should give a drop-down selection of colors.  Selecting a new color should update the current user's color.
  - **Incomplete**: Due to time constraints, the dropdown selection and API Endpoint for updating a user's favorite color was not implemented.

## Test Endpoint (POST www.rainbowconnection.com/testdata)
* PARAMS: userCount - Integer between 1 and 1000000
  - **Partially complete**: A userCount parameter is accepted and used when reseeding the database. However, due to SQLite performance and bulk insertion limitations, the application cannot handle creating more than 800 users at once.
* This endpoint should clear the database, and populate it with a set of [userCount] users with randomly generated, human first and last names.
  - **Complete**
* Each user should have between 0 and 50 randomly generated connections.
  - **Complete**: When seeding, each user is given a random connection count between 0 and 50. As connections are built, the seeder tracks the number of connections for each user to ensure no user surpasses 50.
* Each user should have a randomly generated favorite color.
  - **Complete**
