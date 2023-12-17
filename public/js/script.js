var goto = function(url){
    window.location.href = "/"+url;
}

var store = {
    get: function(n){
        let tmp = localStorage.getItem(n),
            json = JSON.parse(tmp);

        return (json?json:tmp);
    },
    set: function(n,v){
        localStorage.setItem(n,JSON.stringify(v));
    },
    del: function(n){
        localStorage.removeItem(n);
    }
};


var logout = function(){
    store.del('login');
    goto('auth');
}