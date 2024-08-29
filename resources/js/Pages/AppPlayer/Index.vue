<template>
	<!-- <div class="flex flex-col w-screen rotate-90 md:flex-row md:rotate-0 md:h-screen">
		<iframe src="https://www.alfaandfriends.com/toddler-web/" class="w-full h-full" frameborder="0"></iframe>
	</div> -->
	<div class="flex items-center intrinsic-container intrinsic-container-16x9">
		<iframe src="https://www.alfaandfriends.com/toddler-web/" allowfullscreen></iframe>
	</div>
</template>

<style>
.intrinsic-container {
    position: relative;
    height: 0;
    overflow: hidden;
}

/* 16x9 Aspect Ratio */
.intrinsic-container-16x9 {
    padding-bottom: 48.3%;
}

/* 4x3 Aspect Ratio */
.intrinsic-container-4x3 {
    padding-bottom: 30%;
}

.intrinsic-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    transition: transform 0.3s ease; /* Optional: Smooth rotation transition */
}

/* Rotate 90 degrees when the viewport width is less than 425px */
@media (max-width: 425px) {
	.intrinsic-container{
		padding-top: 56.25%;
	}
    .intrinsic-container iframe {
        transform: rotate(90deg);
        transform-origin: center center; /* Ensures rotation is centered */
    }
}
</style>