import axios from 'axios';

const instance = axios.create({
    baseURL: '/api',
});

instance.interceptors.request.use(
    config => {
        const token = localStorage.getItem('authToken');
        if (token) {
            config.headers['Authorization'] = 'Bearer ' + token;
        }

        config.headers['Accept'] = 'application/json';

        return config;
    },
    error => {
        return Promise.reject(error);
    }
);

export default instance;
