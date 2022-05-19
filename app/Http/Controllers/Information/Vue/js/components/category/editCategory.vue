<template>
    <span>

        <Button @click="editModalfunc" icon="ios-create-outline" size="small" type="primary">Edit</Button>

		<Modal v-model="editModal" draggable  class-name="vertical-center-modal" scrollable title="Edit Information">
			<div class="_login_form">
			  <Form>
					<div class="row">
						<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.cat_name">
								<Input v-model="form.cat_name" @keyup.native="error.cat_name=''" size="large" type="text" placeholder="Information name"/>
							</FormItem>
						</div>
					</div>
				</Form>
			</div>
			 <div slot="footer">
				<Button @click="editInformation" :loading="isLoading" :disabled="isLoading" type="primary" >{{ isLoading ? 'Please wait . . .' : 'Edit'}}</Button>
				<Button type="error" icon ="md-close" @click="editModal = false">Cancel</Button>
			</div>
		</Modal>
    </span>
</template>

<script>
export default {
	props:['information'],
	data(){
		return{
			editModal: false,
			isLoading:false,
			form:{
                cat_id:'',
				cat_name:''
			},

			error:{
				cat_name:''
			},


		}
	},

	methods:{
		async editInformation() {

			this.clearDataError();

			let flag = 1
			if(!this.form.cat_name  || this.form.cat_name.trim()=='' || this.form.cat_name==null){
				this.error.cat_name ='Information name is required!'
				flag = 0
			}

			if(flag==0) return

			this.isLoading = true;

			const res = await this.callApi('post','/information/editInformation', this.form)

			if(res.status==200 || res.status==201){
				this.editModal=false
				this.s("Information updated successfully!");
				this.information.cat_name = this.form.cat_name;
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
		 editModalfunc(){
			this.form.cat_id = this.information.id;
			this.form.cat_name = this.information.cat_name;
			this.editModal =true;
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
