<template>
	<div class="viewer">
		<div class="box" v-for="photo in photos" :key="photo.name">
			<img :src="'https://p.jennandsteve.ca/upload/' + photo.name" />
		</div>
	</div>
</template>

<style lang="scss">
.viewer {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;

	.box {
		width: 33.33vh;
		height: 33.33vh;
		display: flex;
		align-items: center;
		justify-content: center;

		img {
			width: 90%;
			height: 90%;
			object-fit: contain;
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
			console.log('looking up photos...');
			axios
				.get(`${baseURL}`)
				.then((response) => {
					console.log(response);
					this.photos = response.data;
				})
				.catch((error) => {
					this.errorMessage = error.message;
				});
		},
	},
};
</script>
