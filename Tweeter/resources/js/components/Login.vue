<template>
    <div id="loginBox" class="panel bg-light">
        <div class="markers">LOGIN</div>
        <div class="container">
            <div class="row justify-content-center py-5">
                <div id="login" class=" col-sm-6">
                    <div id="login-text" class="text-center border rounded">
                        <h3 class="my-5">Ready to read the world?</h3>
                        <svg class="rounded mx-auto d-block my-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="height: 50px;"><defs><filter id="shadow-1" height="300%" width="300%" x="-100%" y="-100%"><feFlood flood-color="rgba(255, 255, 255, 1)" result="flood"></feFlood><feComposite in="flood" in2="SourceGraphic" operator="atop" result="composite"></feComposite><feGaussianBlur in="composite" stdDeviation="15" result="blur"></feGaussianBlur><feOffset dx="1" dy="1" result="offset"></feOffset><feComposite in="SourceGraphic" in2="offset" operator="over"></feComposite></filter></defs><g class="" transform="translate(0,0)" style="touch-action: none;"><path d="M96.18 22.49C264.6 98.36 403.1 214.8 40.11 270.5 153 268 191.6 291.1 64.12 382.6c230.18-128 331.68-189 318.98 106.9 30.5-54.4 114.6-241 36.4-268.3 6.2-7.4 15.5-19.4 22.1-31.9 13.1-5.7 22.6-13.6 30.3-23.7-8.7-2-16-2.5-22.8-2.3-.2-2.8-.8-5.5-2.1-7.9-8.7-16.5-48.1-13.7-62.4-12.1 4.7-81-226.8-117.09-288.42-120.81z" fill="#ecd444" transform="translate(0, 0) scale(1, 1) rotate(45, 256, 256)" fill-opacity="1" filter="url(#shadow-1)"></path></g></svg>
                        <a role="button" class="btn btn-outline-primary text-center btn-lg my-3" href="/login">Log in here</a>
                        <h1>or</h1>
                        <a role="button" class="btn btn-outline-primary text-center btn-lg my-3" href="/register">Create new account here</a>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-dark">
            <span class="container align-middle">
                <p class="light ml-2">All rights reserved - Tweeter</p>
            </span>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style>
#login{
    height:80vh;
}
#login-text{
    margin-top:20vh;
}
@media (max-width: 430px){
    #login{
        height:100vh;
    }
}

</style>
