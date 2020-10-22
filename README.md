# Campspot Project

A command line application which takes a JSON file containing search dates, campsites, and existing reservations as input and outputs a list of campsites which can be booked without introducing a one night gap between any existing reservations. 

## Overview

The application consists of the following domain objects: 

- Campsite
  - id (int)
  - string (name) 
- Reservation
  - campsite_id (int)
  - date_range (DateRange)
- DateRange
  - start_date (DateTime)
  - end_date (DateTime)
  
A Scheduling Rule is defined by the *SchedulingRule* interface, which has a single *check* method which will check whether or not that rule passes for a given Date Range and set of Reservations. It is currently implemented by two rules: 
- AlreadyReservedSchedulingRule
  - Will check whether any of the dates are already reserved
- OneNightGapSchedulingRule
  - Will check whether scheduling these dates will create a one day gap between existing reservations
 
New rules can be added by creating new classes implementing the *SchedulingRule* interface.

*SchedulingService::canReservationBeMade* takes a date range, an array of reservations, and an array of Scheduling Rules to check against. If this were to be extended to allow for campsites to determine which rules they wanted their schedules to abide by, you would just have to modify which rules you are passing into this method.

Finally, the command line application *campspot-project* will read the JSON file, where the data will be passed off to *AppController::handle*. This method will call *SchedulingService::canReservationBeMade* with existing reservations for each campsite and output the results. 

## Setting Up

In order to run this project you will first need to clone this repository:
```
git clone https://github.com/SirCortly/campspot-project.git
```

Change directory and run vagrant up to initialize the Vagrant box:
```
cd campspot-project/
vagrant up
```
*You will run the application inside of this vagrant box in case you do not have a PHP environment set up on your local machine.*

SSH into Vagrant box and navigate to shared vagrant directory:
```
vagrant ssh
cd /vagrant
```

Install dependencies:
```
composer install
```

Run the application: 
```
./campspot-project {path-to-json-file}
```
*Make sure you change directory to /vagrant before attempting to run the application*'
*Also, make sure to move any json files you may want to test with into the project directory so that they can be accessed from within the vagrant box*
