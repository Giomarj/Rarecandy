<style type="text/css">
	.headerv{
		height: 100vh;
		display: flex;
		align-items: center;
		color: #fff;
	}
	.contentv{
		max-width: 49rem;
		padding-left: 1rem;
		padding-right: 1rem;
		margin:auto;
		text-align: center;
	}
	.headerv-video{
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100vh;
		overflow: hidden;
	}
	.headerv-video video{
		min-width: 100%;
		min-height: 100%;

		top: 50%;
		left: 50%;

		transform: translateX(-50%) translateY(-50%);
	}
	.headerv-overlay{
		height: 100vh;
		width:  100%;
		position: absolute;
		top: 0;
		left: 0;
		background: #303952;
		z-index: 1;
		opacity: 0.5;
	}
	.headerv-content{
		z-index: 2;
	}
	.headerv-content h1{
		font-size: 50px;
		margin-bottom: 0;

	}	
</style>
<div class="headerv contentv">
	<div class="headerv-video">
		<video src="video/video.mp4" autoplay loop muted poster="imagen"></video>
	</div>

	<div class="headerv-overlay"></div>

	<div class="headerv-content">
		<h1>Hello Papajera!!</h1>
		<p>asfhbjsadfsdfasdfsdfsdfsdfasdf,
		sadfasdfasdfasdfasdfsdf.
	sadfasdfasdfasdfasdf</p>
	<a href="cliente.php" class=""></a>
	</div>
</div>