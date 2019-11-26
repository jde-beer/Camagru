const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const snap = document.getElementById("cap");
const recap = document.getElementById("recap");
const errorMsgElement = document.querySelector('span#errorMsg');
var cur = document.getElementById("view");
var	prevI = 0;
var s = [];


const constraints = {
	audio: false,
	video: {
		width: video.width, height: video.height
	}
};

async function init() {
	try {
		const stream = await navigator.mediaDevices.getUserMedia(constraints);
		handleSuccess(stream);
	} catch (e) {
		console.log(`navigator.getUserMedia error:${e.toString()}`);
	}
}

function handleSuccess(stream) {
  window.stream = stream;
  video.srcObject = stream;
}

init();

snap.addEventListener("click", function() {
	video.pause();
	var prev = document.querySelector(".wrapper");
	prev.style.display="contents";
	var prev = document.querySelector("#postP");
	prev.style.display="block";
	var prev = document.querySelector("#viewS");
	prev.style.display="block";
	prev.width=video.offsetWidth;
	prev.height=video.offsetHeight;
	var prev = document.querySelector("#view");
	prev.style.display="block";
	prev.width=video.offsetWidth;
	prev.height=video.offsetHeight;
	var context = cur.getContext('2d');
	context.drawImage(video, 0, 0, 640, 480);
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

function reset(){
	const canvas = document.getElementById('viewS');
	const context = canvas.getContext('2d');
	context.clearRect(0, 0, canvas.width, canvas.height);
	s=[];
}

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

document.getElementById('ftu').onchange = function(e) {
	var img = new Image();
	img.src = URL.createObjectURL(this.files[0]);
	img.onload = draw;
	img.onerror = failed;
}
function draw(){
	var prev = document.querySelector("#viewS");
	prev.style.display="block";
	prev.width=this.width;
	prev.height=this.height;
	console.log("YE");
	var prev = document.querySelector("#view");
	prev.style.display="block";
	prev.width=this.width;
	prev.height=this.height;
	var context = prev.getContext('2d');
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


