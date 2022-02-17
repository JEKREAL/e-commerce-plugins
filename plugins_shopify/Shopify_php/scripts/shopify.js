jQuery(document).ready(function () {
    /**
     * Accepts either a URL or querystring and returns an object associating 
     * each querystring parameter to its value. 
     *
     * Returns an empty object if no querystring parameters found.
     */
    function getUrlParams(urlOrQueryString) {
        if ((i = urlOrQueryString.indexOf('?')) >= 0) {
            const queryString = urlOrQueryString.substring(i + 1);
            if (queryString) {
                return _mapUrlParams(queryString);
            }
        }

        return {};
    }
    /**
     * Helper function for `getUrlParams()`
     * Builds the querystring parameter to value object map.
     *
     * @param queryString {string} - The full querystring, without the leading '?'.
     */
    function _mapUrlParams(queryString) {
        return queryString
            .split('&')
            .map(function (keyValueString) { return keyValueString.split('=') })
            .reduce(function (urlParams, [key, value]) {
                if (Number.isInteger(parseInt(value)) && parseInt(value) == value) {
                    urlParams[key] = parseInt(value);
                } else {
                    urlParams[key] = decodeURI(value);
                }
                return urlParams;
            }, {});
    }
    var url = document.getElementsByTagName("script")[0].src;
    var urlParams = getUrlParams(url);
    if(urlParams.layout) {
        $(urlParams.location1).after('<div class="widget" id="widget"><h2>Widget!</h2></div>');
    }
    else {
        $(urlParams.location1).before('<div class="widget" id="widget"><h2>Widget!</h2></div>');
    }
    if(urlParams.anch_layout) {
        $(urlParams.location2).after('<div class="anchor" id="anchor"><h2>Anchor!</h2></div>');
    }
    else {
        $(urlParams.location2).before('<div class="anchor" id="anchor"><h2>Anchor!</h2></div>');
    }
    
    $('head').prepend('<script type="text/javascript" id="pixelScript">let pixelFilter = new Image();pixelFilter.src = "http://self-service.feelter.com/api/pixel/2.png?r="+btoa(window.location.href);let newPix = pixelFilter.src;</script>');  // adding pixel script to the head
    
    // Code below can lock the widget or anchor in the top of the page during scrolling down
    
    //  	$('head').prepend('<style>.header { padding: 10px 16px; background: #555; color: #f1f1f1; } .content { padding: 16px; } .sticky { position: fixed; top: 0; width: 100%} .sticky + .content { padding-top: 102px; }</style>');
    
//     var header = document.getElementById("myHeader");
//     var sticky = header.offsetTop;

//     window.onscroll = function () {
//         if (window.pageYOffset > sticky) {
//             header.classList.add("sticky");
//         } else {
//             header.classList.remove("sticky");
//         }
//     };
});