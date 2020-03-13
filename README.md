# BlogTraining

This project is a training project to test my project organisation and to try the "first test" development method. 

## To Do 
- ~~create a backlog with all the user stories~~
- ~~create a mock-up of the website~~
- ~~create the entity schema~~
- ~~create the site map of the website~~
- ~~install the symfony/website-skeleton in local~~
- ~~add the origin remote to git~~
- ~~write the Read.me~~
- define the constraints of the entities
- develope the app by following the backlog priority with the test-first method
- add the css by following the mock-up
- add the end-to-end test to match with the user stories of the backlog
<br>
<br>

[Backlog](https://docs.google.com/spreadsheets/d/1IqGYPxU0CKftvMIUjacMXJA0FwGxybf_QqFzJ9RCFvA/edit?usp=sharing)<br>
[Mock-up](https://www.figma.com/proto/NPzOdMc70Jtwab6i7hAelx/mock-up?node-id=1%3A2&scaling=min-zoom)<br>
[Entity diagram](https://drive.google.com/file/d/1QU0ZPWntNJrShk8EGn9O4zAjmyAd3X7f/view?usp=sharing)<br>
[Sitemap diagram](https://drive.google.com/file/d/1ddp1XgEQuWALtQ5VDZYvc9cXq-v5Rxln/view?usp=sharing)
<br>

## Entities

**User**
- *id*
- Email string => email 
- Password 
- Firstname string < 255
- Lastname string < 255
<br>

**Alternative**
- *id*
- Title string < 255
- Description text < 400
- Content text
- TypeId 
- ContentTypeId
<br>

**Type**
- *id*
- name string < 255
<br>

**ContentType**
- *id*
- name string < 255
<br>
