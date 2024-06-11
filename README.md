# mts

(otherwise known as "Movie Ticketing System" as per the abbrevation of the project name)

# What to know

- Timezone in this project is set to GMT+8 in parts of this code (see line 5 of `admin/admin_backend/cleanup.php` for example), while the showtimes are set to GMT+2 by default due to some unknown reasons.
- Admin account setting can only be done via MySQL on the `users` table by updating the `isAdmin` property.
- `firstName` is stored under a cookie property due to concerns about over-querying the MySQL server each time you visit any part of this site.
- Please configure your own payment gateway under the `/backend/gateway` directory for payment. Do note that the Redirect URL for the gateway configuration should be under `/backend/gateway/postProcessing` on your own server that this system is running at.
- Ratings are stored under `/admin/add/properties.php`. By default, the ratings under this file are Malaysian film ratings by the Censorship Board of Malaysia (LPF), and images with the same name as the rating set should be stored under `/assets_public/images/filmRatings` as a PNG file.
