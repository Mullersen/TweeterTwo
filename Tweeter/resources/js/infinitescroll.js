const axios = require('axios');
var page = 1;

window.addEventListener('scroll', function(event) {
    if (window.innerHeight - element.scrollTop === element.clientHeight) {
        page++;
        alert("you are at the bottom of the page");
    }
});

function loadMoreData(page) {
    axios.get('/tweetFeed?page=' + page)
        .then(response => {
            if (response.data.html == " ") {
                // $('.ajax-load').html("No more records found");
                console.log("no more data found");
                return;
            }
            //   $('.ajax-load').hide();
            document.getElementById('tweetgrid').append(data.html);
        }).catch(error => {

            console.log(error.message);
        });

};