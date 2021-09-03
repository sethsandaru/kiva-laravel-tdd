# KivaNote - a Laravel TDD Sample Project

[![codecov](https://codecov.io/gh/sethsandaru/kiva-laravel-tdd/branch/master/graph/badge.svg?token=2PQOG1RYGQ)](https://codecov.io/gh/sethsandaru/kiva-laravel-tdd)

Let me introduce you to KivaNote, a simple real-world application using Laravel to show you
how the TDD & Unit Testing works (with PHP & Laravel).

TDD or Unit Testing, it's absolutely good practice and give the developers more confident & trust about their works, their project. Especially importance projects like:
Banking, Healthcare, E-commerce,...

I know out there, many people wants to learn how to write unit testing in proper/real-life ways. And the online articles are just:

- You need to write test
- Write a func `a + b = c` then `assertEquals(2, plus(1,1))`
    - BS, I know right??
- You need to test this, test that,...
- blah blah blah,...

Those articles won't help. In fact, you won't probably learn anything from that, especially for newbie. You always need to learn from
a real-world project.

So, this little project of mine is going to help you know how to write tests, especially using PHP & Laravel.

## Application Introduction
An API Application for a simple note application. It's providing these REST API endpoints

### DB Overview
- 1 User `users`:
  - **n** Images `images`
  - **n** Notes `notes`
    - **n** Note Contents `note_contents` (history purpose)

### Authentication
- [POST] v1/login
  - Body:
    - email
    - password
  - Response:
    - access_token
- [POST] v1/logout
  - Header
    - Bearer **{authToken}**

**Note**: for all the endpoints below, Bearer **{authToken}** is **required**.

### Notes
- [GET] `v1/notes`: Get notes list of user.
  - Query param:
    - page (default **1**)
    - limit (default **10**)
- [GET] `v1/notes/{noteUuid}`: Get a single note details
- [POST] `v1/notes`: Add new note
  - Body
    - title
    - content
- [PUT] `v1/notes/{noteUuid}`: Update an existing note
  - Body
    - title
    - content
- [DELETE] `v1/notes/{noteUuid}`: Delete an existing note

### Images
- [GET] `v1/images`: Get images that uploaded by user
  - Query param:
    - page (default **1**)
    - limit (default **10**)
- [GET] `v/images/{imageUuid}`: Get a single image details
- [POST] `v1/images`: Upload an image
  - Body (`FormData`):
    - image (binary)
    - type: 
      - `self-hosted`: save in the filesystem
      - `imgbb`: save on ImgBB external service
- [DELETE] `v1/images/{imageUuid}`: Delete an image

### External Services
- ImgBB: to upload image
  - Also showing you how to write tests for the external APIs

## What do we have?
- PHP8
  - Super recommended, fast and added a lot of cool syntax.
- Laravel 8
- PHPUnit (of course)
- Coverage - using CodeCov (free)

## Continuous Integration
Yes. That's where the fun begin. In real life, every projects that have unit testing also have CI process. Some use GitLab CI, some use Jenkins CI.

But for Kiva, I will use GitHub Action.

## Test definitions
- Unit Test
  - Where we're going to test methods of the Class
- Quick Test
  - Same as Unit, but this test won't involve database, all we need to do is mocking then testing
  - Super fast since no dependencies at all.
- Feature Test
  - HTTP Test to test the endpoints
- Integration Test
  - Test multiple endpoints of a flow to see if they are working correctly
    - Not sure we would have it for Kiva, but let's see

### Coverage Info
So it depends which kind of projects are you working on to set a coverage goal.

In my opinion, **70%++** would be cool and give me a lot of confident. 

When you're writing unit tests, you should coverage all the cases that might happen and that would be totally enough.

Don't do trick or cheat to get high coverage though.

### Where should you start?
- Check out the routes and the Controllers
- Check out the `tests` folder
  - Quick first, then Unit and then Feature

## Contribute?
Sure, just fork it and add your PR, remember to:

- Write tests
- Follow PSR conventions

## You like it?

Then please give it a Star ⭐

Also, you can support me by donate via [Kofi](https://ko-fi.com/sethphat) too. Thank you very much!!

## Have questions?
Feel free to create an issue or ping me via email. Gracias.

## Copyright
By Seth Phat - 2021.
