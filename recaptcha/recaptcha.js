grecaptcha.ready(function() {
    grecaptcha.execute('6LdbcewUAAAAAEFgZ6RxuIPZDLzz3KgARBr-s5Ho', { action: 'ecommerce' }).then(function(token) {
        document.getElementById('g-recaptcha-response').value = token;
    });
});