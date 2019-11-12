
// window.onload = function() {
// 	var canvas = document.getElementById('canvas'),
// 		context = canvas.getContext('2d'),
// 		video = document.getElementById('video'),
// 		// vendorUrl = window.URL || window.webkitURL,
// 		captureButton = document.getElementById('capture');
// 	    captureButton.addEventListener("click", Snap);

// 	navigator.getMedia = 	navigator.getUserMedia ||
// 							navigator.webkitGetUserMedia ||
// 							navigator.mozGetUserMedia ||
// 							navigator.msGetUserMedia ||
// 							navigator.oGetUserMedia;
// 	if (navigator.getUserMedia) {
// 			navigator.getUserMedia({video: true, audio: false}, 
//             	handleVideo, videoError);
//         }
//         // navigator.getUserMedia{

//         //     video = true;
//         //     aduio = false;
// 		// }
// 		function handleVideo(stream) {
// 			video.srcObject = stream;
// 		}
// 		function videoError(error) {
// 			// An error occured
// 			// error.code
//         }		
// 	function Snap() {
// 		alert("sdfsdgsdgsd");
// 		context.drawImage(video, 0, 0, canvas.width, canvas.height);
// 	}

// };
let width = 500,
	height = 0,
	filter ='none',
	stream = false;
	
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const photo = document.getElementById('photo');
const photoButton = document.getElementById('photoButton');
const clearButton = document.getElementById('clearButton');
const photoFilter = document.getElementById('photoFilter');

navigator.mediaDevices.getUserMedia({video: true, audio: false})
.then(function(stream)
{
	video.srcObject = stream;
	//video.onplay();
	//video.srcObject(stream);
	video.onplay();
})
.catch(function(err){
	console.log('Error: ${err}');
});

