<template>
    <!-- Profile Details=============================== -->
    <div class="bg-light shadow-sm rounded text-center p-3 mb-4">
        <form id="form_change_avatar" method="post" @submit.prevent=""></form>
            <div class="profile-thumb mt-3 mb-4"> 
                <img class="rounded-circle" 
                    :src="get_avatar()" 
                    height="100"
                    width="100"
                    alt="">
              
                <div class="profile-thumb-edit custom-file bg-primary text-white" 
                    data-toggle="tooltip" 
                    title="Change Profile Picture"> 
                    <i class="fas fa-camera position-absolute"></i>
            
                    <input type="file" class="custom-file-input" id="avatar" name="avatar" @change="set_avatar">

                </div>
            
            </div>

            <p class="text-3 font-weight-500 mb-2">
                Hello, {{ full_name() | ucwords }}
            </p>

            <p class="mb-2">

                <router-link to="/bpa/profile" 
                    class="text-5 text-light" 
                    data-toggle="tooltip" 
                    title="Edit Profile">
                        <i class="fas fa-edit"></i>
                </router-link>

                <button class="btn btn-primary btn-block"
                            @click="update_avatar"
                            :class="{'btn btn-secondary btn-block': isInvalid}"
                            :disabled="isInvalid">
                            Change Profile Picture 
                </button>
            </p>

        </form>
    </div>
    <!-- Profile Details End -->
</template>

<script>
    export default {
        mounted() {
            
        },

        data(){
            return {
                userDetails: this.userDetails,
                isInvalid: true,

                form_change_avatar: new Form({
                    avatar: this.user.avatar,
                    changed: false,
                    file_type: null,
                    file_size: null,
                })
                ,
                
            }
        },

        methods: {
            full_name() {
                return this.userDetails.admin_name + " " + this.userDetails.admin_father_name; 
            }
            ,

            get_avatar(){
                return (this.form_change_avatar.avatar.length > 100) ? 
                this.form_change_avatar.avatar:"/storage/uploads/users_profile_picture/"+this.form_change_avatar.avatar;
            }
            ,

            set_avatar(e){
      
                try {
                    const file = e.target.files[0];
                    if(file != null && this.validate_avatar(file)){

                        let reader = new FileReader();
                        reader.onloadend = (file) => {
                            this.form_change_avatar.avatar = reader.result;
                        }

                        reader.readAsDataURL(file);
                        this.form_change_avatar.file_type = file['type']; 
                        this.form_change_avatar.file_size = file['size'];
                        this.isInvalid = false;
                        this.form_change_avatar.changed = true;             
                    }
                } catch (error) {
                    this.form_change_avatar.avatar = user.avatar;
                    console.log('ALERT ERROR HAPPENED C2' + error.message);
                    some_thing_went_wrong.fire();
                    ECHO.$emit('END_LOADING');
                }
                
                
            }
            ,

            validate_avatar(file){
                if( file['type'].search('image') == -1 ){
                    this.form_change_avatar.avatar = user.avatar;
                    swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Unsupported image format!'
                    });
                    return false;
                }
                else if( file['size'] > 5242880 ){
                    this.form_change_avatar.avatar = user.avatar;
                    swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: 'You are uploading a large file!'
                    });
                    return false;
                }
                return true;
            }
            ,

            update_avatar(){
                
              ECHO.$emit('START_LOADING');

                this.form_change_avatar.put('api/update_avatar/')
                    .then(( response ) => {

                        let data = response.data;

                        if( data == 'unsupported format' ){
                            this.form_change_avatar.avatar = user.avatar;
                            swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Unsupported format!'
                            });
                            
                        }
                        else if( data == 'file size too large' ){
                            this.form_change_avatar.avatar = user.avatar;
                            swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'You are uploading a large file!'
                            });
                        }
                        else if( data == 'failed' ){
                            this.form_change_avatar.avatar = user.avatar;
                            console.log('ALERT ERROR HAPPENED C1' + error.message);
                            some_thing_went_wrong.fire();
                            ECHO.$emit('END_LOADING');
                        }
                        else{
                            toast.fire({
                                type: 'success',
                                title: 'Profile Picture Updated Successfully'
                            });

                            //this.form_change_avatar.avatar = data.avatar;
                            this.isInvalid = true;

                            //let profile_picture_path = '/storage/uploads/users_profile_picture/' + this.form_change_avatar.avatar;

                            let sidebar_profile = document.getElementById('profile_picture_sidebar');
                            let dropdown_profile = document.getElementById('profile_picture_dropdown');
                            let navbar_profile = document.getElementById('profile_picture_navbar');

                            sidebar_profile.src = this.form_change_avatar.avatar;
                            navbar_profile.src = this.form_change_avatar.avatar;
                            dropdown_profile.src = this.form_change_avatar.avatar;

                            ECHO.$emit('UPDATE_USER', data);
                            ECHO.$emit('END_LOADING');
                        }
                        
                    })
                    .catch((error) => {
                        this.form_change_avatar.avatar = user.avatar;
                        console.log('ALERT ERROR HAPPENED C2' + error.message);
                        some_thing_went_wrong.fire();
                        ECHO.$emit('END_LOADING');
                    });
            }
            ,

        },

        created(){

            ECHO.$on('UPDATE_BILL_PAYMENT_PROVIDER_DETAILS',(data)=>{
                this.userDetails = data;
            });

            ECHO.$on('UPDATE_USER',(data)=>{
                Vue.prototype.user = data;
            });

        }
        ,

    }
</script>
