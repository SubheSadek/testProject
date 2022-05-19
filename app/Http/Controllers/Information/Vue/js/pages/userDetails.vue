<template>
	<div>
		<div class="_main_content">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-12 _mar_b10">
					<Alert show-icon>
						<span style="font-weight:bold;"> Total Users data: {{informations.total}}</span>
						<template slot="desc">All Users with search, create, edit and delete options.</template>
					</Alert>
				</div>
				<div class="col-12 col-md-12 col-lg-12">
					<div class="_box _b_radious3 _padd20">
						<div class="_1card_top _mar_b20">

							<div class="_1card_top_left">

								<div class="_1card_top_search">
									<Input @on-change="serchResetlt" v-model="str" suffix="ios-search" placeholder="Search users by event, App Plateform etc ..." />
								</div>

							</div>
							

						</div>
						<div class="_table_responsive">
							 <Table class="" border :columns="columns1" :data="informations.data">
									<template slot-scope="{row}" slot="event">
										<p>{{row.event}}</p>
									</template> 
									<template slot-scope="{row}" slot="app_platform">
										<p>{{row.app_platform}}</p>
									</template> 
									<template slot-scope="{row}" slot="app_version_code">
										<p>{{row.app_version_code}}</p>
									</template> 
									<template slot-scope="{row}" slot="device">
										<p>{{row.device}}</p>
									</template> 
									<template slot-scope="{row}" slot="created_at">
										<p>{{row.created_at | dateFormat}}</p>
									</template> 
									<template slot-scope="{row, index }" slot="action">
                                        <p>
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
					title: 'Event',
					slot: 'event',
					width:300,
				},
				{
					title: 'App Platform',
					slot: 'app_platform',
					width:300,
				},
				{
					title: 'App Version',
					slot: 'app_version_code',
					width:300,
				},
				{
					title: 'Device Type',
					slot: 'device',
					width:300,
				},
				{
					title: 'Date',
					slot: 'created_at',
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
	async informationDetails(){
		let id = this.$route.params ? this.$route.params.id :null;
		const res = await this.callApi('get', `/information/userDetails/${id}?page=${this.page}&perPage=${this.perPage}&str=${this.str}`)
			if(res.status==200){
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
		this.informationDetails()
    },

    deleteInformation(row, i){
	this.$Modal.confirm({
          title: 'Message',
          content: '<p>Are you sure to delete this Information ?</p>',
          onOk: async() => {
                    let obj ={
						id: row.id,
					}
				const res = await this.callApi('post',`/information/deleteSingleInfo/`, obj)

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
		this.informationDetails()
	}
}
</script>


<style scoped>
._1card_top_search .ivu-input-wrapper{
	width:130%;
}
</style>
