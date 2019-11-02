function jmsj(str) {



    var pubkey='-----BEGIN PUBLIC KEY-----';
    pubkey+='MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCytYlGIkLH8Vp6FY72PSfjnlkw';
    pubkey+='IkR6r8Iw6DJvSwVil8ww88hNx3sf86CeE1ttoyIJO1jV52Oijr6P5cvtG3oG9J0U';
    pubkey+='Lp+wrJmtiEBJkAKuK/45+D65boBKrI8ye/AGiQe0tm611JVGDMFyBJUKlAVQjsrk';
    pubkey+='kjf93uzY562B448U4QIDAQAB';
    pubkey+='-----END PUBLIC KEY-----';
    var encrypt = new JSEncrypt();
    encrypt.setPublicKey(pubkey);
    var encrypted = encrypt.encrypt(JSON.stringify(str));
    return encrypted;
}