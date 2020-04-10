<template class="panel">
  <div id="welcomeBanner" class="container-fluid">
        <div id="gridWrapper" class="row align-items-center">
            <div id="welcome" class="col-sm-7" style="height:90vh;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="150 50 350 350" style="height: 90vh; width: 62vw;"><defs><filter id="shadow-1" height="300%" width="300%" x="-100%" y="-100%"><feFlood flood-color="rgb(255, 255, 255)" result="flood"></feFlood><feComposite in="flood" in2="SourceGraphic" operator="atop" result="composite"></feComposite><feGaussianBlur in="composite" stdDeviation="15" result="blur"></feGaussianBlur><feOffset dx="1" dy="1" result="offset"></feOffset><feComposite in="SourceGraphic" in2="offset" operator="over"></feComposite></filter></defs><g class="" transform="translate(0,0)" style="touch-action: none;"><path d="M96.18 22.49C264.6 98.36 403.1 214.8 40.11 270.5 153 268 191.6 291.1 64.12 382.6c230.18-128 331.68-189 318.98 106.9 30.5-54.4 114.6-241 36.4-268.3 6.2-7.4 15.5-19.4 22.1-31.9 13.1-5.7 22.6-13.6 30.3-23.7-8.7-2-16-2.5-22.8-2.3-.2-2.8-.8-5.5-2.1-7.9-8.7-16.5-48.1-13.7-62.4-12.1 4.7-81-226.8-117.09-288.42-120.81z" fill="#ecd444" transform="translate(0, 0) scale(1, 1) rotate(45, 256, 256)" filter="url(#shadow-1)"></path></g></svg>
            </div>
            <div class=" visibleBlock col-sm-5 bg-light" style="height:90vh;">
                <h3 id="headerOne" class="ml-5">Hi there and welcome to</h3>
                <h1 class="ml-5 mb-4">Tweeter</h1>
                <a role="button" class="pushForward btn btn-outline-primary btn-lg my-3 ml-5" href="/login">Login</a>
                <a role="button" class="pushForward btn btn-outline-primary btn-lg my-3" href="/register">Register</a>
                <div id="arrow" class="text-center">
                    <h6>Please Scroll</h6>
                    <svg version="1.1" id="Layer_1" width="50px" height="50px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	                    viewBox="0 0 512 512"  xml:space="preserve"><g><g><path d="M505.752,123.582c-8.331-8.331-21.839-8.331-30.17,0L256,343.163L36.418,123.582c-8.331-8.331-21.839-8.331-30.17,0
			            s-8.331,21.839,0,30.17l234.667,234.667c8.331,8.331,21.839,8.331,30.17,0l234.667-234.667
			            C514.083,145.42,514.083,131.913,505.752,123.582z"/></g></g></svg>
                </div>
            </div>
        </div>
        <div id="hiddenBlock">
            <h3 class="text-center">Hi there and welcome to</h3>
            <h1 id="headerTwo" class="text-center">Tweeter</h1>
            <p></p>
            <a role="button" class="btn btn-primary text-center btn-block my-3" href="/login">Login</a>
            <a role="button" class="btn btn-primary text-center btn-block my-3" href="/register">Register</a>
        </div>
  </div>
</template>

<script>
export default {

}
</script>

<style>
#headerOne{
    margin-top: 35vh;
}
#arrow{
    margin-top: 20vh;
}
#welcome{
    z-index:500;
    box-shadow: 0px 0px 5px 5px #888;
    padding:0 !important;
    background-color: rgba(112, 171, 175, 1);
}
#hiddenBlock{
    display:none;
}
.pushForward{
    z-index:2000;
}
@media (max-width: 430px){
    .visibleBlock{
        display:none;
    }
    #hiddenBlock{
        display:block;
        position:absolute;
        top:30vh;
        width:60vw;
        left: 20vw;
        z-index:1000;
    }
    #welcome{
        background-color: rgba(112, 171, 175, 0.5);
    }
    svg{
        fill-opacity: 0.8;
    }
}


</style>
