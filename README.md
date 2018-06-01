# hotel

## Introduction

This application is for managing the booking system of a hotel.

When accessing the homepage(index.php) for the first time, it will initialize the database with minimal information if given the correct login information in the 'login_info.php' file in the 'include' folder.


## Database


The application works with a MySQL database.

When initializing it will create the followings:

- Create the database according to the name given in the on the 'login_info.php' file.
- Create the tables: 'guest', 'room', 'user' and 'booking'.
- Insert a user and several rooms.

## Pages

### View Bookings:

Allows to view current and future registered bookings.

For each booking, the user can either **Edit** or **Delete** it.

Using the **Edit** button will change the page to display the information of the picked booking to change.

*note: the edition will fail if given wrong information (ex. date range in the wrong order)*

Using the **Delete** button will imediately delete the selected booking(no confirmation).

### Add Booking:

Allows to add a new booking.

The user can fill the information. All information is mandatory except for the second date(displayed with checkbox).

### Check Availability:

Shows a list available rooms for a given date range.

### Statistics:

Shows some statistics about the hotel:

- Total number of guests.
- All booking recorded.
- Past bookings.
- Current bookings.
- Future bookings.

### Guests:

Lists all the guests of the hotel.

The user can view the details for each guest thus displaying the history of bookings for the guest.