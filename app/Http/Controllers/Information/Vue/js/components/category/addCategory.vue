<template>
    <span>

		<div class="_1card_top_right">
			<ul class="_1card_top_right_list">
				<li><template>
					<Button @click="createModalfunc" icon="md-add" type="primary">Add Information</Button>
				</template></li>
			</ul>
		</div>

		<Modal v-model="createModal" draggable  class-name="vertical-center-modal" scrollable title="Create New Information">
			<div class="_login_form">
			  <Form>
					<div class="row">
						<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.cat_name">
								<Input v-model="form.cat_name" @enter.native="addInformation" @keyup.native="error.cat_name=''" size="large" type="text" placeholder="Information name"/>
							</FormItem>
						</div>
					</div>
				</Form>
			</div>
			 <div slot="footer">
				<Button @click="addInformation" :loading="isLoading" :disabled="isLoading" icon="md-add" type="primary" >{{ isLoading ? 'Please wait . . .' : 'Add Information'}}</Button>
				<Button type="error" icon ="md-close" @click="createModal = false">Cancel</Button>
			</div>
		</Modal>
    </span>
</template>

<script>
export default {
	props:['information'],
	data(){
		return{
			createModal: false,
			isLoading:false,
			form:{
				cat_name:''
			},

			error:{
				cat_name:''
			},


		}
	},

	methods:{
		async addInformation() {

			this.clearDataError();

			let flag = 1
			if(!this.form.cat_name  || this.form.cat_name.trim()=='' || this.form.cat_name==null){
				this.error.cat_name ='Information name is required!'
				flag = 0
			}

			if(flag==0) return

			this.isLoading = true;

			const res = await this.callApi('post','/information/addInformation', this.form)

			if(res.status==200 || res.status==201){
				this.createModal=false
				this.s("Information created successfully!");
				this.information.total++
				this.information.data.unshift(res.data)
				this.clearData()
			}
			this.isLoading = false;

		},
		clearDataError() {
			this.error = {
				cat_name:''
		   }
    	},
		clearData() {
			this.form = {
				cat_name:''
			}
		},
		 createModalfunc(){
			this.clearData();
			this.createModal =true;
		 },



	}






}
</script>
<style scoped>
/* .ivu-btn[disabled]{
    background: #2d8cf0;
}

._1input_pass span{
	top: 2px;
}
._1input_pass span i{
	font-size: 18px;
} */

</style>
