require('./bootstrap');

window.select2 = require(newFunction());

$('#state').select2();

function newFunction() {
    return 'select2/dist/js/select2.min.js';
}
