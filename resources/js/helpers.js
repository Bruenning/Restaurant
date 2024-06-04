import CryptoJS from 'crypto-js';

/**
 * Criptografa a senha do usuário com sha256
 * 
 * @param {String} passsword 
 */
function hash (passsword) {
    return CryptoJS.SHA256(passsword).toString(CryptoJS.enc.Hex);

}

/**
 * route - Função para gerar rotas com parametros dinamicos baseados em laravel routes names
 * 
 * @param {String} route
 * @param {Object} params
 * @returns {String}
 * 
 * @example
 * 
 * route('user.edit', {id: 1})
 *
 */

function route (route, params) {
    let url = window.location.origin + '/';

    if (route) {
        route = route.split('.');
        route.forEach((value, index) => {
            url += value + '/';
        })
    }

    if (params) {
        for (let key in params) {
            url = url.replace('{' + key + '}', params[key]);
        }
    }

    return url;
}

/**
 * Função para validar formulários passando as rules regex e o form.
 */
function validateForm(form, rules) {
    let valid = true;
    let error = '';

    Object.keys(rules).forEach(field => {
        let fieldRules = rules[field];
        if (Array.isArray(fieldRules)) {
            fieldRules.forEach(rule => {
                if (typeof rule === 'function') {
                    let result = rule(form[field]);
                    if (result !== true) {
                        valid = false;
                        error = result;
                    }
                } else {
                    error = `Invalid validation rule for field ${field}: ${rule}`;
                }
            });
        } else {
            error = `Invalid validation rules for field ${field}: ${fieldRules}`;
        }
    });

    return valid ? true : error;
}

function getDate(date) {
    
    date = new Date(date.replace('Z', '').replace('T', ' '));

    return date.toLocaleDateString('pt-BR');
}

function getTime(date) {

    date = new Date(date);
    date.setUTCHours(date.getUTCHours() + 3)

    return date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
}

export default { hash, route, validateForm, getDate, getTime }   