export default class HttpClient {
    constructor(baseUrl = '', csrfToken = '') {
        this.baseUrl = baseUrl;
        this.csrfToken = csrfToken;
    }

    request(method = 'GET', url, callback, parametres = {}, headers = {}) {
        let fullUrl = this.baseUrl + url;
        if (method !== 'GET') {
            headers['X-CSRF-TOKEN'] = this.csrfToken;
        }
        const options = {
            method: method,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                ...headers
            }
        };
        if (method == 'GET' && Object.keys(parametres).length === 0) {
            const queryParams = new URLSearchParams(parametres).toString();
            fullUrl = `${fullUrl}?${queryParams}`;
        } else if (method !== 'GET') {
            options.body = JSON.stringify(parametres);
        }
        fetch(fullUrl, options)
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Something went wrong');
                }
            })
            .then(data => {
                callback(data);
            })
            .catch(error => {
                console.error(error);
            });

    }

    get(url, callback, parametres = {}, headers = {}) {
        this.request('GET', url, callback, parametres, headers);
    }
    post(url, callback, parametres = {}, headers = {}) {
        this.request('POST', url, callback, parametres, headers);
    }
    put(url, callback, parametres = {}, headers = {}) {
        this.request('PUT', url, callback, parametres, headers);
    }
    delete(url, callback, parametres = {}, headers = {}) {
        this.request('DELETE', url, callback, parametres, headers);
    }

}