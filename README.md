<div align="center">
    <h1>SongWishesForDJ</h1>
    <p>A simple song wishes system for spotify in Laravel</p>
</div>

## 🔎 Requirements
To run this project, you need to have the following requirements:
- [PHP](https://www.php.net/downloads.php) >= 8.1
- [Composer](https://getcomposer.org/download/) >= 2.5.7
- [Node.js](https://nodejs.org/en/download/package-manager) >= 20.7.0
- [NPM](https://nodejs.org/en/download/package-manager) >= 10.1.0

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
```bash
composer install --no-dev --optimize-autoloader
```

4. Generate the application key:
```bash
php artisan key:generate
```

5. Install the npm dependencies:
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
SPOTIFY_PLAYLIST_ID=
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
