<div align="center">
    <h1>SongWishesForDJ</h1>
    <p>A simple song wishes system for spotify in Laravel</p>
</div>

## 📦 Installation
To install this project, you need to follow these steps:

1. Clone this repository using following command:
```bash
git clone https://github.com/CrafterLP2007/SongWishesForDJ
```

2. Copy the .env.example to the .env file:
```bash
cp .env.example .env
```

3. Install the composer dependencies:
> [!IMPORTANT]  
> If you don't have composer installed, you can download it [here](https://getcomposer.org/download/).
```bash
composer install --no-dev --optimize-autoloader
```

4. Generate the application key:
```bash
php artisan key:generate
```

5. Install the npm dependencies:
> [!IMPORTANT]
> If you don't have npm installed, you can download it [here](https://nodejs.org/en/download/).
```bash
npm install
```

6. Build the assets using npm:
```bash
npm run build
```

## 🛠️ Configuration
> [!IMPORTANT]
> A complete guide can be found [here](https://developer.spotify.com/documentation/web-api/concepts/apps).
1. Go to your Spotify Developer Dashboard and create a new application.
2. Copy the client id, client secret and the redirect uri to the .env file.
3. Open the **.env** file and configure the following variables:
```dotenv
SPOTIFY_CLIENT_ID=
SPOTIFY_CLIENT_SECRET=
SPOTIFY_REDIRECT_URI=
```
4. To authorize your user with your client details, you need to execute the following command:
```bash
php artisan swf:spotify:authorize
```

## 🚀 Troubleshooting
If you have any problems with the installation, you can try the following steps or [open an issue](https://github.com/CrafterLP2007/SongWishesForDJ/issues/new):
### ❌ Errors
- **Cannot add song** 
  If you can't add a song to the playlist, you should check if the authorization is correct.

- **Song limit exceeded**
  If you get an error that the song limit is exceeded, you should check if the playlist is full or go into the **.env** file and change the following variable:
    ```dotenv
    SPOTIFY_PLAYLIST_LIMIT=VALUE_YOU_WANT
    ```
  
## 🏳️ Multi-Language
This project is available in multiple languages. You can change the language in the **.env** file:
```dotenv
APP_LOCALE=en
```
> [!TIP]
> The available languages are: `en`, `de`

## 📝 Contributing
If you want to contribute to this project, you can fork this repository and create a pull request.

## 📜 License
This project is licensed under the MIT License - see the [LICENSE](https://github.com/CrafterLP2007/SongWishesForDJ/blob/master/LICENSE) file for details.
