(function () {
    const formTopo = document.getElementById('form-contato-topo');
    if (!formTopo) return;

    const flashTopo = document.getElementById('mensagem-flash-topo');

    function showMessageTopo(text, type = 'success', timeout = 5000) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
        flashTopo.innerHTML = `<div class="alert ${alertClass}">${text}</div>`;
        
        // Removido style.marginTop aqui → controlado só pelo CSS
        if (timeout > 0) {
            setTimeout(() => {
                flashTopo.innerHTML = '';
            }, timeout);
        }
    }

    formTopo.addEventListener('submit', function (e) {
        e.preventDefault();

        const submitBtn = formTopo.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn ? submitBtn.innerHTML : null;

        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Enviando...';
        }

        const data = new FormData(formTopo);

        fetch(formTopo.action, {
            method: formTopo.method || 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: data,
            credentials: 'same-origin'
        })
        .then(async response => {
            let json = null;
            try { json = await response.json(); } catch (err) {}

            if (response.ok) {
                if ((json && (json.status === 'success' || json.success === true)) || !json) {
                    showMessageTopo('Enviado com sucesso', 'success', 5000);
                    formTopo.reset();
                } else if (json && json.message) {
                    showMessageTopo(json.message, (json.status === 'success' || json.success) ? 'success' : 'error', 5000);
                    if (json.status === 'success' || json.success) formTopo.reset();
                } else {
                    showMessageTopo('Enviado com sucesso', 'success', 5000);
                    formTopo.reset();
                }
            } else {
                showMessageTopo((json && json.message) || 'Erro ao enviar. Tente novamente.', 'error', 5000);
            }
        })
        .catch(err => {
            console.error(err);
            showMessageTopo('Erro de conexão. Verifique sua internet.', 'error', 5000);
        })
        .finally(() => {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText || 'Enviar solicitação de orçamento';
            }
        });
    });
})();


// FORMULÁRIO TOPO 2

(function () {
    const formTopo = document.getElementById('form-contato-topo2');
    if (!formTopo) return;

    const flashTopo = document.getElementById('mensagem-flash-topo2');

    function showMessageTopo(text, type = 'success', timeout = 5000) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
        flashTopo.innerHTML = `<div class="alert ${alertClass}">${text}</div>`;
        
        // Removido style.marginTop aqui → controlado só pelo CSS
        if (timeout > 0) {
            setTimeout(() => {
                flashTopo.innerHTML = '';
            }, timeout);
        }
    }

    formTopo.addEventListener('submit', function (e) {
        e.preventDefault();

        const submitBtn = formTopo.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn ? submitBtn.innerHTML : null;

        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Enviando...';
        }

        const data = new FormData(formTopo);

        fetch(formTopo.action, {
            method: formTopo.method || 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: data,
            credentials: 'same-origin'
        })
        .then(async response => {
            let json = null;
            try { json = await response.json(); } catch (err) {}

            if (response.ok) {
                if ((json && (json.status === 'success' || json.success === true)) || !json) {
                    showMessageTopo('Enviado com sucesso', 'success', 5000);
                    formTopo.reset();
                } else if (json && json.message) {
                    showMessageTopo(json.message, (json.status === 'success' || json.success) ? 'success' : 'error', 5000);
                    if (json.status === 'success' || json.success) formTopo.reset();
                } else {
                    showMessageTopo('Enviado com sucesso', 'success', 5000);
                    formTopo.reset();
                }
            } else {
                showMessageTopo((json && json.message) || 'Erro ao enviar. Tente novamente.', 'error', 5000);
            }
        })
        .catch(err => {
            console.error(err);
            showMessageTopo('Erro de conexão. Verifique sua internet.', 'error', 5000);
        })
        .finally(() => {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText || 'Enviar solicitação de orçamento';
            }
        });
    });
})();


// FORMULARIO CONTATO

(function () {
    const formTopo = document.getElementById('form-contato-topo3');
    if (!formTopo) return;

    const flashTopo = document.getElementById('mensagem-flash-topo3');

    function showMessageTopo(text, type = 'success', timeout = 5000) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
        flashTopo.innerHTML = `<div class="alert ${alertClass}">${text}</div>`;
        
        // Removido style.marginTop aqui → controlado só pelo CSS
        if (timeout > 0) {
            setTimeout(() => {
                flashTopo.innerHTML = '';
            }, timeout);
        }
    }

    formTopo.addEventListener('submit', function (e) {
        e.preventDefault();

        const submitBtn = formTopo.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn ? submitBtn.innerHTML : null;

        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Enviando...';
        }

        const data = new FormData(formTopo);

        fetch(formTopo.action, {
            method: formTopo.method || 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: data,
            credentials: 'same-origin'
        })
        .then(async response => {
            let json = null;
            try { json = await response.json(); } catch (err) {}

            if (response.ok) {
                if ((json && (json.status === 'success' || json.success === true)) || !json) {
                    showMessageTopo('Enviado com sucesso', 'success', 5000);
                    formTopo.reset();
                } else if (json && json.message) {
                    showMessageTopo(json.message, (json.status === 'success' || json.success) ? 'success' : 'error', 5000);
                    if (json.status === 'success' || json.success) formTopo.reset();
                } else {
                    showMessageTopo('Enviado com sucesso', 'success', 5000);
                    formTopo.reset();
                }
            } else {
                showMessageTopo((json && json.message) || 'Erro ao enviar. Tente novamente.', 'error', 5000);
            }
        })
        .catch(err => {
            console.error(err);
            showMessageTopo('Erro de conexão. Verifique sua internet.', 'error', 5000);
        })
        .finally(() => {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText || 'Enviar solicitação de orçamento';
            }
        });
    });
})();



// FORMULARIO SOBRE

(function () {
    const formTopo = document.getElementById('form-contato-topo4');
    if (!formTopo) return;

    const flashTopo = document.getElementById('mensagem-flash-topo4');

    function showMessageTopo(text, type = 'success', timeout = 5000) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
        flashTopo.innerHTML = `<div class="alert ${alertClass}">${text}</div>`;
        
        // Removido style.marginTop aqui → controlado só pelo CSS
        if (timeout > 0) {
            setTimeout(() => {
                flashTopo.innerHTML = '';
            }, timeout);
        }
    }

    formTopo.addEventListener('submit', function (e) {
        e.preventDefault();

        const submitBtn = formTopo.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn ? submitBtn.innerHTML : null;

        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Enviando...';
        }

        const data = new FormData(formTopo);

        fetch(formTopo.action, {
            method: formTopo.method || 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: data,
            credentials: 'same-origin'
        })
        .then(async response => {
            let json = null;
            try { json = await response.json(); } catch (err) {}

            if (response.ok) {
                if ((json && (json.status === 'success' || json.success === true)) || !json) {
                    showMessageTopo('Enviado com sucesso', 'success', 5000);
                    formTopo.reset();
                } else if (json && json.message) {
                    showMessageTopo(json.message, (json.status === 'success' || json.success) ? 'success' : 'error', 5000);
                    if (json.status === 'success' || json.success) formTopo.reset();
                } else {
                    showMessageTopo('Enviado com sucesso', 'success', 5000);
                    formTopo.reset();
                }
            } else {
                showMessageTopo((json && json.message) || 'Erro ao enviar. Tente novamente.', 'error', 5000);
            }
        })
        .catch(err => {
            console.error(err);
            showMessageTopo('Erro de conexão. Verifique sua internet.', 'error', 5000);
        })
        .finally(() => {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText || 'Enviar solicitação de orçamento';
            }
        });
    });
})();

// FORMULARIO SERVIÇOS

(function () {
    const formTopo = document.getElementById('form-contato-topo5');
    if (!formTopo) return;

    const flashTopo = document.getElementById('mensagem-flash-topo5');

    function showMessageTopo(text, type = 'success', timeout = 5000) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
        flashTopo.innerHTML = `<div class="alert ${alertClass}">${text}</div>`;
        
        // Removido style.marginTop aqui → controlado só pelo CSS
        if (timeout > 0) {
            setTimeout(() => {
                flashTopo.innerHTML = '';
            }, timeout);
        }
    }

    formTopo.addEventListener('submit', function (e) {
        e.preventDefault();

        const submitBtn = formTopo.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn ? submitBtn.innerHTML : null;

        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Enviando...';
        }

        const data = new FormData(formTopo);

        fetch(formTopo.action, {
            method: formTopo.method || 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: data,
            credentials: 'same-origin'
        })
        .then(async response => {
            let json = null;
            try { json = await response.json(); } catch (err) {}

            if (response.ok) {
                if ((json && (json.status === 'success' || json.success === true)) || !json) {
                    showMessageTopo('Enviado com sucesso', 'success', 5000);
                    formTopo.reset();
                } else if (json && json.message) {
                    showMessageTopo(json.message, (json.status === 'success' || json.success) ? 'success' : 'error', 5000);
                    if (json.status === 'success' || json.success) formTopo.reset();
                } else {
                    showMessageTopo('Enviado com sucesso', 'success', 5000);
                    formTopo.reset();
                }
            } else {
                showMessageTopo((json && json.message) || 'Erro ao enviar. Tente novamente.', 'error', 5000);
            }
        })
        .catch(err => {
            console.error(err);
            showMessageTopo('Erro de conexão. Verifique sua internet.', 'error', 5000);
        })
        .finally(() => {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText || 'Enviar solicitação de orçamento';
            }
        });
    });
})();