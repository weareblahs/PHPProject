# mts

(otherwise known as "Movie Ticketing System" as per the abbrevation of the project name)

# What to know

- Timezone in this project is set to GMT+8 in parts of this code (see line 5 of `admin/admin_backend/cleanup.php` for example), while the showtimes are set to GMT+2 by default due to some unknown reasons.
- Admin account setting can only be done via MySQL on the `users` table by updating the `isAdmin` property.
- `firstName` is stored under a cookie property due to concerns about over-querying the MySQL server each time you visit any part of this site.
- Please configure your own payment gateway under the `/backend/gateway` directory for payment. Do note that the Redirect URL for the gateway configuration should be under `/backend/gateway/postProcessing` on your own server that this system is running at.
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

- Ratings are stored under `/admin/add/properties.php`. By default, the ratings under this file are Malaysian film ratings by the Censorship Board of Malaysia (LPF), and images with the same name as the rating set should be stored under `/assets_public/images/filmRatings` as a PNG file.
- For every new seating template, user should modify the rows and columns by copying the `template.php` file under `/admin/halls/seatmap` to the PHP file that has the generated Seat ID.

# Known bugs

- Tickets under `guest` cannot be deleted
- All options under "Display options" must be ticked, otherwise the add query won't work
