<template> 
	<div>
		<h1 ref="myref">Hook tutorial</h1>
		<h1>My Name is: {{ name }}</h1>
	</div>
</template>

<script>
export default{
	data(){
		return {
			name:"Ashik"
		}
	},
	created(){
		console.log('created',this.name)
	},
	mounted(){
		console.log(this.$refs.myref.textContent)
	}
}

</script>