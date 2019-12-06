(function() {

	const video = document.getElementById('video');
	const canvas = document.getElementById('view');
	const context = canvas.getContext('2d');
	const over = document.getElementById('viewS');
	var overCtx = over.getContext('2d');
	var bul = document.getElementById('bul');
	var pika = document.getElementById('pika');
	var squ = document.getElementById('squ');
	const capture = document.getElementById('cap');
	const fileBtn = document.getElementById('ftu');
	const postBtn = document.getElementById('postBtn');
	var con = 0;

	navigator.mediaDevices.getUserMedia({video: true, audio: false})
	.then(function(stream)
	{
		video.srcObject = stream;
		//video.onplay();
		//video.srcObject(stream);
		//video.onplay();
	})
	.catch(function(err){
		console.log(err);
	});

	capture.addEventListener('click', function(){
		context.setTransform(-1, 0, 0, 1, canvas.width, 0);
		context.drawImage(video, 0, 0, 480, 300);
		con = 1;
	});

	fileBtn.onchange = function(e){
		var image = new Image();
		image.onload = draw;
		image.onerror = failure;
		image.src = URL.createObjectURL(this.files[0]);
	};

	function draw(){
		canvas.width = 400;
		canvas.height = 300;
		context.drawImage(this, 0, 0, 400, 300);
		con = 1;
	};

	function failure(){
		console.log("File is not an allowed file type");
	}

	bul.addEventListener('click', function(){
		pokemonObj = new Image;
		pokemonObj.src = 'stickers/bulbasaur.png';
		pokemonObj.onload = function(){
			overCtx.drawImage(pokemonObj, 0, 0, 75, 75);
		}
	});

	pika.addEventListener('click', function(){
		pokemonObj = new Image;
		pokemonObj.src = 'stickers/pikachu.png';
		pokemonObj.onload = function(){
			overCtx.drawImage(pokemonObj, 0, 0, 75, 75);
		}
	});

	squ.addEventListener('click', function(){
		pokemonObj = new Image;
		pokemonObj.src = 'stickers/squirtle.png';
		pokemonObj.onload = function(){
			overCtx.drawImage(pokemonObj,0, 0, 75, 75);
		}
	});

	postBtn.addEventListener('click', function(){

		if (con == 1){

			var imgUrl = canvas.toDataURL();
			var sURL = over.toDataURL();
			//var url = "camtodb.php";
			var xhttp = new XMLHttpRequest();
			let stuff = "imgUrl="+encodeURIComponent(imgUrl)+"&sURL="+encodeURIComponent(sURL);
			console.log(stuff);
			xhttp.open("POST", "camtodb.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.onreadystatechange = function(){
				if (xhttp.status == 200){
					console.log(this.responseText);
				}
			}
			xhttp.send(stuff);
			window.location.reload(true);
		}
		else{
			alert("No image added");
		}

	})
})();