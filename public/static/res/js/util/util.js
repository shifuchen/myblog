function jmsj(str) {


    var pubkey = '-----BEGIN PUBLIC KEY-----';
    pubkey += 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCytYlGIkLH8Vp6FY72PSfjnlkw';
    pubkey += 'IkR6r8Iw6DJvSwVil8ww88hNx3sf86CeE1ttoyIJO1jV52Oijr6P5cvtG3oG9J0U';
    pubkey += 'Lp+wrJmtiEBJkAKuK/45+D65boBKrI8ye/AGiQe0tm611JVGDMFyBJUKlAVQjsrk';
    pubkey += 'kjf93uzY562B448U4QIDAQAB';
    pubkey += '-----END PUBLIC KEY-----';
    var encrypt = new JSEncrypt();
    encrypt.setPublicKey(pubkey);
    var encrypted = encrypt.encrypt(JSON.stringify(str));
    return encrypted;
}

function formAtDate(format) {
    var date = new Date(format);
    var Y = date.getFullYear() + '-';
    var M = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + '-';
    var D = (date.getDate() < 10 ? '0' + date.getDate() : date.getDate()) + ' ';
    var h = (date.getHours() < 10 ? '0' + date.getHours() : date.getHours()) + ':';
    var m = (date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes()) + ':';
    var s = (date.getSeconds() < 10 ? '0' + date.getSeconds() : date.getSeconds());
    return Y + M + D + h + m + s;
};