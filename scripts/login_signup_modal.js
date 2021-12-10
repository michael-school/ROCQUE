//get the parameters from URL (for use in signup and login modals)
const searchParams = new URLSearchParams(window.location.search);
const signup = searchParams.get('signup');
const login = searchParams.get('login');

//open modals
var loginModal = new bootstrap.Modal(document.getElementById('loginModal'), {});
var signupModal = new bootstrap.Modal(document.getElementById('signupModal'), {});
window.onload = function() {
    if (login == 'failed' || signup == 'success'){
        loginModal.toggle();
    } else if (signup == 'failed') {
        signupModal.toggle();
    }
};