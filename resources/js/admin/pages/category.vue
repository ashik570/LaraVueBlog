<template>
	<div>
		<div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Category <Button @click="addModal=true">+ Add category</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Category image</th>
								<th>Category name</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(category, i) in categorylists" :key="i" v-if="categorylists.length">
								<td>{{category.id}}</td>
								<td class="demo-upload-list">
									<img :src="category.categoryIconImage"/>
								</td>

								<td class="_table_name">{{category.categoryName}}</td>

								<td>{{category.created_at}}</td>
								<td>
									<Button type="info" size="small" @click="showEditModal(category, i)">Edit</Button>
									<Button type="error" size="small" @click="showDeletingModal(category, i)" :loading="category.isDeleting">Delete</Button>
								</td>
							</tr>
								<!-- ITEMS -->

						</table>
					</div>
				</div>

				<!--Category Adding Modal-->
				<Modal
					v-model="addModal"
					title="Add Category"
					:mask-closable="false"
					:closable="false">

					<Input v-model="data.categoryName" placeholder="Add category name"/>
					<div class="mt-2"></div>
					<Upload
						ref="uploads"
					    type="drag"
					    :headers="{'x-csrf-token' : token, 'X-Requested-With' : 'XMLHttpRequest'}"
					    :on-success="handleSuccess"
					    :on-error="handleError"
					    :format="['jpg','jpeg','png']"
				        :max-size="2048"
				        :on-format-error="handleFormatError"
				        :on-exceeded-size="handleMaxSize"
					    action="/LaraVueBlog/app/upload">
					    <div style="padding: 20px 0">
					        <i class="fas fa-cloud-upload-alt"></i>
					        <p>Click or drag files here to upload</p>
					    </div>
					</Upload>

					<div class="demo-upload-list" v-if="data.categoryIconImage">
						<img :src ="`${data.categoryIconImage}`" />
						<div class="demo-upload-list-cover">
							<i class="fas fa-trash-alt" @click="deleteImage"></i>
						</div>
					</div>

					<div slot="footer">
						<Button type="default" @click="addModal=false">Close</Button>
						<Button type="primary" @click="addCategory" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding..' : 'Add category' }}</Button>
					</div>
				</Modal>

				<!--Category Editing Modal-->
				<Modal
					v-model="editModal"
					title="Edit Category"
					:mask-closable="false"
					:closable="false">

					<Input v-model="editData.categoryName" placeholder="Edit category name"/>
					<div class="mt-2"></div>
					<Upload v-show="isIconImageNew"
						ref="editDataUploads"
					    type="drag"
					    :headers="{'x-csrf-token' : token, 'X-Requested-With' : 'XMLHttpRequest'}"
					    :on-success="handleSuccess"
					    :on-error="handleError"
					    :format="['jpg','jpeg','png']"
				        :max-size="2048"
				        :on-format-error="handleFormatError"
				        :on-exceeded-size="handleMaxSize"
					    action="/LaraVueBlog/app/upload">
					    <div style="padding: 20px 0">
					        <i class="fas fa-cloud-upload-alt"></i>
					        <p>Click or drag files here to upload</p>
					    </div>
					</Upload>

					<div class="demo-upload-list" v-if="editData.categoryIconImage">
						<img :src ="`${editData.categoryIconImage}`" />
						<div class="demo-upload-list-cover">
							<i class="fas fa-trash-alt" @click="deleteImage(false)"></i>
						</div>
					</div>

					<div slot="footer">
						<Button type="default" @click="closeEditModal">Close</Button>
						<Button type="primary" @click="editCategory" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Editing..' : 'Edit category' }}</Button>
					</div>
				</Modal>

				<Modal v-model="showDeleteModal" width="360">
			        <p slot="header" style="color:#f60;text-align:center">
			            <Icon type="ios-information-circle"></Icon>
			            <span>Delete confirmation</span>
			        </p>
			        <div style="text-align:center">
			            <p>Are you sure want to delete tag?</p>
			        </div>
			        <div slot="footer">
			            <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteTag">Delete</Button>
			        </div>
			    </Modal>


			</div>
		</div>
	</div>
</template>

<script>
	export default {

		data(){
			return {
				data: {
					categoryIconImage : '',
					categoryName : ''
				},
				addModal : false,
				editModal : false,
				isAdding : false,
				isDeleting : false,
				categorylists : [],
				editData : {
					categoryIconImage : '',
					categoryName : ''
				},
				index : -1,
				showDeleteModal : false,
				deleteItem : {},
				deletingIndex : -1,
				token : '',
				isIconImageNew: false,
				isEditingItem : false
			}
		},

		methods : {
			async addCategory(){
				if(this.data.categoryName.trim()=='') return this.e('Category name is required')
				if(this.data.categoryIconImage.trim()=='') return this.e('Image name is required')
				this.data.categoryIconImage = `public/uploads/${this.data.categoryIconImage}`
				const res = await this.callApi('post','app/create_category', this.data)
				if(res.status === 201){
					console.log('success')
					this.categorylists.unshift(res.data)
					this.s('Category has been added successfully!')
					this.addModal = false
					this.data.categoryName = ''
					this.$refs.uploads.clearFiles()
					this.data.categoryIconImage = ''
				}else{
					if(res.status==422){
						if(res.data.errors.categoryName){
							this.e(res.data.errors.categoryName[0])
						}
						if(res.data.errors.categoryIconImage){
							this.e(res.data.errors.categoryIconImage[0])
						}
					}else{
						this.swr()
					}
					
				}
			},
			async editCategory(){
				if(this.editData.categoryName.trim()=='') return this.e('Category name is required')
				if(this.editData.categoryIconImage.trim()=='') return this.e('Image name is required')
				const res = await this.callApi('post','app/edit_category', this.editData)
				if(res.status === 200){
					this.categorylists[this.index].categoryName = this.editData.categoryName
					this.s('Category has been updated successfully!')
					this.editModal = false
				}else{
					if(res.status==422){
						if(res.data.errors.categoryName){
							this.e(res.data.errors.categoryName[0])
						}
						if(res.data.errors.categoryIconImage){
							this.e(res.data.errors.categoryIconImage[0])
						}
					}else{
						this.swr()
					}
					
				}
			},
			showEditModal(category, index){

				this.editData = category
				this.editModal = true
				this.index = index
				this.isEditingItem = true
			},

			async deleteTag(){
				this.isDeleting = true
				const res = await this.callApi('post','app/delete_tag', this.deleteItem)
				if(res.status===200){
					this.tags.splice(this.deletingIndex,1)
					this.s('Tag has been deleted successfully!')
				}else{
					this.swr()
				}
				this.isDeleting = false
				this.showDeleteModal = false
			},
			showDeletingModal(tag, i){
				this.deleteItem = tag
				this.deletingIndex = i
				this.showDeleteModal = true
			},

			handleSuccess (res, file) {
				res = `public/uploads/${res}`
				if(this.isEditingItem){
					return this.editData.categoryIconImage = res
				}
                this.data.categoryIconImage = res
            },
            handleError (res, file) {
                console.log('res',res)
                console.log('file',file)
                this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: `${file.errors.file.length ? file.errors.file[0] : 'Something went wrong!'}`
                });
            },
            handleFormatError (file) {
                this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
                });
            },
            handleMaxSize (file) {
                this.$Notice.warning({
                    title: 'Exceeding file size limit',
                    desc: 'File  ' + file.name + ' is too large, no more than 2M.'
                });
            },
            async deleteImage(isAdd=true){
            	if(!isAdd){
            		this.isIconImageNew = true
            		let image = this.editData.categoryIconImage
            		this.editData.categoryIconImage = ''
            		this.$refs.editDataUploads.clearFiles()
            	}else{
            		let image = this.data.categoryIconImage
            		this.data.categoryIconImage = ''
            		this.$refs.uploads.clearFiles()
            	}
            	let image = this.data.categoryIconImage
            	this.data.categoryIconImage = ''
            	this.$refs.uploads.clearFiles()
            	const res = await this.callApi('post','app/delete_image',{imageName : image})
            	if(res.status!=200){
            		this.data.categoryIconImage = image
            		this.swr()
            	}
            },
            closeEditModal(){
            	this.isEditingItem = false,
            	this.editModal = false
            }
		},

		async created(){
			this.token = window.Laravel.csrfToken
			const res = await this.callApi('get','app/get_category')
			if(res.status==200){
				this.categorylists = res.data
			}else{
				this.swr()
			}
		}
	}
</script>