
window.onload = function() {
	var canvas = document.getElementById('canvas'),
		context = canvas.getContext('2d'),
		video = document.getElementById('video'),
		// vendorUrl = window.URL || window.webkitURL,
		captureButton = document.getElementById('photo-button');
		saveButton = document.getElementById('save imagine');
		captureButton.addEventListener("click", Snap);
		saveButton.addEventListener("click", takePicture);

	navigator.getMedia = 	navigator.getUserMedia ||
							navigator.webkitGetUserMedia ||
							navigator.mozGetUserMedia ||
							navigator.msGetUserMedia ||
							navigator.oGetUserMedia;

        navigator.getMedia({
            video: true,
            audio: false
        }, function(stream){
            video.srcObject = stream;
            video.play();
        }, function(error){
            console.log('error');
        });
		
	function Snap() {

		context.drawImage(video, 0, 0, canvas.width, canvas.height);
		
		var dataURL = canvas.toDataURL("image/jpeg");
		//console.log("PHP request");		

	}

	//saves the image.
	function takePicture(){
		var dataURL = canvas.toDataURL();
		//creation of form
		const form = document.createElement('form');
		form.action = 'camtodb.php';
		form.method = 'post';

		//creation of image
		const myogimage = document.createElement('input');
		myogimage.value = dataURL;
		myogimage.name = 'baseimage';

		//add input to form
		form.appendChild(myogimage);
		//append form to document
		document.body.appendChild(form);
		//self submit such
		form.submit();
	}
	
	function clearPicture(){
		
	}

};


