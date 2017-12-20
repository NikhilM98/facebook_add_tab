# Facebook Add Tab using PHP SDK

    This application is useful to add dynamic tabs in the facebook pages.

# The Problem with Facebook Add Tab

    Users can only add simple secure url in Page Tabs.

> Those URLs cannot have GET data.

> For example one cannot add www.website.com/page/?id=2

> He can only add www.website.com/page

> Users cannot create dynamic content depending on who visits the tab and on which page its added.

# What you get here

> I have uploaded the code which is currently used by the application as well as fully commented boilerplate code which you can use to create your own custom Add Tab Application.

# How does the application works

    Objective of the sample project

> I was given a task where I have to create a single application to add a Page Tab in the facebook page of doctors or clinics.

> The URL of the page I had used GET data to identify the doctors or clinics. For example, www.site.com/page/?id=1 is used to identify first doctor and www.site.com/page/cid=1 is used to identify first clinics.

> At first, the logged in doctor was supposed to go to a page where he got to select the clinic/doctor page which he wants to add. The IDs of the clinic are obtained from the session and then their names are retrived from the database. He also gets to select the in which facebook page should he add the tab. Then he presses submit

> Once user submits the data, a tab is generated and the data about the clinic/doctor and page_id is stored in the database.

> The second part of the work involded actually displaying different add_tab pages on different facebook pages.

> User has to click on a button to launch the app (view the page) within the Added Tab. Different content is displayed on the pages using the page_id from the page itself and the database.


    First Part: AddNewTab.php:

> This page is used to add a new tab in facebook page

> Database is connected

> Facebook object is created using app_id and app_secret

> Access Token from the user is obtained

> Access Token is converted into long-lived access token

> GET request is made from the graph api and user info and info about his pages is retrived

> // (Data from the database is fetched about the available clinics using the data stored in session. This step explicit for the docconsult project only)

> A form is generated in which a user can select the page on which he has to add the page. (He can also select the clinic or doctor for which the tab is to be added)

> POST request is made to the graph api in order to create a new tab

> Data about the page_id on which the tab is added and "corresponding other data" (What to display?) is stored in the database.


    Second Part: AddedTab.php:

> This page is the page that is displayed in the added tab. You have to set the url of facebook secure tab url in your app dashboard equal to this page url

> This app works in a similar fashion. Database is connected, Facebook object is created.

> User has to click on a button. Once the user clicks on that button, access token is obtained. That access token is used to Get Signed Request from facebook using getPageTabHelper.

> The Signed Request contains the data about the page_id of the current page. That page_id sent to the database and "corresponding other data" (What to display?) is obtained. // (In our case that data contains Clinic/Doctor ID.)

> That "corresponding other data" is manupulated and data in $_GET is set. We have done this because we want to reuse the component that our website uses which depends on the $_GET data.


# How to use

> You need to download and import the Facebook PHP SDK in your Project folder.

> Put your app_id, app_secret, default_graph_version, database host, database username, database password, and database name in the required places.

> The Boilerplate code is nicely commented. Edit the that code in order to create your own custom Add Tab App.