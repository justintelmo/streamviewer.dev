var api_url = '';

switch ( process.env.NODE_ENV ) {
    case 'development':
        api_url = 'https://streamviewer.dev/api/v1';
        break;
    case 'production':
        api_url = 'https://telmo-streamviewer.heroku.com/api/v1';
        break;
}

export const STREAMVIEWER_CONFIG = {
    API_URL: api_url
};