<template>
  <div id="stats" class="panel">
       <div class="markers">STATS</div>
        <div id="statsContent" class="container">
            <div class="container my-4">
                <h2 id="statsHeader"><strong>Tweeter</strong> has been the place to share thoughts and ideas since 2001, and it is not about to stop.</h2>
            </div>
            <div id="trigger1"></div>
            <div class="row">
                <div class=" revealStats col-md-3 mt-2">
                    <div class="mx-4">
                    <h4>FOUNDED</h4>
                    <h1>2001</h1>
                    <h6 class="stats">Founded in 2001. We cant believe it either - time flies when you are having fun</h6>
                    </div>
                </div>
                <div class=" revealStats col-md-3 mt-2">
                    <div class="mx-4">
                    <h4>TWEETS</h4>
                    <h1>90M+</h1>
                    <h6 class="stats">Now more than 90M+ tweets! And many many new tweets every day.</h6>
                    </div>
                </div>
                <div class=" revealStats col-md-3 mt-2">
                    <div class="mx-4">
                    <h4>DEVICES</h4>
                    <h1>8</h1>
                    <h6 class="stats">Available on all devices. We come in all shapes and sizes. Tweet on anything.</h6>
                    </div>
                </div>
                <div class=" revealStats col-md-3 mt-2">
                    <div class="mx-4">
                    <h4>USERS</h4>
                    <h1>21M</h1>
                    <h6 class="stats">21 Million users on a daily basis. See what all the celebrities are up to!</h6>
                    </div>
                </div>
            </div>
            <img id="birdsOnWire" class="rounded mx-auto d-block" :src="'/images/birdonwire.png'" alt="Flying Tweeters">
        </div>
  </div>
</template>

<script>
export default {

}
</script>

<style>
#statsHeader{
    margin-left: 5vw;
}
#stats{
    height:150vh;
}
#statsContent{
    padding-top: 20vh;
}
@media (max-width: 430px){
    .stats{
        border-bottom: #1C1C1C 1px dotted;
    }
    #header{
        margin-left:0;
    }
    #birdsOnWire{
        display:none !important;
    }
    #stats{
    height:150vh;
}
}

.revealStats {
		opacity: 0;
		-webkit-transform: scale(0.9);
			 -moz-transform: scale(0.9);
				-ms-transform: scale(0.9);
				 -o-transform: scale(0.9);
						transform: scale(0.9);
		-webkit-transition: all 1s ease-in-out;
			 -moz-transition: all 1s ease-in-out;
				-ms-transition: all 1s ease-in-out;
				 -o-transition: all 1s ease-in-out;
						transition: all 1s ease-in-out;
	}
	.revealStats.visible {
		opacity: 1;
		-webkit-transform: none;
			 -moz-transform: none;
				-ms-transform: none;
				 -o-transform: none;
						transform: none;
	}

</style>
