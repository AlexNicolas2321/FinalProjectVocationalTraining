# Spotify Clone - Full Stack Project

## Description
This project is a Spotify clone that implements the main features of the platform. Developed with Angular for the frontend and Symfony for the backend, it demonstrates skills in modern web development, software architecture, and good programming practices.

## Technologies Used

### Frontend
- Angular 17
- TypeScript
- HTML5/CSS3
- RxJS
- Angular Material

### Backend
- Symfony 6
- PHP 8
- MySQL
- Docker
- REST API

## Project Structure
```
spotify_project/
├── Angular/          # Angular Frontend
├── Symfony/          # Symfony Backend
└── README.md         # Main Documentation
```

## Implemented Features
- User Authentication
- Music Search
- Song Playback
- Playlists
- User Profiles
- RESTful API

## Prerequisites
- Node.js 18+
- PHP 8.2+
- Docker and Docker Compose
- MySQL 8.0+

## Installation and Execution

### Frontend (Angular)
```bash
cd Angular
npm install
ng serve
```

### Backend (Symfony)
```bash
cd Symfony
docker-compose up -d
composer install
php bin/console doctrine:migrations:migrate
```

## Contribution
This project is open source and available for educational and demonstrative purposes. If you wish to contribute, please follow the contribution guidelines.

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contact
If you are interested in this project or my work, feel free to contact me at [abladorive@gmail.com]