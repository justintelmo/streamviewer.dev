# Streamviewer

By Justin Telmo

## Description

A single page application that is built with Vue and Laravel

Users may log in with their Google accounts via OAuth2.0, which lets them see a list of currently active live broadcasts on YouTube, sorted by viewers. Once a user selects a live broadcast, they may view and participate in the chat. They may also see current stats of the stream, including the most recent chats.

## Time Taken

Overall, this took me about a couple weeks, with 12 hours of work in total.

## Technologies Used

PHP

-   Laravel

Javascript

-   Vue
-   Bootstrap
-   jQuery

While I do have some PHP experience, a lot of my experience comes without knowledge of modern frameworks, so I decided to use PHP with a framework that I was interested in learning wholeheartedly. Laravel seemed to stick out as the framework of choice for a lot of modern PHP developers, so I went with that.

On the client side, Vue has been getting a lot of traction lately so I decided to use that to see what the fuss was about. Turns out, it's a pretty darn intuitive framework. Routing and templating were made very simple with this.

## Known Issues

Right now, there seems to be a CORS issue regarding logging in and seeing the streams for the first time. For some reason, this is the only request still being sent over HTTP instead of HTTPS. In order to get around this, after your login, simply prepend `https://` to the URL inside your browser. I still do not fully understand why this is happening, as I have tried multiple methods of getting around this.

## Design Decisions

My first design decision was to figure out how often we should be updated the chats table. In the grandest scope, I was thinking that I could keep a running update on every live stream at the same time using WebSockets or something, but that would quickly rate limit my application fast. So instead, we only keep track of live stats while a user is watching a given broadcast.

Designing the flow of the app seemed pretty straightforward. We want the user to see the landing page, log in, then see the streams automatically. From the streams page a user should be able to select a given stream, then be taken to it. Using the already-built embeded iframes for the YouTube video and YouTube chat saved a ton of time and potential headache.

Being able to swap between stream and stats was pretty important in order to keep up with the pace of how a user might want to use this. I was unfortunately unable to keep track of stats in a rolling window, but I would have implemented this if I had more time.

On the back-end, using Laravel made designing the routes, controllers, and models very easy to manage. I decided to not have a model for streams since everything tied to them was given a separate model and table anyway. This would make it easier on me, as the controller for the Streams would just be something calling the YouTube API to grab the top 25 or so streams.

As far as CSS styling went, I wanted everything to be centered in order to make a reactive design that much easier. In the end, I went with Bootstrap due to previous experience.
