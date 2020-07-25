window._ = require('lodash');

//

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

//

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

//

import EchoLibrary from 'laravel-echo';

window.Pusher = require('pusher-js');

Pusher.logToConsole = true;

window.Echo = new EchoLibrary({
    broadcaster: 'pusher',
    key: '236acea19ee8b3a3672a',
    cluster: 'us2',
    encrypted: false,
    forceTLS: false,
    authEndpoint: '/broadcast',
});