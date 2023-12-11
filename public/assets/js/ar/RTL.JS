
document.addEventListener('DOMContentLoaded', function () {
    var rtlButton = document.getElementById('rtlButton');

    rtlButton.addEventListener('click', function () {
        document.documentElement.dir = 'rtl';
    });
});

