var api_url = '';
var web_url = '';
switch (process.env.NODE_ENV) {
    case 'development':
        api_url = 'http://localhost:8000/api/v1';
        web_url = 'http://localhost:8000/';
        break;
    case 'production':
        api_url = 'https://streamviewer-telmo.herokuapp.com/api/v1';
        web_url = 'https://streamviewer-telmo.herokuapp.com/';
        break;
}

export const STREAMVIEWER_CONFIG = {
    API_URL: api_url,
    WEB_URL: web_url
};
