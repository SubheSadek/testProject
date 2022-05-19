<template>
	<div>
		<div class="_main_content">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-12 _mar_b10">
					<Alert show-icon>
						<span style="font-weight:bold;"> Total Users : {{informations.total}}</span>
						<template slot="desc">All Users with search, create, edit and delete options.</template>
					</Alert>
				</div>
				<div class="col-12 col-md-12 col-lg-12">
					<div class="_box _b_radious3 _padd20">
						<div class="_1card_top _mar_b20">

							<div class="_1card_top_left">

								<div class="_1card_top_search">
									<Input @on-change="serchResetlt" v-model="str" suffix="ios-search" placeholder="Search users by id ..." />
								</div>

							</div>
							

						</div>
						<div class="_table_responsive">
							 <Table class="" border :columns="columns1" :data="informations.data">
									<template slot-scope="{row}" slot="user_id">
										<p>{{row.user_id}}</p>
									</template> 
									<template slot-scope="{row, index }" slot="action">
                                        <p>
											<Button :to="`/users-details/${row.user_id}`" size="small" type="primary">View Details</Button>
										    <Button icon="ios-trash-outline" type="error" size="small" @click="deleteInformation(row, index)">Delete</Button>
                                        </p>
									</template>
							</Table>
						</div>
						<div class="_pagination _padd_t20">
							<Page :total="informations.total"  show-sizer :page-size-opts="pageOption" @on-page-size-change="getSizeChange"  @on-change="paginateDataInfo" />
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</template>

<script>

import _ from 'lodash';

export default {

	data () {
		return {
            informations:[],
			// allCounts:'',
			isLoading:false,
			pageOption:[5,10,15,20],
			str:'',
			page:1,
			perPage:10,


			datacollection: null,
			columns1: [
				 {
                    title: 'Sl.',
                    width: 150,
					type:'index',
                    align: 'center',

					indexMethod: (row) => {
                        return (row._index + 1) + (this.perPage * this.page) - this.perPage;
                    }
                },
				{
					title: 'User ID',
					slot: 'user_id',
					width:300,
				},
				
				{
					title: 'Action',
                    minWidth: 350,
                    align: 'center',
					slot: 'action',
				},

			]
		}
	},

	methods: {
	async allInformations(){
		
		const res = await this.callApi('get', `/information/getAllInfos?page=${this.page}&perPage=${this.perPage}&str=${this.str}`)
			if(res.status==200){
				console.log(res.data)
				this.informations = res.data;
			}
	},

	serchResetlt:_.debounce(function (){
		this.perPage = 10
		this.paginateDataInfo(1)
	},200),

	getSizeChange(e){
		this.perPage =e
		this.paginateDataInfo(1)
	},
	paginateDataInfo(e){
	   this.page = e
		this.allInformations()
    },

    deleteInformation(row, i){
	this.$Modal.confirm({
          title: 'Message',
          content: '<p>Are you sure to delete this Information ?</p>',
          onOk: async() => {
                    let obj ={
						user_id: row.user_id,
					}
				const res = await this.callApi('post',`/information/deleteInfo/`, obj)

				if(res.status == 200){
					this.s('Information deleted successfully !!')
					this.informations.data.splice(i, 1);
					this.informations.total--
				}
				else{
					this.swr()
				}
          },

          onCancel: () => {

          }
      });
    },




	},

	async created () {
		this.allInformations()
	}
}
</script>


<style scoped>
._1card_top_search .ivu-input-wrapper{
	width:130%;
}
</style>
