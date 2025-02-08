// Import and configure axios
import axios from 'axios';

// Set axios as a global variable with proper type definitions
window.axios = axios;

// Configure default headers
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'Accept': 'application/json',
    'Content-Type': 'application/json'
};

// Add response interceptor for error handling
window.axios.interceptors.response.use(
    response => response,
    error => {
        // Handle common errors
        if (error.response) {
            // Log error details in development
            if (process.env.NODE_ENV === 'development') {
                console.error('API Error:', error.response);
            }
        }
        return Promise.reject(error);
    }
);

// Set default timeout
window.axios.defaults.timeout = 30000; // 30 seconds
