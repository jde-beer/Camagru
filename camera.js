const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const snap = document.getElementById("cap");
const recap = document.getElementById("recap");
const errorMsgElement = document.querySelector('span#errorMsg');
var cur = document.getElementById("view");



//sets up the web camera and sets audio to nothing.
const constraints = {
	audio: false,
	video: {
		width: video.width, height: video.height
	}
};

// this initialise the web camera.
async function init() {
	try {
		const stream = await navigator.mediaDevices.getUserMedia(constraints);
		handleSuccess(stream);
	} catch (e) {
		console.log(`navigator.getUserMedia error:${e.toString()}`);
	}
}

// this only happens when the web camera works
function handleSuccess(stream) {
  window.stream = stream;
  video.srcObject = stream;
}

init();
// capture image
snap.addEventListener("click", function() {
	video.pause();
	// this shows a div that contains two canvas
	var prev = document.querySelector(".wrapper");
	prev.style.display="contents";
	// this shows the button to post the image
	var prev = document.querySelector("#postP");
	prev.style.display="block";
	// this views the stickers and sets width and height.
	var prev = document.querySelector("#viewS");
	prev.style.display="block";
	prev.width=video.offsetWidth;
	prev.height=video.offsetHeight;
	// this views the picture you have taken and sets width and height.
	var prev = document.querySelector("#view");
	prev.style.display="block";
	prev.width=video.offsetWidth;
	prev.height=video.offsetHeight;
	// draws the image from video to canvas.
	var context = cur.getContext('2d');
	context.drawImage(video, 0, 0, 640, 480);
	// this shows and hides necessary buttons.
	var prev = document.querySelector("#video");
	prev.style.display = "none";
	var prev = document.querySelector("#recap");
	prev.style.display="inline-block";
	var prev = document.querySelector("#reset");
	prev.style.display="inline-block";
	var prev = document.querySelector("#cap");
	prev.style.display="none";
	var prev = document.querySelector(".dec");
	prev.style.display="block";
});
// this hides the canvas, div and the stickers and the post button
recap.addEventListener("click", function() {
	video.play();
	var prev = document.querySelector("#video");
	prev.style.display="block";
	prev.width=video.offsetWidth;
	prev.height=video.offsetHeight;
	var prev = document.querySelector(".wrapper");
	prev.style.display="none";
	var prev = document.querySelector(".view");
	prev.style.display="none";
	var prev = document.querySelector(".viewS");
	prev.style.display="none";
	var prev = document.querySelector(".wrapper");
	prev.style.display="none";
	var prev = document.querySelector("#postP");
	prev.style.display="none";
	var prev = document.querySelector("#cap");
	prev.style.display="block";
	var prev = document.querySelector("#recap");
	prev.style.display="none";
	var prev = document.querySelector("#reset");
	prev.style.display="none";
	var prev = document.querySelector(".dec");
	prev.style.display="none";
});
//this is to add stickers to your sticker canvas from the folder.
function addImg(img) {
	cur = document.getElementById("viewS");
	var context = cur.getContext('2d');
	base_image = new Image();
	var str = 'stickers/'
	  base_image.src = str.concat(img);
	  s.push(img);
	//to make it random position on the top  
	context.drawImage(base_image, Math.floor((Math.random() * 300) + 1), 0, 100, 100);
}
//it removes all the stickers
function reset(){
	const canvas = document.getElementById('viewS');
	const context = canvas.getContext('2d');
	context.clearRect(0, 0, canvas.width, canvas.height);
	s=[];
}
// this incodes all the canvases and sets it to hide inputs on your form.
function saveImg() {
	cur = document.getElementById("view");
	var imgUrl = cur.toDataURL('image/png');
	imgL = document.getElementById("imgUrl");
	imgL.value=imgUrl;
	cur = document.getElementById("viewS");
	var imgUrl = cur.toDataURL('image/png');
	imgL = document.getElementById("sURL");
	console.log(imgL);
	imgL.value=imgUrl;
}

//this is when you upload a image directly from the computer
document.getElementById('ftu').onchange = function(e) {
	var img = new Image();
	img.src = URL.createObjectURL(this.files[0]);
	//if it loads the image it will call the draw function
	img.onload = draw;
	// else it will fail.
	img.onerror = failed;
}
//this draws the image on the view canvas.
function draw(){
	var prev = document.querySelector("#viewS");
	prev.style.display="block";
	prev.width=this.width;
	prev.height=this.height;
	var prev = document.querySelector("#view");
	prev.style.display="block";
	prev.width=this.width;
	prev.height=this.height;
	var context = prev.getContext('2d');
	// this is the paramter that is the loaded image
	context.drawImage(this, 0, 0, 640, 480);
	var prev = document.querySelector("#video");
	prev.style.display = "none";
	var prev = document.querySelector("#recap");
	prev.style.display="inline-block";
	var prev = document.querySelector("#reset");
	prev.style.display="inline-block";
	var prev = document.querySelector("#cap");
	prev.style.display="none";
	var prev = document.querySelector(".dec");
	prev.style.display="block";
	var prev = document.querySelector(".wrapper");
	prev.style.display="contents";
	var prev = document.querySelector("#post");
	prev.style.display="block";
	var prev = document.querySelector("#viewS");
	prev.style.display="block";
	var prev = document.querySelector("#view");
	prev.style.display="block";
}

function failed() {
	console.error("The provided file couldn't be loaded as an Image media");
  }


