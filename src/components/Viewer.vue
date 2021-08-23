<template>
	<div class="viewer">
		<div class="box" v-for="photo in photos" :class="photo.orientation" :key="photo.name">
			<img :src="'https://p.jennandsteve.ca/upload/' + photo.name" />
		</div>
		<div id="anchor"></div>
	</div>
</template>

<style lang="scss">
.viewer {
	display: flex;
	flex-wrap: wrap;
	padding: 0 5%;

	@keyframes pop {
		0% {
			opacity: 0;
		}
		100% {
			opacity: 1;
		}
	}

	.box {
		position: relative;
		width: 33.33%;
		height: 32vw;
		display: flex;
		align-items: center;
		justify-content: center;
		animation-name: pop;
		animation-fill-mode: both;
		animation-timing-function: ease-out;
		animation-duration: 750ms;
		animation-delay: 1s;
		// flex-shrink: 0;

		@media only screen and (max-width: 567px) {
			width: 50%;
			height: 48vw;
		}

		img {
			padding: 2%;
			background-color: #dfd3c2;
			box-shadow: 0.5vw 0.5vw 0.5vw rgba(0, 0, 0, 0.5);
		}

		&.portrait {
			img {
				width: auto;
				height: 85%;
			}
		}

		&.landscape {
			img {
				width: 85%;
				height: auto;
			}
		}
	}
}
</style>

<script>
import axios from 'axios';

// const baseURL = process.env.NODE_ENV == 'development' ? '//localhost:3000/guests/' : 'guests/';
const baseURL = 'https://p.jennandsteve.ca/api.php';

export default {
	data() {
		return this.initialState();
	},
	mounted() {
		this.lookupPhotos();
		// setInterval(function() {
		// 	window.scrollBy(0, 1);
		// }, 50);
		setInterval(
			function() {
				this.lookupPhotos();
			}.bind(this),
			5000
		);
	},
	methods: {
		initialState() {
			return {
				photos: [],
			};
		},
		reset() {
			Object.assign(this.$data, this.initialState());
		},
		lookupPhotos() {
			// console.log('looking up photos...');
			axios
				.get(`${baseURL}`)
				.then((response) => {
					// console.log(response);
					this.photos = response.data;
					window.location.href = '#anchor';
				})
				.catch((error) => {
					this.errorMessage = error.message;
				});
		},
	},
};
</script>
