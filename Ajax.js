jx = {
    bind: function(a) {
		alert(2);
        var c = {
            url: "",
            onSuccess: false,
            onError: false,
            format: "text",
            method: "GET",
            update: "",
            loading: "",
            loadingIndicator: ""
        };
        for (var b in c) {
            if (a[b]) {
                c[b] = a[b]
            }
        }
        if (!c.url) {
            return
        }
        var d = false;
        if (c.loadingIndicator) {
            d = document.createElement("div");
            d.setAttribute("style", "position:absolute;top:0px;left:0px;");
            d.setAttribute("class", "loading-indicator");
            d.innerHTML = c.loadingIndicator;
            document.getElementsByTagName("body")[0].appendChild(d);
            this.opt.loadingIndicator = d
        }
        if (c.loading) {
            document.getElementById(c.loading).style.display = "block"
        }
        //console.log(c);
        this.load(c.url, function(e) {
            if (c.onSuccess) {
                c.onSuccess(e)
            }
            if (c.update) {
                document.getElementById(c.update).innerHTML = e
            }
            if (d) {
                document.getElementsByTagName("body")[0].removeChild(d)
            }
            if (c.loading) {
                document.getElementById(c.loading).style.display = "none"
            }
        }, c.format, c.method, c)
    },
    init: function() {
		alert(1);
        return this.bind()
    }
};