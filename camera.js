(function() {
	var canvas = document.getElementById('canvas'),
		context = canvas.getContext('2d'),
		video = document.getElementById('video'),
		// vendorUrl = window.URL || window.webkitURL,
		captureButton = document.getElementById('capture');
	    captureButton.addEventListener("click", Snap);

	navigator.getMedia = 	navigator.getUserMedia ||
							navigator.webkitGetUserMedia ||
							navigator.mozGetUserMedia ||
							navigator.msGetUserMedia ||
							navigator.oGetUserMedia;
	// if (navigator.getUserMedia) {
	// 		navigator.getUserMedia({video: true, audio: false}, 
    //         	handleVideo, videoError);
    //     }
        // navigator.getUserMedia{

        //     video = true;
        //     aduio = false;
		// }
		// function handleVideo(stream) {
		// 	video.srcObject = stream;
		// }
		// function videoError(error) {
		// 	// An error occured
		// 	// error.code
        // }
        navigator.getMedia({
            video: true,
            audio: false
        }, function(stream){
            video.srcObject = stream;
            video.play();
        }, function(error){
            //console.log('error');
        });
		
	function Snap() {
		context.drawImage(video, 0, 0, canvas.width, canvas.height);
	}

})();


