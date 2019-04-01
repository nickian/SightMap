# SightMap® API Example

## Demo

See a live demo: https://nick.do/sightmap

## What is This?

This small web application demonstrates how to get a list of units from the SightMap® API and sort them. It uses PHP with cURL on the server and HTML/CSS/JavaScript on the front end. 

## Architecture

This example was designed to be flexible and extensible, using object-oriented PHP on the server-side. It provides a "progressively enhanced," single-page JavaScript interface, while still providing functionality when JavaScript is not available using pure HTML/CSS.

### `config.php`
Some global configuration values are stored here.

### `lib/SightMap.php`

This file is the model, where a few methods do the majority of the backend logic, such as cURL requests and data sorting.

### `index.php`

This file serves as the controller and decides whether to output JSON or HTML after doing some validation.

### `view.php`

This is the HTML view, taking a few variables from the controller to use in PHP template tags.

### `js/app.js`

All of the progressive user interaction functionality is defined here, using jQuery, AJAX, and JSON layered on top of the HTML view.