# mts

(otherwise known as "Movie Ticketing System" as per the abbrevation of the project name)

# What to know

- Timezone in this project is set to GMT+8 in parts of this code (see line 5 of `admin/admin_backend/cleanup.php` for example), while the showtimes are set to GMT+2 by default due to some unknown reasons.
- Admin account setting can only be done via MySQL on the `users` table by updating the `isAdmin` property.
- `firstName` is stored under a cookie property due to concerns about over-querying the MySQL server each time you visit any part of this site.
- Please configure your own payment gateway under the `/backend/gateway` directory for payment. Do note that the Redirect URL for the gateway configuration should be under `/backend/gateway/postProcessing` on your own server that this system is running at. Do note that all the required variables from the "Payment" form has been included in the `TEMPLATE` file.
- Malaysian Ringgit (RM) has been hardcoded in parts of this code as its default currency. If you need to use another currency, please change the files accordingly.
- There is no `assets_public/images` folder, so please create it under the structure listed below:

```
assets_public
├── images
│   ├── addons
│   ├── experiences
│   ├── filmRatings
│   ├── movieID
│   └── profile
└── style.css (exists)
```

- Ratings are stored under `/admin/add/properties.php`. By default, the ratings under this file are Malaysian film ratings by the Fillm Censorship Board of Malaysia (LPF), and images with the same name as the rating set should be stored under `/assets_public/images/filmRatings` as a PNG file.
  - Rating information text on some pages are also hardcoded. Please change both `/backend/payment/index.php` and `/filmDetails/index.php` accordingly.
- For every new seating template, user should modify the rows and columns by copying the `template.php` file under `/admin/halls/seatmap` to the PHP file that has the generated Seat ID.
- This project uses `mysqli` for MySQL queries and could be vunerable to SQL injection. To use it in a production environment, please check the PHP codes and replace `mysqli_query` and `mysqli_fetch_all` codes appropriately.

# Known bugs

- Tickets under `guest` cannot be deleted
- Apostrophes on film properties need to be replaced to `''` in order to let it work

# Known functions

This project has a:

- Online ticketing system that allows customers to choose date and time, seats and addons
- Ticket validation system that validates tickets for entrance usage (yes, that "autogate"-like function), which uses external webcam for realtime scanning
- Administrator management system that allows administrators to manage movies, addons, halls, showtimes and morecha

# Credits

| Project name                                                  | Used parts                                            |
| ------------------------------------------------------------- | ----------------------------------------------------- |
| [Bootstrap](https://github.com/twbs/bootstrap/)               | Website framework                                     |
| [PHP](https://www.php.net/)                                   | Main programming language used for backend of website |
| [MySQL](https://www.mysql.com/)                               | Database                                              |
| [mebjas/html5-qrcode](https://github.com/mebjas/html5-qrcode) | QR code scanner for ticket validation                 |
| [Font Awesome](https://github.com/FortAwesome/Font-Awesome)   | Icons for website                                     |

_Do note that Bootstrap and Font Awesome are included in this project through CDNs. Check `/elements/layout.php` for exact CDN URLs_

## Image credits

- Cinema seat vector from [here](https://www.svgrepo.com/svg/383570/cinema-seat-theatre-sofa) by `wishforge.games`, converted using [Glyphter](https://glyphter.com/)
