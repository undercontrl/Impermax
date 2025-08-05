document.addEventListener('DOMContentLoaded', function() {
    const PUBLIC_KEY = 'opM4tQeS5gzjrwzVK'
    const YOUR_SERVICE_I = 'service_8efgeqf'
    const YOUR_TEMPLATE_ID = 'template_pcqbe2p';
    emailjs.init(PUBLIC_KEY);
    document.getElementById('form-contato').addEventListener('submit', function(event) {
        event.preventDefault();
        const statusMessage = document.getElementById('status-mensagem');
        const submitButton = this.querySelector('button[type="submit"]');

        submitButton.textContent = 'Enviando...';
        submitButton.disabled = true;
        statusMessage.textContent = '';

        const servico = document.getElementById('servico').value
        const telefone = document.getElementById('telefone').value

        const menssage = `Telefone: ${telefone}  -  Servico: ${servico} `
        const template = {
            name: document.getElementById('nome').value,
            email: document.getElementById('email').value,
            message: menssage
        };

        //console.log(template)
        emailjs.send(YOUR_SERVICE_I, YOUR_TEMPLATE_ID, template)
            .then(function(response) {
                console.log('SUCESSO!', response.status, response.text);
                statusMessage.textContent = 'E-mail enviado com sucesso!';
                statusMessage.style.color = 'green';
                
                document.getElementById('form-contato').reset();

            }, function(error) {
                console.log('FALHA...', error);
                statusMessage.textContent = 'Falha ao enviar o e-mail. Tente novamente mais tarde.';
                statusMessage.style.color = 'red';
            })
            .finally(function() {
                submitButton.textContent = 'Enviar Mensagem';
                submitButton.disabled = false;
            });
    });
});






document.addEventListener('DOMContentLoaded', function() {
    const PUBLIC_KEY = 'opM4tQeS5gzjrwzVK'
    const YOUR_SERVICE_I = 'service_8efgeqf'
    const YOUR_TEMPLATE_ID = 'template_pcqbe2p';
    emailjs.init(PUBLIC_KEY);
    document.getElementById('form-contato2').addEventListener('submit', function(event) {
        event.preventDefault();
        const statusMessage = document.getElementById('status-mensagem2');
        const submitButton = this.querySelector('button[type="submit"]');

        submitButton.textContent = 'Enviando...';
        submitButton.disabled = true;
        statusMessage.textContent = '';

        const servico = document.getElementById('servico2').value
        const telefone = document.getElementById('telefone2').value

        const menssage = `Telefone: ${telefone}  -  Servico: ${servico} `
        const template = {
            name: document.getElementById('nome2').value,
            email: document.getElementById('email2').value,
            message: menssage
        };

        //console.log(template)
        emailjs.send(YOUR_SERVICE_I, YOUR_TEMPLATE_ID, template)
            .then(function(response) {
                console.log('SUCESSO!', response.status, response.text);
                statusMessage.textContent = 'E-mail enviado com sucesso!';
                statusMessage.style.color = 'green';
                
                document.getElementById('form-contato2').reset();

            }, function(error) {
                console.log('FALHA...', error);
                statusMessage.textContent = 'Falha ao enviar o e-mail. Tente novamente mais tarde.';
                statusMessage.style.color = 'red';
            })
            .finally(function() {
                submitButton.textContent = 'Enviar Mensagem';
                submitButton.disabled = false;
            });
    });
});



document.addEventListener('DOMContentLoaded', function() {
    const PUBLIC_KEY = 'opM4tQeS5gzjrwzVK'
    const YOUR_SERVICE_I = 'service_8efgeqf'
    const YOUR_TEMPLATE_ID = 'template_pcqbe2p';
    emailjs.init(PUBLIC_KEY);
    document.getElementById('form-contato3').addEventListener('submit', function(event) {
        event.preventDefault();
        const statusMessage = document.getElementById('status-mensagem3');
        const submitButton = this.querySelector('button[type="submit"]');

        submitButton.textContent = 'Enviando...';
        submitButton.disabled = true;
        statusMessage.textContent = '';

        const servico = document.getElementById('servico3').value
        const telefone = document.getElementById('telefone3').value

        const menssage = `Telefone: ${telefone}  -  Servico: ${servico} `
        const template = {
            name: document.getElementById('nome3').value,
            email: document.getElementById('email3').value,
            message: menssage
        };

        //console.log(template)
        emailjs.send(YOUR_SERVICE_I, YOUR_TEMPLATE_ID, template)
            .then(function(response) {
                console.log('SUCESSO!', response.status, response.text);
                statusMessage.textContent = 'E-mail enviado com sucesso!';
                statusMessage.style.color = 'green';
                
                document.getElementById('form-contato3').reset();

            }, function(error) {
                console.log('FALHA...', error);
                statusMessage.textContent = 'Falha ao enviar o e-mail. Tente novamente mais tarde.';
                statusMessage.style.color = 'red';
            })
            .finally(function() {
                submitButton.textContent = 'Enviar Mensagem';
                submitButton.disabled = false;
            });
    });
});




document.addEventListener('DOMContentLoaded', function() {
    const PUBLIC_KEY = 'opM4tQeS5gzjrwzVK'
    const YOUR_SERVICE_I = 'service_8efgeqf'
    const YOUR_TEMPLATE_ID = 'template_pcqbe2p';
    emailjs.init(PUBLIC_KEY);
    document.getElementById('form-contato4').addEventListener('submit', function(event) {
        event.preventDefault();
        const statusMessage = document.getElementById('status-mensagem4');
        const submitButton = this.querySelector('button[type="submit"]');

        submitButton.textContent = 'Enviando...';
        submitButton.disabled = true;
        statusMessage.textContent = '';

        const servico = document.getElementById('servico4').value
        const telefone = document.getElementById('telefone4').value

        const menssage = `Telefone: ${telefone}  -  Servico: ${servico} `
        const template = {
            name: document.getElementById('nome4').value,
            email: document.getElementById('email4').value,
            message: menssage
        };

        //console.log(template)
        emailjs.send(YOUR_SERVICE_I, YOUR_TEMPLATE_ID, template)
            .then(function(response) {
                console.log('SUCESSO!', response.status, response.text);
                statusMessage.textContent = 'E-mail enviado com sucesso!';
                statusMessage.style.color = 'green';
                
                document.getElementById('form-contato4').reset();

            }, function(error) {
                console.log('FALHA...', error);
                statusMessage.textContent = 'Falha ao enviar o e-mail. Tente novamente mais tarde.';
                statusMessage.style.color = 'red';
            })
            .finally(function() {
                submitButton.textContent = 'Enviar Mensagem';
                submitButton.disabled = false;
            });
    });
});